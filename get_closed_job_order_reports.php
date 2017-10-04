<?php  
	include("function.php");
	
	$job_orders = get_closed_job_order_reports($_GET['date_started'],$_GET['date_ended'],$_GET['station_id']);

	if($job_orders->num_rows == 0){
		$response['success'] = 0;
		$response['message'] = "Failed to retrieve id";
	}else{
		$response['job_orders'] = array();
		while($job_orders_rows = $job_orders->fetch_assoc()){
			
			$diagnosis = get_job_order_diagnosis_by_id($job_orders_rows['id']);
			if($diagnosis->num_rows > 0){
				while($diagnosis_rows = $diagnosis->fetch_assoc()){
					$job_orders_rows['jobOrderDiagnosis'] = $diagnosis_rows;
				}
			}

			$shipping = get_job_order_shipping_by_id($job_orders_rows['id']);
			if($shipping->num_rows > 0){
				while($shipping_rows = $shipping->fetch_assoc()){
					$job_orders_rows['jobOrderShipping'] = $shipping_rows;
				}
			}

			$repair_status = get_job_order_repair_status_by_id($job_orders_rows['id']);
			if($repair_status->num_rows > 0){
				while($repair_status_rows = $repair_status->fetch_assoc()){
					$job_orders_rows['jobOrderRepairStatus'] = $repair_status_rows;
				}
			}

			$for_return = get_job_order_for_return($job_orders_rows['id']);
			if($for_return->num_rows > 0){
				while($for_return_rows = $for_return->fetch_assoc()){
					$job_orders_rows['jobOrderForReturn'] = $for_return_rows;
				}
			}

			$customer = get_customer_by_id($job_orders_rows['customer_id']);
			if($customer->num_rows > 0){
				while($customer_rows = $customer->fetch_assoc()){
					$job_orders_rows['customer'] = $customer_rows;
				}
			}

			$job_orders_rows['jobOrderImages'] = array();
			$images = get_images_by_job_order($job_orders_rows['id']);
			if($images->num_rows > 0){
				while($images_rows = $images->fetch_assoc()){
					array_push($job_orders_rows['jobOrderImages'], $images_rows);
				}
			}

			array_push($response['job_orders'], $job_orders_rows);
		}
		$response['success'] = 1;
	}

	$data['data'] = json_encode($response);
	echo json_encode($data);

?>