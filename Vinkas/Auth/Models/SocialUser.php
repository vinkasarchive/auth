<?php

namespace Vinkas\Auth\Models;

use Illuminate\Database\Eloquent\Model;

class SocialUser extends Model
{
  /**
  * The table associated with the model.
  *
  * @var string
  */
  protected $table = 'oauth_users';
}
