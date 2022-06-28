<?php

namespace App\Providers;

use App\Models\User;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\ServiceProvider;
use Firebase\JWT\Key;
use Firebase\JWT\JWT;

class AuthServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        //
    }

    /**
     * Boot the authentication services for the application.
     *
     * @return void
     */
    public function boot()
    {
        // Here you may define how you wish users to be authenticated for your Lumen
        // application. The callback which receives the incoming request instance
        // should return either a User instance or null. You're free to obtain
        // the User instance via an API token or any other method necessary.

        $this->app['auth']->viaRequest('api', function ($request) {
            // if ($request->header('token')) {
            // if ($request->input('api_token')) {
            // // $jwt = $request->bearerToken();
            // // if($jwt) {
            //     return User::where('api_token', $request->input('api_token'))->first();
            // }
            $jwt = $request->bearerToken();
            try {
                $result = JWT::decode($jwt, new Key(config('jwt.key'), 'HS256'));
                if($result) {
                    return User::where('api_token', $jwt)->first();
                } else {
                    return null;
                }
            } catch (\Throwable $e) {
                return null;
            }
        });
    }
}
