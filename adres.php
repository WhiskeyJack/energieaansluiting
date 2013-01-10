<?php
require_once 'lib/base.inc.php';

$_page = "adres";
$_obj_ref = "";
$_searchfield = "";
$_updatetime = "";

if (isset($_GET['id'])) $_objectid = $_GET['id'];
else fatal_error("Er is geen object gespecificeerd.");

// get message id if available
if (isset($_GET['m'])) $_messid = $_GET['m'];
elseif (isset($_POST['m'])) $_messid = $_POST['m'];


$_search = get_search_fields();

$dao_obj = new ObjectenAdresDAO();
$vo = $dao_obj->findByPK($_objectid);

if (!$vo) fatal_error("Er is een fout opgetreden bij het ophalen van de adres gegevens voor ObjectID $_objectid.");

$adr = array('ObjectAdres' => "Adres object:", 'AansluitRegisterAdres' => "Aansluitregister:", 'FactuurAdres' => "Facturatie adres:");
$dao_adr = new AdressenDAO();
/*foreach($adr as $key => $value) {
	if ($vo->$key) {
		$vo_org_array["$key"] = $dao_adr->findByPK($vo->$key);		
	}
}*/


$_obj_ref = "Object: ". format_EAN($vo->EanCode) . " (" . format_Internal_Code($vo->InterneCodering) . ") - " .$vo->ObjectNaam;
$_updatetime = $vo->GewijzigdOp;


$_n = 8;
$table =  n($_n+0) . "<table id=\"table_main\">\n";

$table .= n($_n+2) . "<tr>\n";

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
		if ($key == "AansluitRegisterAdres" && $vo->AansluitRegisterAdres == $vo->ObjectAdres) $adr_lines[0] = "Zelfde als Object adres.";
		else { 
			//if ($vo_array[$vo->$key]->AdresRegel1 != "") $adr_lines[] =  $vo_array[$vo->$key]->AdresRegel1;
			$adr_lines[] = $vo_array[$vo->$key]->AdresRegel1;
			$adr_lines[] = $vo_array[$vo->$key]->StraatNaam . " " . $vo_array[$vo->$key]->Huisnummer . " " . $vo_array[$vo->$key]->HuisnummerToevoeging;
			$adr_lines[] = $vo_array[$vo->$key]->Postcode;
			$adr_lines[] = $vo_array[$vo->$key]->Plaats;
		}
		
		$table .= n($_n+4)  . "<td>\n";
		$table .= n($_n+6)  . "<table class=\"table_address\">\n";
		$table .= n($_n+8)  . "<tr>\n";
		$table .= n($_n+10) . "<td class=\"td_adr_title\">$value</td><td></td>\n";
		$table .= n($_n+8)  . "</tr>\n";
		//$table .= n($_n+8) . "<tr class=\"tr_small_empty_line\"><td colspan=\"2\"></td></tr>\n";
		$table .= n($_n+8)  . "<tr>\n";
		$table .= n($_n+10) . "<td colspan=\"2\">\n";
		$table .= n($_n+12) . "<div id=\"div_$key\">\n";
		
		$table .= n($_n+14) . "<table>\n";
		$table .= n($_n+16) . "<tr><td>" . $adr_lines[0] . "</td></tr>\n";

		if (isset($adr_lines[1])) $table .= n($_n+16) . "<tr><td>" . $adr_lines[1] . "</td></tr>\n";
		if (isset($adr_lines[2])) $table .= n($_n+16) . "<tr><td>" . $adr_lines[2] . "</td></tr>\n";
		if (isset($adr_lines[3])) $table .= n($_n+16) . "<tr><td>" . $adr_lines[3] . "</td></tr>\n";
		if (isset($adr_lines[4])) $table .= n($_n+16) . "<tr><td>" . $adr_lines[4] . "</td></tr>\n";
		
		$table .= n($_n+14) . "</table>\n";
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
if ($facturatie->AdresRegel1 != "") $adr_lines[] =  $facturatie->AdresRegel1;
$adr_lines[] = $facturatie->StraatNaam . " " . $facturatie->Huisnummer . " " . $facturatie->HuisnummerToevoeging;
$adr_lines[] = $facturatie->Postcode;
$adr_lines[] = $facturatie->Plaats;
	
$table .= n($_n+2) . "<tr>\n";		
$table .= n($_n+4) . "<td>\n";
$table .= n($_n+6) . "<table class=\"table_address\">\n";
$table .= n($_n+8) . "<tr>\n";
$table .= n($_n+10) . "<td class=\"td_adr_title\">Factuur naam:</td><td>". $vo->FactuurTenaamStelling . "</td>\n";		
$table .= n($_n+8) . "</tr>\n";
$table .= n($_n+8) . "<tr><td></td></tr>\n";
$table .= n($_n+8) . "<tr>\n";
$table .= n($_n+10) . "<td class=\"td_adr_title\">$value</td><td></td>\n";		

$table .= n($_n+8)  . "</tr>\n";
		$table .= n($_n+8) . "<tr class=\"tr_small_empty_line\"><td colspan=\"2\"></td></tr>\n";
$table .= n($_n+8)  . "<tr>\n";
$table .= n($_n+10) . "<td colspan=\"2\">\n";
$table .= n($_n+12) . "<div id=\"div_$key\">\n";

$table .= n($_n+14) . "<table>\n";
$table .= n($_n+16) . "<tr><td>" . $adr_lines[0] . "</td></tr>\n";
		
if (isset($adr_lines[1])) $table .= n($_n+16) . "<tr><td>" . $adr_lines[1] . "</td></tr>\n";
if (isset($adr_lines[2])) $table .= n($_n+16) . "<tr><td>" . $adr_lines[2] . "</td></tr>\n";
if (isset($adr_lines[3])) $table .= n($_n+16) . "<tr><td>" . $adr_lines[3] . "</td></tr>\n";
if (isset($adr_lines[4])) $table .= n($_n+16) . "<tr><td>" . $adr_lines[4] . "</td></tr>\n";

$table .= n($_n+14) . "</table>\n";
$table .= n($_n+12) . "</div>\n";
$table .= n($_n+10) . "</td>\n";
$table .= n($_n+8) . "</tr>\n";
$table .= n($_n+6) . "</table>\n";
$table .= n($_n+4) . "</td>\n";

$table .= n($_n+4) . "<td></td>\n";

$table .= n($_n+4) . "<td>\n";
$table .= n($_n+6) . "<table class=\"table_address\">\n";
$table .= n($_n+8) . "<tr>\n";
$table .= n($_n+10) . "<td class=\"td_adr_title\">Factuur moment:</td><td>". $vo->FactuurMoment . "</td>\n";
$table .= n($_n+8) . "</tr>\n";
$table .= n($_n+8) . "<tr><td></td></tr>\n";
$table .= n($_n+8) . "<tr>\n";
$table .= n($_n+10) . "<td class=\"td_adr_title\">Verzamel factuur:</td><td>". $vo->FactuurVerzameling . "</td>\n";
$table .= n($_n+8) . "</tr>\n";
$table .= n($_n+8) . "<tr><td></td></tr>\n";
$table .= n($_n+8) . "<tr>\n";
$table .= n($_n+10) . "<td class=\"td_adr_title\">Betalingswijze:</td><td>". $vo->BetalingsWijze . "</td>\n";
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
$table .= n($_n+10) . "<td class=\"td_netwerkb_title\">Lokatienr netwerkbeheerder:</td><td>". $vo->LokatieNrNetwerkBeheerder . "</td>\n";
$table .= n($_n+8) . "</tr>\n";
$table .= n($_n+6) . "</table>\n";
$table .= n($_n+4) . "</td>\n";
$table .= n($_n+2) . "</tr>\n";
$table .= n($_n+0) . "</table>\n";


/**** START HTML OUTPUT *****/


//html_header($_page, $_objectid, $_obj_ref, $_searchfield);
html_header($_page, $_objectid, $_obj_ref,$_search['opt'],"",$_search['str']);
if (isset($_messid)) echo display_message("", false, $_messid);
echo $table;
echo edit_button($_objectid, "adres_edit.php",$_search);
if($_updatetime != "") html_updated($_updatetime, $_objectid);
html_footer();

?>