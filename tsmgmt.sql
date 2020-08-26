SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";

CREATE TABLE `admin` (
  `admin_id` int(11) NOT NULL,
  `unique_id` varchar(100) NOT NULL,
  `username` varchar(255) NOT NULL,
  `email` varchar(50) NOT NULL,
  `password` text NOT NULL,
  `role` varchar(50) NOT NULL,
  `status` int(11) NOT NULL DEFAULT 1,
  `delete` int(11) NOT NULL DEFAULT 0,
  `created_at` datetime NOT NULL,
  `updated_at` datetime NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

CREATE TABLE `admin_setting` (
  `admin_setting_id` int(11) NOT NULL,
  `admin_id` int(11) NOT NULL,
  `admin` int(1) NOT NULL DEFAULT 0,
  `model` int(1) NOT NULL DEFAULT 0,
  `dealer` int(1) NOT NULL DEFAULT 0,
  `sales_man` int(1) NOT NULL DEFAULT 0,
  `branch` int(1) NOT NULL DEFAULT 0,
  `showroom` int(1) NOT NULL DEFAULT 0,
  `cashier` int(1) NOT NULL DEFAULT 0,
  `expence` int(1) NOT NULL DEFAULT 0,
  `exchange` int(1) NOT NULL DEFAULT 0,
  `finance` int(1) NOT NULL DEFAULT 0,
  `atm` int(1) NOT NULL DEFAULT 0,
  `bank` int(1) NOT NULL DEFAULT 0,
  `gatepass` int(1) NOT NULL DEFAULT 0,
  `billing` int(1) NOT NULL DEFAULT 0,
  `rto` int(1) NOT NULL DEFAULT 0,
  `report` int(1) NOT NULL DEFAULT 0,
  `re_passing` int(1) NOT NULL DEFAULT 0,
  `re_total` int(1) NOT NULL DEFAULT 0,
  `re_stock` int(1) NOT NULL DEFAULT 0,
  `re_incentive` int(1) NOT NULL DEFAULT 0,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00'
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

CREATE TABLE `advance` (
  `advance_id` int(11) NOT NULL,
  `admin_id` int(11) NOT NULL,
  `model` varchar(255) NOT NULL,
  `color` varchar(255) NOT NULL,
  `salesman_id` varchar(255) NOT NULL,
  `name` varchar(255) NOT NULL,
  `mobile` varchar(50) NOT NULL,
  `city` varchar(100) NOT NULL DEFAULT 'Rajkot',
  `country` varchar(100) NOT NULL DEFAULT 'India',
  `exchange` text NOT NULL,
  `ex_rate` varchar(50) NOT NULL DEFAULT '0',
  `case_type` varchar(50) NOT NULL,
  `price` varchar(50) NOT NULL,
  `amount_in_word` varchar(255) NOT NULL,
  `bank_name` varchar(255) NOT NULL,
  `cheque_no` varchar(50) NOT NULL,
  `cheque_date` varchar(50) NOT NULL,
  `dd_bank_name` varchar(255) NOT NULL,
  `dd_no` varchar(255) NOT NULL,
  `dd_date` varchar(50) NOT NULL,
  `neft_ac_no` varchar(255) NOT NULL,
  `neft_bank_name` varchar(255) NOT NULL,
  `neft_ifsc_code` varchar(255) NOT NULL,
  `neft_holder_name` varchar(255) NOT NULL,
  `finance` varchar(255) NOT NULL DEFAULT '0',
  `finance_bank` varchar(255) NOT NULL,
  `test_ride` varchar(10) NOT NULL DEFAULT 'false',
  `remark` text NOT NULL,
  `refund` int(11) NOT NULL DEFAULT 0,
  `status` int(11) NOT NULL DEFAULT 0,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00'
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

CREATE TABLE `advance_payment` (
  `advance_payment_id` int(11) NOT NULL,
  `admin_id` int(11) NOT NULL,
  `advance_id` int(11) NOT NULL,
  `case_type` varchar(50) NOT NULL,
  `price` varchar(50) NOT NULL,
  `amount_in_word` varchar(255) NOT NULL,
  `bank_name` varchar(255) NOT NULL,
  `cheque_no` varchar(50) NOT NULL,
  `cheque_date` varchar(50) NOT NULL,
  `dd_bank_name` varchar(255) NOT NULL,
  `dd_no` varchar(50) NOT NULL,
  `dd_date` varchar(50) NOT NULL,
  `neft_ac_no` varchar(255) NOT NULL,
  `neft_bank_name` varchar(255) NOT NULL,
  `neft_ifsc_code` varchar(255) NOT NULL,
  `neft_holder_name` varchar(255) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00'
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

CREATE TABLE `atm` (
  `atm_id` int(11) NOT NULL,
  `admin_id` int(11) NOT NULL,
  `amount` float NOT NULL,
  `remark` text NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00'
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

CREATE TABLE `bank` (
  `bank_id` int(11) NOT NULL,
  `admin_id` int(11) NOT NULL,
  `cash_type` varchar(255) NOT NULL,
  `price` float NOT NULL,
  `bank_name` varchar(255) NOT NULL,
  `cheque_no` varchar(50) NOT NULL,
  `cheque_date` varchar(50) NOT NULL,
  `dd_bank_name` varchar(255) NOT NULL,
  `dd_no` varchar(50) NOT NULL,
  `dd_date` varchar(50) NOT NULL,
  `in_word` varchar(500) NOT NULL,
  `remark` text NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00'
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

CREATE TABLE `billing` (
  `billing_id` int(11) NOT NULL,
  `admin_id` int(11) NOT NULL,
  `product_id` int(11) NOT NULL,
  `gatepass_id` int(11) NOT NULL,
  `customer_detail_id` int(11) NOT NULL,
  `service` int(11) NOT NULL DEFAULT 0,
  `status` int(11) NOT NULL DEFAULT 1,
  `pass` int(11) NOT NULL DEFAULT 0,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00'
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

CREATE TABLE `branch` (
  `branch_id` int(11) NOT NULL,
  `name` varchar(255) NOT NULL,
  `remark` text NOT NULL,
  `status` int(11) NOT NULL DEFAULT 0,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00'
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

CREATE TABLE `cashier` (
  `cashier_id` int(11) NOT NULL,
  `admin_id` int(11) NOT NULL,
  `product_id` int(11) NOT NULL DEFAULT 0,
  `branch_id` int(11) NOT NULL DEFAULT 0,
  `type` varchar(50) NOT NULL,
  `cash_type` varchar(255) NOT NULL,
  `amount` float NOT NULL,
  `amount_in_word` varchar(255) NOT NULL,
  `bank_name` varchar(255) NOT NULL,
  `cheque_no` varchar(255) NOT NULL,
  `cheque_date` varchar(255) NOT NULL,
  `dd_bank_name` varchar(255) NOT NULL,
  `dd_no` varchar(255) NOT NULL,
  `dd_date` varchar(255) NOT NULL,
  `neft_ac_no` varchar(255) NOT NULL,
  `neft_bank_name` varchar(255) NOT NULL,
  `neft_ifsc_code` varchar(255) NOT NULL,
  `neft_holder_name` varchar(255) NOT NULL,
  `remark` text NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00'
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

CREATE TABLE `customer_detail` (
  `customer_detail_id` int(11) NOT NULL,
  `admin_id` int(11) NOT NULL,
  `product_id` int(11) NOT NULL,
  `salesman_id` int(11) NOT NULL,
  `name` varchar(255) NOT NULL,
  `mobile` varchar(50) NOT NULL,
  `street_add1` text NOT NULL,
  `street_add2` text NOT NULL,
  `city` varchar(100) NOT NULL DEFAULT 'Rajkot',
  `country` varchar(100) NOT NULL DEFAULT 'India',
  `remark` text NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  `updated_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00'
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

CREATE TABLE `customer_payment` (
  `customer_payment_id` int(11) NOT NULL,
  `admin_id` int(11) NOT NULL,
  `customer_detail_id` int(11) NOT NULL,
  `case_type` varchar(50) NOT NULL,
  `price` float NOT NULL,
  `amount_in_word` varchar(255) NOT NULL,
  `bank_name` varchar(255) NOT NULL,
  `cheque_no` varchar(255) NOT NULL,
  `cheque_date` varchar(50) NOT NULL,
  `dd_bank_name` varchar(255) NOT NULL,
  `dd_no` varchar(255) NOT NULL,
  `dd_date` varchar(255) NOT NULL,
  `neft_ac_no` varchar(255) NOT NULL,
  `neft_bank_name` varchar(255) NOT NULL,
  `neft_ifsc_code` varchar(255) NOT NULL,
  `neft_holder_name` varchar(255) NOT NULL,
  `remark` text NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00'
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

CREATE TABLE `dealer` (
  `dealer_id` int(11) NOT NULL,
  `product_id` int(11) NOT NULL,
  `admin_id` int(11) NOT NULL,
  `name` text NOT NULL,
  `address` text NOT NULL,
  `price` float NOT NULL,
  `remark` text NOT NULL,
  `status` int(11) NOT NULL DEFAULT 0,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00'
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

CREATE TABLE `exchange` (
  `exchange_id` int(11) NOT NULL,
  `product_id` int(11) NOT NULL,
  `customer_detail_id` int(11) NOT NULL,
  `amount` varchar(50) NOT NULL,
  `veihicle_no` varchar(250) NOT NULL,
  `status` int(11) NOT NULL DEFAULT 0,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00'
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

CREATE TABLE `expense` (
  `expense_id` int(11) NOT NULL,
  `branch_id` int(11) NOT NULL DEFAULT 0,
  `admin_id` int(11) NOT NULL,
  `person` varchar(255) NOT NULL,
  `purpose` text NOT NULL,
  `amount` float NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00'
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

CREATE TABLE `finance` (
  `finance_id` int(11) NOT NULL,
  `product_id` int(11) NOT NULL,
  `admin_id` int(11) NOT NULL,
  `finance_amount` float NOT NULL,
  `dp_amount` float NOT NULL,
  `bank` varchar(255) NOT NULL,
  `status` int(11) NOT NULL DEFAULT 0,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00'
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

CREATE TABLE `gatepass` (
  `gatepass_id` int(11) NOT NULL,
  `admin_id` int(11) NOT NULL,
  `product_id` int(11) NOT NULL,
  `customer_detail_id` int(11) NOT NULL,
  `status` int(11) NOT NULL DEFAULT 1,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00'
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

CREATE TABLE `product` (
  `product_id` int(11) NOT NULL,
  `branch_id` int(11) NOT NULL DEFAULT 0,
  `veihicle_id` int(11) NOT NULL DEFAULT 0,
  `model_code` varchar(50) NOT NULL,
  `color_code` varchar(255) NOT NULL,
  `model` varchar(255) NOT NULL,
  `color` varchar(255) NOT NULL,
  `variant` varchar(255) NOT NULL,
  `chassis_no` varchar(255) NOT NULL,
  `eng_no` varchar(255) NOT NULL,
  `qr_imgPath` varchar(255) NOT NULL DEFAULT '0',
  `barcode_imgPath` varchar(255) NOT NULL DEFAULT '0',
  `key_no` varchar(255) NOT NULL,
  `status` int(11) NOT NULL DEFAULT 1,
  `sale` int(11) NOT NULL DEFAULT 0,
  `delete` int(11) NOT NULL DEFAULT 0,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00'
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

CREATE TABLE `product_pdi` (
  `product_pdi_id` int(11) NOT NULL,
  `product_id` int(11) NOT NULL,
  `sari_gard` int(11) NOT NULL DEFAULT 1,
  `mirror` int(11) NOT NULL DEFAULT 1,
  `oil_level` int(11) NOT NULL DEFAULT 1,
  `breaking` int(11) NOT NULL DEFAULT 1,
  `jumper` int(11) NOT NULL DEFAULT 1,
  `chain` int(11) NOT NULL DEFAULT 1,
  `air_pressure` int(11) NOT NULL DEFAULT 1,
  `status` int(11) NOT NULL DEFAULT 1,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00'
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

CREATE TABLE `product_price` (
  `product_price_id` int(11) NOT NULL,
  `product_id` int(11) NOT NULL,
  `advance_id` int(11) NOT NULL,
  `price` float NOT NULL DEFAULT 0,
  `rto` varchar(255) NOT NULL DEFAULT '0',
  `no_plate_fitting` int(11) NOT NULL DEFAULT 0,
  `rmc_tax` int(11) NOT NULL DEFAULT 0,
  `access_no` varchar(50) NOT NULL,
  `side_stand` varchar(255) NOT NULL,
  `foot_rest` varchar(255) NOT NULL,
  `leg_guard` varchar(255) NOT NULL,
  `chrome_set` varchar(255) NOT NULL,
  `access` varchar(255) NOT NULL DEFAULT '0',
  `amc` int(11) NOT NULL DEFAULT 0,
  `ex_warranty` int(11) NOT NULL DEFAULT 0,
  `insurance` varchar(255) NOT NULL DEFAULT '0',
  `discount` float NOT NULL DEFAULT 0,
  `dd_finance` varchar(255) NOT NULL,
  `exchange_finance` varchar(255) NOT NULL,
  `advance_dp` varchar(50) NOT NULL,
  `pending` varchar(50) NOT NULL DEFAULT '0',
  `total` float NOT NULL DEFAULT 0,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` datetime NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

CREATE TABLE `product_service` (
  `product_service_id` int(11) NOT NULL,
  `product_id` int(11) NOT NULL,
  `admin_id` int(11) NOT NULL,
  `customer_detail_id` int(11) NOT NULL DEFAULT 0,
  `service_barcode` varchar(255) NOT NULL,
  `service_barcode_imgPath` varchar(255) NOT NULL,
  `status` int(11) NOT NULL DEFAULT 0,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00'
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

CREATE TABLE `record_delete` (
  `record_delete_id` int(11) NOT NULL,
  `type` varchar(255) NOT NULL,
  `number` varchar(255) NOT NULL,
  `admin_id` int(11) NOT NULL,
  `name` varchar(255) NOT NULL,
  `remark` int(11) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

CREATE TABLE `rto` (
  `rto_id` int(11) NOT NULL,
  `admin_id` int(11) NOT NULL,
  `product_id` int(11) NOT NULL,
  `billing_id` int(11) NOT NULL,
  `status` int(11) NOT NULL DEFAULT 1,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00'
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

CREATE TABLE `salesman` (
  `salesman_id` int(11) NOT NULL,
  `name` varchar(255) NOT NULL,
  `mobile` varchar(50) NOT NULL,
  `address` text NOT NULL,
  `status` int(11) NOT NULL DEFAULT 1,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` datetime NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

CREATE TABLE `veihicle` (
  `veihicle_id` int(11) NOT NULL,
  `name` varchar(255) NOT NULL,
  `c_of_v` varchar(250) NOT NULL,
  `weight` varchar(255) NOT NULL,
  `cc` varchar(255) NOT NULL,
  `body` varchar(255) NOT NULL,
  `price` int(11) NOT NULL,
  `rto_single` int(11) NOT NULL,
  `rto_double` int(11) NOT NULL,
  `insurance` int(11) NOT NULL,
  `no_plate_fitting` int(11) NOT NULL,
  `rmc_tax` int(11) NOT NULL,
  `side_stand` int(11) NOT NULL,
  `foot_rest` int(11) NOT NULL,
  `leg_guard` int(11) NOT NULL,
  `chrome_set` int(11) NOT NULL,
  `amc` int(11) NOT NULL,
  `ex_warranty` int(11) NOT NULL,
  `2_year_insurance` int(11) NOT NULL,
  `3_year_insurance` int(11) NOT NULL,
  `remark` text NOT NULL,
  `status` int(11) NOT NULL DEFAULT 1,
  `created_at` datetime NOT NULL,
  `updated_at` datetime NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

ALTER TABLE `admin` ADD PRIMARY KEY (`admin_id`);
ALTER TABLE `admin_setting` ADD PRIMARY KEY (`admin_setting_id`);
ALTER TABLE `advance` ADD PRIMARY KEY (`advance_id`);
ALTER TABLE `advance_payment` ADD PRIMARY KEY (`advance_payment_id`);
ALTER TABLE `atm` ADD PRIMARY KEY (`atm_id`);
ALTER TABLE `bank` ADD PRIMARY KEY (`bank_id`);
ALTER TABLE `billing` ADD PRIMARY KEY (`billing_id`);
ALTER TABLE `branch` ADD PRIMARY KEY (`branch_id`);
ALTER TABLE `cashier` ADD PRIMARY KEY (`cashier_id`);
ALTER TABLE `customer_detail` ADD PRIMARY KEY (`customer_detail_id`);
ALTER TABLE `customer_payment` ADD PRIMARY KEY (`customer_payment_id`);
ALTER TABLE `dealer` ADD PRIMARY KEY (`dealer_id`);
ALTER TABLE `exchange` ADD PRIMARY KEY (`exchange_id`);
ALTER TABLE `expense` ADD PRIMARY KEY (`expense_id`);
ALTER TABLE `finance` ADD PRIMARY KEY (`finance_id`);
ALTER TABLE `gatepass` ADD PRIMARY KEY (`gatepass_id`);
ALTER TABLE `product` ADD PRIMARY KEY (`product_id`);
ALTER TABLE `product_pdi` ADD PRIMARY KEY (`product_pdi_id`);
ALTER TABLE `product_price` ADD PRIMARY KEY (`product_price_id`);
ALTER TABLE `product_service` ADD PRIMARY KEY (`product_service_id`);
ALTER TABLE `record_delete` ADD PRIMARY KEY (`record_delete_id`);
ALTER TABLE `rto` ADD PRIMARY KEY (`rto_id`);
ALTER TABLE `salesman` ADD PRIMARY KEY (`salesman_id`);
ALTER TABLE `veihicle` ADD PRIMARY KEY (`veihicle_id`);

ALTER TABLE `admin` MODIFY `admin_id` int(11) NOT NULL AUTO_INCREMENT;
ALTER TABLE `admin_setting` MODIFY `admin_setting_id` int(11) NOT NULL AUTO_INCREMENT;
ALTER TABLE `advance` MODIFY `advance_id` int(11) NOT NULL AUTO_INCREMENT;
ALTER TABLE `advance_payment` MODIFY `advance_payment_id` int(11) NOT NULL AUTO_INCREMENT;
ALTER TABLE `atm` MODIFY `atm_id` int(11) NOT NULL AUTO_INCREMENT;
ALTER TABLE `bank` MODIFY `bank_id` int(11) NOT NULL AUTO_INCREMENT;
ALTER TABLE `billing` MODIFY `billing_id` int(11) NOT NULL AUTO_INCREMENT;
ALTER TABLE `branch` MODIFY `branch_id` int(11) NOT NULL AUTO_INCREMENT;
ALTER TABLE `cashier` MODIFY `cashier_id` int(11) NOT NULL AUTO_INCREMENT;
ALTER TABLE `customer_detail` MODIFY `customer_detail_id` int(11) NOT NULL AUTO_INCREMENT;
ALTER TABLE `customer_payment` MODIFY `customer_payment_id` int(11) NOT NULL AUTO_INCREMENT;
ALTER TABLE `dealer` MODIFY `dealer_id` int(11) NOT NULL AUTO_INCREMENT;
ALTER TABLE `exchange` MODIFY `exchange_id` int(11) NOT NULL AUTO_INCREMENT;
ALTER TABLE `expense` MODIFY `expense_id` int(11) NOT NULL AUTO_INCREMENT;
ALTER TABLE `finance` MODIFY `finance_id` int(11) NOT NULL AUTO_INCREMENT;
ALTER TABLE `gatepass` MODIFY `gatepass_id` int(11) NOT NULL AUTO_INCREMENT;
ALTER TABLE `product` MODIFY `product_id` int(11) NOT NULL AUTO_INCREMENT;
ALTER TABLE `product_pdi` MODIFY `product_pdi_id` int(11) NOT NULL AUTO_INCREMENT;
ALTER TABLE `product_price` MODIFY `product_price_id` int(11) NOT NULL AUTO_INCREMENT;
ALTER TABLE `product_service` MODIFY `product_service_id` int(11) NOT NULL AUTO_INCREMENT;
ALTER TABLE `record_delete` MODIFY `record_delete_id` int(11) NOT NULL AUTO_INCREMENT;
ALTER TABLE `rto` MODIFY `rto_id` int(11) NOT NULL AUTO_INCREMENT;
ALTER TABLE `salesman` MODIFY `salesman_id` int(11) NOT NULL AUTO_INCREMENT;

COMMIT;