<?php
namespace App\Helper;

class Seo {

    private static $instance;

    private $title;
    private $metas = [];

    public static function instance() {
        if (self::$instance) return self::$instance;
        return self::$instance = new Seo();
    }

    public function setTitle($title) {
        $this->title = $title;
        return $this;
    }

    public function addMeta($key, $value) {
        $this->metas[$key] = $value;
        return true;
    }

    public function metas() {
        $result = "";
        foreach($this->metas as $name => $content ) {
            $result .=  '<meta name="'.$name.'" content="'.$content.'"/>';
        }
        return $result;
    }

    public function title() {
        return ($this->title) ? $this->title.' - '.config('app_name', 'Project Base') : config('app_name', 'Project Base');
    }

}
