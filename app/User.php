<?php

namespace App;

use Laravel\Passport\HasApiTokens;
use App\Libraries\MD5Hash\MD5Hasher;
use Illuminate\Notifications\Notifiable;
use Illuminate\Foundation\Auth\User as Authenticatable;

class User extends Authenticatable
{
    use Notifiable, HasApiTokens;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', 'email', 'password',
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];

    protected $table = 'accounts';

    public function validateForPassportPasswordGrant($password, $authPassword) {
        $hasher = new MD5Hasher();
        return $hasher->check($password, $authPassword);
    }
    
}
