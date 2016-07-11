<?php

namespace Vinkas\Auth;

use Vinkas;
use Socialite;

trait Social {

  /**
  * Redirect the user to the authentication page.
  *
  * @return Response
  */
  protected function redirectToSocial($provider)
  {
    return Socialite::driver($provider)->redirect();
  }

  /**
  * Obtain the user information.
  *
  * @return User
  */
  public function getSocialUser($provider)
  {
    $client = new \GuzzleHttp\Client(['verify' => false]);
    Socialite::driver($provider)->setHttpClient($client);
    $user = Socialite::driver($provider)->user();
    return $user;
  }

  public function redirectToGoogle() {
    return $this->redirectToSocial('google');
  }

  public function handleGoogleCallback() {
    $provider = 'google';
    $ouser = $this->getSocialUser($provider);
    $user = $this->queryProfiles($provider)->where('id', $ouser->getId())->first();
    if($user == null) {
      $this->createOAuthUser($ouser, $provider);
    } else {
      Auth::login($user);
    }
  }

  protected function createOAuthUser($user, $provider) {
    if(isset($user->tokenSecret))
    $token_secret = $user->tokenSecret;
    $refresh_token = $user->refreshToken;
    if(isset($user->expires_in))
    $expires_in = $user->expires_in;
    if(isset($token_secret)) {
      \DB::table('oauth_profiles')->insert(['provider' => $provider, 'id' => $user->getId(), 'token' => $user->token, 'token_secret' => $token_secret, 'refresh_token' => $refresh_token, 'expires_in' => $expires_in, 'name' => $user->getName(), 'nickname' => $user->getNickname(), 'email' => $user->getEmail(), 'avatar' => $user->getAvatar()]);
    } else {
      \DB::table('oauth_profiles')->insert(['provider' => $provider, 'id' => $user->getId(), 'token' => $user->token, 'refresh_token' => $refresh_token, 'name' => $user->getName(), 'nickname' => $user->getNickname(), 'email' => $user->getEmail(), 'avatar' => $user->getAvatar()]);
    }
  }

  protected function queryProfiles($provider) {
    $query = \DB::table('oauth_profiles')->where('provider', $provider);
    return $query;
  }

}
