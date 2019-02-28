<?php

namespace App\Providers;

use App\Models\CarAttribute;
use App\Models\CarInteraction;
use App\Models\Comment;
use App\Models\Module;
use App\Models\MyCar;
use App\Models\NewsInteraction;
use App\Models\NotificationUser;
use App\Models\Review;
use App\Models\Subscriber;
use App\Observers\CarsInteractionObserver;
use App\Observers\CommentObserver;
use App\Observers\ModuleObserver;
use App\Observers\NewsInteractionObserver;
use App\Observers\NotificationObserver;
use App\Observers\ReviewObserver;
use App\Observers\SubscriptionObserver;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Request;
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
        CarInteraction::observe(CarsInteractionObserver::class);
        Comment::observe(CommentObserver::class);
        NotificationUser::observe(NotificationObserver::class);
        Review::observe(ReviewObserver::class);
        Subscriber::observe(SubscriptionObserver::class);

        \Validator::extend('phone', function ($attribute, $value, $parameters, $validator) {
            return preg_match('%^(?:(?:\(?(?:00|\+)([1-4]\d\d|[1-9]\d?)\)?)?[\-\ \\\/]?)?((?:\(?\d{1,}\)?[\-\ \\\/]?){0,})(?:[\-\ \\\/]?(?:#|ext\.?|extension|x)[\-\ \\\/]?(\d+))?$%i', $value) && strlen($value) >= 7;
        });
        \Validator::replacer('phone', function ($message, $attribute, $rule, $parameters) {
            $attribute = ucwords(str_replace('_', ' ', $attribute));
            return str_replace(':attribute', $attribute, 'Invalid :attribute');
        });

        \Validator::extend('attr', function ($attribute, $value, $parameters, $validator) {
            return strlen($value) > 0;
        });
        \Validator::replacer('attr', function ($message, $attribute, $rule, $parameters, $value) {
            $carAttribute = CarAttribute::where('id', explode(".", $attribute)[1])->first();
            return str_replace(':attribute', $carAttribute->name, ':attribute is required');
        });

        \Validator::extend('greater_than_field', function ($attribute, $value, $parameters, $validator) {
            $from = $parameters[0];
            $data = $validator->getData();
            $min_value = $data[$from];
            return $value > $min_value;
        });
        \Validator::replacer('greater_than_field', function ($message, $attribute, $rule, $parameters) {
            return 'Production life cycle start year must be less then end year';
        });

        \Validator::extend('check_featured', function ($attribute, $value, $parameters, $validator) {
            if ($value == 1) {
                $user = Auth::user();
                $featured_car_count = $user->cars()->where(['is_featured' => 1, 'status' => MyCar::ACTIVE])->count();
                return $featured_car_count < $user->details->limit_for_featured_cars;
            }
            return true;
        });
        \Validator::replacer('check_featured', function ($message, $attribute, $rule, $parameters, $value) {
            return 'Your featured cars have reached to the limit.(' . Auth::user()->details->limit_for_featured_cars . ')';
        });

        \Validator::extend('check_featured_update', function ($attribute, $value, $parameters, $validator) {
            $user = Auth::user();
            if ($value == 1 && (!$user->hasRole('admin'))) {
                $featured_car_count = $user->cars()->where('status', MyCar::ACTIVE)->where('is_featured', 1)->where('id', '!=', Request::segment(3))->count();
                return $featured_car_count < $user->details->limit_for_featured_cars;
            }
            return true;
        });
        \Validator::replacer('check_featured_update', function ($message, $attribute, $rule, $parameters, $value) {
            return 'Your featured cars have reached to the limit.(' . Auth::user()->details->limit_for_featured_cars . ')';
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
