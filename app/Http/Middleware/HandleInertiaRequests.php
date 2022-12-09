<?php

namespace App\Http\Middleware;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\App;
use Inertia\Middleware;
use Tightenco\Ziggy\Ziggy;

class HandleInertiaRequests extends Middleware
{
    /**
     * The root template that is loaded on the first page visit.
     *
     * @var string
     */
    protected $rootView = 'app';

    /**
     * Determine the current asset version.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return string|null
     */
    public function version(Request $request)
    {
        return parent::version($request);
    }

    /**
     * Define the props that are shared by default.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function share(Request $request)
    {
        $language = config('default-language', 'en');
        if (session()->get('language')) $language = session()->get('language');
        App::setLocale($language);

        $avatar = null;
        if ($request->user()) {
            $avatar = ($request->user()->avatar) ? storage_url($request->user()->avatar, 100) : url('images/avatar.png');
        }
        return array_merge(parent::share($request), [
            'auth' => [
                'user' => $request->user(),
                'avatar' => $avatar
            ],
            'ziggy' => function () use ($request) {
                return array_merge((new Ziggy)->toArray(), [
                    'location' => $request->url(),
                ]);
            },
            'flash' => [
                'message' => $request->session()->get('message')
            ],
            'locale' => App::currentLocale(),
            'config' => [
                'site_title' => config('site-title', 'ProjectBase'),
                'theme' => config('default-theme', 'light'),
                'lightLogo' => (config('site-light-logo')) ? storage_url(config('site-light-logo')) : asset('images/logo-light.png'),
                'darkLogo' => (config('site-dark-logo')) ? storage_url(config('site-dark-logo')) : asset('images/logo-dark.png'),
                'icon' => (config('site-favicon')) ? storage_url(config('site-favicon')) : asset('images/icon.png')
            ],
            'languages' => [
                ['title' => __('English'), 'value' => 'en'],
                ['title' => __('French'), 'value' => 'fr'],
                ['title' => __('Arabic'), 'value' => 'ar'],
            ],
            'user_menu'  => [
                [
                    'title' => __('Menu'),
                    'divider' => true,
                    'menus' => [
                        ['title' => __('Home'), 'link' => '/dashboard', 'icon' => 'mdi-home'],
                        ['title' => __('Clients'), 'link' => '/clients', 'icon' => 'mdi-account-group-outline'],
                        [
                            'title' => __('Expenses'),
                            'link' => '/expenses',
                            'icon' => 'mdi-file-document-edit-outline',
                            'sub' => [
                                ['title' => __('Lists'), 'link' => '/expenses', 'icon' => 'mdi-text-box-outline'],
                                ['title' => __('Add New'), 'link' => '/expenses/new', 'icon' => 'mdi-text-box-plus-outline'],

                            ]
                        ],
                        [
                            'title' => __('Reports'),
                            'link' => '/reports',
                            'icon' => 'mdi-finance',
                            'sub' => [
                                ['title' => __('Expenses'), 'link' => '/reports/expenses', 'icon' => 'mdi-file-chart-outline'],
                            ]
                        ],
                    ]
                ],
                [
                    'title' => __('Profile'),
                    'divider' => false,
                    'menus' => [
                        ['title' => __('Profile'), 'link' => '/profile', 'icon' => 'mdi-account-circle-outline'],
                    ]
                ]
            ],
            'admin_menu' => [
                [
                    'title' => __('Menu'),
                    'divider' => true,
                    'menus' => [
                        ['title' => __('Dashboard'), 'link' => '/admin/dashboard', 'icon' => 'mdi-trending-up'],
                        ['title' => __('Configurations'),
                            'link' => '/admin/settings',
                            'icon' => 'mdi-cog-transfer-outline',
                            'sub' => [
                                ['title' => __('General'), 'link' => '/admin/settings', 'icon' => 'mdi-database-settings-outline'],
                                ['title' => __('Appearance'), 'link' => '/admin/settings/appearance', 'icon' => 'mdi-invert-colors'],
                                ['title' => __('Email'), 'link' => '/admin/settings/email', 'icon' => 'mdi-email-edit-outline'],
                                ['title' => __('Users'), 'link' => '/admin/settings/users', 'icon' => 'mdi-account-key-outline'],
                                ['title' => __('Social'), 'link' => '/admin/settings/social', 'icon' => 'mdi-share-variant-outline'],
                                ['title' => __('Announcements'), 'link' => '/admin/settings/announcement', 'icon' => 'mdi-bullhorn-variant-outline'],
                                ['title' => __('Payment processors'), 'link' => '/admin/settings/payment', 'icon' => 'mdi-credit-card-edit-outline'],
                                ['title' => __('Billing Information'), 'link' => '/admin/settings/billing', 'icon' => 'mdi-note-text-outline'],
                                ['title' => __('Legal'), 'link' => '/admin/settings/legal', 'icon' => 'mdi-note-outline'],
                                ['title' => __('Cron job'), 'link' => '/admin/settings/cron', 'icon' => 'mdi-clipboard-text-clock-outline'],
                                ['title' => __('Script license'), 'link' => '/admin/settings/license', 'icon' => 'mdi-license'],
                            ],

                        ],
                        ['title' => __('Users'), 'link' => '/admin/users', 'icon' => 'mdi-account-group-outline'],
                        ['title' => __('Payments'), 'link' => '/admin/payments', 'icon' => 'mdi-cash-multiple'],
                        ['title' => __('Plans'), 'link' => '/admin/plans', 'icon' => 'mdi-view-grid-plus-outline'],
                    ]
                ],

                [
                    'title' => __('Others'),
                    'menus' => [
                        ['title' => __('Pages'), 'link' => '/admin/pages', 'icon' => 'mdi-note-text-outline'],
                        ['title' => __('Coupons'), 'link' => '/admin/coupons', 'icon' => 'mdi-ticket-percent-outline'],
                        ['title' => __('Tax rates'), 'link' => '/admin/tax', 'icon' => 'mdi-align-horizontal-distribute']
                    ]
                ]
            ]
        ]);
    }
}
