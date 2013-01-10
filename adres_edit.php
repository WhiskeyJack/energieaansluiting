<?php
require_once 'lib/base.inc.php';

$_page = "adres_edit";
$_obj_ref = "";
$_searchfield = "";
$_updatetime = "";
$_errors = array();

if (isset($_GET['id'])) $_objectid = secure_string($_GET['id']);
elseif (isset($_POST['id'])) $_objectid = secure_string($_POST['id']);
else fatal_error("Er is geen object gespecificeerd.");

$_search = get_search_fields();

$dao_obj = new ObjectenAdresDAO();
$vo = $dao_obj->findByPK($_objectid);

if (!$vo) fatal_error("Er is een fout opgetreden bij het ophalen van de adres gegevens voor ObjectID $_objectid.");

$adr = array('ObjectAdres' => "Adres object:", 'AansluitRegisterAdres' => "Aansluitregister:", 'FactuurAdres' => "Factuur adres:");
$dao_adr = new AdressenDAO();


/**** Validation of form *****/
if ($_POST['mode'] == 'validate') {
	// new dBug($_POST);
	trim_post_data();
	
	
	$vo = new ObjectenAdresVO();
	$vo->readForm();
  //new dBug($_POST);
	$errors = $vo->validate_fields();
	
	// validate new address form 
	$formarray = array("ObjectAdres" => "object adres", "AansluitRegisterAdres" => "aansluitregister adres", "FactuurAdres" => "factuur adres");
	foreach ($formarray as $key => $val) {
		if ($_POST[$key] == "-2") {
			//if ($_POST[$key . "_Plaats"] == "&#039;s Gravenhage") $_POST[$key . "_Plaats"] = "&#039;s-Gravenhage"; // 's-Gravenhage is met streepje
			//$_POST[$key . "_StraatNaam"] = stripslashes($_POST[$key . "_StraatNaam"]);
			$_POST[$key . "_Postcode"] = formatPostcode($_POST[$key . "_Postcode"]);
			if (strlen($_POST[$key . "_AdresRegel1"])> 50 ) $errors[$key . "_AdresRegel1"] = "T.a.v. adresregel van het $val is niet correct";
			if (empty($_POST[$key . "_StraatNaam"]) || strlen($_POST[$key . "_Straatnaam"]) > 50 ) $errors[$key . "_StraatNaam"] = "Straatnaam of postbus van het $val is niet correct";
			if ((!str_is_integer($_POST[$key . "_Huisnummer"]) && !empty($_POST[$key . "_Huisnummer"])) || strlen($_POST[$key . "_Huisnummer"])> 10 ) $errors[$key . "_Huisnummer"] = "Huisnummer van het $val is niet correct";
			if (strlen($_POST[$key . "_HuisnummerToevoeging"])> 20 ) $errors[$key . "_HuisnummerToevoeging"] = "Huisnummer toevoeging van het $val is niet correct";
			if (!validPostcode($_POST[$key . "_Postcode"])) $errors[$key . "_Postcode"] = "Postcode van het $val is niet correct";
			if (!validPlaats($_POST[$key . "_Plaats"]) || empty($_POST[$key . "_Plaats"])) $errors[$key . "_Plaats"] = "Plaats van het $val is niet correct";
		} 
	}

   //new dBug($_POST);
   // new dBug($vo);
	//new dBug($errors);

	if (sizeof($errors) == 0) {
		secure_post_data();

		foreach ($formarray as $key => $val) {
			if ($_POST[$key] == "-2") {
				// found new address, put form data in new VO			
				$vo_adr = new AdressenVO(
										0,
										$_POST[$key . "_AdresRegel1"],
										$_POST[$key . "_StraatNaam"],
										$_POST[$key . "_Huisnummer"],
										$_POST[$key . "_HuisnummerToevoeging"],
										$_POST[$key . "_Postcode"],
										$_POST[$key . "_Plaats"],
										1,
										1);
										//new dBug($vo_adr);
				$id = $dao_adr->insertVO($vo_adr);
				if ($id>0) {
					$vo->$key = $id;
					$succes[] = "Het nieuwe $val is toegevoegd.";
				}
			} elseif ($_POST[$key] == "-3") {
				$vo->$key = $vo->ObjectAdres; 
			}
		}
		//new dBug($vo);
		if ($dao_obj->updateVO($vo) == 1) $m = 1;
		else $m = 2;
		$host  = $_SERVER['HTTP_HOST'];
    $uri   = rtrim(dirname($_SERVER['PHP_SELF']), '/\\');
    $extra = $cfg['adres_page'];
    if ($_search) $searchlink = "&s=" . urlencode($_search['str']) . "&o=" . $_search['opt'];
    header("Location: http://$host$uri/$extra?id=$_objectid&m=$m$searchlink");
  
	} else {
		$vo_orig = $dao_obj->findByPK($_objectid);
		// Set reference string and get update time 
		$_obj_ref = "Object: ". format_EAN($vo_orig->EanCode) . " (" . format_Internal_Code($vo_orig->InterneCodering) . ") - " .$vo_orig->ObjectNaam;
		$_updatetime = $vo->GewijzigdOp;
	}
	
	//new dBug($vo_post);
	//new dBug($errors);
} else {
	$vo = $dao_obj->findByPK($_objectid);
	if (!$vo) fatal_error("Er is een fout opgetreden bij het ophalen van de object gegevens voor ObjectID $_objectid.");
	// Set reference string and get update time 
	$_obj_ref = "Object: ". format_EAN($vo->EanCode) . " (" . format_Internal_Code($vo->InterneCodering) . ") - " .$vo->ObjectNaam;
	$_updatetime = $vo->GewijzigdOp;
}



// Get list of adressen
$adr_volist = $dao_adr->findWhere("","Plaats ASC");


	$_n = 8;
	$table = n($_n+0) . "<form method=\"post\" action=\"" . $_SERVER['PHP_SELF'] . "\">\n";
	$_n = 10;
$table .=  n($_n+0) . "<table id=\"table_main\">\n";

$table .= n($_n+2) . "<tr>\n";
$i=0;
foreach($adr as $key=>$value) {
	if (!$vo->$key) {	
		$table .= n($_n+4) . "<td>\n";
		$table .= n($_n+6) . "<table class=\"table_organization\">\n";
		$table .= n($_n+8) . "<tr>\n";
		$table .= n($_n+10) . "<td class=\"td_org_title\">$value</td>\n";
		//$table .= n($_n+10) . "<td class=\"td_org\"></td>\n";
		$table .= n($_n+8) . "</tr>\n";
		$table .= n($_n+8) . "<tr>\n";
		$table .= n($_n+10) . "<td>Onbekend</td>\n";
		$table .= n($_n+8) . "</tr>\n";
		$table .= n($_n+6) . "</table>\n";
		$table .= n($_n+4) . "</td>\n";
	} elseif ($key != "FactuurAdres") {
		$vo_array[$vo->$key] = $dao_adr->findByPK($vo->$key);
		if ($key == "AansluitRegisterAdres" && $vo->AansluitRegisterAdres == $vo->ObjectAdres) $adr_lines[0] = "Zelfde als het object adres.";
		else { 
			//if ($vo_array[$vo->$key]->AdresRegel1 != "") $adr_lines[] =  $vo_array[$vo->$key]->AdresRegel1;
			$adr_lines[] = $adr_vo->AdresRegel1;
			$adr_lines[] = $vo_array[$vo->$key]->StraatNaam . " " . $vo_array[$vo->$key]->Huisnummer . " " . $vo_array[$vo->$key]->HuisnummerToevoeging;
			$adr_lines[] = $vo_array[$vo->$key]->Postcode;
			$adr_lines[] = $vo_array[$vo->$key]->Plaats;
		}
		$i++;
		// html_select_list_vo("DoelID", $doelen_volist, "DoelID", "Omschrijving", $vo->DoelID, $_n+6) . n($_n+4) ."</td>\n";
		
		$table .= n($_n+4)  . "<td>\n";
		$table .= n($_n+6)  . "<table class=\"table_address\">\n";
		$table .= n($_n+8)  . "<tr>\n";
		$classname = red("td_adr_title", "$key", $errors);
		$table .= n($_n+10) . "<td class=\"$classname\">$value</td>\n";
		$table .= n($_n+10) . "<td>\n";

		$onchange = "onchange=\"showAddress('div_$key', this.value, $i)\"";
		if ($i ==2 ) $extraopt =  array ("-3" => "Zelfde als het object adres");
		$table .= html_select_list_vo_ajax("$key", $adr_volist, "AdresID", "Plaats", $onchange, $vo->$key, $_n+12, 'address', true, $extraopt);
		$table .= n($_n+10) . "</td>\n";
		$table .= n($_n+8)  . "</tr>\n";
		//$table .= n($_n+8) . "<tr class=\"tr_small_empty_line\"><td colspan=\"2\"></td></tr>\n";
		$table .= n($_n+8)  . "<tr>\n";
		$table .= n($_n+10) . "<td colspan=\"2\">\n";
		$table .= n($_n+12) . "<div id=\"div_$key\">\n";
		if ($vo->$key == "-2") {
			// user was adding new address 
			$atype = $key;
			$table .= n($_n+14) . "<table>\n";
			$table .= "<tr><td></td></tr>\n";
			$classname = red("", $key . "_AdresRegel1", $errors);
			$table .= "<tr><td class=\"$classname\">T.a.v. adresregel:</td><td><input maxlength=\"50\" name=\"". $atype . "_AdresRegel1\" size=\"35\" type=\"text\" value=\"" . $_POST[$key . "_AdresRegel1"] . "\" /></td></tr>\n";
			$classname = red("", $key . "_StraatNaam", $errors);
			$table .= "<tr><td class=\"$classname\">Straatnaam:</td><td><input maxlength=\"50\" name=\"". $atype . "_StraatNaam\" size=\"35\" type=\"text\" value=\"" . $_POST[$key . "_StraatNaam"] . "\" /></td></tr>\n";
			$classname = red("", $key . "_Huisnummer", $errors);
			$table .= "<tr><td class=\"$classname\">Huisnummer:</td><td><input maxlength=\"10\" name=\"". $atype . "_Huisnummer\" size=\"35\" type=\"text\" value=\"" . $_POST[$key . "_Huisnummer"] . "\" /></td></tr>\n";
			$classname = red("", $key . "_HuisnummerToevoeging", $errors);
			$table .= "<tr><td class=\"$classname\">Huisnr toevoeging:</td><td><input maxlength=\"20\" name=\"". $atype . "_HuisnummerToevoeging\" size=\"35\" type=\"text\" value=\"" . $_POST[$key . "_HuisnummerToevoeging"] . "\" /></td></tr>\n";
			$classname = red("", $key . "_Postcode", $errors);
			$table .= "<tr><td class=\"$classname\">Postcode:</td><td><input maxlength=\"7\" name=\"". $atype . "_Postcode\" size=\"35\" type=\"text\" value=\"" . $_POST[$key . "_Postcode"] . "\" /></td></tr>\n";
			$classname = red("", $key . "_Plaats", $errors);
			$table .= "<tr><td class=\"$classname\">Plaats:</td><td><input maxlength=\"50\" name=\"". $atype . "_Plaats\" size=\"35\" type=\"text\" value=\"" . $_POST[$key . "_Plaats"] . "\" /></td></tr>\n";
			$table .= "</table>\n";		
		} elseif ($_POST[$key] == "-3") {
			$table .= n($_n+14) . "<table>\n";
			$table .= n($_n+16) . "<tr><td></td></tr>\n";
			$table .= n($_n+16) . "<tr><td>Zelfde als het object adres.</td><td></td></tr>\n";
			$table .= n($_n+14) . "</table>\n";
		}
		else {
			$table .= n($_n+14) . "<table>\n";
			$table .= n($_n+16) . "<tr><td>" . $adr_lines[0] . "</td></tr>\n";
	
			if (isset($adr_lines[1])) $table .= n($_n+16) . "<tr><td>" . $adr_lines[1] . "</td></tr>\n";
			if (isset($adr_lines[2])) $table .= n($_n+16) . "<tr><td>" . $adr_lines[2] . "</td></tr>\n";
			if (isset($adr_lines[3])) $table .= n($_n+16) . "<tr><td>" . $adr_lines[3] . "</td></tr>\n";
			if (isset($adr_lines[4])) $table .= n($_n+16) . "<tr><td>" . $adr_lines[4] . "</td></tr>\n";
			
			$table .= n($_n+14) . "</table>\n";
		}
		$table .= n($_n+12) . "</div>\n";
		$table .= n($_n+10) . "</td>\n";
		$table .= n($_n+8) . "</tr>\n";
		$table .= n($_n+6) . "</table>\n";
		$table .= n($_n+4) . "</td>\n";
		$table .= n($_n+4) . "<td></td>\n";
		unset($adr_lines);
	}
}
$table .= n($_n+2) . "</tr>\n";

$table .= n($_n+2) . "<tr class=\"tr_small_empty_line \">\n";
$table .= n($_n+4) . "<td class=\"td_border_bottom\" colspan=\"8\"></td>\n";
$table .= n($_n+2) . "</tr>\n";
$table .= n($_n+2) . "<tr class=\"tr_small_empty_line \">\n";
$table .= n($_n+4) . "<td colspan=\"8\"></td>\n";
$table .= n($_n+2) . "</tr>\n";

$facturatie = $dao_adr->findByPK($vo->FactuurAdres);
//$adr_lines[] = $vo->FactuurTenaamStelling;
//if ($facturatie->AdresRegel1 != "") $adr_lines[] =  $facturatie->AdresRegel1;
$adr_lines[] =  $facturatie->AdresRegel1;
$adr_lines[] = $facturatie->StraatNaam . " " . $facturatie->Huisnummer . " " . $facturatie->HuisnummerToevoeging;
$adr_lines[] = $facturatie->Postcode;
$adr_lines[] = $facturatie->Plaats;
	
$table .= n($_n+2) . "<tr>\n";		
$table .= n($_n+4) . "<td>\n";
$table .= n($_n+6) . "<table class=\"table_address\">\n";
$table .= n($_n+8) . "<tr>\n";

$classname = red("td_adr_title", "FactuurTenaamStelling", $errors);
$table .= n($_n+10) . "<td class=\"$classname\">Factuur naam:</td><td>" . html_finput_text("FactuurTenaamStelling", $vo->FactuurTenaamStelling, 35, 35) . "</td>\n";		
$table .= n($_n+8) . "</tr>\n";
$table .= n($_n+8) . "<tr><td></td></tr>\n";
$table .= n($_n+8) . "<tr>\n";

$classname = red("td_adr_title", "FactuurAdres", $errors);
$table .= n($_n+10) . "<td class=\"$classname\">Factuur adres:</td>\n";		
$table .= n($_n+10) . "<td>\n";


$onchange = "onchange=\"showAddress('div_FactuurAdres', this.value,3)\"";
$extraopt =  array ("-3" => "Zelfde als het object adres");
$table .= html_select_list_vo_ajax("FactuurAdres", $adr_volist, "AdresID", "Plaats", $onchange, $vo->FactuurAdres, $_n+12, 'address', true, $extraopt);
$table .= n($_n+10) . "</td>\n";


$table .= n($_n+8)  . "</tr>\n";
$table .= n($_n+8) . "<tr class=\"tr_small_empty_line\"><td colspan=\"2\"></td></tr>\n";
$table .= n($_n+8)  . "<tr>\n";

$table .= n($_n+10) . "<td colspan=\"2\">\n";
$table .= n($_n+12) . "<div id=\"div_FactuurAdres\">\n";

////////////

		if ($vo->FactuurAdres == "-2") {
			// user was adding new address 
			$atype = "FactuurAdres";
			$table .= n($_n+14) . "<table>\n";
			$table .= "<tr><td></td></tr>\n";
			$classname = red("", $key . "_AdresRegel1", $errors);
			$table .= "<tr><td class=\"$classname\">T.a.v. adresregel:</td><td><input maxlength=\"50\" name=\"". $atype . "_AdresRegel1\" size=\"35\" type=\"text\" value=\"" . $_POST[$key . "_AdresRegel1"] . "\" /></td></tr>\n";
			$classname = red("", $key . "_StraatNaam", $errors);
			$table .= "<tr><td class=\"$classname\">Straatnaam:</td><td><input maxlength=\"50\" name=\"". $atype . "_StraatNaam\" size=\"35\" type=\"text\" value=\"" . $_POST[$key . "_StraatNaam"] . "\" /></td></tr>\n";
			$classname = red("", $key . "_Huisnummer", $errors);
			$table .= "<tr><td class=\"$classname\">Huisnummer:</td><td><input maxlength=\"10\" name=\"". $atype . "_Huisnummer\" size=\"35\" type=\"text\" value=\"" . $_POST[$key . "_Huisnummer"] . "\" /></td></tr>\n";
			$classname = red("", $key . "_HuisnummerToevoeging", $errors);
			$table .= "<tr><td class=\"$classname\">Huisnr toevoeging:</td><td><input maxlength=\"20\" name=\"". $atype . "_HuisnummerToevoeging\" size=\"35\" type=\"text\" value=\"" . $_POST[$key . "_HuisnummerToevoeging"] . "\" /></td></tr>\n";
			$classname = red("", $key . "_Postcode", $errors);
			$table .= "<tr><td class=\"$classname\">Postcode:</td><td><input maxlength=\"7\" name=\"". $atype . "_Postcode\" size=\"35\" type=\"text\" value=\"" . $_POST[$key . "_Postcode"] . "\" /></td></tr>\n";
			$classname = red("", $key . "_Plaats", $errors);
			$table .= "<tr><td class=\"$classname\">Plaats:</td><td><input maxlength=\"50\" name=\"". $atype . "_Plaats\" size=\"35\" type=\"text\" value=\"" . $_POST[$key . "_Plaats"] . "\" /></td></tr>\n";
			$table .= "</table>\n";
			
		} elseif ($_POST[$key] == "-3") {
			$table .= n($_n+14) . "<table>\n";
			$table .= n($_n+16) . "<tr><td></td></tr>\n";
			$table .= n($_n+16) . "<tr><td>Zelfde als het object adres.</td><td></td></tr>\n";
			$table .= n($_n+14) . "</table>\n";
		} else{




///////////

$table .= n($_n+14) . "<table>\n";
$table .= n($_n+16) . "<tr><td>" . $adr_lines[0] . "</td></tr>\n";
		
if (isset($adr_lines[1])) $table .= n($_n+16) . "<tr><td>" . $adr_lines[1] . "</td></tr>\n";
if (isset($adr_lines[2])) $table .= n($_n+16) . "<tr><td>" . $adr_lines[2] . "</td></tr>\n";
if (isset($adr_lines[3])) $table .= n($_n+16) . "<tr><td>" . $adr_lines[3] . "</td></tr>\n";
if (isset($adr_lines[4])) $table .= n($_n+16) . "<tr><td>" . $adr_lines[4] . "</td></tr>\n";

$table .= n($_n+14) . "</table>\n";
		}
$table .= n($_n+12) . "</div>\n";
$table .= n($_n+10) . "</td>\n";
$table .= n($_n+8) . "</tr>\n";
$table .= n($_n+6) . "</table>\n";
$table .= n($_n+4) . "</td>\n";

$table .= n($_n+4) . "<td></td>\n";

$table .= n($_n+4) . "<td>\n";
$table .= n($_n+6) . "<table class=\"table_address\">\n";
$table .= n($_n+8) . "<tr>\n";

$classname = red("td_adr_title", "FactuurMoment", $errors);
$table .= n($_n+10) . "<td class=\"$classname\">Factuur moment:</td><td>" . html_select_values("FactuurMoment", $cfg['values']['factuurmoment'], $vo->FactuurMoment,  $_n+12) . "</td>\n";
$table .= n($_n+8) . "</tr>\n";
$table .= n($_n+8) . "<tr><td></td></tr>\n";
$table .= n($_n+8) . "<tr>\n";


$classname = red("td_adr_title", "FactuurVerzameling", $errors);
$table .= n($_n+10) . "<td class=\"$classname\">Verzamel factuur:</td><td>" . html_select_values("FactuurVerzameling", $cfg['values']['factuurverzameling'], $vo->FactuurVerzameling,  $_n+12) . "</td>\n";
$table .= n($_n+8) . "</tr>\n";
$table .= n($_n+8) . "<tr><td></td></tr>\n";
$table .= n($_n+8) . "<tr>\n";

$classname = red("td_adr_title", "BetalingsWijze", $errors);
$table .= n($_n+10) . "<td class=\"$classname\">Betalingswijze:</td><td>" . html_select_values("BetalingsWijze", $cfg['values']['betalingswijze'], $vo->BetalingsWijze,  $_n+12) . "</td>\n";
$table .= n($_n+8) . "</tr>\n";
$table .= n($_n+6) . "</table>\n";

$table .= n($_n+4) . "</td>\n";
$table .= n($_n+2) . "</tr>\n";

$table .= n($_n+2) . "<tr class=\"tr_small_empty_line \">\n";
$table .= n($_n+4) . "<td class=\"td_border_bottom\" colspan=\"8\"></td>\n";
$table .= n($_n+2) . "</tr>\n";
$table .= n($_n+2) . "<tr class=\"tr_small_empty_line \">\n";
$table .= n($_n+4) . "<td colspan=\"8\"></td>\n";
$table .= n($_n+2) . "</tr>\n";

$table .= n($_n+2) . "<tr>\n";
$table .= n($_n+4) . "<td>\n";
$table .= n($_n+6) . "<table class=\"table_address\">\n";
$table .= n($_n+8) . "<tr>\n";

$classname = red("td_netwerkb_title", "LokatieNrNetwerkBeheerder", $errors);
$table .= n($_n+10) . "<td class=\"$classname\">Lokatienr netwerkbeheerder:</td><td>" . html_finput_text("LokatieNrNetwerkBeheerder", $vo->LokatieNrNetwerkBeheerder, 25, 25) . "</td>\n";
$table .= n($_n+8) . "</tr>\n";
$table .= n($_n+6) . "</table>\n";
$table .= n($_n+4) . "</td>\n";
$table .= n($_n+2) . "</tr>\n";
$table .= n($_n+0) . "</table>\n";


/**** START HTML OUTPUT *****/


//html_header($_page, $_objectid, $_obj_ref, $_searchfield);
html_header($_page, $_objectid, $_obj_ref,$_search['opt'],"",$_search['str']);

if (sizeof($errors)> 0) {
	$error_str .= "        <div id=\"div_val_errors\">\n";
	$error_str .= "          <p class=\"val_errors\">Er zijn fouten opgetreden in de verwerking van de aanvraag, graag het volgende corrigeren:</p>\n";
  $error_str .= "          <ul class=\"val_errors\">\n";
	foreach($errors as $key => $value) {
     $error_str .= n(8) . "    <li>$value</li>\n" ;  
    }
  $error_str .= "          </ul>\n";
  $error_str .= "        </div>\n\n";
	echo $error_str;
}


echo $table;

//echo edit_button($_objectid, "netbeheer_edit.php");
/*		$html = "\n        <div id=\"edit_button\">\n";
		$html .= "          <div class=\"cssbutton editb b\">\n";
		$html .= "            <fieldset>\n";
		$html .= "              <input type=\"hidden\" name=\"id\" value=\"$_objectid\" />\n";
		$html .= "              <input type=\"hidden\" name=\"ObjectID\" value=\"$_objectid\" />\n";
		$html .= "              <input type=\"hidden\" name=\"mode\" value=\"validate\" />\n";
		$html .= "              <input type=\"submit\" value=\"Wijzigen\"></input>\n";
		$html .= "            </fieldset>\n";
		$html .= "          </div>\n";
		$html .= "        </div>\n\n";
		$html .= "        </form>\n";
		echo $html;*/
echo edit_button($_objectid, "", $_search);

if($_updatetime != "") html_updated($_updatetime);
html_footer();

?>