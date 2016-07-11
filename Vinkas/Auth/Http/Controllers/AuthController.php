<?php

namespace Vinkas\Auth\Http\Controllers;

use Illuminate\Http\Request;
use Validator;

use App\Http\Controllers\Controller;
use App\User;

use Vinkas\Auth\Social;

abstract class AuthController extends Controller
{

  use Social;

  protected $username = 'username';

  /**
  * Handle a login request to the application.
  *
  * @param  \Illuminate\Http\Request  $request
  * @return \Illuminate\Http\Response
  */
  public function loginByEmailOrUsername(Request $request) {
    if(property_exists($this, 'username')) {
      $this->username = filter_var($request->input('login'), FILTER_VALIDATE_EMAIL) ? 'email' : $this->username;
      $request->merge([$this->username => $request->input('login')]);
    }
    return $this->login($request);
  }

  /**
   * Get a validator for an incoming registration request.
   *
   * @param  array  $data
   * @return \Illuminate\Contracts\Validation\Validator
   */
  protected function validator(array $data)
  {
      return Validator::make($data, [
          'name' => 'required|max:255',
          'username' => 'required|min:4|max:255|unique:users,username',
          'email' => 'required|email|max:255|unique:users',
          'password' => 'required|min:6|confirmed',
          'g-recaptcha-response' => 'required|recaptcha',
      ]);
  }

  /**
  * Create a new user instance after a valid registration.
  *
  * @param  array  $data
  * @return User
  */
  protected function create(array $data)
  {
    $app = app();
    $confirmationCode = $app['vinkas.auth']->generateRandomCode();
    $user =  User::create([
      'name' => $data['name'],
      'username' => $data['username'],
      'email' => $data['email'],
      'password' => bcrypt($data['password']),
      'confirmed' => false,
      'confirmation_code' => $confirmationCode,
    ]);
    $user->sendEmailConfirmation($app['mailer']);
    return $user;
  }

}
