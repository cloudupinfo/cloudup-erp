<?php ob_start();
include_once('../include/comman_model_session.php');
include_once("../config/PDO.php");
$db = new db();

if(isset($_REQUEST['id']) && !empty($_REQUEST['id'])){
	$rto_id = $_REQUEST['id'];
	$billType = $_REQUEST['type'];
	// Type Check
	if((!empty($billType)) && (($billType=="Original") || ($billType=="Duplicate")))
	{
		// find rto data
		$select = $db->getRow("SELECT * FROM `rto` where `rto_id`=?",array($rto_id));
		if(!empty($select))
		{
			//Product detail
			$product = $db->getRow("SELECT * FROM `product` where `product_id`=?",array($select['product_id']));
			if(!empty($product))
			{
				//Vehicle Model
				$veihicle = $db->getRow("SELECT * FROM `veihicle` where `veihicle_id`=?",array($product['veihicle_id']));
				// Customer Detail Add then gatepass generate code
				$customer = $db->getRow("SELECT * FROM `customer_detail` where `product_id`=?",array($product['product_id']));
				if(!empty($customer))
				{
					// find salesman name
					$salesman = $db->getRow("SELECT * FROM `salesman` where `salesman_id`=?",array($customer['salesman_id']));
					// Product price
					$product_price = $db->getRow("SELECT * FROM `product_price` where `product_id`=?",array($product['product_id']));
					if(!empty($product_price))
					{
						// Finance
						$finance = $db->getRow("SELECT * FROM `finance` where `product_id`=?",array($product['product_id']));
					}else{
						header('Location:../dashboard.php');
					}
				}else{
					header('Location:../dashboard.php');
				}
			}else{
				header('Location:../dashboard.php');
			}
		}else{
			header('Location:../dashboard.php');
		}
	}else{
		header('Location:../dashboard.php');
	}
}else{
	header('Location:../dashboard.php');
}
?>
<html>
	<head>
    <title>RTO FORM 21 Invoice</title>
        <style type="text/css">
        body {      
            font-family: Verdana;
        }
         
        div.invoice {
        border:2px solid #000;
        padding:10px;
        height:740pt;
		margin: 0 auto;
        width:570pt;
        }
 
        div.company-address {
            float:left;
            width:550pt;
        }
         
        div.invoice-details {
           // border:1px solid #ccc;
            float:right;
            width:150pt;
        }
         
        div.customer-address {
           // border:1px solid #ccc;
            float:left;
            margin-bottom:40px;
            margin-top:20px;
            width:400pt;
        }
		div.rs-in-word{
            //border:1px solid #ccc;
            float:left;
            margin-bottom:20px;
            //margin-top:20px;
            width:570pt;
        }
		div.tin{
			//border:1px solid #ccc;
			float:left;
            width:280pt;
			margin-bottom:20px;
		}
		div.cst{
			//border:1px solid #ccc;
			float:right;
            width:280pt;
			margin-bottom:20px;
		}
		div.note{
			//border:1px solid #ccc;
			float:left;
            width:570pt;
			//margin-bottom:20px;
		}
        div.term{
			//border:1px solid #ccc;
			float:left;
            width:570pt;
			margin-bottom:20px;
		}
         
        div.clear-fix {
            clear:both;
            float:none;
        }
		.invoice-status{
			border: 2px solid #000000;
			float: right;
			padding: 5px 18px;
			//font-weight:bold;
			text-transform: uppercase;
		}
         
        table {
            width:100%;
        }
        .text-left {
            text-align:left;
        }
         
        .text-center {
            text-align:center;
        }
         
        .text-right {
            text-align:right;
        }
		table td {
			padding: 8px 0;
		}
		.finance-div{
			font-size:10px;
		}
        </style>
    </head>
    <body>
	</br></br></br></br></br></br>
    <div class="invoice">
        <div class="company-address text-center">
            <h2 style="margin:0;"><b>FORM 21</b></h2>
            (SEE RULE 47(A)&(D))<br />SALE CERTIFICATE<br />
        </div>
        <div class="clear-fix"></div>
		<hr>
		<div class="customer-address">
			Certify That &nbsp&nbsp&nbsp&nbsp&nbsp <b>HONDA <?php echo $product['model']." - ".$product['color'];?></b><br>
			Has Been Deliverd On &nbsp&nbsp Date: <b><?php echo date("d/m/Y");?></b> By Us To
           
            <br />
            <b>M/s : <?php echo $customer['name']; ?></b>
            <br />
            <?php echo $customer['street_add1'].$customer['street_add2']; ?>
            <br />
            <?php echo $customer['city'].", ".$customer['country']; ?>
            <br />
			<?php echo $customer['mobile']; ?>
        </div>
         
        <div class="clear-fix"></div>
		<hr>
		<div class="finance-div">
			THe Vehicle is held under agreement of hire purchase / lease / hypothecation with &nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp   <b><?php echo !empty($finance) ? $finance['bank'] : 'N/A';?></b>
		</div>
		<hr>	
		<div class="clear-fix"></div>
			<h4>Detail Of The Vehicle Are Given Bellow:</h4>
			<table cellspacing='0'>
                <tr>
					<td>1. Class Of Vehicle</td>
					<td><b><?php echo !empty($veihicle['c_of_v']) ? strtoupper($veihicle['c_of_v']) : '-'?></b></td>
                </tr>
				<tr>
					<td>2. Maker's Name</td>
					<td><b>HONDA MOTORCYCLE & SCOOTER (I)P L</b></td>
                </tr>
				<tr>
					<td>3. Chassis No.</td>
					<td><b><?php echo $product['chassis_no']?></b></td>
                </tr>
				<tr>
					<td>4. Engine No.</td>
					<td><b><?php echo $product['eng_no']?></b></td>
                </tr>
				<tr>
					<td>5. H.P. / C.C.</td>
					<td><b><?php echo $veihicle['cc']?> CC</b></td>
                </tr>
				<tr>
					<td>6. Fuel Used No.</td>
					<td><b>Petrol</b></td>
                </tr>
				<tr>
					<td>7. No. Of Cylinders </td>
					<td><b>1</b></td>
                </tr>
				<tr>
					<td>8. Month & Year Of Mfg. </td>
					<td><b><?php echo date('M-Y');?></b></td>
                </tr>
				<tr>
					<td>9. Seating Capacity (Incl.Driver)</td>
					<td><b>2</b></td>
                </tr>
				<tr>
					<td>10. Unleaden Weight</td>
					<td><b><?php echo $veihicle['weight']?></b></td>
                </tr>
				<tr>
					<td>11. Color Of Body</td>
					<td><b><?php echo $product['color']?></b></td>
                </tr>
				<tr>
					<td>12. Gross Vehicle Weight</td>
					<td><b><?php echo $veihicle['weight']?></b></td>
                </tr>
				<tr>
					<td>13. Type Of Body</td>
					<td><b><?php echo $veihicle['body']?></b></td>
                </tr>
            </table>
			
			<div class="clear-fix"></div>
			<hr>
			<div class="term">
				<b style="float:right;">For,XYZ Moto (Gujarat) PVT.LTD.</b>
				<br>
				<br>
				<br>
				<br>
				<br>
				<br>
				<span style="float:right">(Autorised Signatory)</span>
			</div>
        </div>
    </body>
</html>