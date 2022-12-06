<?php

namespace App\View\Components;


use Illuminate\Support\Arr;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\File;
use Illuminate\View\Component;

class Translations extends Component
{
    /**
     * Create a new component instance.
     *
     * @return void
     */
    public function __construct()
    {
        //
    }

    /**
     * Get the view / contents that represent the component.
     *
     * @return \Illuminate\Contracts\View\View|\Closure|string
     */
    public function render()
    {
        $locale = App::getLocale();

        $translations = Cache::rememberForever("translations_$locale", function() use($locale) {
            $phpTranslations = [];
            $jsonTranslations = [];

            if (File::exists(base_path("lang/$locale"))) {

                $phpTranslations = collect(File::allFiles(base_path("lang/$locale")))
                    ->filter(function($file) {
                        return $file->getExtension() === "php";
                    })->flatMap(function($file) {
                        return Arr::dot(File::getRequire($file->getRealPath()));
                    })->toArray();
            }

            if (File::exists(base_path("lang/$locale.json"))) {
                $jsonTranslations = json_decode(File::get(base_path("lang/$locale.json")), true);
            }

            return  array_merge($phpTranslations, $jsonTranslations);
        });

        return view('components.translations', ['translations' => $translations]);
    }
}
