<?php
require_once 'lib/base.inc.php';
if (!$cfg['enable_reg']) exit;

$_page="register";

// get message id if available
if (isset($_GET['m'])) $_messid = $_GET['m'];
elseif (isset($_POST['m'])) $_messid = $_POST['m'];

$texta  = "        <p>Welkom op Energie Aansluiting registratie pagina.</p>\n";
$textb = "        <p>U kunt hieronder een account aanmaken.</p>\n";

// get post mode
if (isset($_POST['mode'])) {
	$mode = $_POST['mode'];
} elseif (isset($_GET['mode'])) {
	$mode = $_GET['mode'];
} else {
	$mode = "register";
}

switch($mode){

	case "validate":
 
		if (isset($_POST['username'])) {
			$username = $_POST['username']; }
		if (isset($_POST['password'])) {
			$password = $_POST['password']; }
		if (isset($_POST['auto'])) {
			$auto = $_POST['auto']; }  // To remember user with a cookie for autologin

		$user = new uFlex($username,$password,$auto);
		if($user->signed){
			// successful login, sent to this page to let common.php handle next page
			header("Location: http://" . $_SERVER['HTTP_HOST'] . $_SERVER['PHP_SELF']);
			exit;
				
		}
		break; 
		
	 case "register":
		   //Code Here
		   $showregisterform = true;
		   break;

	 case "processregister":
		include("lib/common/email_validator.php");
		// validate fields
		$errorString = ""; 
		if (!is_valid_name($_POST['username'])) {
			$errorString[] = "De login naam is te kort of bevat niet geaccepteerde tekens.";
		}
		if (!is_valid_real_name($_POST['realname'])) {
			$errorString[] = "De volledige naam is te kort of bevat niet geaccepteerde tekens.";
		}
		elseif (username_exists($_POST['username'])) {
			$errorString[] = "De login naam is al eerder geregistreerd en kan niet nogmaals geregistreerd worden.";
		}
		if (!is_valid_password($_POST['password'],$_POST['password2'])) {
			$errorString[] = "Het wachtwoord is te kort of niet gelijk aan het verificatie wachtwoord.";
		}
		if (!is_rfc3696_valid_email_address($_POST['email'])) {
			$errorString[] = "Het opgegeven email adres heeft geen geldig email adres formaat.";
		}
		if (email_exists($_POST['email'],true)) {
			$errorString[] = "Het email adres is al eerder geregistreerd en kan niet nogmaals geregistreerd worden.";
		}

		if(!empty($errorString)) {
			$showregisterform = true;
		} else {
      // no errors, register user
		  // add default group and remove post mode
		  unset($_POST['mode']);
		  $_POST['group_id']  = 0;

      // new user, register with uFlex
        $registered = $user->register($_POST,false);
				if($registered){
					$user = new uFlex($_POST['username'],$_POST['password'],$_POST['auto']);
					$link = "<a href=\"" . $cfg['index_page'] . "\">hier</a>";
					$registercomplete=  "<p>U bent geregistreerd. Klik $link om verder te gaan.</p>";
					//$registercomplete[] .= "Click <a href=\"http://" . $_SERVER['HTTP_HOST'] . $_SERVER['PHP_SELF']. "\">here</a> to continue";
				}else{
					//Display Errors
					foreach($user->error() as $err){
							echo "<b>Error:</b> {$err} <br />";
					}
				}

		}
		break;

}
	

  


/**** START HTML OUTPUT *****/

if ($registercomplete) $showbox = true;
else $showbox = false;



if ($showregisterform) {
  //print_pagetitle("Registration");
	//html_header_login($_page,$showbox);
	html_header_login($_page,false);
  
  if ($errorString) {
  	$error_str = "        <p>Er zijn fouten opgetreden in de verwerking van de aanvraag, graag het volgende corrigeren:</p>\n";
  	$error_str .= "        <ul class=\"register_errors\">\n";
    foreach ($errorString as $key => $value) {
     $error_str .= n(8) . "  <li>$value</li>\n" ;  
    }
    $error_str .= "        </ul>\n";
  }
  
  if($error_str) echo $error_str;
  else {
  if (isset($_messid)) {
	echo display_message("", false, $_messid);
	echo $textb;
}
  }
  
  	$_n=2;
  	$form = n($_n+6) . "<form method=\"post\" action=\"" . $_SERVER['PHP_SELF'] . "\">\n";
  	
  	$form .= n($_n+8) . "<fieldset>\n";
  	$_n=6;
  	$form .= n($_n+6) . "<input name=\"mode\" type=\"hidden\" value=\"processregister\" />\n";
  	$form .= n($_n+6) . "<table id=\"register_table\">\n";
		$form .= n($_n+8) . "<tr>\n";
		$form .= n($_n+10) . "<td class=\"td_reg_title\">Login naam:</td>\n";
		$form .= n($_n+10) . "<td><input name=\"username\" type=\"text\" value=\"".  $_POST['username'] . "\"/></td>\n";
		$form .= n($_n+8) . "</tr>\n";
		$form .= n($_n+8) . "<tr>\n";
		$form .= n($_n+10) . "<td class=\"td_reg_title\">Volledige naam:</td>\n";
		$form .= n($_n+10) . "<td><input name=\"realname\" type=\"text\" value=\"".  $_POST['realname'] . "\"/></td>\n";
		$form .= n($_n+8) . "</tr>\n";
		$form .= n($_n+8) . "<tr>\n";
		$form .= n($_n+10) . "<td class=\"td_reg_title\">Email adres:</td>\n";
		$form .= n($_n+10) . "<td><input name=\"email\" type=\"text\" value=\"".  $_POST['email'] . "\"/></td>\n";
		$form .= n($_n+8) . "</tr>\n";
		$form .= n($_n+8) . "<tr>\n";
		$form .= n($_n+10) . "<td class=\"td_reg_title\">Wachtwoord:</td>\n";
		$form .= n($_n+10) . "<td><input name=\"password\" type=\"password\" value=\"\"/></td>\n";
		$form .= n($_n+8) . "</tr>\n";
		$form .= n($_n+8) . "<tr>\n";
		$form .= n($_n+10) . "<td class=\"td_reg_title\">Wachtwoord ter verificatie:</td>\n";
		$form .= n($_n+10) . "<td><input name=\"password2\" type=\"password\" value=\"\"/></td>\n";
		$form .= n($_n+8) . "</tr>\n";				
		$form .= n($_n+8) . "<tr class=\"tr_small_empty_line\">\n";
		$form .= n($_n+10) . "<td></td>\n";
		$form .= n($_n+8) . "</tr>\n";
		$form .= n($_n+8) . "<tr>\n";
		$form .= n($_n+10) . "<td colspan=\"2\" align=\"center\"><input value=\"Registreren\" type=\"submit\" /></td>\n";
		$form .= n($_n+8) . "</tr>\n";
		$form .= n($_n+6) . "</table>\n";
		$_n=2;
		$form .= n($_n+8) . "</fieldset>\n";
		$form .= n($_n+6) . "</form>\n";
		echo $form;


} elseif ($registercomplete) {
  //if ($cfg['public_login']) {	
  if($user->signed && $cfg['public_login']){ 
  	html_header_login($_page,false);
		//echo "        <p>Registratie voltooid, u kunt bovenaan de pagina inloggen.</p>\n";
		echo $registercomplete;
  } else {
		// user added by  existing user , just inform user was added on register page
		  $host  = $_SERVER['HTTP_HOST'];
      $uri   = rtrim(dirname($_SERVER['PHP_SELF']), '/\\');
      $extra = $cfg['register_page'];
      $opt = "?m=3";
      header("Location: http://$host$uri/$extra$opt");
	}
}




html_footer();


?>