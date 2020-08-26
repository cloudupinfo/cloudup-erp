<div class="col-sm-12">
						<div class="page-header">
							<h3>Customer Detail <?php echo $type;?> - <small class="required-field">* asterisk mark will be compulsory</small></h3>
						</div>
						<div class="form-group">
							<label class="col-sm-2 control-label" for="form-field-1">
								Sales Man Name <span class="required-field">*</span>
							</label>
							<div class="col-sm-7">
								<select name="salesman_id" id="salesman_id" class="form-control">
									<option value="">Select Sales Man</option>
								<?php !empty($customer['salesman_id']) ? $salesmanId=$customer['salesman_id'] : $salesmanId="";
								foreach($salesmans as $salesman){?>
									<option value="<?php echo $salesman['salesman_id'];?>" <?php echo $salesmanId==$salesman['salesman_id'] ? 'selected' : '';?>><?php echo $salesman['name'];?></option>
								<?php } ?>
								</select>
							</div>
						</div>
						<div class="form-group">
							<label class="col-sm-2 control-label" for="form-field-1">
								Customer Name <span class="required-field">*</span>
							</label>
							<div class="col-sm-7">
								<input type="text" placeholder="Customer Name" id="name" class="form-control" name="name" value="<?php echo !empty($customer['name']) ? $customer['name'] : '' ?>">
							</div>
						</div>
						<div class="form-group">
							<label class="col-sm-2 control-label" for="form-field-1">
								Customer Mobile No <span class="required-field">*</span>
							</label>
							<div class="col-sm-7">
								<div class="input-group">
									<input type="text" placeholder="Customer Mobile No" id="mobile" class="form-control" name="mobile" value="<?php echo !empty($customer['mobile']) ? $customer['mobile'] : '' ?>">
									<span class="input-group-addon"> <i class="fa fa-mobile"></i> </span>
								</div>
							</div>
						</div>
						<div class="form-group">
							<label class="col-sm-2 control-label" for="form-field-1">
								Street Address 1
							</label>
							<div class="col-sm-7">
								<div class="input-group">
									<input type="text" placeholder="Street Address 1" id="street_add1" class="form-control" name="street_add1" value="<?php echo !empty($customer['street_add1']) ? $customer['street_add1'] : '' ?>">
									<span class="input-group-addon"> <i class="fa fa-map-marker"></i> </span>
								</div>
							</div>
						</div>
						<div class="form-group">
							<label class="col-sm-2 control-label" for="form-field-1">
								Street Address 2
							</label>
							<div class="col-sm-7">
								<div class="input-group">
									<input type="text" placeholder="Street Address 2" id="street_add2" class="form-control" name="street_add2" value="<?php echo !empty($customer['street_add2']) ? $customer['street_add2'] : '' ?>">
									<span class="input-group-addon"> <i class="fa fa-map-marker"></i> </span>
								</div>
							</div>
						</div>
						<div class="form-group">
							<label class="col-sm-2 control-label" for="form-field-1">
								District
							</label>
							<div class="col-sm-7">
								<?php !empty($customer['city']) ? $district=$customer['city'] : $district='Rajkot'?>
								<select id="city" class="form-control" name="city">
									<option value="Ahmedabad" <?php echo $district=="Ahmedabad" ? 'selected' : '' ?>>Ahmedabad</option>
									<option value="Amreli" <?php echo $district=="Amreli" ? 'selected' : '' ?>>Amreli</option>
									<option value="Anand" <?php echo $district=="Anand" ? 'selected' : '' ?>>Anand</option>
									<option value="Aravalli" <?php echo $district=="Aravalli" ? 'selected' : '' ?>>Aravalli</option>
									<option value="Banaskantha" <?php echo $district=="Banaskantha" ? 'selected' : '' ?>>Banaskantha</option>
									<option value="Botad" <?php echo $district=="Botad" ? 'selected' : '' ?>>Botad</option>
									<option value="Bharuch" <?php echo $district=="Bharuch" ? 'selected' : '' ?>>Bharuch</option>
									<option value="Bhavnagar" <?php echo $district=="Bhavnagar" ? 'selected' : '' ?>>Bhavnagar</option>
									<option value="Chhota Udaipur" <?php echo $district=="Chhota Udaipur" ? 'selected' : '' ?>>Chhota Udaipur</option>
									<option value="Dahod" <?php echo $district=="Dahod" ? 'selected' : '' ?>>Dahod</option>
									<option value="Devbhoomi Dwarka" <?php echo $district=="Devbhoomi Dwarka" ? 'selected' : '' ?>>Devbhoomi Dwarka</option>
									<option value="Gandhinagar" <?php echo $district=="Gandhinagar" ? 'selected' : '' ?>>Gandhinagar</option>
									<option value="Gir Somnath" <?php echo $district=="Gir Somnath" ? 'selected' : '' ?>>Gir Somnath</option>
									<option value="Jamnagar" <?php echo $district=="Jamnagar" ? 'selected' : '' ?>>Jamnagar</option>
									<option value="Junagadh" <?php echo $district=="Junagadh" ? 'selected' : '' ?>>Junagadh</option>
									<option value="Kheda" <?php echo $district=="Kheda" ? 'selected' : '' ?>>Kheda</option>
									<option value="Kutch" <?php echo $district=="Kutch" ? 'selected' : '' ?>>Kutch</option>
									<option value="Mahisagar" <?php echo $district=="Mahisagar" ? 'selected' : '' ?>>Mahisagar</option>
									<option value="Mahesana" <?php echo $district=="Mahesana" ? 'selected' : '' ?>>Mahesana</option>
									<option value="Mahesana" <?php echo $district=="Mahesana" ? 'selected' : '' ?>>Mahesana</option>
									<option value="Morbi" <?php echo $district=="Morbi" ? 'selected' : '' ?>>Morbi</option>
									<option value="Narmada" <?php echo $district=="Narmada" ? 'selected' : '' ?>>Narmada</option>
									<option value="Navsari" <?php echo $district=="Navsari" ? 'selected' : '' ?>>Navsari</option>
									<option value="Panchmahal" <?php echo $district=="Panchmahal" ? 'selected' : '' ?>>Panchmahal</option>
									<option value="Patan" <?php echo $district=="Patan" ? 'selected' : '' ?>>Patan</option>
									<option value="Porbandar" <?php echo $district=="Porbandar" ? 'selected' : '' ?>>Porbandar</option>
									<option value="Rajkot" <?php echo $district=="Rajkot" ? 'selected' : '' ?>>Rajkot</option>
									<option value="Sabarkantha" <?php echo $district=="Sabarkantha" ? 'selected' : '' ?>>Sabarkantha</option>
									<option value="Surat" <?php echo $district=="Surat" ? 'selected' : '' ?>>Surat</option>
									<option value="Surendranagar" <?php echo $district=="Surendranagar" ? 'selected' : '' ?>>Surendranagar</option>
									<option value="Tapi" <?php echo $district=="Tapi" ? 'selected' : '' ?>>Tapi</option>
									<option value="The Dangs" <?php echo $district=="The Dangs" ? 'selected' : '' ?>>The Dangs</option>
									<option value="Vadodara" <?php echo $district=="Vadodara" ? 'selected' : '' ?>>Vadodara</option>
									<option value="Valsad" <?php echo $district=="Valsad" ? 'selected' : '' ?>>Valsad</option>
								</select>
							</div>
						</div>
						<div class="form-group">
							<label class="col-sm-2 control-label" for="form-field-1">
								Country
							</label>
							<div class="col-sm-7">
								<div class="input-group">
									<input readonly type="text" placeholder="Country" id="country" class="form-control" name="country" value="<?php echo !empty($customer['country']) ? $customer['country'] : 'India' ?>">
									<span class="input-group-addon"> <i class="clip-world"></i> </span>
								</div>
							</div>
						</div>
						<div class="form-group">
							<label class="col-sm-2 control-label" for="form-field-1">
								Payment Type <span class="required-field">*</span>
							</label>
							<div class="col-sm-7">
								<?php !empty($customer['case_type']) ? $paymentType = $customer['case_type'] : $paymentType="Cash";?>
								<input type="radio" class="case_by_case" name="case_type" value="Cash" <?php echo $paymentType=="Cash" ? 'checked' : '';?>> By Cash &nbsp&nbsp&nbsp&nbsp&nbsp&nbsp
								<input type="radio" class="case_by_cheque" name="case_type" value="Cheque" <?php echo $paymentType=="Cheque" ? 'checked' : '';?>> By Cheque &nbsp&nbsp&nbsp&nbsp&nbsp&nbsp
								<input type="radio" class="case_by_dd" name="case_type" value="NEFT" <?php echo $paymentType=="NEFT" ? 'checked' : '';?>> Demand Draft &nbsp&nbsp&nbsp&nbsp&nbsp&nbsp
								<input type="radio" class="case_by_neft" name="case_type" value="NEFT" <?php echo $paymentType=="NEFT" ? 'checked' : '';?>> NEFT / RTGS
							</div>
						</div>
						<div class="by_case_cheque" style="<?php echo $paymentType=="Cheque" ? 'display:block' : 'display:none';?>;">
							<div class="form-group">
								<label class="col-sm-2 control-label"></label>
								<div class="col-sm-7">
									<h4 class="text-right"><a href="http://www.ifsc-code.com/" target="_blank">Click To Bank Find</a></h4>
								</div>
							</div>
							<div class="form-group">
								<label class="col-sm-2 control-label" for="form-field-1">
									Bank Name
								</label>
								<div class="col-sm-7">
									<div class="input-group">
										<?php !empty($customer['bank_name']) ? $bankName = $customer['case_type'] : $paymentType="Cash";?>
										<select id="bank_name" name="bank_name">
											<option selected="selected" value="">--Select Bank Name --</option>
											<option value="ABHYUDAYA COOPERATIVE BANK LTD">ABHYUDAYA COOPERATIVE BANK LTD</option>
											<option value="ABU DHABI COMMERCIAL BANK">ABU DHABI COMMERCIAL BANK</option>
											<option value="ALLAHABAD BANK">ALLAHABAD BANK</option>
											<option value="ALMORA URBAN CO.OPERATIVE BANK LTD.">ALMORA URBAN CO.OPERATIVE BANK LTD.</option>
											<option value="ANDHRA BANK">ANDHRA BANK</option>
											<option value="APNA SAHAKARI BANK LTD">APNA SAHAKARI BANK LTD</option>
											<option value="AUSTRALIA AND NEW ZEALAND BANKING GROUP LIMITED.">AUSTRALIA AND NEW ZEALAND BANKING GROUP LIMITED.</option>
											<option value="AXIS BANK">AXIS BANK</option>
											<option value="BANK OF AMERICA">BANK OF AMERICA</option>
											<option value="BANK OF BAHRAIN AND KUWAIT">BANK OF BAHRAIN AND KUWAIT</option>
											<option value="BANK OF BARODA">BANK OF BARODA</option>
											<option value="BANK OF CEYLON">BANK OF CEYLON</option>
											<option value="BANK OF INDIA">BANK OF INDIA</option>
											<option value="BANK OF MAHARASHTRA">BANK OF MAHARASHTRA</option>
											<option value="BANK OF TOKYO MITSUBISHI UFJ LTD.">BANK OF TOKYO MITSUBISHI UFJ LTD.</option>
											<option value="BARCLAYS BANK PLC">BARCLAYS BANK PLC</option>
											<option value="BASSEIN CATHOLIC CO OP BANK LTD">BASSEIN CATHOLIC CO OP BANK LTD</option>
											<option value="BNP PARIBAS">BNP PARIBAS</option>
											<option value="CANARA BANK">CANARA BANK</option>
											<option value="CAPITAL LOCAL AREA BANK LTD.">CAPITAL LOCAL AREA BANK LTD.</option>
											<option value="CATHOLIC SYRIAN BANK LTD">CATHOLIC SYRIAN BANK LTD</option>
											<option value="CENTRAL BANK OF INDIA">CENTRAL BANK OF INDIA</option>
											<option value="CHINATRUST COMMERCIAL BANK">CHINATRUST COMMERCIAL BANK</option>
											<option value="CITIBANK NA">CITIBANK NA</option>
											<option value="CITIZENCREDIT CO.OPERATIVE BANK LTD">CITIZENCREDIT CO.OPERATIVE BANK LTD</option>
											<option value="CITY UNION BANK LTD">CITY UNION BANK LTD</option>
											<option value="COMMONWEALTH BANK OF AUSTRALIA">COMMONWEALTH BANK OF AUSTRALIA</option>
											<option value="CORPORATION BANK">CORPORATION BANK</option>
											<option value="CREDIT AGRICOLE CORPORATE AND INVESTEMENT BANK">CREDIT AGRICOLE CORPORATE AND INVESTEMENT BANK</option>
											<option value="CREDIT SUISSE AG">CREDIT SUISSE AG</option>
											<option value="DBS BANK LTD">DBS BANK LTD</option>
											<option value="DENA BANK">DENA BANK</option>
											<option value="DEUTSCHE BANK">DEUTSCHE BANK</option>
											<option value="DEVELOPMENT CREDIT BANK LIMITED">DEVELOPMENT CREDIT BANK LIMITED</option>
											<option value="DHANLAXMI BANK LTD">DHANLAXMI BANK LTD</option>
											<option value="DICGC">DICGC</option>
											<option value="DOMBIVLI NAGARI SAHAKARI BANK LIMITED">DOMBIVLI NAGARI SAHAKARI BANK LIMITED</option>
											<option value="FIRSTRAND BANK LIMITED">FIRSTRAND BANK LIMITED</option>
											<option value="GURGAON GRAMIN BANK">GURGAON GRAMIN BANK</option>
											<option value="HDFC BANK LTD">HDFC BANK LTD</option>
											<option value="HSBC">HSBC</option>
											<option value="ICICI BANK LTD">ICICI BANK LTD</option>
											<option value="IDBI BANK LTD">IDBI BANK LTD</option>
											<option value="INDIAN BANK">INDIAN BANK</option>
											<option value="INDIAN OVERSEAS BANK">INDIAN OVERSEAS BANK</option>
											<option value="INDUSIND BANK LTD">INDUSIND BANK LTD</option>
											<option value="ING VYSYA BANK LTD">ING VYSYA BANK LTD</option>
											<option value="JALGAON JANATA SAHKARI BANK LTD">JALGAON JANATA SAHKARI BANK LTD</option>
											<option value="JANAKALYAN SAHAKARI BANK LTD">JANAKALYAN SAHAKARI BANK LTD</option>
											<option value="JANATA SAHAKARI BANK LTD (PUNE )">JANATA SAHAKARI BANK LTD (PUNE )</option>
											<option value="JP MORGAN CHASE BANK">JP MORGAN CHASE BANK</option>
											<option value="KALLAPPANNA AWADE ICH JANATA S BANK">KALLAPPANNA AWADE ICH JANATA S BANK</option>
											<option value="KAPOLE CO OP BANK">KAPOLE CO OP BANK</option>
											<option value="KARNATAKA BANK LTD">KARNATAKA BANK LTD</option>
											<option value="KARUR VYSYA BANK">KARUR VYSYA BANK</option>
											<option value="KOTAK MAHINDRA BANK">KOTAK MAHINDRA BANK</option>
											<option value="MAHANAGAR CO.OP BANK LTD">MAHANAGAR CO.OP BANK LTD</option>
											<option value="MAHARASHTRA STATE CO OPERATIVE BANK">MAHARASHTRA STATE CO OPERATIVE BANK</option>
											<option value="MASHREQ BANK PSC">MASHREQ BANK PSC</option>
											<option value="MIZUHO CORPORATE BANK LTD">MIZUHO CORPORATE BANK LTD</option>
											<option value="MUMBAI DISTRICT CENTRAL CO.OP. BANK LTD.">MUMBAI DISTRICT CENTRAL CO.OP. BANK LTD.</option>
											<option value="NAGPUR NAGRIK SAHAKARI BANK LTD">NAGPUR NAGRIK SAHAKARI BANK LTD</option>
											<option value="NEW INDIA CO.OPERATIVE BANK LTD">NEW INDIA CO.OPERATIVE BANK LTD</option>
											<option value="NKGSB CO.OP BANK LTD">NKGSB CO.OP BANK LTD</option>
											<option value="NORTH MALABAR GRAMIN BANK">NORTH MALABAR GRAMIN BANK</option>
											<option value="NUTAN NAGARIK SAHAKARI BANK LTD">NUTAN NAGARIK SAHAKARI BANK LTD</option>
											<option value="OMAN INTERNATIONAL BANK SAOG">OMAN INTERNATIONAL BANK SAOG</option>
											<option value="ORIENTAL BANK OF COMMERCE">ORIENTAL BANK OF COMMERCE</option>
											<option value="PARSIK JANATA SAHAKARI BANK LTD">PARSIK JANATA SAHAKARI BANK LTD</option>
											<option value="PRATHAMA BANK">PRATHAMA BANK</option>
											<option value="PRIME CO OPERATIVE BANK LTD">PRIME CO OPERATIVE BANK LTD</option>
											<option value="PUNJAB AND MAHARASHTRA CO OP BANK LTD">PUNJAB AND MAHARASHTRA CO OP BANK LTD</option>
											<option value="PUNJAB AND SIND BANK">PUNJAB AND SIND BANK</option>
											<option value="PUNJAB NATIONAL BANK">PUNJAB NATIONAL BANK</option>
											<option value="RABOBANK INTERNATIONAL (CCRB)">RABOBANK INTERNATIONAL (CCRB)</option>
											<option value="RAJKOT NAGARIK SAHAKARI BANK LTD">RAJKOT NAGARIK SAHAKARI BANK LTD</option>
											<option value="RESERVE BANK OF INDIA">RESERVE BANK OF INDIA</option>
											<option value="SBERBANK">SBERBANK</option>
											<option value="SHINHAN BANK">SHINHAN BANK</option>
											<option value="SHRI CHHATRAPATI RAJARSHI SHAHU URBAN CO.OP BANK LTD">SHRI CHHATRAPATI RAJARSHI SHAHU URBAN CO.OP BANK LTD</option>
											<option value="SOCIETE GENERALE">SOCIETE GENERALE</option>
											<option value="SOUTH INDIAN BANK">SOUTH INDIAN BANK</option>
											<option value="STANDARD CHARTERED BANK">STANDARD CHARTERED BANK</option>
											<option value="STATE BANK OF BIKANER AND JAIPUR">STATE BANK OF BIKANER AND JAIPUR</option>
											<option value="STATE BANK OF HYDERABAD">STATE BANK OF HYDERABAD</option>
											<option value="STATE BANK OF INDIA">STATE BANK OF INDIA</option>
											<option value="STATE BANK OF MAURITIUS LTD">STATE BANK OF MAURITIUS LTD</option>
											<option value="STATE BANK OF MYSORE">STATE BANK OF MYSORE</option>
											<option value="STATE BANK OF PATIALA">STATE BANK OF PATIALA</option>
											<option value="STATE BANK OF TRAVANCORE">STATE BANK OF TRAVANCORE</option>
											<option value="SYNDICATE BANK">SYNDICATE BANK</option>
											<option value="TAMILNAD MERCANTILE BANK LTD">TAMILNAD MERCANTILE BANK LTD</option>
											<option value="THANE BHARAT SAHAKARI BANK LTD">THANE BHARAT SAHAKARI BANK LTD</option>
											<option value="THE A.P. MAHESH CO.OP URBAN BANK LTD.">THE A.P. MAHESH CO.OP URBAN BANK LTD.</option>
											<option value="THE AHMEDABAD MERCANTILE CO.OPERATIVE BANK LTD">THE AHMEDABAD MERCANTILE CO.OPERATIVE BANK LTD</option>
											<option value="THE BANK OF NOVA SCOTIA">THE BANK OF NOVA SCOTIA</option>
											<option value="THE BHARAT CO.OPERATIVE BANK (MUMBAI) LTD">THE BHARAT CO.OPERATIVE BANK (MUMBAI) LTD</option>
											<option value="THE COSMOS CO.OPERATIVE BANK LTD">THE COSMOS CO.OPERATIVE BANK LTD</option>
											<option value="THE FEDERAL BANK LTD">THE FEDERAL BANK LTD</option>
											<option value="THE GREATER BOMBAY CO.OP BANK LTD">THE GREATER BOMBAY CO.OP BANK LTD</option>
											<option value="THE GUJARAT STATE CO.OPERATIVE BANK LTD">THE GUJARAT STATE CO.OPERATIVE BANK LTD</option>
											<option value="THE JAMMU AND KASHMIR BANK LTD">THE JAMMU AND KASHMIR BANK LTD</option>
											<option value="THE KALUPUR COMMERCIAL CO OP BANK LTD">THE KALUPUR COMMERCIAL CO OP BANK LTD</option>
											<option value="THE KALYAN JANATA SAHAKARI BANK LTD">THE KALYAN JANATA SAHAKARI BANK LTD</option>
											<option value="THE KANGRA CENTRAL CO.OP BANK LIMITED">THE KANGRA CENTRAL CO.OP BANK LIMITED</option>
											<option value="THE KARAD URBAN CO.OP BANK LTD">THE KARAD URBAN CO.OP BANK LTD</option>
											<option value="THE KARNATAKA STATE APEX COOP. BANK LTD">THE KARNATAKA STATE APEX COOP. BANK LTD</option>
											<option value="THE LAKSHMI VILAS BANK LTD">THE LAKSHMI VILAS BANK LTD</option>
											<option value="THE MEHSANA URBAN COOPERATIVE BANK LTD">THE MEHSANA URBAN COOPERATIVE BANK LTD</option>
											<option value="THE MUNICIPAL CO OPERATIVE BANK LTD MUMBAI">THE MUNICIPAL CO OPERATIVE BANK LTD MUMBAI</option>
											<option value="THE NAINITAL BANK LIMITED">THE NAINITAL BANK LIMITED</option>
											<option value="THE NASHIK MERCHANTS CO.OP BANK LTD., NASHIK">THE NASHIK MERCHANTS CO.OP BANK LTD., NASHIK</option>
											<option value="THE RAJASTHAN STATE COOPERATIVE BANK LTD.">THE RAJASTHAN STATE COOPERATIVE BANK LTD.</option>
											<option value="THE RATNAKAR BANK LTD">THE RATNAKAR BANK LTD</option>
											<option value="THE ROYAL BANK OF SCOTLAND NV">THE ROYAL BANK OF SCOTLAND NV</option>
											<option value="THE SARASWAT CO.OPERATIVE BANK LTD">THE SARASWAT CO.OPERATIVE BANK LTD</option>
											<option value="THE SHAMRAO VITHAL CO.OPERATIVE BANK LTD">THE SHAMRAO VITHAL CO.OPERATIVE BANK LTD</option>
											<option value="THE SURAT DISTRICT CO OPERATIVE BANK LTD.">THE SURAT DISTRICT CO OPERATIVE BANK LTD.</option>
											<option value="THE SURAT PEOPLES CO.OP BANK LTD">THE SURAT PEOPLES CO.OP BANK LTD</option>
											<option value="THE SUTEX CO.OP. BANK LTD.">THE SUTEX CO.OP. BANK LTD.</option>
											<option value="THE TAMILNADU STATE APEX COOPERATIVE BANK LIMITED">THE TAMILNADU STATE APEX COOPERATIVE BANK LIMITED</option>
											<option value="THE THANE JANATA SAHAKARI BANK LTD">THE THANE JANATA SAHAKARI BANK LTD</option>
											<option value="THE VARACHHA CO.OP. BANK LTD.">THE VARACHHA CO.OP. BANK LTD.</option>
											<option value="THE WEST BENGAL STATE COOPERATIVE BANK LTD">THE WEST BENGAL STATE COOPERATIVE BANK LTD</option>
											<option value="TUMKUR GRAIN MERCHANTS COOPERATIVE BANK LTD.,">TUMKUR GRAIN MERCHANTS COOPERATIVE BANK LTD.,</option>
											<option value="UBS AG">UBS AG</option>
											<option value="UCO BANK">UCO BANK</option>
											<option value="UNION BANK OF INDIA">UNION BANK OF INDIA</option>
											<option value="UNITED BANK OF INDIA">UNITED BANK OF INDIA</option>
											<option value="VIJAYA BANK">VIJAYA BANK</option>
											<option value="WOORI BANK">WOORI BANK</option>
											<option value="YES BANK LTD">YES BANK LTD</option>
										
							  </select>
										<input type="text" placeholder="Bank Name" id="bank_name" class="form-control" name="bank_name" value="<?php echo !empty($customer['bank_name']) ? $customer['bank_name'] : '' ?>">
										<span class="input-group-addon"> <i class="fa fa-university"></i> </span>
									</div>
								</div>
							</div>
							<!--<div class="form-group">
								<label class="col-sm-2 control-label" for="form-field-1">
									IFSC Code:
								</label>
								<div class="col-sm-7">
									<input type="text" placeholder="IFSC Code:" id="bank_ifsc" class="form-control" name="bank_ifsc" value="<?php echo !empty($customer['bank_ifsc']) ? $customer['bank_ifsc'] : '' ?>">
								</div>
							</div>-->
							<div class="form-group">
								<label class="col-sm-2 control-label" for="form-field-1">
									Cheque No
								</label>
								<div class="col-sm-7">
									<input type="text" placeholder="Cheque No" id="cheque_no" class="form-control" name="cheque_no" value="<?php echo !empty($customer['cheque_no']) ? $customer['cheque_no'] : '' ?>">
								</div>
							</div>
							<div class="form-group">
								<label class="col-sm-2 control-label" for="form-field-1">
									Cheque Date
								</label>
								<div class="col-sm-7">
									<div class="input-group">
										<input type="text" placeholder="Cheque Date" id="cheque_date" class="form-control date-picker" name="cheque_date" value="<?php echo !empty($customer['cheque_date']) ? date("d-m-Y",strtotime($customer['cheque_date'])) : '' ?>">
										<span class="input-group-addon"> <i class="fa fa-calendar"></i> </span>
									</div>
								</div>
							</div>
						</div>
						<div class="by_case_dd" style="<?php echo $paymentType=="DD" ? 'display:block' : 'display:none';?>;">
							<div class="form-group">
								<label class="col-sm-2 control-label"></label>
								<div class="col-sm-7">
									<h4 class="text-right"><a href="http://www.ifsc-code.com/" target="_blank">Click To Bank Find</a></h4>
								</div>
							</div>
							<div class="form-group">
								<label class="col-sm-2 control-label" for="form-field-1">
									Bank Name
								</label>
								<div class="col-sm-7">
									<div class="input-group">
										<input type="text" placeholder="Bank Name" id="dd_bank_name" class="form-control" name="dd_bank_name" value="<?php echo !empty($customer['dd_bank_name']) ? $customer['dd_bank_name'] : '' ?>">
										<span class="input-group-addon"> <i class="fa fa-university"></i> </span>
									</div>
								</div>
							</div>
							<div class="form-group">
								<label class="col-sm-2 control-label" for="form-field-1">
									IFSC Code:
								</label>
								<div class="col-sm-7">
									<input type="text" placeholder="IFSC Code:" id="dd_bank_ifsc" class="form-control" name="dd_bank_ifsc" value="<?php echo !empty($customer['dd_bank_ifsc']) ? $customer['dd_bank_ifsc'] : '' ?>">
								</div>
							</div>
							<div class="form-group">
								<label class="col-sm-2 control-label" for="form-field-1">
									DD No
								</label>
								<div class="col-sm-7">
									<input type="text" placeholder="DD No" id="dd_no" class="form-control" name="dd_no" value="<?php echo !empty($customer['dd_no']) ? $customer['dd_no'] : '' ?>">
								</div>
							</div>
							<div class="form-group">
								<label class="col-sm-2 control-label" for="form-field-1">
									DD Date
								</label>
								<div class="col-sm-7">
									<div class="input-group">
										<input type="text" placeholder="DD Date" id="dd_date" class="form-control date-picker" name="dd_date" value="<?php echo !empty($customer['dd_date']) ? date("d-m-Y",strtotime($customer['dd_date'])) : '' ?>">
										<span class="input-group-addon"> <i class="fa fa-calendar"></i> </span>
									</div>
								</div>
							</div>
						</div>
						<div class="form-group">
							<label class="col-sm-2 control-label" for="form-field-1">
								Amount <span class="required-field">*</span>
							</label>
							<div class="col-sm-7">
								<div class="input-group">
									<input type="text" placeholder="Price" id="price" class="form-control" name="price" value="<?php echo !empty($customer['price']) ? $customer['price'] : '' ?>">
									<span class="input-group-addon"> <i class="fa fa-rupee"></i> </span>
								</div>
							</div>
						</div>
						<div class="form-group">
							<label class="col-sm-2 control-label" for="form-field-1">
								Amount In Word <span class="required-field">*</span>
							</label>
							<div class="col-sm-7">
								<input type="text" placeholder="Amount In Word" id="amount_in_word" class="form-control" name="amount_in_word" value="<?php echo !empty($customer['amount_in_word']) ? $customer['amount_in_word'] : '' ?>">
							</div>
						</div>
						<div class="form-group">
							<label class="col-sm-2 control-label" for="form-field-1">
								Remark
							</label>
							<div class="col-sm-7">
								<textarea placeholder="Remark" id="remark" class="form-control" name="remark"><?php echo !empty($customer['remark']) ? $customer['remark'] : '' ?></textarea>
							</div>
						</div>
						<div class="form-group">
							<div class="col-sm-2"></div>
							<div class="col-sm-9">
								<?php if($type=="add"){?>
								<input type="submit" class="btn btn-success btn-squared" value="Save">
								<?php }else{ ?>
								<input type="submit" class="btn btn-info btn-squared" value="Update">
								<?php }?>
								<a href="cashier_list_today.php" class="btn btn-danger btn-squared">Cancel</a>
							</div>
						</div>
					</div>
				