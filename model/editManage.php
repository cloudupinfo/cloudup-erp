<?php include_once('../include/comman_model_session.php');
include_once("../config/PDO.php");

if($_POST){
	extract($_POST);
	
	$db = new db();
	$table = "product";
	$table1 = "customer_detail";
	$table2 = "customer_payment";
		
	if(isset($_POST['type']) && ($_POST['type']=="customer_payment_detail_edit"))
	{
		$id = isset($_POST['id']) ? $_POST['id'] : '';
		
		$case_type = isset($_POST['case_type']) ? $_POST['case_type'] : '';
		$bank_name = isset($_POST['bank_name']) ? $_POST['bank_name'] : '';
		//$bank_ifsc = isset($_POST['bank_ifsc']) ? $_POST['bank_ifsc'] : '';
		$cheque_no = isset($_POST['cheque_no']) ? $_POST['cheque_no'] : '';
		$cheque_date = isset($_POST['cheque_date']) ? $_POST['cheque_date'] : '';
		$dd_bank_name = isset($_POST['dd_bank_name']) ? $_POST['dd_bank_name'] : '';
		//$dd_bank_ifsc = isset($_POST['dd_bank_ifsc']) ? $_POST['dd_bank_ifsc'] : '';
		$dd_no = isset($_POST['dd_no']) ? $_POST['dd_no'] : '';
		$dd_date = isset($_POST['dd_date']) ? $_POST['dd_date'] : '';
		$neft_bank_name = isset($_POST['neft_bank_name']) ? $_POST['neft_bank_name'] : '';
		$neft_ac_no = isset($_POST['neft_ac_no']) ? $_POST['neft_ac_no'] : '';
		$neft_ifsc_code = isset($_POST['neft_ifsc_code']) ? $_POST['neft_ifsc_code'] : '';
		$neft_holder_name = isset($_POST['neft_holder_name']) ? $_POST['neft_holder_name'] : '';
		
		$price = isset($_POST['price']) ? $_POST['price'] : '';
		$amount_in_word = isset($_POST['amount_in_word']) ? $_POST['amount_in_word'] : '';
		$remark = isset($_POST['remark']) ? $_POST['remark'] : '';
		
		$created_at = isset($_POST['currentDate']) ? date("Y-m-d H:i:s",strtotime($_POST['currentDate'].date("H:i:s"))) : date('Y-m-d H:i:s');

		$update = $db -> updateRow("update ".$table2." set `case_type`=?,`bank_name`=?,`cheque_no`=?,`cheque_date`=?,`dd_bank_name`=?,`dd_no`=?,`dd_date`=?,`neft_bank_name`=?,`neft_ac_no`=?,`neft_ifsc_code`=?,`neft_holder_name`=?,`price`=?,`amount_in_word`=?,`remark`=? where `customer_payment_id`=?",array($case_type,$bank_name,$cheque_no,$cheque_date,$dd_bank_name,$dd_no,$dd_date,$neft_bank_name,$neft_ac_no,$neft_ifsc_code,$neft_holder_name,$price,$amount_in_word,$remark,$id));
		
		if(!$update){
			echo "<script>window.close();</script>";
			exit();
		}else{
			echo "<script>window.reload();</script>";
			exit();
		}
		exit();
	}
	else if(isset($_POST['type']) && ($_POST['type']=="advance_payment_detail_edit"))
	{
		$id = isset($_POST['id']) ? $_POST['id'] : '';
		
		$case_type = isset($_POST['case_type']) ? $_POST['case_type'] : '';
		$bank_name = isset($_POST['bank_name']) ? $_POST['bank_name'] : '';
		$cheque_no = isset($_POST['cheque_no']) ? $_POST['cheque_no'] : '';
		$cheque_date = isset($_POST['cheque_date']) ? $_POST['cheque_date'] : '';
		$dd_bank_name = isset($_POST['dd_bank_name']) ? $_POST['dd_bank_name'] : '';
		$dd_no = isset($_POST['dd_no']) ? $_POST['dd_no'] : '';
		$dd_date = isset($_POST['dd_date']) ? $_POST['dd_date'] : '';
		$neft_bank_name = isset($_POST['neft_bank_name']) ? $_POST['neft_bank_name'] : '';
		$neft_ac_no = isset($_POST['neft_ac_no']) ? $_POST['neft_ac_no'] : '';
		$neft_ifsc_code = isset($_POST['neft_ifsc_code']) ? $_POST['neft_ifsc_code'] : '';
		$neft_holder_name = isset($_POST['neft_holder_name']) ? $_POST['neft_holder_name'] : '';
		
		$price = isset($_POST['price']) ? $_POST['price'] : '';
		$amount_in_word = isset($_POST['amount_in_word']) ? $_POST['amount_in_word'] : '';
		
		$update = $db->updateRow("update `advance_payment` set `case_type`=?,`bank_name`=?,`cheque_no`=?,`cheque_date`=?,`dd_bank_name`=?,`dd_no`=?,`dd_date`=?,`neft_bank_name`=?,`neft_ac_no`=?,`neft_ifsc_code`=?,`neft_holder_name`=?,`price`=?,`amount_in_word`=?,`updated_at`=NOW() where `advance_payment_id`=?",array($case_type,$bank_name,$cheque_no,$cheque_date,$dd_bank_name,$dd_no,$dd_date,$neft_bank_name,$neft_ac_no,$neft_ifsc_code,$neft_holder_name,$price,$amount_in_word,$id));
		
		if(!$update){
			echo "<script>window.close();</script>";
			exit();
		}else{
			echo "<script>window.reload();</script>";
			exit();
		}
		exit();
	}
	else if(isset($_POST['type']) && ($_POST['type']=="customer_detail_edit"))
	{
		$id = isset($_POST['id']) ? $_POST['id'] : '0';
		
		$salesman_id = isset($_POST['salesman_id']) ? $_POST['salesman_id'] : '';
		$name = isset($_POST['name']) ? $_POST['name'] : '';
		$mobile = isset($_POST['mobile']) ? $_POST['mobile'] : '';
		$street_add1 = isset($_POST['street_add1']) ? $_POST['street_add1'] : '';
		$street_add2 = isset($_POST['street_add2']) ? $_POST['street_add2'] : '';
		$city = isset($_POST['city']) ? $_POST['city'] : '';
		$country = isset($_POST['country']) ? $_POST['country'] : '';
		$remark = isset($_POST['remark']) ? $_POST['remark'] : '';
		
		$update = $db->updateRow("update ".$table1." set `salesman_id`=?,`name`=?,`mobile`=?,`street_add1`=?,`street_add2`=?,`city`=?,`country`=?,`remark`=?,`updated_at`=NOW() where `customer_detail_id`=?",array($salesman_id,$name,$mobile,$street_add1,$street_add2,$city,$country,$remark,$id));
		
		if(!$update){
			echo "<script>window.close();</script>";
			exit();
		}else{
			echo "<script>window.reload();</script>";
			exit();
		}
		echo "<script>window.close();</script>";
		exit();
	}
	else if(isset($_POST['type']) && ($_POST['type']=="exchange_detail_edit"))
	{
		$id = isset($_POST['id']) ? $_POST['id'] : '0';
		
		$amount = isset($_POST['amount']) ? $_POST['amount'] : '';
		$veihicle_no = isset($_POST['veihicle_no']) ? $_POST['veihicle_no'] : '';
		
		$update = $db->updateRow("update `exchange` set `amount`=?,`veihicle_no`=?,`updated_at`=NOW() where `exchange_id`=?",array($amount,$veihicle_no,$id));
		
		if(!$update){
			echo "<script>window.close();</script>";
			exit();
		}else{
			echo "<script>window.reload();</script>";
			exit();
		}
		echo "<script>window.close();</script>";
		exit();
	}
	else if(isset($_POST['type']) && ($_POST['type']=="finance_detail_edit"))
	{
		$id = isset($_POST['id']) ? $_POST['id'] : '0';
		
		$finance_amount = isset($_POST['finance_amount']) ? $_POST['finance_amount'] : '';
		$dp_amount = isset($_POST['dp_amount']) ? $_POST['dp_amount'] : '';
		$bank = isset($_POST['bank']) ? $_POST['bank'] : '';
		
		$update = $db->updateRow("update `finance` set `finance_amount`=?,`dp_amount`=?,`bank`=?,`updated_at`=NOW() where `finance_id`=?",array($finance_amount,$dp_amount,$bank,$id));
		
		if(!$update){
			echo "<script>window.close();</script>";
			exit();
		}else{
			echo "<script>window.reload();</script>";
			exit();
		}
		echo "<script>window.close();</script>";
		exit();
	}
	else
	{
		echo "<script>window.reload();</script>";
		exit();
	}
}else{
	echo "<script>window.reload();</script>";
	exit();
}
?>