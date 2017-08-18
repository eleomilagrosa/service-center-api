<?php

// use Storage;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/
Route::get('/', function(\Illuminate\Http\Request $request) {
	$filepath = $request->input('filepath');
	$url = 'public/' . $filepath;	
	$first = strtok($filepath, '/');
	if($first != "images"){
		return Response::json(['message' => ' Unauthorized Access.'], 401);
	}else{
		if (!Storage::exists($url)){
			return Response::json(['message' => 'File not exist.' . $filepath], 404);
		}
	}
	$file = Storage::get($url);
	$type = Storage::mimeType($url);
	$response = Response::make($file, 200)->header('Content-Type', $type);
	return $response;
});
Route::get('/date', function(){
	$response['original_date'] = date("Y-m-d H:i:s");
	$data["data"] = json_encode($response);
	echo json_encode($data);
});