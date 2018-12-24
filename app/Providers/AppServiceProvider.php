<?php

namespace App\Providers;

use App\Models\Comment;
use App\Models\Module;
use App\Models\NewsInteraction;
use App\Models\NotificationUser;
use App\Observers\CommentObserver;
use App\Observers\ModuleObserver;
use App\Observers\NewsInteractionObserver;
use App\Observers\NotificationObserver;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        App::setLocale('en');
        Schema::defaultStringLength(191);
        Module::observe(ModuleObserver::class);
        NewsInteraction::observe(NewsInteractionObserver::class);
        Comment::observe(CommentObserver::class);
        NotificationUser::observe(NotificationObserver::class);

        \Validator::extend('phone', function ($attribute, $value, $parameters, $validator) {
            return preg_match('%^(?:(?:\(?(?:00|\+)([1-4]\d\d|[1-9]\d?)\)?)?[\-\ \\\/]?)?((?:\(?\d{1,}\)?[\-\ \\\/]?){0,})(?:[\-\ \\\/]?(?:#|ext\.?|extension|x)[\-\ \\\/]?(\d+))?$%i', $value) && strlen($value) >= 8;
        });
        \Validator::replacer('phone', function ($message, $attribute, $rule, $parameters) {
            $attribute = ucwords(str_replace('_', ' ', $attribute));
            return str_replace(':attribute', $attribute, 'Invalid :attribute');
        });
    }

    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        //
    }
}
