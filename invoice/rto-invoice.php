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
					// customer payment
					$customer_payment = $db->getRows("SELECT * FROM `customer_payment` where `customer_detail_id`=?",array($customer['customer_detail_id']));
					//gatepass
					$gatepass = $db->getRow("SELECT * FROM `gatepass` where `product_id`=?",array($product['product_id']));
					if(!empty($gatepass))
					{
						// find salesman name
						$salesman = $db->getRow("SELECT * FROM `salesman` where `salesman_id`=?",array($customer['salesman_id']));
						// Product price
						$product_price = $db->getRow("SELECT * FROM `product_price` where `product_id`=?",array($product['product_id']));
						if(!empty($product_price)){
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
}else{
	header('Location:../dashboard.php');
}
$ddBankName = "";
foreach($customer_payment as $value){
	if($value['case_type']=="DD"){
		$ddBankName = $value['dd_bank_name'];
	}
}
?>
<html>
	<head>
    <title>RTO Invoice</title>
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
            width:320pt;
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
         
        th {
            text-align: left;
        }
         
        td {
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
         
        </style>
    </head>
 
    <body>
    <div class="invoice">
        <div class="company-address">
            <h2 style="margin:0;"><b>XYZ Moto (GUJ) Pvt. Ltd.</b></h2>
            Kuvadava Road, Opp.Sadguru Ashram,
            <br />
            Rajkot-363 003. PH :- (0281)1234567  
            <br />
        </div>
     
        <div class="invoice-details">
            Invoice No: <?php echo str_pad($select['rto_id'], 3, "0", STR_PAD_LEFT)."-R";?>
            <br />
            Date: <?php echo date("d/m/Y"); ?>
			<br>
			Sales Man: <?php echo $salesman['name']; ?>
			<br>
			Gate Pass No: <?php echo str_pad($gatepass['gatepass_id'], 3, "0", STR_PAD_LEFT); ?>
			<br>
			Finance: 
			<?php if(!empty($finance)){
				echo $finance['bank'];
			}else if(!empty($ddBankName)){
				echo $ddBankName;
			}else{
				echo "N/A";
			}?>
        </div>
        <div class="clear-fix"></div>
		<hr>
		<div>
			<span class="invoice-status"><?php echo $billType;?></span>
			<img src="<?php echo "../".BARCODE_PATH_DISPLAY.$product['barcode_imgPath'];?>"/>
		</div>
        <div class="customer-address">
            To:
            <br />
            <b><?php echo $customer['name']; ?></b>
            <br />
            <?php echo $customer['street_add1'].$customer['street_add2']; ?>
            <br />
            <?php echo $customer['city'].", ".$customer['country']; ?>
            <br />
			<?php echo $customer['mobile']; ?>
        </div>
         
        <div class="clear-fix"></div>
            <table border='1' cellspacing='0'>
                <tr>
                    <th width=250>Product Name</th>
                    <th width=80>Qty</th>
                    <th width=100>Rate</th>
                    <th width=100>Amount</th>
                </tr>
 
            <?php
			$total = 0;$vat = 12.5;$add = 2.5;
			$productDetail = "Honda ".$product['model']." - ".$product['color']."<br>\tChassis No. - ".$product['chassis_no']."<br>\tEngine No. - ".$product['eng_no'];
            $articles = array($productDetail,1,$product_price['price']);
			
            for($a=0;$a<1;$a++) {
                    $description = $articles[0];
                    $amount = $articles[1];
                    $unit_price = $articles[2];
					$total_price = $amount * $unit_price;
					$total += $total_price;
                    echo("<tr>");
                    echo("<td class='desc'>$description</td>");
                    echo("<td class='text-center'>$amount</td>");
                    echo("<td class='text-right'>Rs $unit_price</td>");
                    echo("<td class='text-right'>Rs $total_price</td>");
                    echo("</tr>");
            }
             
            echo("<tr>");
            echo("<td colspan='3' class='text-right'>Sub total</td>");
            echo("<td class='text-right'>Rs " . number_format($total,2) . "</td>");
            echo("</tr>");
            echo("<tr>");
            echo("<td colspan='3' class='text-right'>VAT 12.5%</td>");
            echo("<td class='text-right'>Rs " . number_format(($total*$vat)/100,2) . "</td>");
            echo("</tr>");
			echo("<tr>");
            echo("<td colspan='3' class='text-right'>ADD 2.5%</td>");
            echo("<td class='text-right'>Rs " . number_format(($total*$add)/100,2) . "</td>");
            echo("</tr>");
			echo("<tr>");
            echo("<td colspan='3' class='text-right'><b>TOTAL</b></td>");
			
			$grand_total = (($total*$vat)/100)+(($total*$add)/100)+$total;
			
            echo("<td class='text-right'><b>Rs " . number_format($grand_total,2) . "</b></td>");
            echo("</tr>");
			
			
            ?>
            </table>
			<div class="rs-in-word">
				<b>Rs.(in Words)</b> : <?php echo $db->convert_number_to_words($grand_total)." Only"; ?>
			</div>
			<div class="clear-fix"></div>
			<div class="tin">
				<b>TIN No.</b>: 24091805974 DT.27-02-2012
			</div>
			<div class="cst">
				<b>CST No.</b>: 24591805974 DT.27-02-2012
			</div>
			<div class="note">
				<b>Note</b> : The above vehicle have delivered as per my satisfaction level and checked by me and found ok.
				
				<br><br><br><br>
				<b>Customer's Signature</b>
			</div>
			<div class="clear-fix"></div>
			<hr>
			<div class="term">
				<b>Terms & Condition :</b> 
				<b style="float:right;">For,XYZ Moto (Gujarat) PVT.LTD.</b>
				<br>
				1.Goods Once Sold will not be accepted back or replaced.
				<br>
				2.Delivery against payment.
				<br>
				3.Warrenty applied as per HMSI Terms.
				<br>
				4.Delivery at our showroom.
				<br>
				5.Subject to RAJKOT Jurisdiction. E.&O.E.
				<span style="float:right">(Autorised Signatory)</span>
			</div>
        </div>
    </body>
</html>