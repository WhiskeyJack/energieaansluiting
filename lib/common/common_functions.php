<?php

function n($count){
  $char = " ";
  return str_repeat($char, $count);
}

function is_valid_name($username){
	// http://stackoverflow.com/questions/1330693/php-validate-username-as-alphanumeric-with-underscores
  // Enter other valid characters below
  $valid_chars = "-_+\.@";
  $min_length = 3;
  $max_length = 25;
	if(!preg_match("/^[A-Za-z0-9$valid_chars]+$/", $username)  || strlen($username)<$min_length || strlen($username)>$max_length){
		return false;
  } 
	return true;
} 

function is_valid_real_name($username, $max_length=35){
	// http://stackoverflow.com/questions/1330693/php-validate-username-as-alphanumeric-with-underscores
  // Enter other valid characters below
  $valid_chars = "-_+\.@' ";
  $min_length = 3;
  //$max_length = 35;
	if(!preg_match("/^[A-Za-z0-9$valid_chars]+$/", $username)  || strlen($username)<$min_length || strlen($username)>$max_length){
		return false;
  } 
	return true;
} 

function is_valid_password($password1,$password2){
	// http://stackoverflow.com/questions/1330693/php-validate-username-as-alphanumeric-with-underscores
  // Enter other valid characters below
  $valid_chars = "-_+\.@";
  $min_length = 6;
  $max_length = 25;
	if ($password1 != $password2  || strlen($password1)<$min_length || strlen($password1)>$max_length){
		return false;
  } 
	return true;
} 



function username_exists($username){
	$sql = "SELECT user_id FROM users WHERE username = '$username'";
	$result = mysql_query($sql);
	if (mysql_num_rows($result) == 1) {
		return true;
	}
	return false;
}

function email_exists($email, $activated=false){
  // checks if email exists
  if ($activated) $and = " AND activated = 1";
  $sql = "SELECT user_id FROM users WHERE email = '$email' $and";
  $result = mysql_query($sql);
  if (mysql_num_rows($result) == 1) {
    return true;
	}
	return false;
}


function secure_string($string){
	// http://www.tech-evangelist.com/2007/11/05/preventing-sql-injection-attack/
	// http://www.learnphponline.com/security/sql-injection-prevention-mysql-php
	// magic quotes are bad, use mysql_real_escape_string
	if(get_magic_quotes_gpc()) { // prevents duplicate backslashes
		$string = stripslashes($string);
	}
	if (phpversion() >= '4.3.0') { //if using new version of PHP and mysql_real_escape_string
		//$string = mysql_real_escape_string(htmlentities($string, ENT_QUOTES));
		$string = mysql_real_escape_string($string);
	}
	else { //for the old version of PHP and mysql_escape_string
		//$string = mysql_escape_string(htmlentities($string, ENT_QUOTES));
		$string = mysql_escape_string($string);
	}
	return $string; //return the secure string
}

function secure_post_data() {
	foreach ($_POST as $key => $value) {
		$_POST[$key] = secure_string($value);
	}
}

function trim_post_data() {
	foreach ($_POST as $key => $value) {
		$_POST[$key] = trim($value);
	}
}

function str_is_integer($str){
	if (!(ereg("^[0-9]+$", $str))) return false;
	else return true;
}

function urlRawDecode($raw_url_encoded) {
	// http://www.php.net/manual/en/function.rawurlencode.php
	// by javier dot alejandro dot segura at gmail dot com 04-Jan-2008 07:40
	# Hex conversion table
	$hex_table = array(
	0 => 0x00,
	1 => 0x01,
	2 => 0x02,
	3 => 0x03,
	4 => 0x04,
	5 => 0x05,
	6 => 0x06,
	7 => 0x07,
	8 => 0x08,
	9 => 0x09,
            "A"=> 0x0a,
            "B"=> 0x0b,
            "C"=> 0x0c,
            "D"=> 0x0d,
            "E"=> 0x0e,
            "F"=> 0x0f
	);
	 
	# Looking for latin characters with a pattern like this %C3%[A-Z0-9]{2} ie. -> %C3%B1 = 'ñ'
	if(preg_match_all("/\%C3\%([A-Z0-9]{2})/i",$raw_url_encoded,$res))
	{
		$res = array_unique($res = $res[1]);
		$arr_unicoded = array();
		foreach($res as $key => $value){
			$arr_unicoded[] = chr(
			(0xc0 | ($hex_table[substr($value,0,1)]<<4)) | (0x03 & $hex_table[substr($value,1,1)])
			);
			$res[$key] = "%C3%" . $value;
		}

		$raw_url_encoded = str_replace($res,$arr_unicoded,$raw_url_encoded);
	}
	 
	# Return raw url decoded
	return rawurldecode($raw_url_encoded);
}

function validPostcode($postcode) {
	// Format: 1234 XX of 1234XX
	$status = (eregi ("^[0-9]{4}[[:space:]]*[A-Za-z]{2}$", $postcode))? true : false; 
	// true als de postcode goed is
	// false als de postcode onjuist is
	return $status;
}

function formatPostcode($postcode) {
	// Formats to 1234 XX but only if valid format was given
	if (!validPostcode($postcode)) return $postcode;
	$postcode = str_replace(" ", "", $postcode);
	$postcode = substr($postcode,0,4) . " " . strtoupper(substr($postcode,4,2)); 
	return $postcode;
}



function validPlaats($plaatsnaam) {
	$plaatsnaam = secure_string($plaatsnaam);
	$plaatsnaam = str_replace("&amp;#039;", "''", $plaatsnaam);
	$sql = "SELECT * FROM `plaatsnamen` WHERE `Plaatsnaam` LIKE '$plaatsnaam'";
	$result = mysql_query($sql);
	if (mysql_num_rows($result) >= 1) {
		return true;
	}
	return false;
}

function utf8_to_cp1251($s)
  {
  if ((mb_detect_encoding($s,'UTF-8,CP1251')) == "UTF-8")
    {
    for ($c=0;$c<strlen($s);$c++)
      {
      $i=ord($s[$c]);
      if ($i<=127) $out.=$s[$c];
      if ($byte2)
        {
        $new_c2=($c1&3)*64+($i&63);
        $new_c1=($c1>>2)&5;
        $new_i=$new_c1*256+$new_c2;
        if ($new_i==1025)
          {
          $out_i=168;
          } else {
          if ($new_i==1105)
            {
            $out_i=184;
            } else {
            $out_i=$new_i-848;
            }
          }
        $out.=chr($out_i);
        $byte2=false;
        }
        if (($i>>5)==6)
          {
          $c1=$i;
          $byte2=true;
          }
      }
    return $out;
    }
  else
    {
    return $s;
    }
  } 

function utf2win1250 ($str) {
  // to convert for pdf
  return (iconv("UTF-8","Windows-1250",$str));
}
  
?>
