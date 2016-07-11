Confirm your email address by clicking the link below <br />
<a href="{{ $url = url('confirmation', $user->confirmation_code) . '?email=' . urlencode($user->email) }}">Click to Confirm</a>
