<?php

namespace App\Providers;

use Stripe\StripeClient;
use Illuminate\Support\ServiceProvider;
class StripeServiceProvider extends ServiceProvider
{
    public function register()
    {

        $this->app->singleton(StripeClient::class, function () {

            $apiKey= '';
            $appEnv = strtolower(config('app.env'));
            \Log::info('-1 StripeServiceProvider $appEnv ::' . print_r($appEnv, true));
            if ($appEnv == 'local' or $appEnv == 'dev') {
                
                \Log::info('+++ StripeServiceProvider $appEnv ::' . print_r($appEnv, true));
                \Log::info('+++ StripeServiceProvider config(app.STRIPE_TEST_KEY) ::' . print_r(config('app.STRIPE_TEST_KEY'), true));
    
                $apiKey = config('app.STRIPE_TEST_KEY');
            }
            if ($appEnv == 'production') {
                $apiKey = config('app.STRIPE_LIVE_KEY');
            }    
            \Log::info('-99 StripeServiceProvider $apiKey ::' . print_r($apiKey, true));
            return new StripeClient( $apiKey );
   // 'STRIPE_LIVE_KEY' => env('STRIPE_LIVE_KEY', null),
        });
    }

/*     'stripe' => [
        'public' => env('STRIPE_CLIENT_KEY'),
        'secret' => env('STRIPE_TEST_KEY'),
        'connect' => env('STRIPE_CONNECT')
    ]
/* STRIPE_CLIENT_KEY = 'pk_test_eHxeh70uxnGVj3TbC1u2QN37002NWM1isv'
STRIPE_TEST_KEY = 'sk_test_4qiBbW7cl6zVdD4wMacxMp3q002YCCQAkm'
 */	
}