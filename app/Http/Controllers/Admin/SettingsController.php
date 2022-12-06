<?php

namespace App\Http\Controllers\Admin;

use App\Helper\Uploader;
use App\Http\Controllers\Controller;
use App\Models\Settings;
use Illuminate\Http\Request;
use Inertia\Inertia;

class SettingsController extends Controller
{
    public function general(Request $request) {
        seo()->setTitle(__('Settings > General'));

        if ($request->post()) {
            $request->validate([
                'title' => 'required',
                'language' => 'required'
            ]);

            Settings::upsert([
                ['settings_key' => 'site-title', 'settings_value' => $request->input('title') ],
                ['settings_key' => 'site-keywords', 'settings_value' => $request->input('keywords') ],
                ['settings_key' => 'site-description', 'settings_value' => $request->input('descriptions') ],
                ['settings_key' => 'default-language', 'settings_value' => $request->input('language') ],
                ['settings_key' => 'default-timezone', 'settings_value' => $request->input('timezone') ],
                ['settings_key' => 'custom-js', 'settings_value' => $request->input('customJs') ],
                ['settings_key' => 'results-per-page', 'settings_value' => $request->input('results') ],
                ['settings_key' => 'results-order', 'settings_value' => $request->input('order') ],
                ['settings_key' => 'default-currency', 'settings_value' => $request->input('currency') ],
            ], ['settings_key'], ['settings_value']);

            return redirect()->route('settings.general')->with('message', __('General settings saved successfully'));
        }
        return Inertia::render('Admin/Settings/General', [
            'title' => config('site-title'),
            'keywords' => config('site-keywords'),
            'descriptions' => config('site-description'),
            'language' => config('default-language'),
            'timezone' => config('default-timezone'),
            'results' => config('results-per-page', '10'),
            'order' => config('results-order', 'asc'),
            'currency' => config('default-currency', 'USD'),
            'ordersData' => [
                ['title' => __('Ascending'), 'value' => 'asc'],
                ['title' => __('Descending'), 'value' => 'desc'],
            ]
        ]);
    }

    public function appearance(Request $request) {

        if ($request->post()) {
            $saveData = [
                ['settings_key' => 'custom-css', 'settings_value' => $request->input('customCss') ],
                ['settings_key' => 'default-theme', 'settings_value' => $request->input('theme') ],
            ];
            $logoLight = $request->file('uploadedLight');
            if ($logoLight) {
                $logoLight = $logoLight[0];
                $uploader = new Uploader($logoLight, 'image');
                $saveData[] = [
                    'settings_key' => 'site-light-logo',
                    'settings_value' => $uploader->setPath('settings')->directUpload()->result()
                ];
            }

            $logoDark = $request->file('uploadedDark');
            if ($logoDark) {
                $logoDark = $logoDark[0];
                $uploader = new Uploader($logoDark, 'image');
                $saveData[] = [
                    'settings_key' => 'site-dark-logo',
                    'settings_value' => $uploader->setPath('settings')->directUpload()->result()
                ];
            }

            $logoFavicon = $request->file('uploadedFavicon');
            if ($logoFavicon) {
                $logoFavicon = $logoFavicon[0];
                $uploader = new Uploader($logoFavicon, 'image');
                $saveData[] = [
                    'settings_key' => 'site-favicon',
                    'settings_value' => $uploader->setPath('settings')->directUpload()->result()
                ];
            }

            Settings::upsert($saveData,  ['settings_key'], ['settings_value']);

            return redirect()->route('settings.appearance')->with('message', __('Appearance settings saved successfully'));

        }
        return Inertia::render('Admin/Settings/Appearance', [
            'themes' => [
                ['title' => __('Light'), 'value' => 'light'],
                ['title' => __('Dark'), 'value' => 'dark']
            ],
            'theme' => config('default-theme'),
            'logoDark' => storage_url(config('site-dark-logo')),
            'logoLight' => storage_url(config('site-light-logo')),
            'favicon' => storage_url(config('site-favicon')),
            'customCss' => config('custom-css')
        ]);
    }

    public function email(Request $request) {

        if ($request->post()) {
            $request->validate([
                'name' => 'required',
                'email' => ' required'
            ]);

            Settings::upsert([
                ['settings_key' => 'contact-name', 'settings_value' => $request->input('name') ],
                ['settings_key' => 'contact-email', 'settings_value' => $request->input('email') ],
                ['settings_key' => 'email-driver', 'settings_value' => $request->input('driver') ],
                ['settings_key' => 'smtp-host', 'settings_value' => $request->input('host') ],
                ['settings_key' => 'smtp-port', 'settings_value' => $request->input('port') ],
                ['settings_key' => 'smtp-secure', 'settings_value' => $request->input('secure') ],
                ['settings_key' => 'smtp-username', 'settings_value' => $request->input('username') ],
                ['settings_key' => 'smtp-password', 'settings_value' => $request->input('password') ],
            ], ['settings_key'], ['settings_value']);

            return redirect()->route('settings.email')->with('message', __('Email settings saved successfully'));
        }

        return Inertia::render('Admin/Settings/Email', [
            'name' => config('contact-name'),
            'email' => config('contact-email'),
            'host' => config('smtp-host'),
            'port' => config('smtp-port'),
            'username' => config('smtp-username'),
            'password' => config('smtp-password'),
            'driver' => config('email-driver', 'mail'),
            'secure' => config('email-driver', 'tls'),
            'drivers' => [
                ['title' => __('Send Mail'), 'value' => 'mail'],
                ['title' => __('SMTP'), 'value' => 'smtp'],
            ]
        ]);
    }

    public function payment(Request $request) {

        return Inertia::render('Admin/Settings/Payment', [

        ]);
    }

    public function legal(Request $request) {
        if ($request->post()) {
            Settings::upsert([
                ['settings_key' => 'terms-url', 'settings_value' => $request->input('terms') ],
                ['settings_key' => 'privacy-url', 'settings_value' => $request->input('privacy') ],
                ['settings_key' => 'cookie-url', 'settings_value' => $request->input('cookie') ],
            ], ['settings_key'], ['settings_value']);

            return redirect()->route('settings.legal')->with('message', __('Legal settings saved successfully'));
        }
        return Inertia::render('Admin/Settings/Legal', [
            'terms' => config('terms-url'),
            'privacy' => config('privacy-url'),
            'cookie' => config('cookie-url')
        ]);
    }

    public function users(Request $request) {
        if ($request->post()) {
            Settings::upsert([
                ['settings_key' => 'user-register', 'settings_value' => $request->input('register') ],
                ['settings_key' => 'email-confirmation', 'settings_value' => $request->input('verify') ],
            ], ['settings_key'], ['settings_value']);

            return redirect()->route('settings.users')->with('message', __('Email settings saved successfully'));
        }
        return Inertia::render('Admin/Settings/Users', [
            'options' => [['title' => __('Yes'), 'value' => "1"], ['title' => __('No'), 'value' => '0']],
            'register' => config('user-register', "1"),
            'verify' => config('email-confirmation', "0")
        ]);
    }

    public function social(Request $request) {
        if ($request->post()) {
            Settings::upsert([
                ['settings_key' => 'social-facebook', 'settings_value' => $request->input('facebook') ],
                ['settings_key' => 'social-twitter', 'settings_value' => $request->input('twitter') ],
                ['settings_key' => 'social-instagram', 'settings_value' => $request->input('instagram') ],
                ['settings_key' => 'social-linkedin', 'settings_value' => $request->input('linkedin') ],
                ['settings_key' => 'social-youtube', 'settings_value' => $request->input('youtube') ],
            ], ['settings_key'], ['settings_value']);

            return redirect()->route('settings.social')->with('message', __('Social settings saved successfully'));
        }
        return Inertia::render('Admin/Settings/Social', [
            'facebook' => config('social-facebook', 'https://facebook.com'),
            'twitter' => config('social-twitter', 'https://twitter.com'),
            'linkedin' => config('social-linkedin', 'https://linkedin.com'),
            'instagram' => config('social-instagram', 'https://instagram.com'),
            'youtube' => config('social-youtube', 'https://youtube.com'),
        ]);
    }

    public function billing(Request $request) {
        if ($request->post()) {
            Settings::upsert([
                ['settings_key' => 'billing-vendor', 'settings_value' => $request->input('vendor') ],
                ['settings_key' => 'billing-invoice', 'settings_value' => $request->input('invoice') ],
                ['settings_key' => 'billing-address', 'settings_value' => $request->input('address') ],
                ['settings_key' => 'billing-city', 'settings_value' => $request->input('city') ],
                ['settings_key' => 'billing-state', 'settings_value' => $request->input('state') ],
                ['settings_key' => 'billing-postcode', 'settings_value' => $request->input('postcode') ],
                ['settings_key' => 'billing-country', 'settings_value' => $request->input('country') ],
                ['settings_key' => 'billing-phone', 'settings_value' => $request->input('phone') ],
                ['settings_key' => 'billing-vat', 'settings_value' => $request->input('vat') ],
            ], ['settings_key'], ['settings_value']);

            return redirect()->route('settings.billing')->with('message', __('Billing information saved successfully'));
        }
        return Inertia::render('Admin/Settings/Billing', [
            'countries' => country_lists(),
            'vendor' => config('billing-vendor'),
            'invoice' => config('billing-invoice'),
            'address' => config('billing-address'),
            'city' => config('billing-city'),
            'state' => config('billing-state'),
            'postcode' => config('billing-postcode'),
            'country' => config('billing-country'),
            'phone' => config('billing-phone'),
            'vat' => config('billing-vat'),
        ]);
    }

    public function cron(Request $request) {

        return Inertia::render('Admin/Settings/Cron', [

        ]);
    }

    public function license(Request $request) {

        return Inertia::render('Admin/Settings/License', [

        ]);
    }

    public function announcement(Request $request) {
        if ($request->post()) {
            Settings::upsert([
                ['settings_key' => 'announcement-guest', 'settings_value' => $request->input('guest') ],
                ['settings_key' => 'announcement-guest-type', 'settings_value' => $request->input('guestType') ],
                ['settings_key' => 'announcement-user', 'settings_value' => $request->input('user') ],
                ['settings_key' => 'announcement-user-type', 'settings_value' => $request->input('userType') ],
            ], ['settings_key'], ['settings_value']);

            return redirect()->route('settings.announcement')->with('message', __('Announcement saved successfully'));
        }
        return Inertia::render('Admin/Settings/Announcement', [
            'options' => [
                ['title' => __('Primary'), 'value' => 'primary'],
                ['title' => __('Success'), 'value' => 'success'],
                ['title' => __('Danger'), 'value' => 'danger'],
                ['title' => __('Warning'), 'value' => 'warning'],
                ['title' => __('Info'), 'value' => 'info'],
                ['title' => __('Secondary'), 'value' => 'secondary'],
            ],
            'guest' => config('announcement-guest'),
            'guestType' => config('announcement-guest-type', 'primary'),
            'userType' => config('announcement-user-type', 'success'),
            'user' => config('announcement-user'),
        ]);
    }
}
