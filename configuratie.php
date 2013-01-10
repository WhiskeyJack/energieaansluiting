<?php
require_once 'lib/base.inc.php';

$_page = "config";
$_obj_ref = "";
$_searchfield = "";
$_objectid = "";


if (!$user) $userid = 1;
else $userid = $user->data['user_id'];

/**** Validation of form *****/
if ($_POST['mode'] == 'validate') {
	// new dBug($_POST);
	$fields = implode(',', $_POST['ckb']);
	$sql = "REPLACE INTO `energie`.`preferences` (`user_id` , `name_format` , `email_notify` , `ListVelden`)
					VALUES ($userid, 0, 0, '$fields')";
	//echo $sql;

 	$result = mysql_query($sql);
 	
 	$msg = "<p class=\"_success\">Configuratie wijzigingen zijn opgeslagen.</p>";

 	
 	
}	
else {
	// fetch values
	$sql = "SELECT ListVelden FROM preferences WHERE user_id = $userid";
	
	$result = mysql_query($sql);
	if (mysql_num_rows($result)==0) {
    // default values
    $field_array = array(1,2,3,9);
  } else {
  	$row = mysql_fetch_array($result, MYSQL_ASSOC);
  	$field_array = explode(",", $row['ListVelden']);
  }
}

$_n = 4;
$cols = array ("Object ID","EAN Code","Omschrijving","Interne codering","Op naam van","Eigenaar","Juridisch eigenaar","Gebruiker","Budgethouder","Doel","Bouwjaar","Gewijzigd Op");
$html  = n($_n) . "<p>Hier kunt de de kolommen selecteren die in het zoek overzicht getoond worden.</p>\n";
$html .= n($_n) . "<form method=\"post\" name=\"formA\" action=\"" . $_SERVER['PHP_SELF'] . "\">\n";

$html .=  n($_n+2) . "<table id=\"table_config\">\n";
$_n = 8;
$ccount = 0;
foreach ($cols as $key=>$val){
	if (in_array($key,$_POST['ckb']) || in_array($key,$field_array) ) {
			$checked = "checked=\"checked\"";
			$ccount++;
	}
	else $checked = "";
	$html .= n($_n) . "<tr><td><input type=\"checkbox\" id=\"check_$key\" name=\"ckb[]\" value=\"$key\" $checked onclick=\"CountChecks(this,3)\")></td><td>$val</td></tr>\n";
}
$_n = 4;
$html .=  n($_n+2) . "</table>\n";
 
$html .= "\n        <div id=\"edit_button\">\n";
		$html .= "          <div class=\"cssbutton editb b\">\n";
		$html .= "            <fieldset>\n";
		$html .= "              <input type=\"hidden\" name=\"mode\" value=\"validate\" />\n";
		$html .= "              <input type=\"submit\" value=\"Wijzigen\"></input>\n";
		$html .= "            </fieldset>\n";
		$html .= "          </div>\n";
		$html .= "        </div>\n\n";
		$html .= "        </form>\n";

/**** START HTML OUTPUT *****/


html_header($_page, $_objectid, $_obj_ref, $_searchfield,"var currCount = $ccount");
if ($msg) echo $msg;
echo $html;
//html_updated($updatetime);
html_footer();


?>