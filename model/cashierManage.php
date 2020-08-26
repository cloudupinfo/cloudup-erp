<?php include_once('../include/comman_model_session.php');
include_once("../config/PDO.php");

if($_POST){
	extract($_POST);
	
	$db = new db();
	include('../include/functions.php');
	$table = "product";
	$table1 = "customer_detail";
	$table3 = "product_price";
	$table4 = "customer_payment";
	
	if(isset($_POST['type']) && ($_POST['type']=="cashier_search"))
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
			header('Location:../cashier_chassis_view.php?aid='.$select['chassis_no'].'');
			exit();
		}else{
			$_SESSION['admin_error'] = "Chassis no not found please enter properly...";
			header('Location:../cashier.php');
			exit();
		}
	}
	else if(isset($_POST['type']) && ($_POST['type']=="add"))
	{
		$admin_id = isset($_POST['admin_id']) ? $_POST['admin_id'] : '';
		$product_id = isset($_POST['product_id']) ? $_POST['product_id'] : '';
		
		$product = $db->getRow("SELECT (`customer_detail_id`) FROM ".$table1." where `product_id`=?",array($product_id));
		if(empty($product))
		{
			$salesman_id = isset($_POST['salesman_id']) ? $_POST['salesman_id'] : '';
			$name = isset($_POST['name']) ? $db->string_format($_POST['name'],true,'upper') : '';
			$mobile = isset($_POST['mobile']) ? $_POST['mobile'] : '';
			$street_add1 = isset($_POST['street_add1']) ? $_POST['street_add1'] : '';
			$street_add2 = isset($_POST['street_add2']) ? $_POST['street_add2'] : '';
			$city = isset($_POST['city']) ? $_POST['city'] : '';
			$country = isset($_POST['country']) ? $_POST['country'] : '';
			$case_type = isset($_POST['case_type']) ? $_POST['case_type'] : '';
			
			$bank_name = isset($_POST['bank_name']) ? $db->string_format($_POST['bank_name'],true,'upper') : '';
			$cheque_no = isset($_POST['cheque_no']) ? $_POST['cheque_no'] : '';
			$cheque_date = isset($_POST['cheque_date']) ? $_POST['cheque_date'] : '';
			$dd_bank_name = isset($_POST['dd_bank_name']) ? $db->string_format($_POST['dd_bank_name'],true,'upper') : '';
			$dd_no = isset($_POST['dd_no']) ? $_POST['dd_no'] : '';
			$dd_date = isset($_POST['dd_date']) ? $_POST['dd_date'] : '';
			$neft_bank_name = isset($_POST['neft_bank_name']) ?  $db->string_format($_POST['neft_bank_name'],true,'upper') : '';
			$neft_ac_no = isset($_POST['neft_ac_no']) ? $_POST['neft_ac_no'] : '';
			$neft_ifsc_code = isset($_POST['neft_ifsc_code']) ?  $db->string_format($_POST['neft_ifsc_code'],false,'upper') : '';
			$neft_holder_name = isset($_POST['neft_holder_name']) ?  $db->string_format($_POST['neft_holder_name'],true,'upper') : '';
			
			$price = isset($_POST['price']) ? $_POST['price'] : '';
			$pending = isset($_POST['pending']) ? $_POST['pending'] : '';
			$amount_in_word = isset($_POST['amount_in_word']) ? $_POST['amount_in_word'] : '';
			$key_no = isset($_POST['key_no']) ? $_POST['key_no'] : '';
			$remark = isset($_POST['remark']) ? $_POST['remark'] : '';
			
			$created_at = isset($_POST['currentDate']) ? date("Y-m-d H:i:s",strtotime($_POST['currentDate'].date("H:i:s"))) : date('Y-m-d H:i:s');
			
			$vehical_price = isset($_POST['vehical_price']) ? $_POST['vehical_price'] : '';
			$rto = isset($_POST['rto']) ? $_POST['rto'] : '';
			$rtoPrice = isset($_POST['rtoPrice']) ? $_POST['rtoPrice'] : '';
			$rtoTotal = $rto."/".$rtoPrice;
			
			$access_no = isset($_POST['access_no']) ? $_POST['access_no'] : '';
			$side_stand = isset($_POST['side_stand']) ? $_POST['side_stand'] : '';
			$foot_rest = isset($_POST['foot_rest']) ? $_POST['foot_rest'] : '';
			$leg_guard = isset($_POST['leg_guard']) ? $_POST['leg_guard'] : '';
			$chrome_set = isset($_POST['chrome_set']) ? $_POST['chrome_set'] : '';
			$access = isset($_POST['access']) ? $_POST['access'] : '';

			$no_plate_fitting = isset($_POST['no_plate_fitting']) ? $_POST['no_plate_fitting'] : '';
			$amc = isset($_POST['amc']) ? $_POST['amc'] : '';
			$rmc_tax = isset($_POST['rmc_tax']) ? $_POST['rmc_tax'] : '';
			$ex_warranty = isset($_POST['ex_warranty']) ? $_POST['ex_warranty'] : '';
			
			$insurance = isset($_POST['insurance']) ? $_POST['insurance'] : '';
			$insurancePrice = isset($_POST['insurancePrice']) ? $_POST['insurancePrice'] : '';
			$insuranceTotal = $insurance."/".$insurancePrice;
			
			//Advance Booking
			$advance_id = isset($_POST['advance_id']) ? $_POST['advance_id'] : 0;
			
			$discount = isset($_POST['discount']) ? $_POST['discount'] : '';
			$main_total = isset($_POST['main_total']) ? $_POST['main_total'] : '';
			
			// Exchange / Finance
			$exchange_finance = isset($_POST['exchange_finance']) ? $_POST['exchange_finance'] : 'No';
			// Exchange
			$exchange = isset($_POST['exchange']) ? $_POST['exchange'] : 'No';
			if($exchange=="Yes" || $exchange=="yes"){
				$exchange_amount = isset($_POST['exchange_amount']) ? $_POST['exchange_amount'] : '';
				$exchange_veihicle_no = isset($_POST['exchange_veihicle_no']) ? $_POST['exchange_veihicle_no'] : '';
			}
			// DD Finance
			$dd_finance = isset($_POST['dd_finance']) ? $_POST['dd_finance'] : 'No';
			if($dd_finance=="Yes" || $dd_finance=="yes"){
				$dd_finance_amount = isset($_POST['dd_finance_amount']) ? $_POST['dd_finance_amount'] : '0';
				$finance = "Yes";
				$finance_bank = $dd_bank_name;
				$dp_amount = $price;
				$finance_amount = $dd_finance_amount;
				$finance_status = 1;
				$price += $dd_finance_amount;
			}else{
				// Finance
				$finance = isset($_POST['finance']) ? $_POST['finance'] : 'No';
				if($finance=="Yes" || $finance=="yes"){
					$finance_bank = isset($_POST['finance_bank']) ? $_POST['finance_bank'] : '';
					$dp_amount = isset($_POST['dp_amount']) ? $_POST['dp_amount'] : '';
					$finance_amount = isset($_POST['finance_amount']) ? $_POST['finance_amount'] : '';
				}
				$finance_status = 0;
			}
			// Advance Booking is DP
			$advance_dp = isset($_POST['advance_dp']) ? $_POST['advance_dp'] : 'No';
			if($advance_dp=="Yes" || $advance_dp=="yes"){
				$advanceSelect = $db->getRow("SELECT * FROM `advance` where `advance_id`=?",array($advance_id));
				// Advance Booking Payment
				$advancePayment = $db->getRows("SELECT * FROM `advance_payment` where `advance_id`=?",array($advanceSelect['advance_id']));
				$advancePaymentPrice = 0;
				foreach($advancePayment as $advancePaymentValue){
					$advancePaymentPrice += $advancePaymentValue['price'];
				}
				$dp_amount += $advancePaymentPrice;
			}
			
			//Customer Detail Insert Code
			$insert = $db->insertRow("INSERT INTO ".$table1." (`admin_id`,`product_id`,`salesman_id`,`name`,`mobile`,`street_add1`,`street_add2`,`city`,`country`,`remark`,`created_at`,`updated_at`)VALUES(?,?,?,?,?,?,?,?,?,?,?,NOW())",array($admin_id,$product_id,$salesman_id,$name,$mobile,$street_add1,$street_add2,$city,$country,$remark,$created_at));
			
			if($insert)
			{
				// Exchange Insert
				if($exchange=="Yes" || $exchange=="yes"){
					$exchange = $db->insertRow("INSERT INTO `exchange` (`product_id`,`customer_detail_id`,`amount`,`veihicle_no`,`updated_at`)VALUES(?,?,?,?,NOW())",array($product_id,$insert,$exchange_amount,$exchange_veihicle_no));
				}
				// Finance Insert
				if($finance=="Yes" || $finance=="yes"){
					// HPA finaly remove
					//$price += 200;
					$finance = $db->insertRow("INSERT INTO `finance` (`product_id`,`admin_id`,`finance_amount`,`dp_amount`,`bank`,`status`,`updated_at`)VALUES(?,?,?,?,?,?,NOW())",array($product_id,$admin_id,$finance_amount,$dp_amount,$finance_bank,$finance_status));
				}
				//Product Price Insert Code
				$insertProPrice = $db->insertRow("INSERT INTO ".$table3." (`product_id`,`advance_id`,`price`,`rto`,`no_plate_fitting`,`rmc_tax`,`access_no`,`side_stand`,`foot_rest`,`leg_guard`,`chrome_set`,`access`,`amc`,`ex_warranty`,`insurance`,`discount`,`dd_finance`,`exchange_finance`,`advance_dp`,`pending`,`total`,`updated_at`)VALUES(?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,NOW())",array($product_id,$advance_id,$vehical_price,$rtoTotal,$no_plate_fitting,$rmc_tax,$access_no,$side_stand,$foot_rest,$leg_guard,$chrome_set,$access,$amc,$ex_warranty,$insuranceTotal,$discount,$dd_finance,$exchange_finance,$advance_dp,$pending,$main_total));
				
				//Customer Payment Type Insert Code
				$insertPayType = $db->insertRow("INSERT INTO ".$table4." (`admin_id`,`customer_detail_id`,`case_type`,`price`,`amount_in_word`,`bank_name`,`cheque_no`,`cheque_date`,`dd_bank_name`,`dd_no`,`dd_date`,`neft_ac_no`,`neft_bank_name`,`neft_ifsc_code`,`neft_holder_name`,`updated_at`)VALUES(?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,NOW())",array($admin_id,$insert,$case_type,$price,$amount_in_word,$bank_name,$cheque_no,$cheque_date,$dd_bank_name,$dd_no,$dd_date,$neft_ac_no,$neft_bank_name,$neft_ifsc_code,$neft_holder_name));

				// Advance Booking Close 1
				if($advance_id!=0){
					$update = $db->updateRow("update `advance` set `status`=? where `advance_id`=?",array(1,$advance_id));
				}
				// Main Product Table Status Change '2' = case done AND Key No Add
				$update = $db->updateRow("update ".$table." set `key_no`=?,`status`=? where `product_id`=?",array($key_no,2,$product_id));
			}
			
			if($insert){
				$_SESSION['admin_success'] = "Payment Done...";
				header('Location:../cashReceipt/cashReceipt.php?aid='.$insert.'&type='.$_POST['print_type']);
				exit();
			}else{
				$_SESSION['admin_error'] = "Payment not done...";
				header('Location:../cashier.php');
				exit();
			}
		}else{
			$_SESSION['admin_error'] = "This Chassis no already purchesed. Chassis NO is = ".$product['chassis_no']."";
			header('Location:../cashier.php');
			exit();
		}
		exit();
	}
	else if(isset($_POST['type']) && ($_POST['type']=="edit"))
	{
		$id = isset($_POST['id']) ? $_POST['id'] : '';
		
		$admin_id = isset($_POST['admin_id']) ? $_SESSION['admin_id'] : $_SESSION['admin_id'];
		$product_id = isset($_POST['product_id']) ? $_POST['product_id'] : 0;
		
		$product = $db->getRow("SELECT (`customer_detail_id`) FROM ".$table1." where `product_id`=?",array($product_id));
		if(!empty($product))
		{
			$case_type = isset($_POST['case_type']) ? $_POST['case_type'] : '';
			$bank_name = isset($_POST['bank_name']) ? $db->string_format($_POST['bank_name'],true,'upper') : '';
			//$bank_ifsc = isset($_POST['bank_ifsc']) ? $_POST['bank_ifsc'] : '';
			$cheque_no = isset($_POST['cheque_no']) ? $_POST['cheque_no'] : '';
			$cheque_date = isset($_POST['cheque_date']) ? $_POST['cheque_date'] : '';
			$dd_bank_name = isset($_POST['dd_bank_name']) ? $db->string_format($_POST['dd_bank_name'],true,'upper') : '';
			//$dd_bank_ifsc = isset($_POST['dd_bank_ifsc']) ? $_POST['dd_bank_ifsc'] : '';
			$dd_no = isset($_POST['dd_no']) ? $_POST['dd_no'] : '';
			$dd_date = isset($_POST['dd_date']) ? $_POST['dd_date'] : '';
			$neft_bank_name = isset($_POST['neft_bank_name']) ? $db->string_format($_POST['neft_bank_name'],true,'upper') : '';
			$neft_ac_no = isset($_POST['neft_ac_no']) ? $_POST['neft_ac_no'] : '';
			$neft_ifsc_code = isset($_POST['neft_ifsc_code']) ? $db->string_format($_POST['neft_ifsc_code'],false,'upper') : '';
			$neft_holder_name = isset($_POST['neft_holder_name']) ? $db->string_format($_POST['neft_holder_name'],true,'upper') : '';
			
			$price = isset($_POST['price']) ? $_POST['price'] : '';
			$pending = isset($_POST['pending']) ? $_POST['pending'] : '';
			$amount_in_word = isset($_POST['amount_in_word']) ? $_POST['amount_in_word'] : '';
			$remark = isset($_POST['remark']) ? $_POST['remark'] : '';
			
			$pendind_amount = isset($_POST['pendind_amount']) ? $_POST['pendind_amount'] : '';
			$pendind_amount -= $price;
			
			// Exchange
			$exchange = isset($_POST['exchange']) ? $_POST['exchange'] : 'No';
			$exchange_id = isset($_POST['exchange_id']) ? $_POST['exchange_id'] : '';
			if($exchange=="Yes"){
				$exchange_amount = isset($_POST['exchange_amount']) ? $_POST['exchange_amount'] : '';
				$exchange_veihicle_no = isset($_POST['e	xchange_veihicle_no']) ? $_POST['exchange_veihicle_no'] : '';
			}else{
				$exchange_amount = 0;
			}
			// Finance
			$finance = isset($_POST['finance']) ? $_POST['finance'] : 'No';
			if($finance=="Yes"){
				$finance_bank = isset($_POST['finance_bank']) ? $_POST['finance_bank'] : '';
				$dp_amount = isset($_POST['dp_amount']) ? $_POST['dp_amount'] : '';
				$finance_amount = isset($_POST['finance_amount']) ? $_POST['finance_amount'] : '';
			}else{
				$finance_amount = $dp_amount = 0;
			}
			$created_at = isset($_POST['currentDate']) ? date("Y-m-d H:i:s",strtotime($_POST['currentDate'].date("H:i:s"))) : date('Y-m-d H:i:s');

			$update = $db->updateRow("update ".$table1." set `remark`=?,`created_at`=?,`updated_at`=NOW() where `customer_detail_id`=?",array($remark,$created_at,$id));
			
			// Exchange Insert OR Edit
			if($exchange=="Yes"){
				if(!empty($exchange_id)){
					$updateExchange = $db->updateRow("update `exchange` set `amount`=?,`veihicle_no`=?,`updated_at`=NOW() where `exchange_id`=?",array($exchange_amount,$exchange_veihicle_no,$exchange_id));
				}else{
					$exchange = $db->insertRow("INSERT INTO `exchange` (`product_id`,`customer_detail_id`,`amount`,`veihicle_no`,`updated_at`)VALUES(?,?,?,?,NOW())",array($product_id,$id,$exchange_amount,$exchange_veihicle_no));
				}
			}
			// Finance Insert OR Edit
			if($finance=="Yes"){
				if(!empty($finance_id)){
					$updateFinance = $db->updateRow("update `finance` set `finance_amount`=?,`dp_amount`=?,`bank`=?,`updated_at`=NOW() where `finance_id`=?",array($finance_amount,$dp_amount,$finance_bank,$finance_id));
				}else{
					$finance = $db->insertRow("INSERT INTO `finance` (`product_id`,`admin_id`,`finance_amount`,`dp_amount`,`bank`,`updated_at`)VALUES(?,?,?,?,?,NOW())",array($product_id,$admin_id,$finance_amount,$dp_amount,$finance_bank));
				}
			}
			
			// Product Price
			$product_price = $db->getRow("SELECT * FROM ".$table3." where `product_id`=?",array($customer['product_id']));
			
			$finalTotal = $product_price['total']+$price+$exchange_amount+$finance_amount;
			
			//Product Price Update Code
			$updateProPrice = $db->updateRow("update ".$table3." set `pending`=?,`total`=?,`updated_at`=NOW() where `product_id`=?",array($pending,$finalTotal,$product_id));
			
			//Customer Payment Type Insert Code
			$insertPayType = $db->insertRow("INSERT INTO ".$table4." (`admin_id`,`customer_detail_id`,`case_type`,`price`,`amount_in_word`,`bank_name`,`cheque_no`,`cheque_date`,`dd_bank_name`,`dd_no`,`dd_date`,`neft_ac_no`,`neft_bank_name`,`neft_ifsc_code`,`neft_holder_name`,`updated_at`)VALUES(?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,NOW())",array($admin_id,$id,$case_type,$price,$amount_in_word,$bank_name,$cheque_no,$cheque_date,$dd_bank_name,$dd_no,$dd_date,$neft_ac_no,$neft_bank_name,$neft_ifsc_code,$neft_holder_name));
			
			if(!$update){
				$_SESSION['admin_success'] = "Customer Detail Update Sussessfully...";
				header('Location:../cashReceipt/cashReceipt.php?aid='.$id.'&type='.$_POST['print_type']);
				exit();
			}else{
				$_SESSION['admin_error'] = "Customer Detail Update in error...";
				header('Location:../cashier.php');
				exit();
			}
			exit();
		}else{
			$_SESSION['admin_error'] = "This Chassis no already purchesed. Chassis NO is = ".$product['chassis_no']."";
			header('Location:../cashier.php');
			exit();
		}
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
	else if(isset($_POST['type']) && ($_POST['type']=="cashier_add"))
	{
		$admin_id = isset($_POST['admin_id']) ? $_SESSION['admin_id'] : $_SESSION['admin_id'];
		$payment_type = isset($_POST['payment_type']) ? $_POST['payment_type'] : '';
		$chassis_no = isset($_POST['chassis_no']) ? $_POST['chassis_no'] : '';
		$branch = isset($_POST['branch']) ? $_POST['branch'] : 'Main Branch';
		
		if(!empty($chassis_no))
		{
			$product = $db->getRow("SELECT `chassis_no`,`product_id` FROM `product` where `chassis_no`=?",array($chassis_no));
			if(!empty($product))
			{
				$product_id = $product['product_id'];
				// check this chassis no in exchange or not
				$exchange = $db->getRow("SELECT * FROM `exchange` where `product_id`=?",array($product['product_id']));
				if(empty($exchange)){
					$_SESSION['admin_error'] = "This Chassis No Not in Exchange Find Onther Chasis No...";
					header('Location:../cashier_add.php');
					exit();
				}else{
					// Update Exchange Table
					$exchangeUpdate = $db->updateRow("update `exchange` set `status`=? where `product_id`=?",array(1,$exchange['product_id']));
				}
			}else{
				$_SESSION['admin_error'] = "Please Enter Right Chassis No...";
				header('Location:../cashier_add.php');
				exit();
			}
		}else{
			$product_id = 0;
		}
		
		$cash_type = isset($_POST['cash_type']) ? $_POST['cash_type'] : '';
			
		$bank_name = isset($_POST['bank_name']) ? $db->string_format($_POST['bank_name'],true,'upper') : '';
		$cheque_no = isset($_POST['cheque_no']) ? $_POST['cheque_no'] : '';
		$cheque_date = isset($_POST['cheque_date']) ? $_POST['cheque_date'] : '';
		$dd_bank_name = isset($_POST['dd_bank_name']) ? $db->string_format($_POST['dd_bank_name'],true,'upper') : '';
		$dd_no = isset($_POST['dd_no']) ? $_POST['dd_no'] : '';
		$dd_date = isset($_POST['dd_date']) ? $_POST['dd_date'] : '';
		$neft_bank_name = isset($_POST['neft_bank_name']) ? $db->string_format($_POST['neft_bank_name'],true,'upper') : '';
		$neft_ac_no = isset($_POST['neft_ac_no']) ? $_POST['neft_ac_no'] : '';
		$neft_ifsc_code = isset($_POST['neft_ifsc_code']) ? $db->string_format($_POST['neft_ifsc_code'],false,'upper') : '';
		$neft_holder_name = isset($_POST['neft_holder_name']) ? $db->string_format($_POST['neft_holder_name'],true,'upper') : '';
		
		$amount = isset($_POST['amount']) ? $_POST['amount'] : '';
		$amount_in_word = isset($_POST['amount_in_word']) ? $_POST['amount_in_word'] : '';
		$remark = isset($_POST['remark']) ? $_POST['remark'] : '';
			
		//Cashier Detail Insert Code
		$insert = $db->insertRow("INSERT INTO `cashier` (`admin_id`,`product_id`,`branch_id`,`type`,`cash_type`,`bank_name`,`cheque_no`,`cheque_date`,`dd_bank_name`,`dd_no`,`dd_date`,`neft_ac_no`,`neft_bank_name`,`neft_ifsc_code`,`neft_holder_name`,`amount`,`amount_in_word`,`remark`,`updated_at`)VALUES(?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,NOW())",array($admin_id,$product_id,$branch,$payment_type,$cash_type,$bank_name,$cheque_no,$cheque_date,$dd_bank_name,$dd_no,$dd_date,$neft_ac_no,$neft_bank_name,$neft_ifsc_code,$neft_holder_name,$amount,$amount_in_word,$remark));
			
		if($insert){
			$_SESSION['admin_success'] = "Cash Add Done...";
			header('Location:../cashReceipt/receipt.php?aid='.$insert.'&type=Original');
			exit();
		}else{
			$_SESSION['admin_error'] = "Cash Add not done...";
			header('Location:../cashier_add.php');
			exit();
		}
	}
	else if(isset($_POST['type']) && ($_POST['type']=="cashier_edit"))
	{
		$id = isset($_POST['id']) ? $_POST['id'] : '';
		
		$admin_id = isset($_POST['admin_id']) ? $_SESSION['admin_id'] : $_SESSION['admin_id'];
		$payment_type = isset($_POST['payment_type']) ? $_POST['payment_type'] : '';
		$chassis_no = isset($_POST['chassis_no']) ? $_POST['chassis_no'] : '';
		$branch = isset($_POST['branch']) ? $_POST['branch'] : 'Main Branch';
		
		$cash_type = isset($_POST['cash_type']) ? $_POST['cash_type'] : '';
		
		$bank_name = isset($_POST['bank_name']) ? $db->string_format($_POST['bank_name'],true,'upper') : '';
		$cheque_no = isset($_POST['cheque_no']) ? $_POST['cheque_no'] : '';
		$cheque_date = isset($_POST['cheque_date']) ? $_POST['cheque_date'] : '';
		$dd_bank_name = isset($_POST['dd_bank_name']) ? $db->string_format($_POST['dd_bank_name'],true,'upper') : '';
		$dd_no = isset($_POST['dd_no']) ? $_POST['dd_no'] : '';
		$dd_date = isset($_POST['dd_date']) ? $_POST['dd_date'] : '';
		$neft_bank_name = isset($_POST['neft_bank_name']) ? $db->string_format($_POST['neft_bank_name'],true,'upper') : '';
		$neft_ac_no = isset($_POST['neft_ac_no']) ? $_POST['neft_ac_no'] : '';
		$neft_ifsc_code = isset($_POST['neft_ifsc_code']) ? $db->string_format($_POST['neft_ifsc_code'],false,'upper') : '';
		$neft_holder_name = isset($_POST['neft_holder_name']) ? $db->string_format($_POST['neft_holder_name'],true,'upper') : '';
		
		$amount = isset($_POST['amount']) ? $_POST['amount'] : '';
		$amount_in_word = isset($_POST['amount_in_word']) ? $_POST['amount_in_word'] : '';
		$remark = isset($_POST['remark']) ? $_POST['remark'] : '';
		
		$update = $db->updateRow("update `cashier` set `branch_id`=?,`cash_type`=?,`amount`=?,`amount_in_word`=?,`bank_name`=?,`cheque_no`=?,`cheque_date`=?,`dd_bank_name`=?,`dd_no`=?,`dd_date`=?,`neft_ac_no`=?,`neft_bank_name`=?,`neft_ifsc_code`=?,`neft_holder_name`=?,`remark`=?,`updated_at`=NOW() where `cashier_id`=?",array($branch,$cash_type,$amount,$amount_in_word,$bank_name,$cheque_no,$cheque_date,$dd_bank_name,$dd_no,$dd_date,$neft_ac_no,$neft_bank_name,$neft_ifsc_code,$neft_holder_name,$remark,$id));
		
		if(!$update){
			$_SESSION['admin_success'] = "Cashier Update Sussessfully...";
			header('Location:../cashReceipt/receipt.php?aid='.$id.'&type=Original');
			exit();
		}else{
			$_SESSION['admin_error'] = "Cashier Update in error...";
			header('Location:../cashier_extra_list.php');
			exit();
		}
		exit();
	}
	else if(isset($_POST['type']) && ($_POST['type']=="cashier_delete"))
	{
		$id = isset($_POST['mid']) ? $_POST['mid'] : 0;
		// Find Cashier 
		$select = $db->getRow("SELECT * FROM ".$table1." where `customer_detail_id`=?",array($id));
		if(!empty($select))
		{
			// store data in deleted
			deletedRecord('cashier',$id,'');
			// Find gatepass
			$gateSelect = $db->getRow("SELECT * FROM `gatepass` where `customer_detail_id`=?",array($select['customer_detail_id']));
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
				$gateDelete = $db->deleteRow("DELETE FROM `gatepass` where `customer_detail_id`=?",array($select['customer_detail_id']));
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
			// Prodcut Price find
			$proPriceSelect = $db->getRow("SELECT * FROM `product_price` where `product_id`=?",array($select['product_id']));
			// Advance Booking Status 0
			$advanceUpdate = $db->updateRow("update `advance` set `status`=?,`updated_at`=NOW() where `advance_id`=?",array(0,$proPriceSelect['advance_id']));
			// Prodcut Price delete
			$proPriceDelete = $db->deleteRow("DELETE FROM `product_price` where `product_id`=?",array($select['product_id']));
			// Delete Finance
			$financeDelete = $db->deleteRow("DELETE FROM `finance` where `product_id`=?",array($select['product_id']));
			// Delete Exchange
			$exchangeDelete = $db->deleteRow("DELETE FROM `exchange` where `product_id`=?",array($select['product_id']));
			// RTO Delete
			$rtoDelete = $db->deleteRow("DELETE FROM `rto` where `product_id`=?",array($select['product_id']));
			// Update Main Product page in status 1 mins bill genareted
			$update = $db->updateRow("update ".$table." set `status`=?,`sale`=?,`updated_at`=NOW() where `product_id`=?",array(1,0,$select['product_id']));
			
			// Delete cashier
			$delete = $db->deleteRow("DELETE FROM ".$table1." where `customer_detail_id`=?",array($id));
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
	else if(isset($_POST['type']) && ($_POST['type']=="cashier_extra_delete"))
	{
		$id = isset($_POST['mid']) ? $_POST['mid'] : 0;
		
		// Delete cashier
		$delete = $db->deleteRow("DELETE FROM `cashier` where `cashier_id`=?",array($id));
		if($delete){
			echo 1;
			exit();
		}else{
			echo 0;
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