<?php $rightsArray = array("index.php","dashboard.php","profile.php","logout.php","veihicle_status.php","case_invoice.php","open_camera.php","customer_payment_detail_edit.php","customer_detail_edit.php","billing_list_service.php","customer_payment_exchange_edit.php","customer_payment_finance_edit.php","cashier_detail_edit.php","create_barcode_customer_detail.php","bill_customer_1.php","bill_customer_2.php","passing_list.php","product.php");

if($_SESSION['adminPermission']['admin']=="1"){
	array_push($rightsArray,"admin.php","admin_list.php");
}if($_SESSION['adminPermission']['model']=="1"){
	array_push($rightsArray,"model.php","model_list.php");
}if($_SESSION['adminPermission']['dealer']=="1"){
	array_push($rightsArray,"dealer.php","dealer_search.php","dealer_gatepass_list.php","dealer_bill_list.php");
}if($_SESSION['adminPermission']['sales_man']=="1"){
	array_push($rightsArray,"salesman_list.php","salesman.php");
}if($_SESSION['adminPermission']['branch']=="1"){
	array_push($rightsArray,"branch_list.php","branch.php");
}if($_SESSION['adminPermission']['showroom']=="1"){
	array_push($rightsArray,"product_excel.php","generate_qrcode.php","product_pdi_today.php","product_pdi.php","product_list_today.php","product_list.php","product_list_report.php","product_direct_sale.php");
}if($_SESSION['adminPermission']['cashier']=="1"){
	array_push($rightsArray,"cashier.php","cashier_list_today.php","cashier_list.php","cashier_pending_list.php","cashier_chassis_view.php","cashier_add.php","cashier_extra_list.php","cashier_detail_view.php","advance_booking.php","advance_booking_list.php","advance_payment_edit.php");
}if($_SESSION['adminPermission']['gatepass']=="1"){
	array_push($rightsArray,"gatepass.php","gatepass_list_today.php","gatepass_list.php","gatepass_detail_view.php","gatepass_chassis_view.php");
}if($_SESSION['adminPermission']['atm']=="1"){
	array_push($rightsArray,"atm.php","atm_list.php");
}if($_SESSION['adminPermission']['bank']=="1"){
	array_push($rightsArray,"bank.php","bank_list.php");
}if($_SESSION['adminPermission']['billing']=="1"){
	array_push($rightsArray,"billing_view.php","billing.php","billing_list.php","billing_detail_view.php","billing_today_list.php");
}if($_SESSION['adminPermission']['rto']=="1"){
	array_push($rightsArray,"rto.php","rto_view.php","rto_list.php");
}if($_SESSION['adminPermission']['expence']=="1"){
	array_push($rightsArray,"expense.php","expense_list.php");
}if($_SESSION['adminPermission']['exchange']=="1"){
	array_push($rightsArray,"exchange_list.php");
}if($_SESSION['adminPermission']['finance']=="1"){
	array_push($rightsArray,"finance_list.php");
}

if($_SESSION['adminPermission']['report']=="1"){
	array_push($rightsArray,"rp_cashier.php","rp_cashier_branch.php","rp_expense.php","rp_atm.php");
	if($_SESSION['adminPermission']['re_passing']=="1"){
		array_push($rightsArray,"passing_list.php");
	}if($_SESSION['adminPermission']['re_total']=="1"){
		array_push($rightsArray,"rp_total.php");
	}if($_SESSION['adminPermission']['re_stock']=="1"){
		array_push($rightsArray,"rp_stock.php");
	}if($_SESSION['adminPermission']['re_incentive']=="1"){
		array_push($rightsArray,"rp_incentive.php");
	}
}
?>