<?php include_once('../include/comman_model_session.php');
include_once("../config/PDO.php");
if($_POST){
	extract($_POST);
	
	$db = new db();
	include('../include/functions.php');
	$table = "product";
	$table1 = "veihicle";
	$table2 = "product_pdi";
	
	if(isset($_POST['type']) && ($_POST['type']=="add"))
	{
		$chassis_no = isset($_POST['chassis_no']) ? $db->string_format($_POST['chassis_no'],false,'upper') : '';
		$eng_no = isset($_POST['eng_no']) ? $db->string_format($_POST['eng_no'],false,'upper') : '';
		$model_code = isset($_POST['model_code']) ? $db->string_format($_POST['model_code'],true,'upper') : '';
		$color_code = isset($_POST['color_code']) ? $db->string_format($_POST['color_code'],true,'upper') : '';
		$model = isset($_POST['model']) ? $db->string_format($_POST['model'],true,'upper') : '';
		$color = isset($_POST['color']) ? $db->string_format($_POST['color'],false,'upper') : '';
		$variant = isset($_POST['variant']) ? $db->string_format($_POST['variant'],true,'upper') : '';
		
		$res = $db->getRow("SELECT * FROM ".$table." where `chassis_no`=?",array($chassis_no));
		
		if($res){
			$_SESSION['admin_error'] = "Product All Ready Exisest...";
			header('Location:../product.php');
			exit();
		}
		else
		{
			
			$result = $db->insertRow("INSERT INTO ".$table." (`chassis_no`,`eng_no`,`model_code`,`color_code`,`model`,`color`,`variant`,`created_at`,`updated_at`)VALUES(?,?,?,?,?,?,?,NOW(),NOW())",array($chassis_no,$eng_no,$model_code,$color_code,$model,$color,$variant));
			
			$productPdi = $db->insertRow("INSERT INTO ".$table2." (`product_id`,`created_at`,`updated_at`)VALUES(?,NOW(),NOW())",array($result));
			
			if($result){
				$_SESSION['admin_success'] = "Product Add Successfully...";
				header('Location:../product.php');
				exit();
			}else{
				$_SESSION['admin_error'] = "Product add in Error...";
				header('Location:../product.php');
				exit();
			}
		}
	}
	else if(isset($_POST['type']) && ($_POST['type']=="edit"))
	{
		$id = isset($_POST['id']) ? $_POST['id'] : '';
		
		//$chassis_no = isset($_POST['chassis_no']) ? $db->string_format($_POST['chassis_no'],false,'upper') : '';
		$eng_no = isset($_POST['eng_no']) ? $db->string_format($_POST['eng_no'],false,'upper') : '';
		$model_code = isset($_POST['model_code']) ? $db->string_format($_POST['model_code'],true,'upper') : '';
		$color_code = isset($_POST['color_code']) ? $db->string_format($_POST['color_code'],true,'upper') : '';
		$model = isset($_POST['model']) ? $db->string_format($_POST['model'],true,'upper') : '';
		$color = isset($_POST['color']) ? $db->string_format($_POST['color'],false,'upper') : '';
		$variant = isset($_POST['variant']) ? $db->string_format($_POST['variant'],true,'upper') : '';
		
		$update = $db->updateRow("update ".$table." set `model_code`=?,`color_code`=?,`model`=?,`color`=?,`variant`=?,`eng_no`=?,`updated_at`=NOW() where `product_id`=?",array($model_code,$color_code,$model,$color,$variant,$eng_no,$id));
		
		if(!$update){
			$_SESSION['admin_success'] = "Product Update Successfully...";
			header('Location:../product_list.php');
			exit();
		}else{
			$_SESSION['admin_error'] = "Product Update in Error...";
			header('Location:../product_list.php');
			exit();
		}
	}
	else if(isset($_POST['type']) && ($_POST['type']=="delete"))
	{
		$id = isset($_POST['mid']) ? $_POST['mid'] : 0;
		// find Product
		$select = $db->getRow("SELECT * FROM ".$table." where `product_id`=?",array($id));
		if(!empty($select))
		{
			// store data in deleted
			deletedRecord('product',$id,'');
			// Find Cashier 
			$cusDetailSelect = $db->getRow("SELECT * FROM `customer_detail` where `product_id`=?",array($select['product_id']));
			if(!empty($cusDetailSelect))
			{
				// store data in deleted
				deletedRecord('cashier',$cusDetailSelect['customer_detail_id'],'');
				// Find gatepass
				$gateSelect = $db->getRow("SELECT * FROM `gatepass` where `customer_detail_id`=?",array($cusDetailSelect['customer_detail_id']));
				if(!empty($gateSelect))
				{
					// store data in deleted 
					deletedRecord('gatepass',$gateSelect['gatepass_id'],'');
					// bill find
					$billSelect = $db->getRow("SELECT * FROM `billing` where `gatepass_id`=?",array($gateSelect['gatepass_id']));
					if(!empty($billSelect))
					{
						// store data in deleted 
						deletedRecord('billing',$billSelect['billing_id'],'');
						// Product service find in 
						$serviceSelect = $db->getRows("SELECT * FROM `product_service` where `product_id`=?",array($billSelect['product_id']));
						if(!empty($serviceSelect))
						{
							foreach($serviceSelect as $value)
							{
								// Service Delete
								$serviceDelete = $db->deleteRow("DELETE FROM `product_service` where `product_service_id`=?",array($value['product_service_id']));
							}
						}
						// Bill Delete
						$billDelete = $db->deleteRow("DELETE FROM `billing` where `gatepass_id`=?",array($gateSelect['gatepass_id']));
					}
					// Delete gatepass
					$gateDelete = $db->deleteRow("DELETE FROM `gatepass` where `customer_detail_id`=?",array($cusDetailSelect['customer_detail_id']));
				}
				// customer payment find
				$cusPaySelect = $db->getRows("SELECT * FROM `customer_payment` where `customer_detail_id`=?",array($id));
				if(!empty($cusPaySelect))
				{
					foreach($cusPaySelect as $value1){
						// Delete Customer Payment
						$cusPayDelete = $db->deleteRow("DELETE FROM `customer_payment` where `customer_payment_id`=?",array($value1['customer_payment_id']));
					}
				}
				// Prodcut Price delete
				$proPriceDelete = $db->deleteRow("DELETE FROM `product_price` where `product_id`=?",array($select['product_id']));
				// Delete Finance
				$financeDelete = $db->deleteRow("DELETE FROM `finance` where `product_id`=?",array($select['product_id']));
				// Delete Exchange
				$exchangeDelete = $db->deleteRow("DELETE FROM `exchange` where `product_id`=?",array($select['product_id']));
				// Delete cashier
				$cashierDelete = $db->deleteRow("DELETE FROM `customer_detail` where `product_id`=?",array($select['product_id']));
			}
			// Delete Cashier Add 
			$cashierAddDelete = $db->deleteRow("DELETE FROM `cashier` where `product_id`=?",array($select['product_id']));
			// Delete Dealer 
			$dealerDelete = $db->deleteRow("DELETE FROM `dealer` where `product_id`=?",array($select['product_id']));
			// Delete product pdi
			$pdiDelete = $db->deleteRow("DELETE FROM `product_pdi` where `product_id`=?",array($select['product_id']));
			// RTO Delete
			$rtoDelete = $db->deleteRow("DELETE FROM `rto` where `product_id`=?",array($select['product_id']));
			// Delete Product
			$delete = $db->deleteRow("DELETE FROM ".$table." where `product_id`=?",array($id));
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
	else if(isset($_POST['type']) && ($_POST['type']=="status"))
	{
		$id = $_POST['mid'];
		$status = $_POST['status'];
		$update = $db -> updateRow("update ".$table." set `status`=? where `veihicle_id`=?",array($status,$id));
		
		if($update){
			echo 1;
			exit();
		}else{
			echo 0;
			exit();
		}
		exit();
	}
	else if(isset($_POST['type']) && ($_POST['type']=="qrcode"))
	{
		include "../qrcode/qrlib.php";
		$level = "L";
		$size = 4;
		//remember to sanitize user input in real-life solution !!!
		$errorCorrectionLevel = 'L';
		if (isset($level) && in_array($level, array('L','M','Q','H')))
			$errorCorrectionLevel = $level;    

		$matrixPointSize = 4;
		if (isset($size))
			$matrixPointSize = min(max((int)$size, 1), 10);

		$select = $db->getRows("SELECT * FROM ".$table." where `qr_imgPath`=?",array(0));
		foreach($select as $value)
		{
			if(isset($value['chassis_no'])) 
			{
				$filename = "../images/qrcode/".$value['chassis_no'].'.png';
				$imgPath = $value['chassis_no'].'.png';
				QRcode::png($value['chassis_no'], $filename, $errorCorrectionLevel, $matrixPointSize, 2);    
				
				$update = $db->updateRow("update ".$table." set `qr_imgPath`=? where `product_id`=?",array($imgPath,$value['product_id']));
			}
		}
		
		if(!$update){
			$_SESSION['admin_success'] = "Generate Successfully...";
			header('Location:../generate_qrcode.php');
			exit();
		}else{
			$_SESSION['admin_error'] = "Generate Unsuccessfully...";
			header('Location:../generate_qrcode.php');
			exit();
		}
		exit();
	}
	else if(isset($_POST['type']) && ($_POST['type']=="single_qrcode"))
	{
		include "../qrcode/qrlib.php";
		$level = "L";
		$size = 4;
		$single_qrcode = isset($_POST['single_qrcode']) ? $_POST['single_qrcode'] : '';
		if(!empty($single_qrcode))
		{
			//remember to sanitize user input in real-life solution !!!
			$errorCorrectionLevel = 'L';
			if (isset($level) && in_array($level, array('L','M','Q','H')))
				$errorCorrectionLevel = $level;    

			$matrixPointSize = 4;
			if (isset($size))
				$matrixPointSize = min(max((int)$size, 1), 10);

			$select = $db->getRow("SELECT * FROM ".$table." where `chassis_no`=?",array($single_qrcode));
			if(!empty($select))
			{
				if(isset($select['chassis_no'])) 
				{
					$filename = "../images/qrcode/".$select['chassis_no'].'.png';
					$imgPath = $select['chassis_no'].'.png';
					QRcode::png($select['chassis_no'], $filename, $errorCorrectionLevel, $matrixPointSize, 2);    
					
					$update = $db->updateRow("update ".$table." set `qr_imgPath`=?,`updated_at`=NOW() where `product_id`=?",array($imgPath,$select['product_id']));
					
					if(!$update){
						$_SESSION['admin_success'] = "QR Code Generate Successfully...";
						header('Location:../generate_qrcode.php');
						exit();
					}else{
						$_SESSION['admin_error'] = "QR Code Generate Unsuccessfully...";
						header('Location:../generate_qrcode.php');
						exit();
					}
				}
			}else{
				$_SESSION['admin_error'] = "This Chassis no not Entered in database...";
				header('Location:../generate_qrcode.php');
				exit();
			}
		}else{
			$_SESSION['admin_error'] = "Chassis no not Entered...";
			header('Location:../generate_qrcode.php');
			exit();
		}
		exit();
	}
	else if(isset($_POST['type']) && ($_POST['type']=="upload_excel"))
	{
		$file = isset($_FILES['image']['tmp_name']) ? $_FILES['image']['tmp_name'] : '';
		if(!empty($file))
		{
			$handle = fopen($file, "r");
			$resultTrueArray = $resultFalseArray = array();
			$resultTrue = $resultFalse = 0;
			$flag = true;
			while(($filesop = fgetcsv($handle, 1000, ",")) !== false)
			{
				if($flag){
					$flag = false;
					continue;
				}else{
					$model_code = $filesop[0];
					$model = $filesop[1];
					$variant = $filesop[2];
					$color_code = $filesop[3];
					$color = $filesop[4];
					$chassis_no = $filesop[5];
					$engine_no = $filesop[6];
					
					$select = $db->getRow("SELECT (`chassis_no`) FROM ".$table." where `chassis_no`=?",array($chassis_no));
					if($select){
						$resultFalse++;
						$resultFalseArray[] = $select['chassis_no'];
						$result = "";
					}else{
						$modelFinal = preg_replace('/\s+/',' ',$model);
						$colorFinal = preg_replace('/\s+/',' ',$color);
						$variantFinal = preg_replace('/\s+/',' ',$variant);
						$chassis_noFinal = preg_replace('/\s+/','',$chassis_no);
						$engine_noFinal = preg_replace('/\s+/','',$engine_no);
						
						$result = $db->insertRow("INSERT INTO ".$table." (`model_code`,`color_code`,`model`,`color`,`variant`,`chassis_no`,`eng_no`,`created_at`,`updated_at`)VALUES(?,?,?,?,?,?,?,NOW(),NOW())",array(strtoupper(trim($model_code)),strtoupper(trim($color_code)),strtoupper(trim($modelFinal)),strtoupper(trim($colorFinal)),strtoupper(trim($variantFinal)),strtoupper(trim($chassis_noFinal)),strtoupper(trim($engine_noFinal))));
						// Select Model
						$selectModel = $db->getRow("SELECT (`veihicle_id`) FROM `veihicle` where `name`=?",array($modelFinal));
						if(!empty($selectModel)){
							// Update Product table select model
							$update = $db->updateRow("update ".$table." set `veihicle_id`=? where `product_id`=?",array($selectModel['veihicle_id'],$result));
						}
						$productPdi = $db->insertRow("INSERT INTO ".$table2." (`product_id`,`created_at`,`updated_at`)VALUES(?,NOW(),NOW())",array($result));
						$resultTrue++;
						$resultTrueArray[] = $chassis_no;
					}
				}
			}
			
			if(!empty($resultTrue)){
				$csv_file = $db->upload_image('image',FILE_PATH_UPLOAD,'');
				$_SESSION['s_count'] = "Total ".$resultTrue." Succussfull inserted -- ";
				$_SESSION['s_count'] .= implode(" / ",$resultTrueArray);
			}
			if(!empty($resultFalse)){
				$_SESSION['e_count'] = "Total ".$resultFalse." Allready inserted -- ";
				$_SESSION['e_count'] .= implode(" / ",$resultFalseArray);
			}
			if($result){
				$_SESSION['admin_success'] = "Upload Successfully...";
				header('Location:../product_excel.php');
				exit();
			}else{
				$_SESSION['admin_error'] = "Upload in Error...";
				header('Location:../product_excel.php');
				exit();
			}
		}else{
			$_SESSION['admin_error'] = "no select file...";
			header('Location:../product_excel.php');
			exit();
		}
		exit();
	}
	else if(isset($_POST['type']) && ($_POST['type']=="select_price"))
	{
		$vei_id = $_POST['vei_id'];
		$pro_id = $_POST['pro_id'];

		$update = $db -> updateRow("update ".$table." set `veihicle_id`=? where `product_id`=?",array($vei_id,$pro_id));
		
		if($update){
			echo 1;
			exit();
		}else{
			echo 0;
			exit();
		}
		exit();
	}
	else if(isset($_POST['type']) && ($_POST['type']=="update_pdi"))
	{
		$id = $_POST['mid'];
		
		$sari_gard = isset($_POST['sari_gard']) ? $_POST['sari_gard'] : '';
		$mirror = isset($_POST['mirror']) ? $_POST['mirror'] : '';
		$oil_level = isset($_POST['oil_level']) ? $_POST['oil_level'] : '';
		$breaking = isset($_POST['breaking']) ? $_POST['breaking'] : '';
		$jumper = isset($_POST['jumper']) ? $_POST['jumper'] : '';
		$chain = isset($_POST['chain']) ? $_POST['chain'] : '';
		$air_pressure = isset($_POST['air_pressure']) ? $_POST['air_pressure'] : '';

		$update = $db->updateRow("update ".$table2." set `sari_gard`=?,`mirror`=?,`oil_level`=?,`breaking`=?,`jumper`=?,`chain`=?,`air_pressure`=? where `product_pdi_id`=?",array($sari_gard,$mirror,$oil_level,$breaking,$jumper,$chain,$air_pressure,$id));
		
		if($update){
			echo 1;
			exit();
		}else{
			echo 0;
			exit();
		}
		exit();
	}
	else if(isset($_POST['type']) && ($_POST['type']=="single_barcode"))
	{
		$single_qrcode = isset($_POST['single_qrcode']) ? $_POST['single_qrcode'] : '';
		
		$select = $db->getRow("SELECT * FROM ".$table." where `chassis_no`=?",array($single_qrcode));
		if(!empty($select))
		{
			// For demonstration purposes, get pararameters that are passed in through $_GET or set to the default value
			$text = $single_qrcode;
			$size = "30";
			$orientation = "horizontal";
			$code_type = "code128a";
			$print = true;
			
			// This function call can be copied into your project and can be made from anywhere in your code
			//$barcodeCode = $db->barCode( $text, $size, $orientation, $code_type, $print );
			//$imgFullPath = BARCODE_PATH_UPLOAD.$text.".jpg";
			$imgPath = $text.".png";
			/*
			// Draw barcode to the screen or save in a file
			if($barcodeCode){
				ob_start();
				imagejpeg($barcodeCode,NULL,75);
				$contents =  ob_get_contents();
				//Converting Image DPI to 300DPI                
				$contents = substr_replace($contents, pack("cnn", 1, 203, 203), 20, 10);             
				ob_end_clean();  
				$data = 'data:image/jpeg;base64,'.base64_encode($contents);
				list($type, $data) = explode(';', $data);
				list(, $data)      = explode(',', $data);
				$data = base64_decode($data);
				file_put_contents($imgFullPath, $data);
				//$result = imagejpeg($barcodeCode,$imgFullPath,75);
			}*/
			
			$db->newBarcode($text);
			$update = $db->updateRow("update ".$table." set `barcode_imgPath`=?,`updated_at`=NOW() where `product_id`=?",array($imgPath,$select['product_id']));
			
			if(!$update){
				$_SESSION['admin_success'] = "BarCode Generate Successfully...<a download href='".BARCODE_PATH_DISPLAY.$imgPath."'>Click To Download</a>";
				header('Location:../generate_qrcode.php');
				exit();
			}else{
				$_SESSION['admin_error'] = "BarCode Generate Unsuccessfully...";
				header('Location:../generate_qrcode.php');
				exit();
			}
		}else{
			$_SESSION['admin_error'] = "This Chassis no not Entered in database...";
			header('Location:../generate_qrcode.php');
			exit();
		}
		exit();
	}
	else if(isset($_POST['type']) && ($_POST['type']=="barcode"))
	{
		$resultTrueArray = $resultFalseArray = array();
		$select = $db->getRows("SELECT * FROM ".$table." where `barcode_imgPath`=?",array(0));
		foreach($select as $value)
		{
			if(isset($value['chassis_no'])) 
			{
				// For demonstration purposes, get pararameters that are passed in through $_GET or set to the default value
				$text = $value['chassis_no'];
				$size = "30";
				$orientation = "horizontal";
				$code_type = "code128a";
				$print = true;

				// This function call can be copied into your project and can be made from anywhere in your code
				//$barcodeCode = $db->barCode( $text, $size, $orientation, $code_type, $print );
				//$imgFullPath = BARCODE_PATH_UPLOAD.$text.".jpg";
				$imgPath = $text.".png";
				
				/* Draw barcode to the screen or save in a file
				if($barcodeCode){
					ob_start();
					imagejpeg($barcodeCode,NULL,75);
					$contents =  ob_get_contents();
					//Converting Image DPI to 300DPI                
					$contents = substr_replace($contents, pack("cnn", 1, 203, 203), 13, 5);             
					ob_end_clean();  
					$data = 'data:image/jpeg;base64,'.base64_encode($contents);
					list($type, $data) = explode(';', $data);
					list(, $data)      = explode(',', $data);
					$data = base64_decode($data);
					file_put_contents($imgFullPath, $data);
					//$result = imagejpeg($barcodeCode,$imgFullPath,75);
				}*/
				
				$db->newBarcode($text);
				$update = $db->updateRow("update ".$table." set `barcode_imgPath`=? where `product_id`=?",array($imgPath,$value['product_id']));
				if(!$update){
					$resultTrueArray[] = "<a download href='".BARCODE_PATH_DISPLAY.$imgPath."'>".$value['chassis_no']."</a>";
				}else{
					$resultFalseArray[] = "<a download href='".BARCODE_PATH_DISPLAY.$imgPath."'>".$value['chassis_no']."</a>";
				}
			}
		}
		
		if(!empty($resultTrueArray)){
			$_SESSION['s_count'] = implode(" / ",$resultTrueArray);
			$_SESSION['s_count'] .= " Click To Download";
		}
		if(!empty($resultFalseArray)){
			$_SESSION['e_count'] = implode(" / ",$resultFalseArray);
		}
		if(!$update){
			$_SESSION['admin_success'] = "Generate Successfully...";
			header('Location:../generate_qrcode.php');
			exit();
		}else{
			$_SESSION['admin_error'] = "Generate Unsuccessfully...";
			header('Location:../generate_qrcode.php');
			exit();
		}
		exit();
	}
	else if(isset($_POST['type']) && ($_POST['type']=="direct_sale"))
	{
		$search = isset($_POST['search']) ? $_POST['search'] : '';
		$select = $db->getRow("SELECT * FROM ".$table." where `chassis_no`=?",array($search));
		if(!empty($select))
		{
			$update = $db->updateRow("update ".$table." set `sale`=?,`updated_at`=NOW() where `product_id`=?",array(1,$select['product_id']));
			
			if(!$update){
				$_SESSION['admin_success'] = "Product Sale Successfully...";
				header('Location:../product_direct_sale.php');
				exit();
			}else{
				$_SESSION['admin_error'] = "Product Sale in Error...";
				header('Location:../product_direct_sale.php');
				exit();
			}
		}else{
			$_SESSION['admin_error'] = "This Chassis no not Entered in database...";
			header('Location:../product_direct_sale.php');
			exit();
		}
	}
	else
	{
		echo 0;
		exit();
	}
}else{
	echo 0;
	exit();
}
?>