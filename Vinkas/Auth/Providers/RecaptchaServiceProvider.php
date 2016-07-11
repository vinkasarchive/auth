<?php

namespace Vinkas\Auth\Providers;

use Illuminate\Support\ServiceProvider;
use Validator;

class RecaptchaServiceProvider extends ServiceProvider
{
  /**
  * Bootstrap the application services.
  *
  * @return void
  */
  public function boot()
  {
    Validator::extend('recaptcha', function($attribute, $value, $parameters, $validator) {
      $app = app();
      $url = "https://www.google.com/recaptcha/api/siteverify";
      $secret = getenv('RECAPTCHA_SECRET');

      $client = new \GuzzleHttp\Client(['timeout' => 2.0]);
      $response = $client->request('POST', $url, [
        'verify' => false,
        'form_params' => [
          'secret' => $secret,
          'response' => $value
        ]
      ]
    );
    $body = $response->getBody();
    $result = json_decode($body);

    return $result->success;
  });
}

/**
* Register the application services.
*
* @return void
*/
public function register()
{
  //
}
}
