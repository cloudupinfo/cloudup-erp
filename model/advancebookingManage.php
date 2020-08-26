<?php include_once('../include/comman_model_session.php');
include_once("../config/PDO.php");

if($_POST){
	extract($_POST);
	
	$db = new db();
	include('../include/functions.php');
	$table = "product";
	$table1 = "advance";
	$table2 = "advance_payment";
	
	if(isset($_POST['type']) && ($_POST['type']=="advance_add"))
	{
		$admin_id = isset($_POST['admin_id']) ? $_POST['admin_id'] : '';
		$model = isset($_POST['model']) ? $_POST['model'] : '';
		$color = isset($_POST['color']) ? $db->string_format($_POST['color'],true,'upper') : '';
		
		$salesman_id = isset($_POST['salesman_id']) ? $_POST['salesman_id'] : '';
		$name = isset($_POST['name']) ? $db->string_format($_POST['name'],true,'upper') : '';
		$mobile = isset($_POST['mobile']) ? $_POST['mobile'] : '';
		$city = isset($_POST['city']) ? $_POST['city'] : '';
		$country = isset($_POST['country']) ? $_POST['country'] : '';
		
		$case_type = isset($_POST['case_type']) ? $_POST['case_type'] : '';
		$price = isset($_POST['price']) ? $_POST['price'] : '';
		$amount_in_word = isset($_POST['amount_in_word']) ? $_POST['amount_in_word'] : '';
		
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
		
		$finance = isset($_POST['finance']) ? $_POST['finance'] : '';
		$finance_bank = isset($_POST['finance_bank']) ? $db->string_format($_POST['finance_bank'],true,'upper') : '';
		
		$remark = isset($_POST['remark']) ? $_POST['remark'] : '';
		$created_at = isset($_POST['currentDate']) ? date("Y-m-d H:i:s",strtotime($_POST['currentDate'].date("H:i:s"))) : date('Y-m-d H:i:s');
		
		//$test_ride = isset($_POST['test_ride']) ? $_POST['test_ride'] : '';
		//$book_type = isset($_POST['book_type']) ? $_POST['book_type'] : '';
		
		$insert = $db->insertRow("INSERT INTO ".$table1." (`admin_id`,`model`,`color`,`salesman_id`,`name`,`mobile`,`city`,`country`,`finance`,`finance_bank`,`remark`,`created_at`,`updated_at`)VALUES(?,?,?,?,?,?,?,?,?,?,?,?,NOW())",array($admin_id,$model,$color,$salesman_id,$name,$mobile,$city,$country,$finance,$finance_bank,$remark,$created_at));
		
		// Add Amount in Advance Payment table
		if(!empty($insert))
		{
			$insertPayment = $db->insertRow("INSERT INTO ".$table2." (`admin_id`,`advance_id`,`case_type`,`price`,`amount_in_word`,`bank_name`,`cheque_no`,`cheque_date`,`dd_bank_name`,`dd_no`,`dd_date`,`neft_ac_no`,`neft_bank_name`,`neft_ifsc_code`,`neft_holder_name`,`updated_at`)VALUES(?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,NOW())",array($admin_id,$insert,$case_type,$price,$amount_in_word,$bank_name,$cheque_no,$cheque_date,$dd_bank_name,$dd_no,$dd_date,$neft_ac_no,$neft_bank_name,$neft_ifsc_code,$neft_holder_name));
		}
		
		if($insert){
			$_SESSION['admin_success'] = "Advance Booking Done...";
			header('Location:../cashReceipt/ABInvoice.php?aid='.$insert.'&type='.$_POST['print_type']);
			exit();
		}else{
			$_SESSION['admin_error'] = "Advance Booking not done...";
			header('Location:../advance_booking.php');
			exit();
		}
		exit();
	}
	else if(isset($_POST['type']) && ($_POST['type']=="advance_edit"))
	{
		$id = isset($_POST['id']) ? $_POST['id'] : '';
		
		$admin_id = isset($_POST['admin_id']) ? $_POST['admin_id'] : '';
		$model = isset($_POST['model']) ? $_POST['model'] : '';
		$color = isset($_POST['color']) ? $db->string_format($_POST['color'],true,'upper') : '';
		
		$salesman_id = isset($_POST['salesman_id']) ? $_POST['salesman_id'] : '';
		$name = isset($_POST['name']) ? $db->string_format($_POST['name'],true,'upper') : '';
		$mobile = isset($_POST['mobile']) ? $_POST['mobile'] : '';
		$city = isset($_POST['city']) ? $_POST['city'] : '';
		$country = isset($_POST['country']) ? $_POST['country'] : '';
		
		$case_type = isset($_POST['case_type']) ? $_POST['case_type'] : '';
		$price = isset($_POST['price']) ? $_POST['price'] : '';
		$amount_in_word = isset($_POST['amount_in_word']) ? $_POST['amount_in_word'] : '';
		
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
		
		$finance = isset($_POST['finance']) ? $_POST['finance'] : '';
		$finance_bank = isset($_POST['finance_bank']) ? $db->string_format($_POST['finance_bank'],true,'upper') : '';
		
		$remark = isset($_POST['remark']) ? $_POST['remark'] : '';
		$created_at = isset($_POST['currentDate']) ? date("Y-m-d H:i:s",strtotime($_POST['currentDate'].date("H:i:s"))) : date('Y-m-d H:i:s');
		
		$update = $db->updateRow("update ".$table1." set `admin_id`=?,`model`=?,`color`=?,`salesman_id`=?,`name`=?,`mobile`=?,`city`=?,`country`=?,`finance`=?,`finance_bank`=?,`remark`=?,`created_at`=?,`updated_at`=NOW() where `advance_id`=?",array($admin_id,$model,$color,$salesman_id,$name,$mobile,$city,$country,$finance,$finance_bank,$remark,$created_at,$id));
		
		// Add Amount in Advance Payment table
		$insertPayment = $db->insertRow("INSERT INTO ".$table2." (`admin_id`,`advance_id`,`case_type`,`price`,`amount_in_word`,`bank_name`,`cheque_no`,`cheque_date`,`dd_bank_name`,`dd_no`,`dd_date`,`neft_ac_no`,`neft_bank_name`,`neft_ifsc_code`,`neft_holder_name`,`updated_at`)VALUES(?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,NOW())",array($admin_id,$id,$case_type,$price,$amount_in_word,$bank_name,$cheque_no,$cheque_date,$dd_bank_name,$dd_no,$dd_date,$neft_ac_no,$neft_bank_name,$neft_ifsc_code,$neft_holder_name));
		
		if(!$update){
			$_SESSION['admin_success'] = "Advance Booking Detail Update Sussessfully...";
			header('Location:../cashReceipt/ABInvoice.php?aid='.$id.'&type='.$_POST['print_type']);
			exit();
		}else{
			$_SESSION['admin_error'] = "Advance Booking Detail Update in error...";
			header('Location:../advance_booking_list.php');
			exit();
		}
		exit();
	}
	else if(isset($_POST['type']) && ($_POST['type']=="advance_delete"))
	{
		$id = isset($_POST['mid']) ? $_POST['mid'] : 0;
		// advance Delete time add Pending amount
		$select = $db->getRow("SELECT * FROM ".$table1." where `advance_id`=?",array($id));
		if(!empty($select))
		{
			// advance paymnet Count
			$selectAdPayment = $db->getRows("SELECT * FROM ".$table2." where `advance_id`=?",array($id));
			$adPaymentPrice = 0;
			foreach($selectAdPayment as $value){
				$adPaymentPrice += $value['price'];
				// delete Advance Payment
				$deleteAdPayment = $db->deleteRow("DELETE FROM ".$table2." where `advance_payment_id`=?",array($value['advance_payment_id']));
			}
			// Find Oginal Payment Pending Amount
			$product_price = $db->getRow("SELECT * FROM `product_price` where `advance_id`=?",array($select['advance_id']));
			if(!empty($product_price)){
				$pending = $product_price['pending']+$adPaymentPrice;
				$ppUpdate = $db->updateRow("update `product_price` set `pending`=?,`updated_at`=NOW() where `product_price_id`=?",array($pending,$product_price['product_price_id']));
			}
			// store data in deleted
			deletedRecord('advance',$id,'');
			
			$delete = $db->deleteRow("DELETE FROM ".$table1." where `advance_id`=?",array($id));
			if($delete){
				echo 1;
				exit();
			}else{
				echo 0;
				exit();
			}
		}else{
			echo 1;
			exit();
		}
	}
	else if(isset($_POST['type']) && ($_POST['type']=="advance_refund"))
	{
		$id = isset($_POST['mid']) ? $_POST['mid'] : '';
		$refund = isset($_POST['refund']) ? $_POST['refund'] : 0;
		
		$update = $db->updateRow("update ".$table1." set `refund`=?,`remark`=?,`updated_at`=NOW() where `advance_id`=?",array($refund,'Advance Booking Refund',$id));
		
		if(!$update){
			echo 1;
			exit();
		}else{
			echo 0;
			exit();
		}
		exit();
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