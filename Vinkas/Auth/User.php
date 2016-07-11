<?php

namespace Vinkas\Auth;

use Illuminate\Foundation\Auth\User as Authenticatable;

abstract class User extends Authenticatable
{

  public function sendEmailConfirmation($mailer)
  {
    $emailView = "emails.email-confirmation";
    if(property_exists($this, 'emailConfirmationView')) {
      $emailView = $emailConfirmationView;
    }
    $user = $this;
    $mailer->send($emailView, compact('user'), function ($mail) use ($user) {
        $mail->to($user->email);
        $mail->subject(trans('vinkasauth.email_confirmation_subject'));
    });
    $this->save();
  }

  public function confirm() {
    $this->confirmed = true;
    $this->confirmation_code = null;
    $this->save();
  }

}
