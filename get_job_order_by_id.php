<?php  
	include("function.php");

	$job_orders = get_job_order_data($_GET['id']);
	$response['success'] = $job_orders['success'];
	$response['message'] = $job_orders['message'];
	if($response['success'] == 1){
		$response['job_orders'] = $job_orders['job_orders'];
	}

	$data['data'] = json_encode($response);
	echo json_encode($data);

?>