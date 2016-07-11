<?php

namespace Vinkas\Auth\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

use App\Http\Controllers\Controller;
use App\User;

abstract class EmailConfirmationController extends Controller
{

  /**
  * @param  \Illuminate\Http\Request  $request
  * @return \Illuminate\Http\Response
  */
  public function verify(Request $request, $code) {
    $validator = Validator::make($request->all(), [
      'email' => 'required|email'
    ]);
    if ($validator->fails()) {
      return $this->onError($request, 'email_confirmation_not_valid');
    }

    $email = $request->input('email');
    $user = User::where('email', $email) -> first();
    if($user->confirmed)
    return $this->onError($request, 'email_already_confirmed');
    if($user->confirmation_code == $code) {
      $user->confirm();
      $request->session()->flash('alert-success', trans('vinkasauth.success_email_confirmed'));
      if(property_exists($this, 'redirectAfterConfirmation')) {
        $redirectTo = $redirectAfterConfirmation;
      }elseif(\Auth::check()) {
        $redirectTo = "/";
      } else {
        $redirectTo = "/login";
      }
      return redirect($redirectTo);
    } else {
      return $this->onError($request, 'email_confirmation_mismatch');
    }
  }

  protected function onError(Request $request, $error) {
    $request->session()->flash('alert-danger', trans('vinkasauth.' . $error));
    if(\Auth::check())
    $redirectTo = "/";
    else
    $redirectTo = "/login";
    if(property_exists($this, 'redirectAfterError')) {
      $redirectTo = $redirectAfterError;
    }
    return redirect($redirectTo);
  }

}
