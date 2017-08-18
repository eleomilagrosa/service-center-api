<?php

namespace App;

use App\Libraries\MD5Hash\MD5Hasher;
use DB;
use Config;
use Storage;
use Response;

class Mediator {

    public $connection;
    public $accepts;
    /**
     * Setting up the entrance and exit
     * of the application.
     *
     * @param  String $name
     * @param  String $username
     * @param  String $password
     * @return void
     */
    public function setPortal($accepts){
        $this->accepts = $accepts;
        $this->setConnection();
    }

    /**
     * Set the self user supplied database.
     *
     * @param  String $name
     * @param  String $username
     * @param  String $password
     * @return void
     */
    public function setConnection(){
        // For testing (local)
        //  Config::set('database.connections.manual', [
        //     'driver'    => 'mysql',
        //     'host'      => '192.168.0.100',
        //     'port'      => '2121',
        //     'database'  => 'servicecenter',
        //     'username'  => 'admin',
        //     'password'  => '21posincbibiza4012006',
        //     'charset'   => 'utf8',
        //     'collation' => 'utf8_unicode_ci',
        //     'prefix'    => '',
        //     'strict'    => false,
        //     'engine'    => null,
        // ]);
        $this->connection = DB::connection();
    }

    /**
     * Set the accept
     *
     * @param  String $accepts
     * @return ConnectionInterface
     */
    public function setAccept($accepts) {
        $this->accepts = $accepts;
    }

    /**
     * Get the self user supplied database.
     * Note: must set connection first.
     *
     * @return ConnectionInterface
     */
    public function getConnection() {
        return $this->connection;
    }
    /**
     * Because each receiver don't have
     * the same output.
     *
     * @param  String $response
     * @param  int $errorCode
     * @return String|Json
     */
    public function makeOutput($response, $errorCode){
        switch ($this->accepts) {
            case 'custom/json':
                $data['data'] = json_encode($response);
                return json_encode($data);
            case 'application/json':
                return Response::json($response, $errorCode);
            default:
                return Response::json($response, $errorCode);
        }
    }
}