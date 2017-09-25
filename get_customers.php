<?php  
	include("function.php");	

	if($_GET['station_id'] == 0){
		$customers = get_customers($_GET['name'],$_GET['date'],$_GET['direction']);	
	}else{
		$customers = get_customers_by_station_id($_GET['name'],$_GET['station_id'],$_GET['date'],$_GET['direction']);	
	}
	
// http://192.168.0.102/servicecenter/get_customers.php?name=&station_id=0&date=2017-19-13%2022:19:32&direction=1
	
	if($customers->num_rows == 0){
		$response['success'] = 0;
		$response['message'] = "Failed to retrieve";
	}else{
		$response['customers'] = array();
		while($r = $customers->fetch_assoc()){
			array_push($response['customers'], $r);
		}
		$response['success'] = 1;
	}

	$data['data'] = json_encode($response);
	echo json_encode($data);

?>