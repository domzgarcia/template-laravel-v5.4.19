<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Validator;
use Hash;
use Auth;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        /*
        |-----------------
        | Valid Name (NA)
        |-----------------
        */
        Validator::extend('valid_name', function($attribute, $value) {
            return preg_match('/^[\pL\s.-]+$/u', $value);
        });
        Validator::replacer('valid_name', function($message, $attribute, $rule, $parameters) {
            return "The ". $attribute ." field should be valid name.";
        });
        /*
        |------------------------------------------
        | String of emails that has separator (NA)
        |------------------------------------------
        */
        Validator::extend('isArrayOfEmails', function($attribute, $value, $parameters){
            // define closure separately for readability
            $checkEmails = function($carry, $email){
                return $carry && filter_var($email, FILTER_VALIDATE_EMAIL) !== false;
            };
            // validate that the value given is an array of valid email addresses
            return array_reduce(array_filter(explode($parameters[0],$value)),$checkEmails,true);
        });
        Validator::replacer('isArrayOfEmails', function($message, $attribute, $rule, $parameters) {
            return "There are 1 or more invalid format of emails.";
        });
        /*
        |--------------
        | White Spaces
        |--------------
        */
        Validator::extend('alpha_spaces', function($attribute, $value) {
            return preg_match('/^[\pL\s]+$/u', $value);
        });
        Validator::replacer('alpha_spaces', function($message, $attribute, $rule, $parameters) {
            return "The ". $attribute ." field should be alphabets and spaces only.";
        });
        /*
        |-------------------
        | Get user Password
        |-------------------
        */
        Validator::extend('should_not_equal_to_old_password', function ($attribute, $value) {
            return !Hash::check($value, Auth::user()->password);
        });
        Validator::replacer('should_not_equal_to_old_password', function($message, $attribute, $rule, $parameters) {
            return "The ". $attribute ." field should match to your old password. Try other password.";
        });
        /*
        |------------------------
        | Get user Password (old)
        |------------------------
        */
        Validator::extend('user_password_old', function ($attribute, $value) {
            $bool = true;
            if($value){
                $bool = Hash::check($value, Auth::user()->password);
            }
            return $bool;
        });
        Validator::replacer('user_password_old', function($message, $attribute, $rule, $parameters) {
            return "The old password field is doesn't match to your old password. Please try again.";
        });
    }
    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        
    }
}
