<?php 
if($currentPageName=="admin.php" || $currentPageName=="admin_list.php" || $currentPageName=="profile.php"){
	if($currentPageName=="admin.php"){
		$sidebarAdminMainMenu="active";
		$sidebarAdminMainListMenu = "";
	}else if($currentPageName=="admin_list.php"){
		$sidebarAdminMainListMenu = "active";
		$sidebarAdminMainMenu = "";
	}
	$sidebarAdminMenu="active open";
	$sidebarProductMenu = $sidebarModelMenu = $sidebarCashierMenu = $sidebarGatepassMenu = $sidebarVeihicalStatus = $sidebarDashboard = $sidebarBillMenu = $sidebarSalesmanMenu = $sidebarExpenseMenu = $sidebarExchangeMenu = $sidebarFinanceMenu = $sidebarBranchMenu = $sidebarAtmMenu = $sidebarReportMenu = $sidebarDealerMenu = $sidebarRTOMenu = $sidebarBankMenu = "";  
}else if($currentPageName=="salesman.php" || $currentPageName=="salesman_list.php"){
	if($currentPageName=="salesman.php"){
		$sidebarSalesmanAddMenu = "active";
		$sidebarSalesmanListMenu = "";
	}else if($currentPageName=="salesman_list.php"){
		$sidebarSalesmanListMenu = "active";
		$sidebarSalesmanAddMenu = "";
	}
	$sidebarSalesmanMenu = "active open";
	$sidebarModelMenu = $sidebarProductMenu = $sidebarAdminMenu = $sidebarCashierMenu = $sidebarGatepassMenu = $sidebarVeihicalStatus = $sidebarDashboard = $sidebarBillMenu = $sidebarExpenseMenu = $sidebarExchangeMenu = $sidebarFinanceMenu = $sidebarBranchMenu = $sidebarReportMenu = $sidebarDealerMenu = $sidebarRTOMenu = $sidebarBankMenu = "";  
}else if($currentPageName=="model.php" || $currentPageName=="model_list.php"){
	if($currentPageName=="model.php"){
		$sidebarModelAddMenu = "active";
		$sidebarModelListMenu = "";
	}else if($currentPageName=="model_list.php"){
		$sidebarModelListMenu = "active";
		$sidebarModelAddMenu = "";
	}
	$sidebarModelMenu = "active open";
	$sidebarProductMenu = $sidebarAdminMenu = $sidebarCashierMenu = $sidebarGatepassMenu = $sidebarVeihicalStatus = $sidebarDashboard = $sidebarBillMenu = $sidebarSalesmanMenu = $sidebarExpenseMenu = $sidebarExchangeMenu = $sidebarFinanceMenu = $sidebarBranchMenu = $sidebarAtmMenu = $sidebarReportMenu = $sidebarDealerMenu = $sidebarRTOMenu = $sidebarBankMenu = "";  
}else if($currentPageName=="product.php" || $currentPageName=="product_list.php" || $currentPageName=="product_list_report.php" || $currentPageName=="product_list_today.php" || $currentPageName=="product_excel.php" || $currentPageName=="generate_qrcode.php" || $currentPageName=="product_pdi.php" || $currentPageName=="product_pdi_today.php" || $currentPageName=="product_direct_sale.php"){
	if($currentPageName=="product_excel.php"){
		$sidebarProductExcelMenu = "active";
		$sidebarProductMainMenu = $sidebarProductMainListMenu = $sidebarProductQrcodeMenu = $sidebarProductListTodayMenu = $sidebarProductPDIMenu = $sidebarProductPDITodayMenu = $sidebarProductDirectSaleMenu = $sidebarProductMainListReportMenu = "";
	}else if($currentPageName=="product_list.php"){
		$sidebarProductMainListMenu = "active";
		$sidebarProductMainMenu = $sidebarProductExcelMenu = $sidebarProductQrcodeMenu = $sidebarProductListTodayMenu = $sidebarProductPDIMenu = $sidebarProductPDITodayMenu = $sidebarProductDirectSaleMenu = $sidebarProductMainListReportMenu = "";
	}else if($currentPageName=="product_list_report.php"){
		$sidebarProductMainListReportMenu = "active";
		$sidebarProductMainMenu = $sidebarProductExcelMenu = $sidebarProductQrcodeMenu = $sidebarProductListTodayMenu = $sidebarProductPDIMenu = $sidebarProductPDITodayMenu = $sidebarProductDirectSaleMenu = $sidebarProductMainListMenu = "";
	}else if($currentPageName=="generate_qrcode.php"){
		$sidebarProductQrcodeMenu = "active";
		$sidebarProductMainListMenu = $sidebarProductMainMenu = $sidebarProductExcelMenu = $sidebarProductListTodayMenu = $sidebarProductPDIMenu = $sidebarProductPDITodayMenu = $sidebarProductDirectSaleMenu = $sidebarProductMainListReportMenu = "";
	}else if($currentPageName=="product_list_today.php"){
		$sidebarProductListTodayMenu = "active";
		$sidebarProductMainListMenu = $sidebarProductMainMenu = $sidebarProductExcelMenu = $sidebarProductQrcodeMenu = $sidebarProductPDIMenu = $sidebarProductPDITodayMenu = $sidebarProductDirectSaleMenu = $sidebarProductMainListReportMenu = "";
	}else if($currentPageName=="product_pdi.php"){
		$sidebarProductPDIMenu = "active";
		$sidebarProductMainListMenu = $sidebarProductMainMenu = $sidebarProductExcelMenu = $sidebarProductQrcodeMenu = $sidebarProductListTodayMenu = $sidebarProductPDITodayMenu = $sidebarProductDirectSaleMenu = $sidebarProductMainListReportMenu = "";
	}else if($currentPageName=="product_pdi_today.php"){
		$sidebarProductPDITodayMenu = "active";
		$sidebarProductMainListMenu = $sidebarProductMainMenu = $sidebarProductExcelMenu = $sidebarProductQrcodeMenu = $sidebarProductListTodayMenu = $sidebarProductPDIMenu = $sidebarProductDirectSaleMenu = $sidebarProductMainListReportMenu = "";
	}else if($currentPageName=="product_direct_sale.php"){
		$sidebarProductDirectSaleMenu = "active";
		$sidebarProductMainListMenu = $sidebarProductMainMenu = $sidebarProductExcelMenu = $sidebarProductQrcodeMenu = $sidebarProductListTodayMenu = $sidebarProductPDITodayMenu = $sidebarProductPDIMenu = $sidebarProductMainListReportMenu = "";
	}else{
		$sidebarProductMainMenu="active";
		$sidebarProductExcelMenu = $sidebarProductMainListMenu = $sidebarProductQrcodeMenu = $sidebarProductListTodayMenu = $sidebarProductPDIMenu = $sidebarProductPDITodayMenu = $sidebarProductDirectSaleMenu = $sidebarProductMainListReportMenu = "";
	}
	$sidebarProductMenu="active open";
	$sidebarAdminMenu = $sidebarModelMenu = $sidebarCashierMenu = $sidebarGatepassMenu = $sidebarVeihicalStatus = $sidebarDashboard = $sidebarBillMenu = $sidebarSalesmanMenu = $sidebarExpenseMenu = $sidebarExchangeMenu = $sidebarFinanceMenu = $sidebarBranchMenu = $sidebarAtmMenu = $sidebarReportMenu = $sidebarDealerMenu = $sidebarRTOMenu = $sidebarBankMenu = "";  
}else if($currentPageName=="cashier.php" || $currentPageName=="cashier_list_today.php" || $currentPageName=="cashier_list.php" ||  $currentPageName=="cashier_pending_list.php" || $currentPageName=="cashier_chassis_view.php" || $currentPageName=="advance_booking.php" || $currentPageName=="advance_booking_list.php" || $currentPageName=="advance_payment_edit.php" || $currentPageName=="cashier_detail_view.php" || $currentPageName=="cashier_add.php" || $currentPageName=="cashier_extra_list.php" || $currentPageName=="cashier_detail_edit.php"){
	if($currentPageName=="cashier_add.php"){
		$sidebarCashierAdd = "active";
		$sidebarCashierExtraList = $sidebarCashierSearch = $sidebarCashierList = $sidebarCashierListToday = $sidebarCashierAdvbook = $sidebarCashierAdvbookList = $sidebarCashierPendingList = "";
	}else if($currentPageName=="cashier_extra_list.php"){
		$sidebarCashierExtraList = "active";
		$sidebarCashierListToday = $sidebarCashierAdd = $sidebarCashierList = $sidebarCashierSearch = $sidebarCashierAdvbook = $sidebarCashierAdvbookList = $sidebarCashierPendingList = "";
	}else if($currentPageName=="cashier_list_today.php"){
		$sidebarCashierListToday = "active";
		$sidebarCashierExtraList = $sidebarCashierAdd = $sidebarCashierList = $sidebarCashierSearch = $sidebarCashierAdvbook = $sidebarCashierAdvbookList = $sidebarCashierPendingList = "";
	}else if($currentPageName=="cashier_list.php" || $currentPageName=="cashier_detail_view.php"){
		$sidebarCashierList = "active";
		$sidebarCashierExtraList = $sidebarCashierAdd = $sidebarCashierSearch = $sidebarCashierListToday = $sidebarCashierAdvbook = $sidebarCashierAdvbookList = $sidebarCashierPendingList = "";
	}else if($currentPageName=="cashier_pending_list.php"){
		$sidebarCashierPendingList = "active";
		$sidebarCashierExtraList = $sidebarCashierAdd = $sidebarCashierSearch = $sidebarCashierListToday = $sidebarCashierAdvbook = $sidebarCashierAdvbookList = $sidebarCashierList = "";
	}else if($currentPageName=="advance_booking.php"){
		$sidebarCashierAdvbook = "active";
		$sidebarCashierExtraList = $sidebarCashierAdd = $sidebarCashierSearch = $sidebarCashierListToday = $sidebarCashierList = $sidebarCashierAdvbookList = $sidebarCashierPendingList = "";
	}else if($currentPageName=="advance_booking_list.php" || $currentPageName=="advance_payment_edit.php"){
		$sidebarCashierAdvbookList = "active";
		$sidebarCashierExtraList = $sidebarCashierSearch = $sidebarCashierAdd = $sidebarCashierListToday = $sidebarCashierList = $sidebarCashierAdvbook = $sidebarCashierPendingList = "";
	}else{
		$sidebarCashierSearch = "active";
		$sidebarCashierExtraList = $sidebarCashierAdd = $sidebarCashierList = $sidebarCashierListToday = $sidebarCashierAdvbook = $sidebarCashierAdvbookList = $sidebarCashierPendingList = "";
	}
	$sidebarCashierMenu = "active open";
	$sidebarProductMenu = $sidebarAdminMenu = $sidebarModelMenu = $sidebarGatepassMenu = $sidebarVeihicalStatus = $sidebarDashboard = $sidebarBillMenu = $sidebarSalesmanMenu = $sidebarExpenseMenu = $sidebarExchangeMenu = $sidebarFinanceMenu = $sidebarBranchMenu = $sidebarAtmMenu = $sidebarReportMenu = $sidebarDealerMenu = $sidebarRTOMenu = $sidebarBankMenu = "";  
}else if($currentPageName=="gatepass.php" || $currentPageName=="gatepass_list_today.php" || $currentPageName=="gatepass_list.php" || $currentPageName=="gatepass_chassis_view.php" || $currentPageName=="gatepass_detail_view.php"){
	if($currentPageName=="gatepass.php" || $currentPageName=="gatepass_chassis_view.php" || $currentPageName=="gatepass_detail_view.php"){
		$sidebarGatepassSearch = "active";
		$sidebarGatepassList = $sidebarCashierListToday = "";
	}else if($currentPageName=="gatepass_list_today.php"){
		$sidebarGatepassListToday = "active";
		$sidebarGatepassList = $sidebarGatepassSearch = "";
	}else if($currentPageName=="gatepass_list.php"){
		$sidebarGatepassList = "active";
		$sidebarGatepassSearch = $sidebarGatepassListToday= "";
	}
	$sidebarGatepassMenu = "active open";
	$sidebarProductMenu = $sidebarAdminMenu = $sidebarModelMenu = $sidebarCashierMenu = $sidebarVeihicalStatus = $sidebarDashboard = $sidebarBillMenu = $sidebarSalesmanMenu = $sidebarExpenseMenu = $sidebarExchangeMenu = $sidebarFinanceMenu = $sidebarBranchMenu = $sidebarAtmMenu = $sidebarReportMenu = $sidebarDealerMenu = $sidebarRTOMenu = $sidebarBankMenu = "";
}else if($currentPageName=="expense.php" || $currentPageName=="expense_list.php"){
	if($currentPageName=="expense.php"){
		$sidebarExpenseAdd = "active";
		$sidebarExpenseList = "";
	}else{
		$sidebarExpenseList = "active";
		$sidebarExpenseAdd = "";
	}
	$sidebarExpenseMenu = "active open";
	$sidebarBillMenu = $sidebarProductMenu = $sidebarAdminMenu = $sidebarModelMenu = $sidebarCashierMenu = $sidebarVeihicalStatus = $sidebarDashboard = $sidebarGatepassMenu = $sidebarSalesmanMenu = $sidebarExchangeMenu = $sidebarFinanceMenu = $sidebarBranchMenu = $sidebarAtmMenu = $sidebarReportMenu = $sidebarDealerMenu = $sidebarRTOMenu = $sidebarBankMenu = "";
}else if($currentPageName=="dealer.php" || $currentPageName=="dealer_list.php" || $currentPageName=="dealer_search.php" || $currentPageName=="dealer_gatepass_list.php" || $currentPageName=="dealer_bill_list.php"){
	if($currentPageName=="dealer_list.php"){
		$sidebarDealerList = "active";
		$sidebarDealerAdd = $sidebarDealerBillList = $sidebarDealerGateList = "";
	}else if($currentPageName=="dealer_gatepass_list.php"){
		$sidebarDealerGateList = "active";
		$sidebarDealerAdd = $sidebarDealerBillList = $sidebarDealerList = "";
	}else if($currentPageName=="dealer_bill_list.php"){
		$sidebarDealerBillList = "active";
		$sidebarDealerAdd = $sidebarDealerGateList = $sidebarDealerList = "";
	}else{
		$sidebarDealerAdd = "active";
		$sidebarDealerList = $sidebarDealerBillList = $sidebarDealerGateList = "";
	}
	$sidebarDealerMenu = "active open";
	$sidebarBillMenu = $sidebarProductMenu = $sidebarAdminMenu = $sidebarModelMenu = $sidebarCashierMenu = $sidebarVeihicalStatus = $sidebarDashboard = $sidebarGatepassMenu = $sidebarSalesmanMenu = $sidebarExchangeMenu = $sidebarFinanceMenu = $sidebarExpenseMenu = $sidebarBranchMenu = $sidebarAtmMenu = $sidebarReportMenu = $sidebarRTOMenu = $sidebarBankMenu = "";
}else if($currentPageName=="exchange_list.php"){
	if($currentPageName=="expense.php"){
		$sidebarExchangeAdd = "active";
		$sidebarExchangeList = "";
	}else{
		$sidebarExchangeList = "active";
		$sidebarExchangeAdd = "";
	}
	$sidebarExchangeMenu = "active open";
	$sidebarBillMenu = $sidebarProductMenu = $sidebarAdminMenu = $sidebarModelMenu = $sidebarCashierMenu = $sidebarVeihicalStatus = $sidebarDashboard = $sidebarGatepassMenu = $sidebarExpenseMenu = $sidebarSalesmanMenu = $sidebarFinanceMenu = $sidebarBranchMenu = $sidebarAtmMenu = $sidebarReportMenu = $sidebarDealerMenu = $sidebarRTOMenu = $sidebarBankMenu = "";
}else if($currentPageName=="atm_list.php" || $currentPageName=="atm.php"){
	if($currentPageName=="atm_list.php"){
		$sidebarAtmList = "active";
		$sidebarAtmAdd = "";
	}else{
		$sidebarAtmAdd = "active";
		$sidebarAtmList = "";
	}
	$sidebarAtmMenu = "active open";
	$sidebarBillMenu = $sidebarProductMenu = $sidebarAdminMenu = $sidebarModelMenu = $sidebarCashierMenu = $sidebarVeihicalStatus = $sidebarDashboard = $sidebarGatepassMenu = $sidebarExpenseMenu = $sidebarSalesmanMenu = $sidebarFinanceMenu = $sidebarBranchMenu = $sidebarExchangeMenu = $sidebarReportMenu = $sidebarDealerMenu = $sidebarRTOMenu = $sidebarBankMenu = "";
}else if($currentPageName=="finance_list.php"){
	if($currentPageName=="expense.php"){
		$sidebarFinanceAdd = "active";
		$sidebarFinanceList = "";
	}else{
		$sidebarFinanceList = "active";
		$sidebarFinanceAdd = "";
	}
	$sidebarFinanceMenu = "active open";
	$sidebarBillMenu = $sidebarProductMenu = $sidebarAdminMenu = $sidebarModelMenu = $sidebarCashierMenu = $sidebarVeihicalStatus = $sidebarDashboard = $sidebarGatepassMenu = $sidebarExpenseMenu = $sidebarSalesmanMenu = $sidebarExchangeMenu = $sidebarBranchMenu = $sidebarAtmMenu = $sidebarReportMenu = $sidebarDealerMenu = $sidebarRTOMenu = $sidebarBankMenu = "";
}else if($currentPageName=="billing.php" || $currentPageName=="billing_view.php" || $currentPageName=="billing_list.php" || $currentPageName=="billing_today_list.php" || $currentPageName=="billing_list_service.php"){
	if($currentPageName=="billing_list_service.php"){
		$sidebarBillListService = "active";
		$sidebarBillSearch = $sidebarBillList = $sidebarBillTodayList = "";
	}else if($currentPageName=="billing_list.php"){
		$sidebarBillList = "active";
		$sidebarBillSearch = $sidebarBillTodayList = $sidebarBillListService = "";
	}else if($currentPageName=="billing_today_list.php"){
		$sidebarBillTodayList = "active";
		$sidebarBillSearch = $sidebarBillList = $sidebarBillListService = "";
	}else{
		$sidebarBillSearch = "active";
		$sidebarBillList = $sidebarBillTodayList = $sidebarBillListService = "";
	}
	$sidebarBillMenu = "active open";
	$sidebarProductMenu = $sidebarAdminMenu = $sidebarModelMenu = $sidebarCashierMenu = $sidebarVeihicalStatus = $sidebarDashboard = $sidebarGatepassMenu = $sidebarSalesmanMenu = $sidebarExpenseMenu = $sidebarExchangeMenu = $sidebarFinanceMenu = $sidebarBranchMenu = $sidebarAtmMenu = $sidebarReportMenu = $sidebarDealerMenu = $sidebarRTOMenu = $sidebarBankMenu = "";
}else if($currentPageName=="branch_list.php" || $currentPageName=="branch.php"){
	if($currentPageName=="branch_list.php"){
		$sidebarBranchList = "active";
		$sidebarBranchAdd = "";
	}else{
		$sidebarBranchAdd = "active";
		$sidebarBranchList = "";
	}
	$sidebarBranchMenu = "active open";
	$sidebarBillMenu = $sidebarProductMenu = $sidebarAdminMenu = $sidebarModelMenu = $sidebarCashierMenu = $sidebarVeihicalStatus = $sidebarDashboard = $sidebarGatepassMenu = $sidebarSalesmanMenu = $sidebarExpenseMenu = $sidebarExchangeMenu = $sidebarFinanceMenu = $sidebarAtmMenu = $sidebarReportMenu = $sidebarDealerMenu = $sidebarRTOMenu = $sidebarBankMenu = "";
}else if($currentPageName=="rp_cashier.php" || $currentPageName=="rp_stock.php" || $currentPageName=="rp_incentive.php" || $currentPageName=="rp_cashier_branch.php" || $currentPageName=="rp_expense.php" || $currentPageName=="rp_atm.php" || $currentPageName=="rp_total.php" || $currentPageName=="passing_list.php"){
	if($currentPageName=="rp_cashier.php"){
		$sidebarReportCase = "active";
		$sidebarBranchAdd = $sidebarReportCaseBranch = $sidebarReportExpe = $sidebarReportAtm = $sidebarReportStock = $sidebarReportPass = $sidebarReportIncentive = "";
	}else if($currentPageName=="rp_cashier_branch.php"){
		$sidebarReportCaseBranch = "active";
		$sidebarBranchAdd = $sidebarReportCase = $sidebarReportExpe = $sidebarReportAtm = $sidebarReportStock = $sidebarReportPass = $sidebarReportIncentive = "";
	}else if($currentPageName=="rp_expense.php"){
		$sidebarReportExpe = "active";
		$sidebarBranchAdd = $sidebarReportCase = $sidebarReportAtm = $sidebarReportCaseBranch = $sidebarReportStock = $sidebarReportPass = $sidebarReportIncentive = "";
	}else if($currentPageName=="rp_atm.php"){
		$sidebarReportAtm = "active";
		$sidebarReportExpe = $sidebarBranchAdd = $sidebarReportCase = $sidebarReportCaseBranch = $sidebarReportStock = $sidebarReportPass = $sidebarReportIncentive = "";
	}else if($currentPageName=="rp_stock.php"){
		$sidebarReportStock = "active";
		$sidebarReportExpe = $sidebarBranchAdd = $sidebarReportCase = $sidebarReportCaseBranch = $sidebarReportAtm = $sidebarReportPass = $sidebarReportIncentive = "";
	}else if($currentPageName=="rp_incentive.php"){
		$sidebarReportIncentive = "active";
		$sidebarReportStock = $sidebarReportExpe = $sidebarBranchAdd = $sidebarReportCase = $sidebarReportCaseBranch = $sidebarReportAtm = $sidebarReportPass = "";
	}else if($currentPageName=="passing_list.php"){
		$sidebarReportPass = "active";
		$sidebarReportExpe = $sidebarBranchAdd = $sidebarReportCase = $sidebarReportCaseBranch = $sidebarReportAtm = $sidebarReportStock = $sidebarReportIncentive = "";
	}else{
		$sidebarReportTotal = "active";
		$sidebarReportCase = $sidebarReportExpe = $sidebarReportCaseBranch = $sidebarReportAtm = $sidebarReportStock = $sidebarReportPass = $sidebarReportIncentive = "";
	}
	$sidebarReportMenu = "active open";
	$sidebarBranchMenu = $sidebarBillMenu = $sidebarProductMenu = $sidebarAdminMenu = $sidebarModelMenu = $sidebarCashierMenu = $sidebarVeihicalStatus = $sidebarDashboard = $sidebarGatepassMenu = $sidebarSalesmanMenu = $sidebarExpenseMenu = $sidebarExchangeMenu = $sidebarFinanceMenu = $sidebarAtmMenu = $sidebarDealerMenu = $sidebarRTOMenu = $sidebarBankMenu = "";
}else if($currentPageName=="rto.php" || $currentPageName=="rto_view.php" || $currentPageName=="rto_list.php"){
	if($currentPageName=="rto_list.php"){
		$sidebarRTOList = "active";
		$sidebarRTOAdd = "";
	}else{
		$sidebarRTOAdd = "active";
		$sidebarRTOList = "";
	}
	$sidebarRTOMenu = "active open";
	$sidebarBranchMenu = $sidebarBillMenu = $sidebarProductMenu = $sidebarAdminMenu = $sidebarModelMenu = $sidebarCashierMenu = $sidebarVeihicalStatus = $sidebarDashboard = $sidebarGatepassMenu = $sidebarSalesmanMenu = $sidebarExpenseMenu = $sidebarExchangeMenu = $sidebarFinanceMenu = $sidebarAtmMenu = $sidebarDealerMenu = $sidebarReportMenu = $sidebarBankMenu = "";
}else if($currentPageName=="bank.php" || $currentPageName=="bank_list.php"){
	if($currentPageName=="bank_list.php"){
		$sidebarBankList = "active";
		$sidebarBankAdd = "";
	}else{
		$sidebarBankAdd = "active";
		$sidebarBankList = "";
	}
	$sidebarBankMenu = "active open";
	$sidebarBranchMenu = $sidebarBillMenu = $sidebarProductMenu = $sidebarAdminMenu = $sidebarModelMenu = $sidebarCashierMenu = $sidebarVeihicalStatus = $sidebarDashboard = $sidebarGatepassMenu = $sidebarSalesmanMenu = $sidebarExpenseMenu = $sidebarExchangeMenu = $sidebarFinanceMenu = $sidebarAtmMenu = $sidebarDealerMenu = $sidebarReportMenu = $sidebarRTOMenu = "";
}else if($currentPageName=="veihicle_status.php"){
	$sidebarVeihicalStatus = "active open";
	$sidebarProductMenu = $sidebarAdminMenu = $sidebarModelMenu = $sidebarCashierMenu = $sidebarGatepassMenu = $sidebarDashboard = $sidebarBillMenu = $sidebarSalesmanMenu = $sidebarExpenseMenu = $sidebarExchangeMenu = $sidebarFinanceMenu = $sidebarBranchMenu = $sidebarAtmMenu = $sidebarReportMenu = $sidebarDealerMenu = $sidebarRTOMenu = $sidebarBankMenu = "";
}else{
	$sidebarDashboard = "active open";
	$sidebarProductMenu = $sidebarAdminMenu = $sidebarModelMenu = $sidebarCashierMenu = $sidebarGatepassMenu = $sidebarVeihicalStatus = $sidebarBillMenu = $sidebarSalesmanMenu = $sidebarExpenseMenu = $sidebarExchangeMenu = $sidebarFinanceMenu = $sidebarBranchMenu = $sidebarAtmMenu = $sidebarReportMenu = $sidebarDealerMenu = $sidebarRTOMenu = $sidebarBankMenu = "";
}?>
<!-- start: MAIN NAVIGATION MENU -->
<ul class="main-navigation-menu">
	<li class="<?php echo $sidebarDashboard;?>">
		<a href="dashboard.php"><i class="clip-home-3"></i>
			<span class="title"> Dashboard </span><span class="selected"></span>
		</a>
	</li>
	<li class="<?php echo $sidebarVeihicalStatus;?>">
		<a href="veihicle_status.php"><i class="clip-cart"></i>
			<span class="title"> Docate </span><span class="selected"></span>
		</a>
	</li>
	<?php if($_SESSION['adminPermission']['admin']=="1"){ ?>
	<li class="<?php echo $sidebarAdminMenu;?>">
		<a href="javascript:void(0)"><i class="clip-user-2"></i>
			<span class="title"> Admin </span><i class="icon-arrow"></i>
			<span class="selected"></span>
		</a>
		<ul class="sub-menu">
			<li class="<?php echo $sidebarAdminMainMenu;?>">
				<a href="admin.php"><span class="title">Admin Add</span></a>
			</li>
			<li class="<?php echo $sidebarAdminMainListMenu;?>">
				<a href="admin_list.php"><span class="title">Admin List</span></a>
			</li>
		</ul>
	</li>
	<?php } ?>
	<?php if($_SESSION['adminPermission']['model']=="1"){ ?>
	<li class="<?php echo $sidebarModelMenu;?>">
		<a href="javascript:void(0)"><i class="clip-truck"></i>
			<span class="title"> Models </span><i class="icon-arrow"></i>
			<span class="selected"></span>
		</a>
		<ul class="sub-menu">
			<li class="<?php echo $sidebarModelAddMenu;?>">
				<a href="model.php"><span class="title">Model Add</span></a>
			</li>
			<li class="<?php echo $sidebarModelListMenu;?>">
				<a href="model_list.php"><span class="title">Models List</span></a>
			</li>
		</ul>
	</li>
	<?php } ?>
	<?php if($_SESSION['adminPermission']['dealer']=="1"){ ?>
	<li class="<?php echo $sidebarDealerMenu;?>">
		<a href="javascript:void(0)"><i class="clip-paperplane"></i>
			<span class="title"> Dealer </span><i class="icon-arrow"></i>
			<span class="selected"></span>
		</a>
		<ul class="sub-menu">
			<li class="<?php echo $sidebarDealerAdd;?>">
				<a href="dealer.php"><span class="title"> Add Chassis No.</span></a>
			</li>
			<li class="<?php echo $sidebarDealerGateList;?>">
				<a href="dealer_gatepass_list.php"><span class="title"> Gatepass Generate </span></a>
			</li>
			<li class="<?php echo $sidebarDealerBillList;?>">
				<a href="dealer_bill_list.php"><span class="title"> Bill Generate </span></a>
			</li>
			<!--<li class="<?php echo $sidebarDealerList;?>">
				<a href="dealer_list.php"><span class="title">Dealer List</span></a>
			</li>-->
		</ul>
	</li>
	<?php } ?>
	<?php if($_SESSION['adminPermission']['sales_man']=="1"){ ?>
	<li class="<?php echo $sidebarSalesmanMenu;?>">
		<a href="javascript:void(0)"><i class="clip-users"></i>
			<span class="title"> Sales Man </span><i class="icon-arrow"></i>
			<span class="selected"></span>
		</a>
		<ul class="sub-menu">
			<li class="<?php echo $sidebarSalesmanAddMenu;?>">
				<a href="salesman.php"><span class="title">Sales Man Add</span></a>
			</li>
			<li class="<?php echo $sidebarSalesmanListMenu;?>">
				<a href="salesman_list.php"><span class="title">Sales Man List</span></a>
			</li>
		</ul>
	</li>
	<?php } ?>
	<?php if($_SESSION['adminPermission']['branch']=="1"){ ?>
	<li class="<?php echo $sidebarBranchMenu;?>">
		<a href="javascript:void(0)"><i class="clip-expand"></i>
			<span class="title"> Branch </span><i class="icon-arrow"></i>
			<span class="selected"></span>
		</a>
		<ul class="sub-menu">
			<li class="<?php echo $sidebarBranchAdd;?>">
				<a href="branch.php"><span class="title">Branch Add</span></a>
			</li>
			<li class="<?php echo $sidebarBranchList;?>">
				<a href="branch_list.php"><span class="title">Branch List</span></a>
			</li>
		</ul>
	</li>
	<?php } ?>
	<?php if($_SESSION['adminPermission']['showroom']=="1"){ ?>
	<li class="<?php echo $sidebarProductMenu;?>">
		<a href="javascript:void(0)"><i class="clip-world"></i>
			<span class="title"> Showroom Veihicle </span><i class="icon-arrow"></i>
			<span class="selected"></span>
		</a>
		<ul class="sub-menu">
			<li class="<?php echo $sidebarProductMainMenu;?>">
				<a href="product.php"><span class="title">Single Veihicle Add</span></a>
			</li>
			<li class="<?php echo $sidebarProductExcelMenu;?>">
				<a href="product_excel.php"><span class="title">Excel File Add</span></a>
			</li>
			<li class="<?php echo $sidebarProductQrcodeMenu;?>">
				<a href="generate_qrcode.php"><span class="title">Generate BarCode</span></a>
			</li>
			<li class="<?php echo $sidebarProductPDITodayMenu;?>">
				<a href="product_pdi_today.php"><span class="title">PDI Add Today</span></a>
			</li>
			<li class="<?php echo $sidebarProductPDIMenu;?>">
				<a href="product_pdi.php"><span class="title">PDI Add All</span></a>
			</li>
			<li class="<?php echo $sidebarProductDirectSaleMenu;?>">
				<a href="product_direct_sale.php"><span class="title">Direct Sale</span></a>
			</li>
			<li class="<?php echo $sidebarProductListTodayMenu;?>">
				<a href="product_list_today.php"><span class="title">Today Veihicle</span></a>
			</li>
			<li class="<?php echo $sidebarProductMainListMenu;?>">
				<a href="product_list.php"><span class="title">Showroom Vehicle List</span></a>
			</li>
			<li class="<?php echo $sidebarProductMainListReportMenu;?>">
				<a href="product_list_report.php"><span class="title">Showroom Vehicle List Report</span></a>
			</li>
		</ul>
	</li>
	<?php } ?>
	<?php if($_SESSION['adminPermission']['cashier']=="1"){ ?>
	<li class="<?php echo $sidebarCashierMenu;?>">
		<a href="javascript:void(0)"><i class="clip-banknote"></i>
			<span class="title"> Cashier </span><i class="icon-arrow"></i>
			<span class="selected"></span>
		</a>
		<ul class="sub-menu">
			<li class="<?php echo $sidebarCashierSearch;?>">
				<a href="cashier.php"><span class="title">Cashier Search</span></a>
			</li>
			<li class="<?php echo $sidebarCashierAdd;?>">
				<a href="cashier_add.php"><span class="title">Cashier Add</span></a>
			</li>
			<li class="<?php echo $sidebarCashierExtraList;?>">
				<a href="cashier_extra_list.php"><span class="title">Cashier Extra List</span></a>
			</li>
			<li class="<?php echo $sidebarCashierListToday;?>">
				<a href="cashier_list_today.php"><span class="title">Cashier List Today </span></a>
			</li>
			<li class="<?php echo $sidebarCashierList;?>">
				<a href="cashier_list.php"><span class="title">Cashier List All</span></a>
			</li>
			<li class="<?php echo $sidebarCashierPendingList;?>">
				<a href="cashier_pending_list.php"><span class="title">Pending Amount List</span></a>
			</li>
			<li class="<?php echo $sidebarCashierAdvbook;?>">
				<a href="advance_booking.php"><span class="title">Advance Booking</span></a>
			</li>
			<li class="<?php echo $sidebarCashierAdvbookList;?>">
				<a href="advance_booking_list.php"><span class="title">Advance Booking List</span></a>
			</li>
		</ul>
	</li>
	<?php } ?>
	<?php if($_SESSION['adminPermission']['expence']=="1"){ ?>
	<li class="<?php echo $sidebarExpenseMenu;?>">
		<a href="javascript:void(0)"><i class="fa fa-rupee"></i>
			<span class="title"> Expense </span><i class="icon-arrow"></i>
			<span class="selected"></span>
		</a>
		<ul class="sub-menu">
			<li class="<?php echo $sidebarExpenseAdd;?>">
				<a href="expense.php"><span class="title">Expense Add</span></a>
			</li>
			<li class="<?php echo $sidebarExpenseList;?>">
				<a href="expense_list.php"><span class="title">Expense List </span></a>
			</li>
		</ul>
	</li>
	<?php } ?>
	<?php if($_SESSION['adminPermission']['exchange']=="1"){ ?>
	<li class="<?php echo $sidebarExchangeMenu;?>">
		<a href="javascript:void(0)"><i class="clip-arrow-3"></i>
			<span class="title"> Exchange </span><i class="icon-arrow"></i>
			<span class="selected"></span>
		</a>
		<ul class="sub-menu">
			<li class="<?php echo $sidebarExchangeList;?>">
				<a href="exchange_list.php"><span class="title">Exchange List</span></a>
			</li>
		</ul>
	</li>
	<?php } ?>
	<?php if($_SESSION['adminPermission']['finance']=="1"){ ?>
	<li class="<?php echo $sidebarFinanceMenu;?>">
		<a href="javascript:void(0)"><i class="clip-tree"></i>
			<span class="title"> Finance </span><i class="icon-arrow"></i>
			<span class="selected"></span>
		</a>
		<ul class="sub-menu">
			<li class="<?php echo $sidebarFinanceList;?>">
				<a href="finance_list.php"><span class="title">Finance List</span></a>
			</li>
		</ul>
	</li>
	<?php } ?>
	<?php if($_SESSION['adminPermission']['atm']=="1"){ ?>
	<li class="<?php echo $sidebarAtmMenu;?>">
		<a href="javascript:void(0)"><i class="clip-note"></i>
			<span class="title"> ATM </span><i class="icon-arrow"></i>
			<span class="selected"></span>
		</a>
		<ul class="sub-menu">
			<li class="<?php echo $sidebarAtmAdd;?>">
				<a href="atm.php"><span class="title">ATM Add</span></a>
			</li>
			<li class="<?php echo $sidebarAtmList;?>">
				<a href="atm_list.php"><span class="title">ATM List</span></a>
			</li>
		</ul>
	</li>
	<?php } ?>
	<?php if($_SESSION['adminPermission']['bank']=="1"){ ?>
	<li class="<?php echo $sidebarBankMenu;?>">
		<a href="javascript:void(0)"><i class="clip-note"></i>
			<span class="title"> Bank </span><i class="icon-arrow"></i>
			<span class="selected"></span>
		</a>
		<ul class="sub-menu">
			<li class="<?php echo $sidebarBankAdd;?>">
				<a href="bank.php"><span class="title">Bank</span></a>
			</li>
			<li class="<?php echo $sidebarBankList;?>">
				<a href="bank_list.php"><span class="title">Bank List</span></a>
			</li>
		</ul>
	</li>
	<?php } ?>
	<?php if($_SESSION['adminPermission']['gatepass']=="1"){ ?>
	<li class="<?php echo $sidebarGatepassMenu;?>">
		<a href="javascript:void(0)"><i class="clip-exit"></i>
			<span class="title"> Gate Pass </span><i class="icon-arrow"></i>
			<span class="selected"></span>
		</a>
		<ul class="sub-menu">
			<li class="<?php echo $sidebarGatepassSearch;?>">
				<a href="gatepass.php"><span class="title">Gatepass Search</span></a>
			</li>
			<li class="<?php echo $sidebarGatepassListToday;?>">
				<a href="gatepass_list_today.php"><span class="title">Gatepass List Today</span></a>
			</li>
			<li class="<?php echo $sidebarGatepassList;?>">
				<a href="gatepass_list.php"><span class="title">Gatepass List All</span></a>
			</li>
		</ul>
	</li>
	<?php } ?>
	<?php if($_SESSION['adminPermission']['billing']=="1"){ ?>
	<li class="<?php echo $sidebarBillMenu;?>">
		<a href="javascript:void(0)"><i class="clip-file-openoffice"></i>
			<span class="title"> Billing </span><i class="icon-arrow"></i>
			<span class="selected"></span>
		</a>
		<ul class="sub-menu">
			<li class="<?php echo $sidebarBillSearch;?>">
				<a href="billing.php"><span class="title">Billing Search</span></a>
			</li>
			<li class="<?php echo $sidebarBillTodayList;?>">
				<a href="billing_today_list.php"><span class="title">Billing List Today</span></a>
			</li>
			<li class="<?php echo $sidebarBillList;?>">
				<a href="billing_list.php"><span class="title">Billing List All</span></a>
			</li>
			<li class="<?php echo $sidebarBillListService;?>">
				<a href="billing_list_service.php"><span class="title">Service List </span></a>
			</li>
		</ul>
	</li>
	<?php } ?>
	<?php if($_SESSION['adminPermission']['rto']=="1"){ ?>
	<li class="<?php echo $sidebarRTOMenu;?>">
		<a href="javascript:void(0)"><i class="clip-lamp"></i>
			<span class="title"> RTO </span><i class="icon-arrow"></i>
			<span class="selected"></span>
		</a>
		<ul class="sub-menu">
			<li class="<?php echo $sidebarRTOAdd;?>">
				<a href="rto.php"><span class="title">RTO Search</span></a>
			</li>
			<li class="<?php echo $sidebarRTOList;?>">
				<a href="rto_list.php"><span class="title">RTO List</span></a>
			</li>
		</ul>
	</li>
	<?php } ?>
	<?php if($_SESSION['adminPermission']['report']=="1"){ ?>
	<li class="<?php echo $sidebarReportMenu;?>">
		<a href="javascript:void(0)"><i class="clip-file-pdf"></i>
			<span class="title"> Report </span><i class="icon-arrow"></i>
			<span class="selected"></span>
		</a>
		<ul class="sub-menu">
			<!--<li class="<?php echo $sidebarReportCase;?>">
				<a href="rp_cashier.php"><span class="title"> Cashier Main </span></a>
			</li>
			<li class="<?php echo $sidebarReportCaseBranch;?>">
				<a href="rp_cashier_branch.php"><span class="title"> Cashier Branch </span></a>
			</li>-->
			<li class="<?php echo $sidebarReportAtm;?>">
				<a href="rp_atm.php"><span class="title"> ATM </span></a>
			</li>
			<li class="<?php echo $sidebarReportExpe;?>">
				<a href="rp_expense.php"><span class="title"> Expense </span></a>
			</li>
			<?php if($_SESSION['adminPermission']['re_passing']=="1"){ ?>
			<li class="<?php echo $sidebarReportPass;?>">
				<a href="passing_list.php"><span class="title"> Passing </span></a>
			</li>
			<?php } ?>
			<?php if($_SESSION['adminPermission']['re_total']=="1"){ ?>
			<li class="<?php echo $sidebarReportTotal;?>">
				<a href="rp_total.php"><span class="title"> Total </span></a>
			</li>
			<?php } ?>
			<?php if($_SESSION['adminPermission']['re_stock']=="1"){ ?>
			<li class="<?php echo $sidebarReportStock;?>">
				<a href="rp_stock.php"><span class="title"> Stock </span></a>
			</li>
			<?php } ?>
			<?php if($_SESSION['adminPermission']['re_incentive']=="1"){ ?>
			<li class="<?php echo $sidebarReportIncentive;?>">
				<a href="rp_incentive.php"><span class="title"> Incentive </span></a>
			</li>
			<?php } ?>
		</ul>
	</li>
	<?php } ?>
</ul>
<!-- end: MAIN NAVIGATION MENU -->