<?php

namespace App\Http\Controllers;

use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Routing\Controller as BaseController;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Request;
use App\Mediator;

class Controller extends BaseController
{
    
    use AuthorizesRequests, DispatchesJobs, ValidatesRequests;

    protected $mediator;

    /**
     * Initialize components.
     *
     */
    public function __construct() {
        $this->mediator = new Mediator();
    	if (isset(Request::header()['accept'][0])){
    		$this->mediator->setPortal(
				Request::header()['accept'][0]
			);
    	}
    }

}
