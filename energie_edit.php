<?php
require_once 'lib/base.inc.php';

$_page = "energie_edit";
$_obj_ref = "";
$_searchfield = "";
$_updatetime = "";
$_errors = array();

if (isset($_GET['id'])) $_objectid = secure_string($_GET['id']);
elseif (isset($_POST['id'])) $_objectid = secure_string($_POST['id']);
else fatal_error("Er is geen object gespecificeerd.");


$_search = get_search_fields();

$dao_obj = new ObjectenEnergieDAO();
$vo = $dao_obj->findByPK($_objectid);
if (!$vo) fatal_error("Er is een fout opgetreden bij het ophalen van de energie gegevens voor ObjectID $_objectid.");


$_obj_ref = "Object: ". format_EAN($vo->EanCode) . " (" . format_Internal_Code($vo->InterneCodering) . ") - " .$vo->ObjectNaam;
$_updatetime = $vo->GewijzigdOp;


/**** Validation of form *****/
if ($_POST['mode'] == 'validate') {
	//new dBug($_POST);
	
	secure_post_data();
	
	// $vo_post = new ObjectenBasisVO();
	// $vo_post->readForm();
	// $errors = $vo_post->validate_fields();
	  
  $_POST['RealisatieDatumStart'] = $_POST['date_year_start'] . "-" . $_POST['date_month_start'] ."-" . $_POST['date_day_start'];
  if (isset($_POST['date_year_end']) && isset($_POST['date_month_end']) && isset($_POST['date_day_end']) ) {
		$_POST['RealisatieDatumEinde'] = $_POST['date_year_end'] . "-" . $_POST['date_month_end'] ."-" . $_POST['date_day_end'];
  }
  //$_POST['IngangsDatumLeverancier'] = strftime('%F', strtotime("$datestr 00:00:00"));
//new dBug($_POST);
	$vo = new ObjectenEnergieVO();
	$vo->readForm();
  
	$errors = $vo->validate_fields();
  // new dBug($_POST);
  // new dBug($vo);
//new dBug($errors);

	if (sizeof($errors) == 0) {
		//echo "UPDATING";
    if ($dao_obj->updateVO($vo) == 1) $m = 1;
		else $m = 2;
		$host  = $_SERVER['HTTP_HOST'];
    $uri   = rtrim(dirname($_SERVER['PHP_SELF']), '/\\');
    $extra = $cfg['energie_page'];
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

// Get producten list
$producten_dao = new ProductenDAO();
$producten_volist = $producten_dao->findWhere("", "ProductNaam ASC");

// Get fiscale groep list
$fgroup_dao = new FiscaleGroepenDAO();
$fgroup_volist = $fgroup_dao->findWhere("", "FiscaalGroupType ASC");

//new dBug($_POST);

	$_n = 8;
	$table = n($_n+0) . "<form method=\"post\" name=\"energie_edit\" action=\"" . $_SERVER['PHP_SELF'] . "\">\n";
	$_n = 10;
$table .=  n($_n+0) . "<table id=\"table_main\">\n";
$table .= n($_n+2) . "<tr>\n";

$classname = red("td_main_title_wide", "ProductID", $errors);
$table .= n($_n+4) . "<td class=\"$classname\">Product:</td>\n";

$table .= n($_n+4) . "<td class=\"td_main_wide_energie\">" . html_select_list_vo("ProductID", $producten_volist, "ProductID", "ProductNaam", $vo->ProductID, $_n+6) . n($_n+4) ."</td>\n";
//$table .= n($_n+4) . "<td class=\"td_main_wide_energie\">". $vo->ProductNaam . "</td>\n";

$table .= n($_n+4) . "<td class=\"td_spacer\"></td>\n";

$classname = red("td_main_title_middle", "MeterNummer", $errors);
$table .= n($_n+4) . "<td class=\"$classname\">Meternummer:</td>\n";

$table .= n($_n+4) . "<td class=\"td_main_middle\">" . html_finput_text("MeterNummer", $vo->MeterNummer, 15, 15) . "</td>\n";
//$table .= n($_n+4) . "<td class=\"td_main_wide_energie\">". $vo->MeterNummer . "</td>\n";

$table .= n($_n+4) . "<td class=\"td_main_spacer\"></td>\n";

$classname = red("td_main_title_right", "GrootKleinVerbruik", $errors);
$table .= n($_n+4) . "<td class=\"$classname\">Groot/klein :</td>\n";

$table .= n($_n+4) . "<td class=\"td_main_wide_energie\">" . html_select_values("GrootKleinVerbruik", $cfg['values']['grootkleinverbruik'], $vo->GrootKleinVerbruik,  $_n+6) . n($_n+4) ."</td>\n";
///$table .= n($_n+4) . "<td class=\"td_main_wide_energie\">". $vo->GrootKleinVerbruik . "</td>\n";

$table .= n($_n+2) . "</tr>\n";
$table .= n($_n+2) . "<tr>\n";
$classname = red("td_main_title_wide", "StandaardJaarVerbruik", $errors);
$table .= n($_n+4) . "<td class=\"$classname\">Standaard jaarverbruik:</td>\n";

$table .= n($_n+4) . "<td class=\"td_main_wide_energie\">" . html_finput_text("StandaardJaarVerbruik", $vo->StandaardJaarVerbruik, 15, 15) . "</td>\n";
//$table .= n($_n+4) . "<td class=\"td_main_wide_energie\">". $vo->StandaardJaarVerbruik . "</td>\n";

$table .= n($_n+4) . "<td class=\"td_main_spacer\"></td>\n";
$classname = red("td_main_title_wide", "MeterSoort", $errors);
$table .= n($_n+4) . "<td class=\"$classname\">Soort meter:</td>\n";

$table .= n($_n+4) . "<td class=\"td_main_middle\">" . html_finput_text("MeterSoort", $vo->MeterSoort, 15, 15) . "</td>\n";
//$table .= n($_n+4) . "<td class=\"td_main_wide_energie\">". $vo->MeterSoort . "</td>\n";

$table .= n($_n+4) . "<td class=\"td_spacer\"></td>\n";
$classname = red("td_main_title_right", "EnergieOpmerkingen", $errors);
$table .= n($_n+4) . "<td class=\"$classname\" rowspan=\"4\">Opmerkingen:</td>\n";

$table .= n($_n+4) . "<td rowspan=\"4\" class=\"td_main_wide_energie\">" . html_finput_textarea("EnergieOpmerkingen", $vo->EnergieOpmerkingen, 20, 4) . "</td>\n";
//$table .= n($_n+4) . "<td class=\"td_main_wide_energie\" rowspan=\"4\">" . $vo->EnergieOpmerkingen . "</td>\n";

$table .= n($_n+2) . "</tr>\n";
$table .= n($_n+2) . "<tr>\n";
$classname = red("td_main_title_wide", "InBedrijf", $errors);
$table .= n($_n+4) . "<td class=\"$classname\">In bedrijf:</td>\n";

$table .= n($_n+4) . "<td class=\"td_main_wide_energie\">" . html_select_values("InBedrijf", $cfg['values']['inbedrijf'], $vo->InBedrijf,  $_n+6) . n($_n+4) ."</td>\n";
//$table .= n($_n+4) . "<td class=\"td_main_wide_energie\">". $vo->InBedrijf . "</td>\n";

$table .= n($_n+4) . "<td class=\"td_spacer\"></td>\n";
$classname = red("td_main_title_middle", "MeetdienstContractNummer", $errors);
$table .= n($_n+4) . "<td class=\"$classname\">Meetdienst contract:</td>\n";

$table .= n($_n+4) . "<td class=\"td_main_middle\">" . html_finput_text("MeetdienstContractNummer", $vo->MeetdienstContractNummer, 15, 15) . "</td>\n";
//$table .= n($_n+4) . "<td class=\"td_main_wide_energie\">". $vo->MeetdienstContractNummer . "</td>\n";

$table .= n($_n+4) . "<td class=\"td_main_spacer\"></td>\n";
$table .= n($_n+2) . "</tr>\n";
$table .= n($_n+2) . "<tr>\n";
$classname = red("td_main_title_wide", "RealisatieDatumStart", $errors);
$table .= n($_n+4) . "<td class=\"$classname\">Realisatie aansluiting:</td>\n";
$ext = "_start";
//echo "\n<!-- POST: " . $_POST["date_day$ext"] . " -->\n";
if (isset($_POST["date_day$ext"])) $day_s = $_POST["date_day$ext"];
else $day_s = date("j", strtotime($vo->RealisatieDatumStart));
if (isset($_POST["date_month$ext"])) $month_s = $_POST["date_month$ext"];
else $month_s = date("n", strtotime($vo->RealisatieDatumStart));
if (isset($_POST["date_year$ext"])) $year_s = $_POST["date_year$ext"];
else $year_s = date("Y", strtotime($vo->RealisatieDatumStart));
//echo "\n<!-- date_dropdown($day_s,$month_s,$year_s,12,'_start') -->\n";
$table .= n($_n+4) . "<td class=\"td_main_wide_energie\" colspan=2>". date_dropdown($day_s,$month_s,$year_s,12,'_start');
$table .= n($_n+4) . "</td>\n";
//$table .= n($_n+4) . "<td class=\"td_main_wide_energie\">". format_mysql_timestamp($vo->RealisatieDatumStart, $cfg['format']['strf_time_date_full']) . "</td>\n";

//$table .= n($_n+4) . "<td class=\"td_spacer\"></td>\n";
$classname = red("td_main_title_wide", "ContractWaarde", $errors);
$table .= n($_n+4) . "<td class=\"$classname\">Contract waarde:</td>\n";

$table .= n($_n+4) . "<td class=\"td_main_middle\">" . html_finput_text("ContractWaarde", $vo->ContractWaarde, 10, 10) . " $vo->ProductEenheid</td>\n";
//$table .= n($_n+4) . "<td class=\"td_main_wide_energie\">". $vo->ContractWaarde . " " . $vo->ProductEenheid . "</td>\n";

$table .= n($_n+4) . "<td class=\"td_main_spacer\"></td>\n";
$table .= n($_n+2) . "</tr>\n";
$table .= n($_n+2) . "<tr>\n";

$ext = "_end";
if (isset($_POST["date_day$ext"])) $day_s = $_POST["date_day$ext"];
elseif (!empty($vo->RealisatieDatumEinde)) $day_s = date("j", strtotime($vo->RealisatieDatumEinde));
else $day_s="''";
if (isset($_POST["date_month$ext"])) $month_s = $_POST["date_month$ext"];
elseif (!empty($vo->RealisatieDatumEinde)) $month_s = date("n", strtotime($vo->RealisatieDatumEinde));
else $month_s = "''";
if (isset($_POST["date_year$ext"])) $year_s = $_POST["date_year$ext"];
elseif (!empty($vo->RealisatieDatumEinde)) $year_s = date("Y", strtotime($vo->RealisatieDatumEinde));
else $year_s = "''";
if (!empty($vo->RealisatieDatumEinde)) $chkd = " checked=\"checked\"";
$checkbox = "<input type=\"checkbox\" name=\"end_check\" value=\"1\" $chkd onClick=\"show_end_date_select('end_date_select',$day_s, $month_s, $year_s);\">";
$classname = red("td_main_title_wide", "RealisatieDatumEinde", $errors);
$table .= n($_n+4) . "<td class=\"$classname\">Be&euml;indigd?&nbsp;&nbsp; $checkbox</td>\n";

$table .= n($_n+4) . "<td class=\"td_main_wide_energie\" colspan=2>\n";
$table .= n($_n+6) . "<div id=\"end_date_select\">\n";
if (!empty($vo->RealisatieDatumEinde)) $table .= n($_n+8) . "<div id=\"end_date_select\"> \n". date_dropdown($day_s,$month_s,$year_s,12,'_end');
$table .= n($_n+6) . "</div>\n";
$table .= n($_n+4) . "</td>\n";
//$table .= n($_n+4) . "<td class=\"td_main_wide_energie\">". format_mysql_timestamp($vo->RealisatieDatumEinde, $cfg['format']['strf_time_date_full']) . "</td>\n";

//$table .= n($_n+4) . "<td class=\"td_spacer\"></td>\n";

$classname = red("td_main_title_middle", "AansluitingType", $errors);
$table .= n($_n+4) . "<td class=\"$classname\">Aansluiting type:</td>\n";

$table .= n($_n+4) . "<td class=\"td_main_middle\">" . html_finput_text("AansluitingType", $vo->AansluitingType, 15, 8) . "</td>\n";
//$table .= n($_n+4) . "<td class=\"td_main_wide_energie\">". $vo->AansluitingType . "</td>\n";

$table .= n($_n+4) . "<td class=\"td_main_spacer\"></td>\n";
$table .= n($_n+2) . "</tr>\n";

$table .= n($_n+2) . "<tr class=\"tr_small_empty_line \">\n";
$table .= n($_n+4) . "<td class=\"td_border_bottom\" colspan=\"8\"></td>\n";
$table .= n($_n+2) . "</tr>\n";
$table .= n($_n+2) . "<tr class=\"tr_small_empty_line \">\n";
$table .= n($_n+4) . "<td colspan=\"8\"></td>\n";
$table .= n($_n+2) . "</tr>\n";

$table .= n($_n+2) . "<tr>\n";
$classname = red("td_main_title_wide", "BrutoVloerOppervlak", $errors);
$table .= n($_n+4) . "<td class=\"$classname\">Bruto vloeroppervlak:</td>\n";

$table .= n($_n+4) . "<td class=\"td_main_wide_energie\">" . html_finput_text("BrutoVloerOppervlak", $vo->BrutoVloerOppervlak, 15, 15) . "  m<sup>2</sup></td>\n";
//$table .= n($_n+4) . "<td class=\"td_main_wide_energie\">". $vo->BrutoVloerOppervlak . " m<sup>2</sup></td>\n";

$table .= n($_n+4) . "<td class=\"td_spacer\"></td>\n";
$classname = red("td_main_title_middle", "EnergieLabel", $errors);
$table .= n($_n+4) . "<td class=\"$classname\">Label codering:</td>\n";

$table .= n($_n+4) . "<td class=\"td_main_middle\">" . html_select_values("EnergieLabel", $cfg['values']['energielabel'], $vo->EnergieLabel,  $_n+6) . n($_n+4) ."</td>\n";
//$table .= n($_n+4) . "<td class=\"td_main_wide_energie\">". $vo->EnergieLabel . "</td>\n";

$table .= n($_n+4) . "<td class=\"td_main_spacer\"></td>\n";
$classname = red("td_main_title_right", "LED", $errors);
$table .= n($_n+4) . "<td class=\"$classname\">LED:</td>\n";

$table .= n($_n+4) . "<td class=\"td_main_wide_energie\">" . html_select_values("LED", $cfg['values']['LED'], $vo->LED,  $_n+6) . n($_n+4) ."</td>\n";
//$table .= n($_n+4) . "<td class=\"td_main_wide_energie\">". $vo->LED . "</td>\n";

$table .= n($_n+2) . "</tr>\n";
$table .= n($_n+2) . "<tr>\n";
$classname = red("td_main_title_wide", "EnergieScan", $errors);
$table .= n($_n+4) . "<td class=\"$classname\">Energiescan:</td>\n";

$table .= n($_n+4) . "<td class=\"td_main_wide_energie\">" . html_select_values("EnergieScan", $cfg['values']['energiescan'], $vo->EnergieScan,  $_n+6) . n($_n+4) ."</td>\n";
//$table .= n($_n+4) . "<td class=\"td_main_wide_energie\">". $vo->EnergieScan . "</td>\n";

$table .= n($_n+4) . "<td class=\"td_main_spacer\"></td>\n";
$classname = red("td_main_title_middle", "EnergieLabelAfmelding", $errors);
$table .= n($_n+4) . "<td class=\"$classname\">Label afmelding:</td>\n";

$table .= n($_n+4) . "<td class=\"td_main_middle\">" . html_select_values("EnergieLabelAfmelding", $cfg['values']['energielabelafmelding'], $vo->EnergieLabelAfmelding,  $_n+6) . n($_n+4) ."</td>\n";
//$table .= n($_n+4) . "<td class=\"td_main_wide_energie\">". $vo->EnergieLabelAfmelding . "</td>\n";

$table .= n($_n+4) . "<td class=\"td_spacer\"></td>\n";
$table .= n($_n+4) . "<td class=\"td_main_title_right\"></td>\n";
$table .= n($_n+4) . "<td class=\"td_main_wide_energie\"></td>\n";
$table .= n($_n+2) . "</tr>\n";

$table .= n($_n+2) . "<tr class=\"tr_small_empty_line \">\n";
$table .= n($_n+4) . "<td class=\"td_border_bottom\" colspan=\"8\"></td>\n";
$table .= n($_n+2) . "</tr>\n";
$table .= n($_n+2) . "<tr class=\"tr_small_empty_line \">\n";
$table .= n($_n+4) . "<td colspan=\"8\"></td>\n";
$table .= n($_n+2) . "</tr>\n";

$table .= n($_n+2) . "<tr>\n";
$classname = red("td_main_title_wide", "BijzondereAansluiting", $errors);
$table .= n($_n+4) . "<td class=\"$classname\">Bijzondere aansluiting:</td>\n";

$table .= n($_n+4) . "<td class=\"td_main_wide_energie\">" . html_select_values("BijzondereAansluiting", $cfg['values']['bijzondereaansluiting'], $vo->BijzondereAansluiting,  $_n+6) . n($_n+4) ."</td>\n";
//$table .= n($_n+4) . "<td class=\"td_main_wide_energie\">". $vo->BijzondereAansluiting . "</td>\n";

$table .= n($_n+4) . "<td class=\"td_spacer\"></td>\n";
$classname = red("td_main_title_middle", "EnergieBelasting", $errors);
$table .= n($_n+4) . "<td class=\"$classname\">Energie belasting:</td>\n";

$table .= n($_n+4) . "<td class=\"td_main_middle\">" . html_select_values("EnergieBelasting", $cfg['values']['energiebelasting'], $vo->EnergieBelasting,  $_n+6) . n($_n+4) ."</td>\n";
//$table .= n($_n+4) . "<td class=\"td_main_wide_energie\">". $vo->EnergieBelasting . "</td>\n";

$table .= n($_n+4) . "<td class=\"td_main_spacer\"></td>\n";
$table .= n($_n+4) . "<td class=\"td_main_title_right\"></td>\n";
$table .= n($_n+4) . "<td class=\"td_main_wide_energie\"></td>\n";
$table .= n($_n+2) . "</tr>\n";
$table .= n($_n+2) . "<tr>\n";
$classname = red("td_main_title_wide", "FiscaalGroepID", $errors);
$table .= n($_n+4) . "<td class=\"$classname\">Fiscale groep:</td>\n";

$table .= n($_n+4) . "<td class=\"td_main_wide_energie\">" . html_select_list_vo("FiscaalGroepID", $fgroup_volist, "FiscaalGroepID", "FiscaalGroupType", $vo->FiscaalGroepID, $_n+6) . n($_n+4) ."</td>\n";
//$table .= n($_n+4) . "<td class=\"td_main_wide_energie\">". $vo->FiscaalGroupType . "</td>\n";

$table .= n($_n+4) . "<td class=\"td_main_spacer\"></td>\n";
$table .= n($_n+4) . "<td class=\"td_main_title_middle\"></td>\n";
$table .= n($_n+4) . "<td class=\"td_main_middle\"></td>\n";
$table .= n($_n+4) . "<td class=\"td_spacer\"></td>\n";
$table .= n($_n+4) . "<td class=\"td_main_title_right\"></td>\n";
$table .= n($_n+4) . "<td class=\"td_main_wide_energie\"></td>\n";
$table .= n($_n+2) . "</tr>\n";
$table .= n($_n+0) . "</table>\n";



/**** START HTML OUTPUT *****/

//html_header($_page, $_objectid, $_obj_ref, $_searchfield);

html_header($_page, $_objectid, $_obj_ref,$_search['opt'],"" ,$_search['str']);
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

echo edit_button($_objectid, "", $_search);


if($_updatetime != "") html_updated($_updatetime);
html_footer();


?>