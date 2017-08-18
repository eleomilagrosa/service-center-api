<?php
namespace App\Providers;
 
use Illuminate\Hashing\HashServiceProvider;
use App\Libraries\MD5Hash\MD5Hasher as MD5Hasher;
 
class MD5HashServiceProvider extends HashServiceProvider
{
    public function register()
    {
        $this->app->singleton('hash', function () {
            return new MD5Hasher;
        });
    }
}