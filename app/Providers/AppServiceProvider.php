<?php

namespace App\Providers;

use App\Repositories\AdminRepository;
use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\Response;
use Illuminate\Database\Eloquent\ModelNotFoundException;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        $this->registerCustomResponse();
        $this->registerCustomValidate();
    }

    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        if ($this->app->environment() !== 'production') {
            $this->app->register(\Barryvdh\LaravelIdeHelper\IdeHelperServiceProvider::class);
        }

        $this->registerInjection();
    }

    /**
     * Register custom response
     *
     * @return void
     */
    private function registerCustomResponse()
    {
        Response::macro('success', function ($message, $data = [], $statusCode = 200, $headers = []) {
            return response()->json([
                'status_code' => $statusCode,
                'message' => $message,
                'data' => $data
            ], $statusCode, $headers);
        });

        Response::macro('error', function ($message, $errors = [], $statusCode = 500, $headers = []) {
            return response()->json([
                'status_code' => $statusCode,
                'message' => $message,
                'errors' => $errors
            ], $statusCode, $headers);
        });

        Response::macro('notfound', function ($data, $errors = [], $statusCode = 404, $headers = []) {
            if ($data instanceof ModelNotFoundException) {
                $data = trans(sprintf('messages.%s.not_found', $data->getModel()));
            }
            return response()->json([
                'status_code' => $statusCode,
                'message' => $data,
                'errors' => $errors
            ], $statusCode, $headers);
        });
    }

    /**
     * Register custom validate
     *
     * @return void
     */
    private function registerCustomValidate()
    {
        //Validate data is kana character.
        app('validator')->extend('is_kana', function ($attribute, $value, $parameters, $validator) {
            $regex = '{^(
                (\xe3\x82[\xa1-\xbf])
               |(\xe3\x83[\x80-\xbe])
               |(\xef\xbc[\x90-\x99])
               |(\xef\xbd[\xa6-\xbf])
               |(\xef\xbe[\x80-\x9f])
               |(\xe3\x80\x80)
            )+$}x';
            $result = preg_match($regex, $value, $match);
            if ($result === 1 || is_null($value)) {
                return true;
            }

            return false;
        });

    }

    /**
     * Register class injection
     *
     * @return void
     */
    private function registerInjection()
    {
//        $this->app->bind(AdminRepository::class);
    }
}
