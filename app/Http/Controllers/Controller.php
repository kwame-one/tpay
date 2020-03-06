<?php

namespace App\Http\Controllers;

use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Routing\Controller as BaseController;

class Controller extends BaseController
{
    use AuthorizesRequests, DispatchesJobs, ValidatesRequests;

    public function results($data, $code=200) {
    	$status = "";
    	if($code == 200)
    		$status = "success";
    	else if($code == 404)
    		$status = "error";
    	else if($code == 401)
    		$status = "unauthorized";
    	
    	return response([
    		'status' => $status,
    		'message' => $data['message'],
    		'data' => $data['data']
    	], $code);
    }


    public function validateError($message) {
    	return response([
    		'status' => 'error',
    		'message' => $message,
    		'data' => null
    	], 422);
    }
}
