<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Libraries\MD5Hash\MD5Hasher;
use App\Mediator;

class AccountController extends Controller{

	public function accountVerification($username, $password){
		$con = $this->mediator->getConnection();
		$hasher = new MD5Hasher();
		$response['accounts'] = array();
		if($account = $con->table('accounts')
			->where('username', $username)
			->where('password', $hasher->make($password))
			->first()){
				if($station = $con->table('stations')
				->where('id', $account->station_id)
				->first()){
					$account->station = $station;
				}
			array_push($response['accounts'], $account);
			$response['success'] = 1;
			$response['message'] = 'Success';
		}else{
			$response['success'] = 0;
			$response['message'] = 'username and password does not exist';
		}
		return $this->mediator->makeOutput($response, 200);
	}
}