<?php


/*function check_db_connection() {
  
	if($this->DB == null) {
    $this->RS = null;
    $this->DB = mysql_pconnect ($dbserver, $dbuser, $dbpass)
      or $error_message = mysql_errno().": ".mysql_error();
    if(!mysql_select_db($dbname, $this->DB)) {
      $error_message = mysql_errno().": ".mysql_error();
    }
  }        
}
*/

function check_permission($objectid, $mode="view") {
	// checks if current user has permission to view or edit this object
	
	// fatal_error("Geen rechten voor dit object"); 
	//exit;
}

function format_EAN($eancode) {
	// checks if code is 13 or 18 characters and formats with spaces
	if (strlen($eancode) !=18 && strlen($eancode) !=13) {
		// fatal_error ("Geen geldige EAN code ($eancode)");
		return ($eancode);
	}
	$country = substr($eancode, 0 , 2); // digit 1 & 2
	$organization = substr($eancode, 2 , 5); // digit 3-7
	if (strlen($eancode) ==18) {
		$netlocation = substr($eancode, 7 , 10); // digit 8-17
		$checkdigit = substr($eancode, 17 , 1); // digit 18 
		return ("$country $organization $netlocation $checkdigit");	
	}
	else {
		$productcode = substr($eancode, 7 , 5); // digit 8-12
		$checkdigit = substr($eancode, 12 , 1); // digit 13
		return ("$country $organization $productcode $checkdigit");	
	}
}



function format_Internal_Code($icode) {
	// returns formatted internal code
	return($icode);
}

function format_mysql_timestamp($timestamp, $format="") {
  // return a date formatted with setlocale and strftime
	global $cfg;
	setlocale(LC_TIME, 'nl_NL.utf8');		// Set locale to Dutch 
	if (empty($format)) $format = $cfg['format']['strf_time_updated'];
	if (!empty($timestamp))	return (strftime($format, date("U", strtotime($timestamp) ) ));
	else return (strftime($format, date("U") ));
}

function fatal_error($msg) {
	// echo fatal error message and exits
	html_header("fatal-error");
	echo "        <div class=\"fatal-error\">\n          $msg\n        </div>\n";
	html_footer();
	exit;
}

function red($classname, $key, $array) {
	// appends "_red" to classname if key in array
	if ( array_key_exists($key, $array) ) $classname = $classname . "_red";
	return $classname;
}

function get_search_fields() {
	if (isset($_GET['s']))  $_search['str'] = $_GET['s'];
	elseif (isset($_POST['s']))  $_search['str'] = $_POST['s'];
	else $_search['str'] = false;
	
	if (isset($_GET['o'])) $_search['opt'] = $_GET['o'];
	elseif (isset($_POST['o'])) $_search['opt'] = $_POST['o'];
  else $_search['opt']  = false;
  return $_search;
}



?>