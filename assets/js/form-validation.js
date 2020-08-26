// Login Validation
$('#form-login').validate({
	errorElement: "span", // contain the error msg in a span tag
	errorClass: 'help-block',
	errorPlacement: function (error, element) { // render error placement for each input type
		if (element.attr("type") == "radio" || element.attr("type") == "checkbox") { // for chosen elements, need to insert the error after the chosen container
			error.insertAfter($(element).closest('.form-group').children('div').children().last());
		} else if (element.attr("name") == "dd" || element.attr("name") == "mm" || element.attr("name") == "yyyy") {
			error.insertAfter($(element).closest('.form-group').children('div'));
		} else {
			error.insertAfter(element);
			// for other inputs, just perform default behavior
		}
	},
	ignore: "",
	rules: {
		email: {
			required: true,
			email:true
		},
		password: {
			required: true,
			nowhitespace:true,
		},
		password_again: {
			required: true,
			equalTo: "#password"
		},
	},
	messages: {
	},
	invalidHandler: function (event, validator) { //display error alert on form submit
	},
	highlight: function (element) {
		$(element).closest('.help-block').removeClass('valid');
		// display OK icon
		$(element).closest('.form-group').removeClass('has-success').addClass('has-error').find('.symbol').removeClass('ok').addClass('required');
		// add the Bootstrap error class to the control group
	},
	unhighlight: function (element) { // revert the change done by hightlight
		$(element).closest('.form-group').removeClass('has-error');
		// set error class to the control group
	},
	success: function (label, element) {
		label.addClass('help-block valid');
		// mark the current input as valid and display OK icon
		$(element).closest('.form-group').removeClass('has-error').addClass('has-success').find('.symbol').removeClass('required').addClass('ok');
	},
	submitHandler: function (form) {
		// submit form
		//$('#form').submit();
	}
});

// Register Validation
$('#form-register').validate({
	errorElement: "span", // contain the error msg in a span tag
	errorClass: 'help-block',
	errorPlacement: function (error, element) { // render error placement for each input type
		if (element.attr("type") == "radio" || element.attr("type") == "checkbox") { // for chosen elements, need to insert the error after the chosen container
			error.insertAfter($(element).closest('.form-group').children('div').children().last());
		} else if (element.attr("name") == "dd" || element.attr("name") == "mm" || element.attr("name") == "yyyy") {
			error.insertAfter($(element).closest('.form-group').children('div'));
		} else {
			error.insertAfter(element);
			// for other inputs, just perform default behavior
		}
	},
	ignore: "",
	rules: {
		role: {
			required: true,
		},
		username: {
			required: true,
			nowhitespace:true
		},
		email: {
			required: true,
			email:true
		},
		password: {
			required: true,
			nowhitespace:true,
			minlength:6
		},
		password_again: {
			required: true,
			equalTo: "#password"
		},
	},
	messages: {
	},
	invalidHandler: function (event, validator) { //display error alert on form submit
	},
	highlight: function (element) {
		$(element).closest('.help-block').removeClass('valid');
		// display OK icon
		$(element).closest('.form-group').removeClass('has-success').addClass('has-error').find('.symbol').removeClass('ok').addClass('required');
		// add the Bootstrap error class to the control group
	},
	unhighlight: function (element) { // revert the change done by hightlight
		$(element).closest('.form-group').removeClass('has-error');
		// set error class to the control group
	},
	success: function (label, element) {
		label.addClass('help-block valid');
		// mark the current input as valid and display OK icon
		$(element).closest('.form-group').removeClass('has-error').addClass('has-success').find('.symbol').removeClass('required').addClass('ok');
	},
	submitHandler: function (form) {
		// submit form
		//$('#form').submit();
	}
});

// Admin Validation
$('#admin-add-frm').validate({
	errorElement: "span", // contain the error msg in a span tag
	errorClass: 'help-block',
	errorPlacement: function (error, element) { // render error placement for each input type
		if (element.attr("type") == "radio" || element.attr("type") == "checkbox") { // for chosen elements, need to insert the error after the chosen container
			error.insertAfter($(element).closest('.form-group').children('div').children().last());
		} else if (element.attr("name") == "dd" || element.attr("name") == "mm" || element.attr("name") == "yyyy") {
			error.insertAfter($(element).closest('.form-group').children('div'));
		} else {
			error.insertAfter(element);
			// for other inputs, just perform default behavior
		}
	},
	ignore: "",
	rules: {
		role: {
			required: true,
		},
		username: {
			required: true,
			nowhitespace:true
		},
		email: {
			required: true,
			email:true
		},
		password: {
			required: true,
			nowhitespace:true,
			minlength:6
		},
		password_again: {
			required: true,
			equalTo: "#password"
		},
		cli_phone: {
			number:true,
			minlength:10,
		},
	},
	messages: {
		username: {
			name:"Invalid Username"
		}
	},
	invalidHandler: function (event, validator) { //display error alert on form submit
	},
	highlight: function (element) {
		$(element).closest('.help-block').removeClass('valid');
		// display OK icon
		$(element).closest('.form-group').removeClass('has-success').addClass('has-error').find('.symbol').removeClass('ok').addClass('required');
		// add the Bootstrap error class to the control group
	},
	unhighlight: function (element) { // revert the change done by hightlight
		$(element).closest('.form-group').removeClass('has-error');
		// set error class to the control group
	},
	success: function (label, element) {
		label.addClass('help-block valid');
		// mark the current input as valid and display OK icon
		$(element).closest('.form-group').removeClass('has-error').addClass('has-success').find('.symbol').removeClass('required').addClass('ok');
	},
	submitHandler: function (form) {
		// submit form
		//$('#form').submit();
	}
});

// Model Validation
$('#model-add-frm').validate({
	errorElement: "span", // contain the error msg in a span tag
	errorClass: 'help-block',
	errorPlacement: function (error, element) { // render error placement for each input type
		if (element.attr("type") == "radio" || element.attr("type") == "checkbox") { // for chosen elements, need to insert the error after the chosen container
			error.insertAfter($(element).closest('.form-group').children('div').children().last());
		} else if (element.attr("name") == "dd" || element.attr("name") == "mm" || element.attr("name") == "yyyy") {
			error.insertAfter($(element).closest('.form-group').children('div'));
		} else {
			error.insertAfter(element);
			// for other inputs, just perform default behavior
		}
	},
	ignore: "",
	rules: {
		name: {
			required: true,
		},
		price: {
			required: true,
			number:true,
			maxlength:8
		},
		rto_single: {
			required: true,
			number:true,
			maxlength:8
		},
		rto_double: {
			number:true,
			maxlength:8
		},
		insurance: {
			number:true,
			maxlength:8
		},
		no_plate_fitting: 
		{
			required: true,
			number:true,
			maxlength:8
		},
		rmc_tax: {
			required: true,
			number:true,
			maxlength:8
		},
		access_half:{
			number:true,
			maxlength:8
		},
		access_full:{
			number:true,
			maxlength:8
		},
		amc:{
			number:true,
			maxlength:8
		},
		ex_warranty:{
			number:true,
			maxlength:8
		},
		year_2_insurance:{
			number:true,
			maxlength:8
		},
		year_3_insurance:{
			number:true,
			maxlength:8
		},
	},
	messages: {
		username: {
			name:"Invalid Username"
		}
	},
	invalidHandler: function (event, validator) { //display error alert on form submit
	},
	highlight: function (element) {
		$(element).closest('.help-block').removeClass('valid');
		// display OK icon
		$(element).closest('.form-group').removeClass('has-success').addClass('has-error').find('.symbol').removeClass('ok').addClass('required');
		// add the Bootstrap error class to the control group
	},
	unhighlight: function (element) { // revert the change done by hightlight
		$(element).closest('.form-group').removeClass('has-error');
		// set error class to the control group
	},
	success: function (label, element) {
		label.addClass('help-block valid');
		// mark the current input as valid and display OK icon
		$(element).closest('.form-group').removeClass('has-error').addClass('has-success').find('.symbol').removeClass('required').addClass('ok');
	},
	submitHandler: function (form) {
		// submit form
		form.submit();
	}
});

// Expense Validation
$('#expense-add-frm').validate({
	errorElement: "span", // contain the error msg in a span tag
	errorClass: 'help-block',
	errorPlacement: function (error, element) { // render error placement for each input type
		if (element.attr("type") == "radio" || element.attr("type") == "checkbox") { // for chosen elements, need to insert the error after the chosen container
			error.insertAfter($(element).closest('.form-group').children('div').children().last());
		} else if (element.attr("name") == "dd" || element.attr("name") == "mm" || element.attr("name") == "yyyy") {
			error.insertAfter($(element).closest('.form-group').children('div'));
		} else {
			error.insertAfter(element);
			// for other inputs, just perform default behavior
		}
	},
	ignore: "",
	rules: {
		purpose: {
			required: true,
		},
		amount: {
			required: true,
			number:true,
			maxlength:8
		},
	},
	messages: {
	},
	invalidHandler: function (event, validator) { //display error alert on form submit
	},
	highlight: function (element) {
		$(element).closest('.help-block').removeClass('valid');
		// display OK icon
		$(element).closest('.form-group').removeClass('has-success').addClass('has-error').find('.symbol').removeClass('ok').addClass('required');
		// add the Bootstrap error class to the control group
	},
	unhighlight: function (element) { // revert the change done by hightlight
		$(element).closest('.form-group').removeClass('has-error');
		// set error class to the control group
	},
	success: function (label, element) {
		label.addClass('help-block valid');
		// mark the current input as valid and display OK icon
		$(element).closest('.form-group').removeClass('has-error').addClass('has-success').find('.symbol').removeClass('required').addClass('ok');
	},
	submitHandler: function (form) {
		// submit form
		form.submit();
	}
});

// Billing Validation
$('#billing_add_frm').validate({
	errorElement: "span", // contain the error msg in a span tag
	errorClass: 'help-block',
	errorPlacement: function (error, element) { // render error placement for each input type
		if (element.attr("type") == "radio" || element.attr("type") == "checkbox") { // for chosen elements, need to insert the error after the chosen container
			error.insertAfter($(element).closest('.form-group').children('div').children().last());
		} else if (element.attr("name") == "dd" || element.attr("name") == "mm" || element.attr("name") == "yyyy") {
			error.insertAfter($(element).closest('.form-group').children('div'));
		} else {
			error.insertAfter(element);
			// for other inputs, just perform default behavior
		}
	},
	ignore: "",
	rules: {
		service_book: {
			required: true,
		},
	},
	messages: {
	},
	invalidHandler: function (event, validator) { //display error alert on form submit
	},
	highlight: function (element) {
		$(element).closest('.help-block').removeClass('valid');
		// display OK icon
		$(element).closest('.form-group').removeClass('has-success').addClass('has-error').find('.symbol').removeClass('ok').addClass('required');
		// add the Bootstrap error class to the control group
	},
	unhighlight: function (element) { // revert the change done by hightlight
		$(element).closest('.form-group').removeClass('has-error');
		// set error class to the control group
	},
	success: function (label, element) {
		label.addClass('help-block valid');
		// mark the current input as valid and display OK icon
		$(element).closest('.form-group').removeClass('has-error').addClass('has-success').find('.symbol').removeClass('required').addClass('ok');
	},
	submitHandler: function (form) {
		// submit form
		form.submit();
	}
});

// Product Add Validation
$('#product-add-frm').validate({
	errorElement: "span", // contain the error msg in a span tag
	errorClass: 'help-block',
	errorPlacement: function (error, element) { // render error placement for each input type
		if (element.attr("type") == "radio" || element.attr("type") == "checkbox") { // for chosen elements, need to insert the error after the chosen container
			error.insertAfter($(element).closest('.form-group').children('div').children().last());
		} else if (element.attr("name") == "dd" || element.attr("name") == "mm" || element.attr("name") == "yyyy") {
			error.insertAfter($(element).closest('.form-group').children('div'));
		} else {
			error.insertAfter(element);
			// for other inputs, just perform default behavior
		}
	},
	ignore: "",
	rules: {
		chassis_no: {
			required: true,
			nowhitespace:true,
			minlength:17,
			maxlength:17
		},
		eng_no: {
			required: true
		},
	},
	messages: {
		
	},
	invalidHandler: function (event, validator) { //display error alert on form submit
	},
	highlight: function (element) {
		$(element).closest('.help-block').removeClass('valid');
		// display OK icon
		$(element).closest('.form-group').removeClass('has-success').addClass('has-error').find('.symbol').removeClass('ok').addClass('required');
		// add the Bootstrap error class to the control group
	},
	unhighlight: function (element) { // revert the change done by hightlight
		$(element).closest('.form-group').removeClass('has-error');
		// set error class to the control group
	},
	success: function (label, element) {
		label.addClass('help-block valid');
		// mark the current input as valid and display OK icon
		$(element).closest('.form-group').removeClass('has-error').addClass('has-success').find('.symbol').removeClass('required').addClass('ok');
	},
	submitHandler: function (form) {
		// submit form
		form.submit();
	}
});

// Upload CSV Validation
$('#upload_csv-add-frm').validate({
	errorElement: "span", // contain the error msg in a span tag
	errorClass: 'help-block',
	errorPlacement: function (error, element) { // render error placement for each input type
		if (element.attr("type") == "radio" || element.attr("type") == "checkbox") { // for chosen elements, need to insert the error after the chosen container
			error.insertAfter($(element).closest('.form-group').children('div').children().last());
		} else if (element.attr("name") == "dd" || element.attr("name") == "mm" || element.attr("name") == "yyyy") {
			error.insertAfter($(element).closest('.form-group').children('div'));
		} else {
			error.insertAfter(element);
			// for other inputs, just perform default behavior
		}
	},
	ignore: "",
	rules: {
		image: {
			required: true,
			extension: "csv"
		},
	},
	messages: {
		image: {
			required:"Select .CSV File then continue...",
			extension:"Only Upload .CSV File..."
		}
	},
	invalidHandler: function (event, validator) { //display error alert on form submit
	},
	highlight: function (element) {
		$(element).closest('.help-block').removeClass('valid');
		// display OK icon
		$(element).closest('.form-group').removeClass('has-success').addClass('has-error').find('.symbol').removeClass('ok').addClass('required');
		// add the Bootstrap error class to the control group
	},
	unhighlight: function (element) { // revert the change done by hightlight
		$(element).closest('.form-group').removeClass('has-error');
		// set error class to the control group
	},
	success: function (label, element) {
		label.addClass('help-block valid');
		// mark the current input as valid and display OK icon
		$(element).closest('.form-group').removeClass('has-error').addClass('has-success').find('.symbol').removeClass('required').addClass('ok');
	},
	submitHandler: function (form) {
		// submit form
		form.submit();
	}
});

// Product Single QR Code Validation
$('#product-single-qrcode').validate({
	errorElement: "span", // contain the error msg in a span tag
	errorClass: 'help-block',
	errorPlacement: function (error, element) { // render error placement for each input type
		if (element.attr("type") == "radio" || element.attr("type") == "checkbox") { // for chosen elements, need to insert the error after the chosen container
			error.insertAfter($(element).closest('.form-group').children('div').children().last());
		} else if (element.attr("name") == "dd" || element.attr("name") == "mm" || element.attr("name") == "yyyy") {
			error.insertAfter($(element).closest('.form-group').children('div'));
		} else {
			error.insertAfter(element);
			// for other inputs, just perform default behavior
		}
	},
	ignore: "",
	rules: {
		single_qrcode: {
			required: true
		},
	},
	messages: {
		single_qrcode: {
			required:"Select Enter Right Chassis no...",
		}
	},
	invalidHandler: function (event, validator) { //display error alert on form submit
	},
	highlight: function (element) {
		$(element).closest('.help-block').removeClass('valid');
		// display OK icon
		$(element).closest('.form-group').removeClass('has-success').addClass('has-error').find('.symbol').removeClass('ok').addClass('required');
		// add the Bootstrap error class to the control group
	},
	unhighlight: function (element) { // revert the change done by hightlight
		$(element).closest('.form-group').removeClass('has-error');
		// set error class to the control group
	},
	success: function (label, element) {
		label.addClass('help-block valid');
		// mark the current input as valid and display OK icon
		$(element).closest('.form-group').removeClass('has-error').addClass('has-success').find('.symbol').removeClass('required').addClass('ok');
	},
	submitHandler: function (form) {
		// submit form
		form.submit();
	}
});

// Veihicle Status Search Validation 'AND' Cashier Search Chassis No Validation 'AND' Gate Pass Search Validation 'AND' Direct Sale Search Validation 'AND' Billing Search Validation 'AND' Dealer Search Validation
$('#veihicle_status_search, #cashier_search, #gatepass_search, #direct_sale_search, #billing_search, #dealer_search').validate({
	errorElement: "span", // contain the error msg in a span tag
	errorClass: 'help-block',
	errorPlacement: function (error, element) { // render error placement for each input type
		if (element.attr("type") == "radio" || element.attr("type") == "checkbox") { // for chosen elements, need to insert the error after the chosen container
			error.insertAfter($(element).closest('.form-group').children('div').children().last());
		} else if (element.attr("name") == "dd" || element.attr("name") == "mm" || element.attr("name") == "yyyy") {
			error.insertAfter($(element).closest('.form-group').children('div'));
		} else {
			error.insertAfter(element);
			// for other inputs, just perform default behavior
		}
	},
	ignore: "",
	rules: {
		search: {
			required: true
		},
	},
	messages: {
		search: {
			required:"Please Enter Right Chassis no...",
		}
	},
	invalidHandler: function (event, validator) { //display error alert on form submit
	},
	highlight: function (element) {
		$(element).closest('.help-block').removeClass('valid');
		// display OK icon
		$(element).closest('.form-group').removeClass('has-success').addClass('has-error').find('.symbol').removeClass('ok').addClass('required');
		// add the Bootstrap error class to the control group
	},
	unhighlight: function (element) { // revert the change done by hightlight
		$(element).closest('.form-group').removeClass('has-error');
		// set error class to the control group
	},
	success: function (label, element) {
		label.addClass('help-block valid');
		// mark the current input as valid and display OK icon
		$(element).closest('.form-group').removeClass('has-error').addClass('has-success').find('.symbol').removeClass('required').addClass('ok');
	},
	submitHandler: function (form) {
		// submit form
		form.submit();
	}
});

// Cashier Add Product Validation
$('#cashier_add_frm').validate({
	errorElement: "span", // contain the error msg in a span tag
	errorClass: 'help-block',
	errorPlacement: function (error, element) { // render error placement for each input type
		if (element.attr("type") == "radio" || element.attr("type") == "checkbox") { // for chosen elements, need to insert the error after the chosen container
			error.insertAfter($(element).closest('.form-group').children('div').children().last());
		} else if (element.attr("name") == "dd" || element.attr("name") == "mm" || element.attr("name") == "yyyy") {
			error.insertAfter($(element).closest('.form-group').children('div'));
		} else {
			error.insertAfter(element);
			// for other inputs, just perform default behavior
		}
	},
	ignore: "",
	rules: {
		salesman_id: {
			required: true
		},
		name: {
			required: true
		},
		mobile: {
			required: true,
			number:true,
			minlength:10
		},
		street_add1: {
			required: true
		},
		type: {
			required: true
		},
		price: {
			required: true,
			number:true,
			maxlength:10
		},
		pending: {
			number:true,
			maxlength:10
		},
		exchange_amount: {
			number:true,
			maxlength:10
		},
		dp_amount: {
			number:true,
			maxlength:10
		},
		finance_amount: {
			number:true,
			maxlength:10
		},
		amount_in_word: {
			required: true
		},
		key_no: {
			required: true
		}
	},
	messages: {
		sales_man: {
			required:"Please Enter Sales Man...",
		},
		name: {
			required:"Please Enter Customer Name...",
		},
		type: {
			required:"Please Select Payment Type...",
		},
		price: {
			required:"Please Enter Price...",
		},
		amount_in_word: {
			required:"Please Enter Amount in Word...",
		},
	},
	invalidHandler: function (event, validator) { //display error alert on form submit
	},
	highlight: function (element) {
		$(element).closest('.help-block').removeClass('valid');
		// display OK icon
		$(element).closest('.form-group').removeClass('has-success').addClass('has-error').find('.symbol').removeClass('ok').addClass('required');
		// add the Bootstrap error class to the control group
	},
	unhighlight: function (element) { // revert the change done by hightlight
		$(element).closest('.form-group').removeClass('has-error');
		// set error class to the control group
	},
	success: function (label, element) {
		label.addClass('help-block valid');
		// mark the current input as valid and display OK icon
		$(element).closest('.form-group').removeClass('has-error').addClass('has-success').find('.symbol').removeClass('required').addClass('ok');
	},
	submitHandler: function (form) {
		// submit form
		form.submit();
	}
});

// Cashier Add Advance Booking Validation
$('#cashier_avdbook_add_frm').validate({
	errorElement: "span", // contain the error msg in a span tag
	errorClass: 'help-block',
	errorPlacement: function (error, element) { // render error placement for each input type
		if (element.attr("type") == "radio" || element.attr("type") == "checkbox") { // for chosen elements, need to insert the error after the chosen container
			error.insertAfter($(element).closest('.form-group').children('div').children().last());
		} else if (element.attr("name") == "dd" || element.attr("name") == "mm" || element.attr("name") == "yyyy") {
			error.insertAfter($(element).closest('.form-group').children('div'));
		} else {
			error.insertAfter(element);
			// for other inputs, just perform default behavior
		}
	},
	ignore: "",
	rules: {
		model: {
			required: true
		},
		sales_man: {
			required: true
		},
		name: {
			required: true
		},
		book_type: {
			required: true
		},
		mobile: {
			required: true,
			number:true,
			minlength:10
		},
		price: {
			required: true,
			number:true,
			maxlength:10
		},
		ex_rate: {
			number:true,
			maxlength:10
		},
		onroad_price: {
			required: true,
			number:true,
			maxlength:10
		},
	},
	messages: {
		sales_man: {
			required:"Please Enter Sales Man...",
		},
		name: {
			required:"Please Enter Customer Name...",
		},
		price: {
			required:"Please Enter Price...",
		},
	},
	invalidHandler: function (event, validator) { //display error alert on form submit
	},
	highlight: function (element) {
		$(element).closest('.help-block').removeClass('valid');
		// display OK icon
		$(element).closest('.form-group').removeClass('has-success').addClass('has-error').find('.symbol').removeClass('ok').addClass('required');
		// add the Bootstrap error class to the control group
	},
	unhighlight: function (element) { // revert the change done by hightlight
		$(element).closest('.form-group').removeClass('has-error');
		// set error class to the control group
	},
	success: function (label, element) {
		label.addClass('help-block valid');
		// mark the current input as valid and display OK icon
		$(element).closest('.form-group').removeClass('has-error').addClass('has-success').find('.symbol').removeClass('required').addClass('ok');
	},
	submitHandler: function (form) {
		// submit form
		form.submit();
	}
});

// Sales Man Validation
$('#salesman-add-frm').validate({
	errorElement: "span", // contain the error msg in a span tag
	errorClass: 'help-block',
	errorPlacement: function (error, element) { // render error placement for each input type
		if (element.attr("type") == "radio" || element.attr("type") == "checkbox") { // for chosen elements, need to insert the error after the chosen container
			error.insertAfter($(element).closest('.form-group').children('div').children().last());
		} else if (element.attr("name") == "dd" || element.attr("name") == "mm" || element.attr("name") == "yyyy") {
			error.insertAfter($(element).closest('.form-group').children('div'));
		} else {
			error.insertAfter(element);
			// for other inputs, just perform default behavior
		}
	},
	ignore: "",
	rules: {
		name: {
			required: true
		},
		mobile: {
			number:true,
			minlength:10
		}
	},
	messages: {
		sales_man: {
			required:"Please Enter Sales Man...",
		},
		name: {
			required:"Please Enter Customer Name...",
		},
		price: {
			required:"Please Enter Price...",
		},
	},
	invalidHandler: function (event, validator) { //display error alert on form submit
	},
	highlight: function (element) {
		$(element).closest('.help-block').removeClass('valid');
		// display OK icon
		$(element).closest('.form-group').removeClass('has-success').addClass('has-error').find('.symbol').removeClass('ok').addClass('required');
		// add the Bootstrap error class to the control group
	},
	unhighlight: function (element) { // revert the change done by hightlight
		$(element).closest('.form-group').removeClass('has-error');
		// set error class to the control group
	},
	success: function (label, element) {
		label.addClass('help-block valid');
		// mark the current input as valid and display OK icon
		$(element).closest('.form-group').removeClass('has-error').addClass('has-success').find('.symbol').removeClass('required').addClass('ok');
	},
	submitHandler: function (form) {
		// submit form
		form.submit();
	}
});

// Cashier Extra Add Validation
$('#cashier_extra_add_frm').validate({
	errorElement: "span", // contain the error msg in a span tag
	errorClass: 'help-block',
	errorPlacement: function (error, element) { // render error placement for each input type
		if (element.attr("type") == "radio" || element.attr("type") == "checkbox") { // for chosen elements, need to insert the error after the chosen container
			error.insertAfter($(element).closest('.form-group').children('div').children().last());
		} else if (element.attr("name") == "dd" || element.attr("name") == "mm" || element.attr("name") == "yyyy") {
			error.insertAfter($(element).closest('.form-group').children('div'));
		} else {
			error.insertAfter(element);
			// for other inputs, just perform default behavior
		}
	},
	ignore: "",
	rules: {
		payment_type: {
			required: true
		},
		amount: {
			required: true,
			number:true,
			maxlength:8
		}
	},
	messages: {
		sales_man: {
			required:"Please Enter Sales Man...",
		},
		name: {
			required:"Please Enter Customer Name...",
		},
		price: {
			required:"Please Enter Price...",
		},
	},
	invalidHandler: function (event, validator) { //display error alert on form submit
	},
	highlight: function (element) {
		$(element).closest('.help-block').removeClass('valid');
		// display OK icon
		$(element).closest('.form-group').removeClass('has-success').addClass('has-error').find('.symbol').removeClass('ok').addClass('required');
		// add the Bootstrap error class to the control group
	},
	unhighlight: function (element) { // revert the change done by hightlight
		$(element).closest('.form-group').removeClass('has-error');
		// set error class to the control group
	},
	success: function (label, element) {
		label.addClass('help-block valid');
		// mark the current input as valid and display OK icon
		$(element).closest('.form-group').removeClass('has-error').addClass('has-success').find('.symbol').removeClass('required').addClass('ok');
	},
	submitHandler: function (form) {
		// submit form
		form.submit();
	}
});

// ATM Add Validation
$('#atm-add-frm').validate({
	errorElement: "span", // contain the error msg in a span tag
	errorClass: 'help-block',
	errorPlacement: function (error, element) { // render error placement for each input type
		if (element.attr("type") == "radio" || element.attr("type") == "checkbox") { // for chosen elements, need to insert the error after the chosen container
			error.insertAfter($(element).closest('.form-group').children('div').children().last());
		} else if (element.attr("name") == "dd" || element.attr("name") == "mm" || element.attr("name") == "yyyy") {
			error.insertAfter($(element).closest('.form-group').children('div'));
		} else {
			error.insertAfter(element);
			// for other inputs, just perform default behavior
		}
	},
	ignore: "",
	rules: {
		amount: {
			required: true,
			number:true,
			maxlength:8
		}
	},
	messages: {
		sales_man: {
			required:"Please Enter Sales Man...",
		},
		name: {
			required:"Please Enter Customer Name...",
		},
		price: {
			required:"Please Enter Price...",
		},
	},
	invalidHandler: function (event, validator) { //display error alert on form submit
	},
	highlight: function (element) {
		$(element).closest('.help-block').removeClass('valid');
		// display OK icon
		$(element).closest('.form-group').removeClass('has-success').addClass('has-error').find('.symbol').removeClass('ok').addClass('required');
		// add the Bootstrap error class to the control group
	},
	unhighlight: function (element) { // revert the change done by hightlight
		$(element).closest('.form-group').removeClass('has-error');
		// set error class to the control group
	},
	success: function (label, element) {
		label.addClass('help-block valid');
		// mark the current input as valid and display OK icon
		$(element).closest('.form-group').removeClass('has-error').addClass('has-success').find('.symbol').removeClass('required').addClass('ok');
	},
	submitHandler: function (form) {
		// submit form
		form.submit();
	}
});