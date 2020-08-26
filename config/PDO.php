<?php date_default_timezone_set("Asia/Kolkata");
define("MAIN_HOST","localhost");
define("MAIN_DBNAME","tsmgmt");
define("MAIN_USERNAME","root");
define("MAIN_PASSWORD","");

define("DB_DSN",'mysql:host='.MAIN_HOST.';dbname='.MAIN_DBNAME.'');
error_reporting(E_ALL);
class configDatabase
{
    public static $DB_DSN = DB_DSN; // set host name and database name
    public static $DB_USERNAME = MAIN_USERNAME; // set user name
    public static $DB_PASSWORD = MAIN_PASSWORD; // set password
}

class db extends configDatabase
{
    public $isConnected;
    protected $datab;
    public function __construct()
    {
        $this->isConnected = true;

        try 
        { 
            $this->datab = new PDO(parent::$DB_DSN, parent::$DB_USERNAME, parent::$DB_PASSWORD); 
            $this->datab->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION); 
            $this->datab->setAttribute(PDO::ATTR_DEFAULT_FETCH_MODE, PDO::FETCH_ASSOC);
        } 
        catch(PDOException $e) 
        { 
            $this->isConnected = false;
            throw new Exception($e->getMessage());
        }
    }
    public function Disconnect()
    {
        $this->datab = null;
        $this->isConnected = false;
    }
    public function queryRow($query)
    {
        try
        {
            $stmt = $this->datab->prepare($query); 
            $stmt->execute();
            return true; 
        }
        catch(PDOException $e)
        {
            throw new Exception($e->getMessage());
            return false;
        }
    }
    public function getRow($query, $params=array())
    {
        try
        { 
            $stmt = $this->datab->prepare($query); 
            $stmt->execute($params);
            return $stmt->fetch();  
        }
        catch(PDOException $e)
        {
            throw new Exception($e->getMessage());
        }
    }
	public function numRow($query, $params=array())
    {
        try
        {
            $stmt = $this->datab->prepare($query);
            $stmt->execute($params);
            return $stmt->rowCount();

        }
        catch(PDOException $e)
        {
            throw new Exception($e->getMessage());
        }
    }
    public function getRows($query, $params=array()){
        try
        { 
            $stmt = $this->datab->prepare($query); 
            $stmt->execute($params);
            return $stmt->fetchAll();       
        }
        catch(PDOException $e)
        {
            throw new Exception($e->getMessage());
        }       
    }
    public function insertRow($query, $params){
        try
        {           		 
            $stmt = $this->datab->prepare($query); 
            $stmt->execute($params);
			$id = $this->datab->lastInsertId();
            return $id;
        }
        catch(PDOException $e)
        {
            throw new Exception($e->getMessage());
            return false;
        }           
    }
    public function updateRow($query, $params){
        return $this->insertRow($query, $params);
    }
    public function deleteRow($query, $params){
        return $this->insertRow($query, $params);
    }
	
	public function upload_image($field_name, $uploadTo, $filename='') 
	{
		if (isset($_FILES[$field_name]) && $_FILES[$field_name]['name'] != "") {
			$filenameOrg = $_FILES[$field_name]['name'];
			$extArray = explode('.', $filenameOrg);
			$ext = end($extArray);
			//$filename = date('YmdHis') . uniqid() . '.' . $ext;
			if($filename==""){
				$filename = microtime().'.'.$ext;
			}else{
				$filename = $filename.'.'.$ext;
			}
			$target_image = $uploadTo.$filename;
			chmod($uploadTo, 0777);
			$uploadimage = move_uploaded_file($_FILES[$field_name]['tmp_name'], $target_image);
			if ($uploadimage) {
				return $filename;
			} else {
				return false;
			}
		} else {
			return false;
		}
	}
	
	public function multi_upload_image($field_name, $uploadTo, $filename='',$k) 
	{
		if (isset($_FILES[$field_name]) && $_FILES[$field_name]['name'][$k] != "") 
		{
			$filenameOrg = $_FILES[$field_name]['name'][$k];
			$extArray = explode('.', $filenameOrg);
			$ext = end($extArray);
			//$filename = date('YmdHis') . uniqid() . '.' . $ext;
			if($filename==""){
				$filename = microtime().'.'.$ext;
			}else{
				$filename = $filename.'.'.$ext;
			}
			$target_image = $uploadTo.$filename;
			chmod($uploadTo, 0777);
			$uploadimage = move_uploaded_file($_FILES[$field_name]['tmp_name'][$k], $target_image);
			if ($uploadimage) {
				return $filename;
			} else {
				return false;
			}
		} else {
			return false;
		}
	}
	
	// Create Thumbnail Image Function
	function makeThumbnails($updir, $img, $image_beforeword ,$width, $height)
	{
		$thumbnail_width = $width;
		$thumbnail_height = $height;
		$thumb_beforeword = $image_beforeword;
		$arr_image_details = getimagesize("$updir" . "$img"); // pass id to thumb name
		$original_width = $arr_image_details[0];
		$original_height = $arr_image_details[1];
		if ($original_width > $original_height) {
			$new_width = $thumbnail_width;
			$new_height = intval($original_height * $new_width / $original_width);
		} else {
			$new_height = $thumbnail_height;
			$new_width = intval($original_width * $new_height / $original_height);
		}
		$dest_x = intval(($thumbnail_width - $new_width) / 2);
		$dest_y = intval(($thumbnail_height - $new_height) / 2);
		if ($arr_image_details[2] == 1) {
			$imgt = "ImageGIF";
			$imgcreatefrom = "ImageCreateFromGIF";
		}
		if ($arr_image_details[2] == 2) {
			$imgt = "ImageJPEG";
			$imgcreatefrom = "ImageCreateFromJPEG";
		}
		if ($arr_image_details[2] == 3) {
			$imgt = "ImagePNG";
			$imgcreatefrom = "ImageCreateFromPNG";
		}
		if ($imgt) {
			$old_image = $imgcreatefrom("$updir" . "$img");
			$new_image = imagecreatetruecolor($thumbnail_width, $thumbnail_height);
			imagecopyresized($new_image, $old_image, $dest_x, $dest_y, 0, 0, $new_width, $new_height, $original_width, $original_height);
			$imgt($new_image, "$updir" ."$thumb_beforeword" . '_' . "$img");
		}
	}
	
	// Barcode Generator
	function barCode( $text="0", $size="30", $orientation="horizontal", $code_type="code128", $print=true ) 
	{
		$originalText = $text;
		$code_string = "";
		$size = "30";
		$code_type = "code128a";
		// Translate the $text into barcode the correct $code_type
		if ( in_array(strtolower($code_type), array("code128", "code128b")) ) {
			$chksum = 104;
			// Must not change order of array elements as the checksum depends on the array's key to validate final code
			$code_array = array(" "=>"212222","!"=>"222122","\""=>"222221","#"=>"121223","$"=>"121322","%"=>"131222","&"=>"122213","'"=>"122312","("=>"132212",")"=>"221213","*"=>"221312","+"=>"231212",","=>"112232","-"=>"122132","."=>"122231","/"=>"113222","0"=>"123122","1"=>"123221","2"=>"223211","3"=>"221132","4"=>"221231","5"=>"213212","6"=>"223112","7"=>"312131","8"=>"311222","9"=>"321122",":"=>"321221",";"=>"312212","<"=>"322112","="=>"322211",">"=>"212123","?"=>"212321","@"=>"232121","A"=>"111323","B"=>"131123","C"=>"131321","D"=>"112313","E"=>"132113","F"=>"132311","G"=>"211313","H"=>"231113","I"=>"231311","J"=>"112133","K"=>"112331","L"=>"132131","M"=>"113123","N"=>"113321","O"=>"133121","P"=>"313121","Q"=>"211331","R"=>"231131","S"=>"213113","T"=>"213311","U"=>"213131","V"=>"311123","W"=>"311321","X"=>"331121","Y"=>"312113","Z"=>"312311","["=>"332111","\\"=>"314111","]"=>"221411","^"=>"431111","_"=>"111224","\`"=>"111422","a"=>"121124","b"=>"121421","c"=>"141122","d"=>"141221","e"=>"112214","f"=>"112412","g"=>"122114","h"=>"122411","i"=>"142112","j"=>"142211","k"=>"241211","l"=>"221114","m"=>"413111","n"=>"241112","o"=>"134111","p"=>"111242","q"=>"121142","r"=>"121241","s"=>"114212","t"=>"124112","u"=>"124211","v"=>"411212","w"=>"421112","x"=>"421211","y"=>"212141","z"=>"214121","{"=>"412121","|"=>"111143","}"=>"111341","~"=>"131141","DEL"=>"114113","FNC 3"=>"114311","FNC 2"=>"411113","SHIFT"=>"411311","CODE C"=>"113141","FNC 4"=>"114131","CODE A"=>"311141","FNC 1"=>"411131","Start A"=>"211412","Start B"=>"211214","Start C"=>"211232","Stop"=>"2331112");
			$code_keys = array_keys($code_array);
			$code_values = array_flip($code_keys);
			for ( $X = 1; $X <= strlen($text); $X++ ) {
				$activeKey = substr( $text, ($X-1), 1);
				$code_string .= $code_array[$activeKey];
				$chksum=($chksum + ($code_values[$activeKey] * $X));
			}
			$code_string .= $code_array[$code_keys[($chksum - (intval($chksum / 103) * 103))]];

			$code_string = "211214" . $code_string . "2331112";
		} elseif ( strtolower($code_type) == "code128a" ) {
			$chksum = 103;
			$text = strtoupper($text); // Code 128A doesn't support lower case
			// Must not change order of array elements as the checksum depends on the array's key to validate final code
			$code_array = array(" "=>"212222","!"=>"222122","\""=>"222221","#"=>"121223","$"=>"121322","%"=>"131222","&"=>"122213","'"=>"122312","("=>"132212",")"=>"221213","*"=>"221312","+"=>"231212",","=>"112232","-"=>"122132","."=>"122231","/"=>"113222","0"=>"123122","1"=>"123221","2"=>"223211","3"=>"221132","4"=>"221231","5"=>"213212","6"=>"223112","7"=>"312131","8"=>"311222","9"=>"321122",":"=>"321221",";"=>"312212","<"=>"322112","="=>"322211",">"=>"212123","?"=>"212321","@"=>"232121","A"=>"111323","B"=>"131123","C"=>"131321","D"=>"112313","E"=>"132113","F"=>"132311","G"=>"211313","H"=>"231113","I"=>"231311","J"=>"112133","K"=>"112331","L"=>"132131","M"=>"113123","N"=>"113321","O"=>"133121","P"=>"313121","Q"=>"211331","R"=>"231131","S"=>"213113","T"=>"213311","U"=>"213131","V"=>"311123","W"=>"311321","X"=>"331121","Y"=>"312113","Z"=>"312311","["=>"332111","\\"=>"314111","]"=>"221411","^"=>"431111","_"=>"111224","NUL"=>"111422","SOH"=>"121124","STX"=>"121421","ETX"=>"141122","EOT"=>"141221","ENQ"=>"112214","ACK"=>"112412","BEL"=>"122114","BS"=>"122411","HT"=>"142112","LF"=>"142211","VT"=>"241211","FF"=>"221114","CR"=>"413111","SO"=>"241112","SI"=>"134111","DLE"=>"111242","DC1"=>"121142","DC2"=>"121241","DC3"=>"114212","DC4"=>"124112","NAK"=>"124211","SYN"=>"411212","ETB"=>"421112","CAN"=>"421211","EM"=>"212141","SUB"=>"214121","ESC"=>"412121","FS"=>"111143","GS"=>"111341","RS"=>"131141","US"=>"114113","FNC 3"=>"114311","FNC 2"=>"411113","SHIFT"=>"411311","CODE C"=>"113141","CODE B"=>"114131","FNC 4"=>"311141","FNC 1"=>"411131","Start A"=>"211412","Start B"=>"211214","Start C"=>"211232","Stop"=>"2331112");
			$code_keys = array_keys($code_array);
			$code_values = array_flip($code_keys);
			for ( $X = 1; $X <= strlen($text); $X++ ) {
				$activeKey = substr( $text, ($X-1), 1);
				$code_string .= $code_array[$activeKey];
				$chksum=($chksum + ($code_values[$activeKey] * $X));
			}
			$code_string .= $code_array[$code_keys[($chksum - (intval($chksum / 103) * 103))]];

			$code_string = "211412" . $code_string . "2331112";
		} elseif ( strtolower($code_type) == "code39" ) {
			$code_array = array("0"=>"111221211","1"=>"211211112","2"=>"112211112","3"=>"212211111","4"=>"111221112","5"=>"211221111","6"=>"112221111","7"=>"111211212","8"=>"211211211","9"=>"112211211","A"=>"211112112","B"=>"112112112","C"=>"212112111","D"=>"111122112","E"=>"211122111","F"=>"112122111","G"=>"111112212","H"=>"211112211","I"=>"112112211","J"=>"111122211","K"=>"211111122","L"=>"112111122","M"=>"212111121","N"=>"111121122","O"=>"211121121","P"=>"112121121","Q"=>"111111222","R"=>"211111221","S"=>"112111221","T"=>"111121221","U"=>"221111112","V"=>"122111112","W"=>"222111111","X"=>"121121112","Y"=>"221121111","Z"=>"122121111","-"=>"121111212","."=>"221111211"," "=>"122111211","$"=>"121212111","/"=>"121211121","+"=>"121112121","%"=>"111212121","*"=>"121121211");

			// Convert to uppercase
			$upper_text = strtoupper($text);

			for ( $X = 1; $X<=strlen($upper_text); $X++ ) {
				$code_string .= $code_array[substr( $upper_text, ($X-1), 1)] . "1";
			}

			$code_string = "1211212111" . $code_string . "121121211";
		} elseif ( strtolower($code_type) == "code25" ) {
			$code_array1 = array("1","2","3","4","5","6","7","8","9","0");
			$code_array2 = array("3-1-1-1-3","1-3-1-1-3","3-3-1-1-1","1-1-3-1-3","3-1-3-1-1","1-3-3-1-1","1-1-1-3-3","3-1-1-3-1","1-3-1-3-1","1-1-3-3-1");

			for ( $X = 1; $X <= strlen($text); $X++ ) {
				for ( $Y = 0; $Y < count($code_array1); $Y++ ) {
					if ( substr($text, ($X-1), 1) == $code_array1[$Y] )
						$temp[$X] = $code_array2[$Y];
				}
			}

			for ( $X=1; $X<=strlen($text); $X+=2 ) {
				if ( isset($temp[$X]) && isset($temp[($X + 1)]) ) {
					$temp1 = explode( "-", $temp[$X] );
					$temp2 = explode( "-", $temp[($X + 1)] );
					for ( $Y = 0; $Y < count($temp1); $Y++ )
						$code_string .= $temp1[$Y] . $temp2[$Y];
				}
			}

			$code_string = "1111" . $code_string . "311";
		} elseif ( strtolower($code_type) == "codabar" ) {
			$code_array1 = array("1","2","3","4","5","6","7","8","9","0","-","$",":","/",".","+","A","B","C","D");
			$code_array2 = array("1111221","1112112","2211111","1121121","2111121","1211112","1211211","1221111","2112111","1111122","1112211","1122111","2111212","2121112","2121211","1121212","1122121","1212112","1112122","1112221");

			// Convert to uppercase
			$upper_text = strtoupper($text);

			for ( $X = 1; $X<=strlen($upper_text); $X++ ) {
				for ( $Y = 0; $Y<count($code_array1); $Y++ ) {
					if ( substr($upper_text, ($X-1), 1) == $code_array1[$Y] )
						$code_string .= $code_array2[$Y] . "1";
				}
			}
			$code_string = "11221211" . $code_string . "1122121";
		}

		// Pad the edges of the barcode
		$code_length = 10;
		if ($print) {
			$text_height = 20;
		} else {
			$text_height = 0;
		}
		
		for ( $i=1; $i <= strlen($code_string); $i++ ){
			$code_length = $code_length + (integer)(substr($code_string,($i-1),1));
			}

		if ( strtolower($orientation) == "horizontal" ) {
			$img_width = $code_length;
			$img_height = $size;
		} else {
			$img_width = $size;
			$img_height = $code_length;
		}

		$image = imagecreate($img_width, $img_height + $text_height);
		$black = imagecolorallocate ($image, 0, 0, 0);
		$white = imagecolorallocate ($image, 255, 255, 255);

		imagefill( $image, 0, 0, $white );
		if ( $print ) {
			imagestring($image, 10, 50, $img_height, $text, $black );
		}

		$location = 10;
		for ( $position = 1 ; $position <= strlen($code_string); $position++ ) {
			$cur_size = $location + ( substr($code_string, ($position-1), 1) );
			if ( strtolower($orientation) == "horizontal" )
				imagefilledrectangle( $image, $location, 0, $cur_size, $img_height, ($position % 2 == 0 ? $white : $black) );
			else
				imagefilledrectangle( $image, 0, $location, $img_width, $cur_size, ($position % 2 == 0 ? $white : $black) );
			$location = $cur_size;
		}
		
		return $image;
	}
	
	public function newBarcode($chasisNo,$store="chassis")
	{
	
		include_once('class/BCGFontFile.php');
		include_once('class/BCGColor.php');
		include_once('class/BCGDrawing.php');
		include_once('class/BCGcode128.barcode.php'); 
		
		$colorFont = new BCGColor(0, 0, 0);
		$colorBack = new BCGColor(255, 255, 255); 
		//$font = new BCGFontFile('/home/daddygo/public_html/works/rajkothonda/config/arial.ttf', 12); 
		//$font = new BCGFontFile('E:/xampp/htdocs/rajkothonda/config/arial.ttf', 12); 

		$code = new BCGcode128();
		$code->setScale(1); // Resolution
		$code->setThickness(30); // Thickness
		$code->setForegroundColor($colorFont); // Color of bars
		$code->setBackgroundColor($colorBack); // Color of spaces
		//$code->setFont($font);
		$code->parse($chasisNo); // Text 
		$text = $chasisNo.".png";
		if($store=="service"){
			$drawing = new BCGDrawing(BARCODE_SERVICE_PATH_UPLOAD.$text, $colorBack);
		}else{
			$drawing = new BCGDrawing(BARCODE_PATH_UPLOAD.$text, $colorBack);
		}
		$drawing->setBarcode($code);
		$drawing->draw();
		$drawing->finish(BCGDrawing::IMG_FORMAT_PNG); 
	}
	
	// generate random string by given length
	public static function generateRandomString($count = '12') {
		$randomString = substr(substr( "abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ" ,mt_rand( 0 ,99 ) ,1 ) .substr( md5( microtime() ), 1) , 1, $count);
		return $randomString;
	}
	
	// Convert Number to Words
	public function convert_number_to_words($number) 
	{
		$hyphen      = '-';
		$conjunction = ' and ';
		$separator   = ', ';
		$negative    = 'negative ';
		$decimal     = ' point ';
		$dictionary  = array(0=> 'zero',1=> 'one',2=> 'two',3=> 'three',4=> 'four',5=> 'five',6=> 'six',7 => 'seven', 8=> 'eight',9=> 'nine',10=> 'ten',11=> 'eleven',12=> 'twelve',13=> 'thirteen',14=> 'fourteen',15=> 'fifteen',16=> 'sixteen',17=> 'seventeen',18=> 'eighteen',19=> 'nineteen',20=> 'twenty',30=> 'thirty',40=> 'fourty',50=> 'fifty',60=> 'sixty',70=> 'seventy',80=> 'eighty',90=> 'ninety',100=>'hundred',1000=> 'thousand',1000000=> 'million',1000000000=> 'billion',1000000000000=> 'trillion',1000000000000000=> 'quadrillion',1000000000000000000 => 'quintillion');

		if (!is_numeric($number)) {
			return false;
		}

		if (($number >= 0 && (int) $number < 0) || (int) $number < 0 - PHP_INT_MAX) {
			// overflow
			trigger_error(
				'convert_number_to_words only accepts numbers between -' . PHP_INT_MAX . ' and ' . PHP_INT_MAX,
				E_USER_WARNING
			);
			return false;
		}

		if ($number < 0) {
			return $negative . $this->convert_number_to_words(abs($number));
		}

		$string = $fraction = null;

		if (strpos($number, '.') !== false) {
			list($number, $fraction) = explode('.', $number);
		}

		switch (true) {
			case $number < 21:
				$string = $dictionary[$number];
				break;
			case $number < 100:
				$tens   = ((int) ($number / 10)) * 10;
				$units  = $number % 10;
				$string = $dictionary[$tens];
				if ($units) {
					$string .= $hyphen . $dictionary[$units];
				}
				break;
			case $number < 1000:
				$hundreds  = $number / 100;
				$remainder = $number % 100;
				$string = $dictionary[$hundreds] . ' ' . $dictionary[100];
				if ($remainder) {
					$string .= $conjunction . $this->convert_number_to_words($remainder);
				}
				break;
			default:
				$baseUnit = pow(1000, floor(log($number, 1000)));
				$numBaseUnits = (int) ($number / $baseUnit);
				$remainder = $number % $baseUnit;
				$string = $this->convert_number_to_words($numBaseUnits) . ' ' . $dictionary[$baseUnit];
				if ($remainder) {
					$string .= $remainder < 100 ? $conjunction : $separator;
					$string .= $this->convert_number_to_words($remainder);
				}
				break;
		}

		if (null !== $fraction && is_numeric($fraction)) {
			$string .= $decimal;
			$words = array();
			foreach (str_split((string) $fraction) as $number) {
				$words[] = $dictionary[$number];
			}
			$string .= implode(' ', $words);
		}

		return $string;
	}
	
	// string format with space (First->String,Second->with space(true),No Space(false),casecensitive(Upper,Lower,First))
	public static function string_format($string,$space=false,$case='')
	{
		//check space or not
		if($space)
			$string = preg_replace('/\s+/',' ',$string);
		else
			$string = preg_replace('/\s+/','',$string);
		
		// check upper lower first
		if(strtolower($case)=="lower")
			$string = strtolower(trim($string));
		else if(strtolower($case)=="upper")
			$string = strtoupper(trim($string));
		else if(strtolower($case)=="first")
			$string = ucfirst(trim($string));
		else
			$string = trim($string);
		
		return $string;
	}
	
	// Generate Password Function Encrypt
	public function passwordEncrypt($string) 
	{
		// Convert md5
		$string = md5($string);
		
		return $string;
	}
}

define("IMAGE_PATH_DISPLAY","images/");
define("IMAGE_PATH_UPLOAD","../images/");
define("USER_IMAGE_PATH_DISPLAY","admin/images/");
define("QRCODE_PATH_DISPLAY","images/qrcode/");
define("QRCODE_PATH_UPLOAD","../images/qrcode/");
define("FILE_PATH_DISPLAY","images/csv_file/");
define("FILE_PATH_UPLOAD","../images/csv_file/");
define("BARCODE_PATH_UPLOAD","../images/barcode/");
define("BARCODE_PATH_DISPLAY","images/barcode/");
define("BARCODE_SERVICE_PATH_UPLOAD","../images/barcode_service/");
define("BARCODE_SERVICE_PATH_DISPLAY","images/barcode_service/");