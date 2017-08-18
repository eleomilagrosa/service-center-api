<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Mediator;
use Request;
use DB;
use Config; 
use Storage;
use Response;

class GenericClassCrudController extends Controller{

	/**
     * insert table row data.
     *
     * @param  Request $request
     * @return String Json
     */
    public function insertRowByTableName(\Illuminate\Http\Request $request){
        $data = [];
        $tableName = $request->input('data_table_name');
        foreach ($request->all() as $key => $value){
            # mapping the request
            if($key != "data_table_name"){
                if(!empty($value)){
                    if($value != "null"){
                       $data[$key] = $value;
                    }else{
                        $data[$key] = NULL;
                    }
                }else{
                    $data[$key] = '';
                }               
            }
        }
        
        
        $con = $this->mediator->getConnection();
        $id = $con->table($tableName)->insertGetId($data);
        $response[$tableName] = $this->genericResultGetterByPrimaryId($tableName,$id);

        return $this->mediator->makeOutput($response, 200);
    }
     /**
     * update table row data.
     *
     * @param  Request $request
     * @return String Json
     */
    public function updateRowByTableName(\Illuminate\Http\Request $request){
        $data = [];
        $tableName = $request->input('data_table_name');
        foreach ($request->all() as $key => $value){
            # mapping the request
            if($key != "data_table_name"){
                if(!empty($value)){
                    if($value != "null"){
                       $data[$key] = $value;                   
                    }else{
                        $data[$key] = NULL;
                    }
                }else{
                    $data[$key] = '';
                }            
            }
        }
        $id = $data['id'];  
        $con = $this->mediator->getConnection();
        $con->table($tableName)->where('id', $id)->update($data);
        $response[$tableName] = $this->genericResultGetterByPrimaryId($tableName,$id);
        return $this->mediator->makeOutput($response, 200);
    }

    /**
     * Delete row by id
     *
     * @param  Request $request
     * @return String Json
     */
    public function deleteRowByTableName(\Illuminate\Http\Request $request){
        $id = $request->input('id');
        $tableName = $request->input('data_table_name');
        $con = $this->mediator->getConnection();
        $con->table($tableName)->delete($id);
        return $this->mediator->makeOutput(['message' => 'Success' , 'success' => 1 ,'delete_id' => $id ], 200);
    }

    /**
     * Get table rows data.
     *
     * @param  table_name
     * @param  primary id
     * @return table rows
     */
    public function genericResultGetterByPrimaryId($tableName,$id){
        $con = $this->mediator->getConnection();
        $array = array();
        if ($query_result =$con->table($tableName)
                    ->select('*',DB::raw('1 as is_saved_online'))
                    ->where('id', $id)->first()){
            array_push($array, $query_result);
        }
        return $array;
    }


    public function getRowByTableName($tableName , $id){
        $response[$tableName] = $this->genericResultGetterByPrimaryId($tableName,$id);
        return $this->mediator->makeOutput($response, 200);
    }


}