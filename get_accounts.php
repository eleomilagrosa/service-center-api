<?php  
	include("function.php");
	
	$get_list_type = addslashes($_GET['get_list_type']);		

	if($get_list_type == 1){
		if($_GET['station_id'] == 0){
			$accounts = get_accounts($_GET['name']);
		}else{
			$accounts = get_accounts_by_station_id($_GET['station_id'],$_GET['name']);
		}
	}else if($get_list_type == 2){
		if($_GET['station_id'] == 0){
			$accounts = get_accounts_to_be_approved($_GET['name']);
		}else{
			$accounts = get_accounts_to_be_approved_by_station_id($_GET['station_id'],$_GET['name']);
		}
	}else if($get_list_type == 3){
		$accounts = get_admins($_GET['name']);
	}
	
	if($accounts->num_rows == 0){
		$response['success'] = 0;
		$response['message'] = "Failed to retrieve";
	}else{
		$response['accounts'] = array();
		while($r = $accounts->fetch_assoc()){
			$stations = get_station_by_id($r['station_id']);
			while($per_stations = $stations->fetch_assoc()){
				$r['station'] = $per_stations; 
			}
			array_push($response['accounts'], $r);
		}
		$response['success'] = 1;
	}

	$data['data'] = json_encode($response);
	echo json_encode($data);

?>