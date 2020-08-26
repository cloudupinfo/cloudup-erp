<?php include_once('../include/comman_model_session.php');
include_once("../config/PDO.php");
	
if($_POST){
	extract($_POST);
	
	$db = new db();
	include('../include/functions.php');
	$table = "product";
	$table1 = "billing";
	$table2 = "customer_detail";
	$table3 = "gatepass";
	$table4 = "product_service";
	
	if(isset($_POST['type']) && ($_POST['type']=="billing_search"))
	{
		$search = isset($_POST['search']) ? $_POST['search'] : '';
		$echoJson = "";
		if(!empty($search))
		{
			$search = "%".$search."%";
			$select = $db->getRows("SELECT (`chassis_no`) FROM ".$table." where `chassis_no` LIKE ?",array($search));
			if(count($select)>0)
			{	
				$echoJson .= '<ul class="chasier_chassis_ul">';
				foreach($select as $value){
					$echoJson .= '<li>'.$value['chassis_no'].'</li>';
				}
				$echoJson .= '</ul>';
			}
		}
		echo $echoJson;
		exit();
	}
	else if(isset($_POST['type']) && ($_POST['type']=="search"))
	{
		$search = isset($_POST['search']) ? $_POST['search'] : '';
		$select = $db->getRow("SELECT (`chassis_no`) FROM ".$table." where `chassis_no`=?",array($search));
		if($select){
			//$_SESSION['admin_success'] = "Generate Unsuccessfully...";
			header('Location:../billing_view.php?aid='.$select['chassis_no'].'');
			exit();
		}else{
			$_SESSION['admin_error'] = "Chassis no not found please enter properly...";
			header('Location:../billing.php');
			exit();
		}
	}
	else if(isset($_POST['type']) && ($_POST['type']=="add"))
	{
		$resultTrueArray = array();
		$admin_id = isset($_POST['admin_id']) ? $_POST['admin_id'] : $_SESSION['admin_id'];
		$customer_detail_id = isset($_POST['customer_detail_id']) ? $_POST['customer_detail_id'] : '';
		$chassis_no = isset($_POST['chassis_no']) ? $_POST['chassis_no'] : '';
		$gatepass_id = isset($_POST['gatepass_id']) ? $_POST['gatepass_id'] : '';
		$product_id = isset($_POST['product_id']) ? $_POST['product_id'] : '';
		$service_book = isset($_POST['service_book']) ? $_POST['service_book'] : '';
		
		$product = $db->getRow("SELECT `product_id`,`chassis_no` FROM ".$table." where `chassis_no`=?",array($chassis_no));
		
		if(!empty($product))
		{
			$select = $db->getRow("SELECT * FROM ".$table1." where `product_id`=?",array($product['product_id']));
			if(empty($select))
			{
				// find customer detail
				$customer_detail = $db->getRow("SELECT `customer_detail_id`,`product_id` FROM ".$table2." where `product_id`=?",array($product['product_id']));
				if(!empty($customer_detail))
				{
					// gatepass generate or not check
					$gatepass = $db->getRow("SELECT (`gatepass_id`) FROM ".$table3." where `product_id`=?",array($product['product_id']));
					if(!empty($gatepass))
					{
						$insert = $db->insertRow("INSERT INTO ".$table1." (`admin_id`,`product_id`,`gatepass_id`,`customer_detail_id`,`service`,`updated_at`)VALUES(?,?,?,?,?,NOW())",array($admin_id,$product['product_id'],$gatepass['gatepass_id'],$customer_detail['customer_detail_id'],$service_book));
						
						// Update Main Product page in status 4 mins bill genareted
						$update = $db->updateRow("update ".$table." set `status`=?,`sale`=?,`updated_at`=NOW() where `product_id`=?",array(4,1,$customer_detail['product_id']));
						
						if($insert)
						{
							$service_book += 4;
							for($i=1; $i<=$service_book; $i++)
							{
								// Barcode Generator Code
								$text = $product['chassis_no']."0".$i;
								$imgPath = $text.".png";
								$db->newBarcode($text,"service");
								
								// find product service detail
								$product_service = $db->getRow("SELECT `product_service_id`,`service_barcode` FROM ".$table4." where `service_barcode`=?",array($text));
								if(empty($product_service))
								{
									$serviceInsert = $db->insertRow("INSERT INTO ".$table4." (`admin_id`,`product_id`,`customer_detail_id`,`service_barcode`,`service_barcode_imgPath`,`updated_at`)VALUES(?,?,?,?,?,NOW())",array($admin_id,$product['product_id'],$customer_detail['customer_detail_id'],$text,$imgPath));
								}else{
									$updateService = $db->updateRow("update ".$table4." set `service_barcode`=?,`service_barcode_imgPath`=?,`updated_at`=NOW() where `product_service_id`=?",array($text,$imgPath,$product_service['product_service_id']));
								}
								//Service Barcode add in array to download
								$resultTrueArray[] = "<a download href='".BARCODE_SERVICE_PATH_DISPLAY.$imgPath."'>".$text."</a>";
							}
						}
						// Click To Download Service Barcode
						if(!empty($resultTrueArray)){
							$_SESSION['s_count'] = implode(" / ",$resultTrueArray);
							$_SESSION['s_count'] .= " Click To Download";
						}
						if($insert){
							$_SESSION['admin_success'] = "Billing Done... <a download href='".BARCODE_PATH_DISPLAY.$product['chassis_no'].".png'>".$product['chassis_no']."</a> Click To Download";
							header('Location:../billing_today_list.php');
							exit();
						}else{
							$_SESSION['admin_error'] = "Billing not done...";
							header('Location:../billing.php');
							exit();
						}
					}else{
						$_SESSION['admin_error'] = "Gatepass Not Generated Contact Sub-Admin...";
						header('Location:../billing.php');
						exit();
					}
					
				}else{
					$_SESSION['admin_error'] = "Customer Detail Not Add...";
					header('Location:../billing.php');
					exit();
				}
			}else{
				$_SESSION['admin_error'] = "Customer Detail Not Add...";
				header('Location:../billing.php');
				exit();
			}
		}else{
			$_SESSION['admin_error'] = "This Chassis No. not found. Chassis NO is = ".$chassis_no."";
			header('Location:../billing.php');
			exit();
		}
		exit();
	}
	else if(isset($_POST['type']) && ($_POST['type']=="edit"))
	{
		$id = isset($_POST['id']) ? $_POST['id'] : '';
		$resultTrueArray = array();
		
		$customer_detail_id = isset($_POST['customer_detail_id']) ? $_POST['customer_detail_id'] : '';
		$chassis_no = isset($_POST['chassis_no']) ? $_POST['chassis_no'] : '';
		$gatepass_id = isset($_POST['gatepass_id']) ? $_POST['gatepass_id'] : '';
		$product_id = isset($_POST['product_id']) ? $_POST['product_id'] : '';
		$service_book = isset($_POST['service_book']) ? $_POST['service_book'] : '';
		
		$product = $db->getRow("SELECT `product_id`,`chassis_no` FROM ".$table." where `chassis_no`=?",array($chassis_no));
		if(!empty($product))
		{
			// find customer detail
			$customer_detail = $db->getRow("SELECT `customer_detail_id`,`product_id` FROM ".$table2." where `product_id`=?",array($product['product_id']));
			if(!empty($customer_detail))
			{
				// gatepass generate or not check
				$gatepass = $db->getRow("SELECT `gatepass_id` FROM ".$table3." where `product_id`=?",array($product['product_id']));
				if(!empty($gatepass))
				{
					$update = $db->updateRow("update ".$table1." set `product_id`=?,`gatepass_id`=?,`customer_detail_id`=?,`service`=?,`updated_at`=NOW() where `billing_id`=?",array($product['product_id'],$gatepass['gatepass_id'],$customer_detail['customer_detail_id'],$service_book,$id));
					
					if(!$update)
					{
						$service_book += 4;
						for($i=1; $i<=$service_book; $i++)
						{
							$text = $product['chassis_no']."0".$i;
							
							// find product service detail
							$product_service = $db->getRow("SELECT `product_service_id`, `service_barcode` FROM ".$table4." where `service_barcode`=?",array($text));
							// Service barcode genrator code
							$imgPath = $text.".png";
							$db->newBarcode($text,"service");
							
							if(empty($product_service))
							{
								$serviceInsert = $db->insertRow("INSERT INTO ".$table4." (`admin_id`,`product_id`,`customer_detail_id`,`service_barcode`,`service_barcode_imgPath`,`updated_at`)VALUES(?,?,?,?,?,NOW())",array($admin_id,$product['product_id'],$customer_detail['customer_detail_id'],$text,$imgPath));
							}else{
								$updateService = $db->updateRow("update ".$table4." set `service_barcode`=?,`service_barcode_imgPath`=?,`updated_at`=NOW() where `product_service_id`=?",array($text,$imgPath,$product_service['product_service_id']));
							}
							//Service Barcode add in array to download
							$resultTrueArray[] = "<a download href='".BARCODE_SERVICE_PATH_DISPLAY.$imgPath."'>".$text."</a>";
						}
					}
					// Click To Download Service Barcode
					if(!empty($resultTrueArray)){
						$_SESSION['s_count'] = implode(", ",$resultTrueArray);
						$_SESSION['s_count'] .= " Click To Download";
					}
					if(!$update){
						$_SESSION['admin_success'] = "Billing Update Sussessfully... <a download href='".BARCODE_PATH_DISPLAY.$product['chassis_no'].".png'>".$product['chassis_no']."</a> Click To Download";
						header('Location:../billing_list.php');
						exit();
					}else{
						$_SESSION['admin_error'] = "Billing Detail Update in error...";
						header('Location:../billing.php');
						exit();
					}
				}else{
					$_SESSION['admin_error'] = "Gatepass Not Generated Conatct Sub-Admin...";
					header('Location:../billing.php');
					exit();
				}
			}else{
				$_SESSION['admin_error'] = "Customer Detail Not Added Contact To Cashier...";
				header('Location:../billing.php');
				exit();
			}
		}else{
			$_SESSION['admin_error'] = "This Chassis No. not found. Chassis NO is = ".$chassis_no."";
			header('Location:../billing.php');
			exit();
		}
	}
	else if(isset($_POST['type']) && ($_POST['type']=="billing_delete"))
	{
		$id = isset($_POST['mid']) ? $_POST['mid'] : 0;
		// bill find
		$select = $db->getRow("SELECT * FROM ".$table1." where `billing_id`=?",array($id));
		if(!empty($select))
		{
			// store data in deleted
			deletedRecord('billing',$id,'');
			// Product service find in 
			$service = $db->getRows("SELECT * FROM `product_service` where `product_id`=?",array($select['product_id']));
			if(!empty($service))
			{
				foreach($service as $value)
				{
					// Service Delete
					$serviceDelete = $db->deleteRow("DELETE FROM `product_service` where `product_service_id`=?",array($value['product_service_id']));
				}
			}
			// Update Main Product page in status 3 mins bill genareted
			$update = $db->updateRow("update ".$table." set `status`=?,`sale`=?,`updated_at`=NOW() where `product_id`=?",array(3,0,$select['product_id']));
			// RTO Delete
			$rtoDelete = $db->deleteRow("DELETE FROM `rto` where `product_id`=?",array($select['product_id']));
			// Bill Delete
			$delete = $db->deleteRow("DELETE FROM ".$table1." where `billing_id`=?",array($id));
			if($delete){
				echo 1;
				exit();
			}else{
				echo 0;
				exit();
			}
		}
		echo 1;
		exit();
		
	}
	else if(isset($_POST['type']) && ($_POST['type']=="service_delete"))
	{
		$id = isset($_POST['mid']) ? $_POST['mid'] : 0;
		// Delete Image 
		$select = $db->getRow("SELECT * FROM `product_service` where `product_service_id`=?",array($id));
		if(!empty($select['service_barcode_imgPath']))
		{
			if(file_exists(BARCODE_SERVICE_PATH_UPLOAD.$select['service_barcode_imgPath']))
				unlink(BARCODE_SERVICE_PATH_UPLOAD.$select['service_barcode_imgPath']);
		
			// Update Billing in service one minus minus
			$updateBilling = $db->updateRow("update ".$table1." set `service`=`service`-1, `updated_at`=NOW() where `product_id`=?",array($select['product_id']));
			
			$delete = $db->deleteRow("DELETE FROM `product_service` where `product_service_id`=?",array($id));
			
			if($delete){
				echo 1;
				exit();
			}else{
				echo 0;
				exit();
			}
		}else{
			echo "Service Id not found Please hard refress to continue...";
			exit();
		}
	}
	else
	{
		header('Location:../billing.php');
		exit();
	}
}else{
	header('Location:../billing.php');
	exit();
}
?>