<?php
require_once 'lib/base.inc.php';

$_page = "net_edit";
$_searchfield = "";
$_obj_ref = "";
$_updatetime = ""; 
$_errors = array();

if (isset($_GET['id'])) $_objectid = secure_string($_GET['id']);
elseif (isset($_POST['id'])) $_objectid = secure_string($_POST['id']);
else fatal_error("Er is geen object gespecificeerd.");


$_search = get_search_fields();

check_permission($_objectid, "view");


$dao_obj = new ObjectenBeheerderDAO();
//$vo = $dao_obj->findByPK($_objectid);
//if (!$vo) fatal_error("Er is een fout opgetreden bij het ophalen van de netbeheer gegevens voor ObjectID $_objectid.");



/**** Validation of form *****/
if ($_POST['mode'] == 'validate') {
	//new dBug($_POST);
	
	secure_post_data();
	
	// $vo_post = new ObjectenBasisVO();
	// $vo_post->readForm();
	// $errors = $vo_post->validate_fields();
	
	$_POST['IngangsDatumLeverancier']  = $_POST['date_year'] . "-" . $_POST['date_month'] ."-" . $_POST['date_day'];
	//$_POST['IngangsDatumLeverancier'] = strftime('%F', strtotime("$datestr 00:00:00"));
//new dBug($_POST);
	$vo = new ObjectenBeheerderVO();
	$vo->readForm();
	$errors = $vo->validate_fields();
//new dBug($vo);
//new dBug($errors);

	if (sizeof($errors) == 0) {
		if ($dao_obj->updateVO($vo) == 1) $m = 1;
		else $m = 2;
		$host  = $_SERVER['HTTP_HOST'];
    $uri   = rtrim(dirname($_SERVER['PHP_SELF']), '/\\');
    $extra = $cfg['netbeheer_page'];
    if ($_search) $searchlink = "&s=" . urlencode($_search['str']) . "&o=" . $_search['opt'];
    header("Location: http://$host$uri/$extra?id=$_objectid&m=$m$searchlink");
    exit;
	} else {
		$vo_orig = $dao_obj->findByPK($_objectid);
		// Set reference string and get update time 
		$_obj_ref = "Object: ". format_EAN($vo_orig->EanCode) . " (" . format_Internal_Code($vo_orig->InterneCodering) . ") - " .$vo_orig->ObjectNaam;
		$_updatetime = $vo->GewijzigdOp;
		
		// get EANs for netbeheerder and leverancier
		$dao_lev = new LeveranciersDAO();
		$lev_vo = $dao_lev->findByPK($vo->LeverancierID);
		$vo->LeverancierEAN = format_EAN($lev_vo->LeverancierEAN);
		$dao_net = new NetbeheerdersDAO();
		$net_vo = $dao_net->findByPK($vo->NetBeheerderID);
		$vo->NetbeheerderEAN = format_EAN($net_vo->NetBeheerderEAN);
		
		
		
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


// Get list of organizations
$dao_lev = new LeveranciersDAO();
$lev_volist = $dao_lev->findWhere("","LeverancierNaam ASC");
// Get list of organizations
$dao_net = new NetbeheerdersDAO();
$net_volist = $dao_net->findWhere("","NetbeheerderNaam ASC");


	$_n = 8;
	$table = n($_n+0) . "<form method=\"post\" action=\"" . $_SERVER['PHP_SELF'] . "\">\n";
	$_n = 10;
$table .=  n($_n+0) . "<table id=\"table_main\">\n";
$table .= n($_n+2) . "<tr>\n";
$classname = red("td_main_title", "LeverancierID", $errors);
$table .= n($_n+4) . "<td class=\"$classname\">Leverancier:</td>\n";

$onchange = "onchange=\"showDiv('div_lev_ean', this.value, 'lev')\"";
$table .= n($_n+4) . "<td class=\"td_main\">" . html_select_list_vo_ajax("LeverancierID", $lev_volist, "LeverancierID", "LeverancierNaam", $onchange, $vo->LeverancierID, 6, false) . "</td>\n";
$table .= n($_n+4) . "<td class=\"td_spacer\"></td>\n";

$classname = red("td_main_title", "ContractNummerLeverancier", $errors);
$table .= n($_n+4) . "<td class=\"$classname\">Contractnummer:</td>\n";

$table .= n($_n+4) . "<td class=\"td_main\">" . html_finput_text("ContractNummerLeverancier", $vo->ContractNummerLeverancier, 25, 25) . "</td>\n";
$table .= n($_n+4) . "<td class=\"td_main_spacer\"></td>\n";

$classname = red("td_main_title", "StroomType", $errors);
$table .= n($_n+4) . "<td class=\"$classname\">Type stroom:</td>\n";

$table .= n($_n+4) . "<td class=\"td_main\">" . html_select_values("StroomType", $cfg['values']['stroomtype'], $vo->StroomType,  $_n+6) . n($_n+4) ."</td>\n";

$table .= n($_n+2) . "</tr>\n";
$table .= n($_n+2) . "<tr>\n";
$table .= n($_n+4) . "<td class=\"td_main_title\">EAN leverancier:</td>\n";
$div = "<div id=\"div_lev_ean\">";
$table .= n($_n+4) . "<td class=\"td_main\">$div" . format_EAN($vo->LeverancierEAN) . "</div></td>\n";

$table .= n($_n+4) . "<td class=\"td_main_spacer\"></td>\n";

$classname = red("td_main_title", "IngangsDatumLeverancier", $errors);
$table .= n($_n+4) . "<td class=\"$classname\">Ingangsdatum:</td>\n";

if (isset($_POST['date_day'])) $day_s = $_POST['date_day'];
else $day_s = date("j", strtotime($vo->IngangsDatumLeverancier));
if (isset($_POST['date_month'])) $month_s = $_POST['date_month'];
else $month_s = date("n", strtotime($vo->IngangsDatumLeverancier));
if (isset($_POST['date_year'])) $year_s = $_POST['date_year'];
else $year_s = date("Y", strtotime($vo->IngangsDatumLeverancier));
$table .= n($_n+4) . "<td class=\"td_main\">". date_dropdown($day_s,$month_s,$year_s);
$table .= n($_n+4) . "</td>\n";
$table .= n($_n+4) . "<td class=\"td_spacer\"></td>\n";
$table .= n($_n+4) . "<td class=\"td_main_title\"></td>\n";
$table .= n($_n+4) . "<td class=\"td_main\"></td>\n";
$table .= n($_n+2) . "</tr>\n";

$table .= n($_n+2) . "<tr class=\"tr_small_empty_line \">\n";
$table .= n($_n+4) . "<td class=\"td_border_bottom\" colspan=\"8\"></td>\n";
$table .= n($_n+2) . "</tr>\n";
$table .= n($_n+2) . "<tr class=\"tr_small_empty_line \">\n";
$table .= n($_n+4) . "<td colspan=\"8\"></td>\n";
$table .= n($_n+2) . "</tr>\n";

$table .= n($_n+2) . "<tr>\n";

$classname = red("td_main_title", "NetBeheerderID", $errors);
$table .= n($_n+4) . "<td class=\"$classname\">Netbeheerder:</td>\n";

$div = "<div id=\"div_net_ean\">";
$onchange = "onchange=\"showDiv('div_net_ean', this.value, 'net')\"";
$table .= n($_n+4) . "<td class=\"td_main\">\n" . html_select_list_vo_ajax("NetBeheerderID", $net_volist, "NetBeheerderID", "NetBeheerderNaam", $onchange, $vo->NetBeheerderID, 6);
$table .= n($_n+4) . "</td>\n";

$table .= n($_n+4) . "<td class=\"td_spacer\"></td>\n";

$classname = red("td_main_title", "ContractNummerNetbeheerder", $errors);
$table .= n($_n+4) . "<td class=\"$classname\">Contractnummer:</td>\n";

$table .= n($_n+4) . "<td class=\"td_main\">" . html_finput_text("ContractNummerNetbeheerder", $vo->ContractNummerNetbeheerder, 25, 25) . "</td>\n";
$table .= n($_n+4) . "<td class=\"td_main_spacer\"></td>\n";
$table .= n($_n+4) . "<td class=\"td_main_title\"></td>\n";
$table .= n($_n+4) . "<td class=\"td_main\"></td>\n";
$table .= n($_n+2) . "</tr>\n";
$table .= n($_n+2) . "<tr>\n";
$table .= n($_n+4) . "<td class=\"td_main_title\">EAN beheerder:</td>\n";
$table .= n($_n+4) . "<td class=\"td_main\">$div". format_EAN($vo->NetbeheerderEAN) . "</div></td>\n";
$table .= n($_n+4) . "<td class=\"td_spacer\"></td>\n";
$table .= n($_n+4) . "<td class=\"td_main_title\"></td>\n";
$table .= n($_n+4) . "<td class=\"td_main\"></td>\n";
$table .= n($_n+4) . "<td class=\"td_main_spacer\"></td>\n";
$table .= n($_n+4) . "<td class=\"td_main_title\"></td>\n";
$table .= n($_n+4) . "<td class=\"td_main\"></td>\n";
$table .= n($_n+2) . "</tr>\n";
$table .= n($_n+0) . "</table>\n";
$_n = 8;
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
echo edit_button($_objectid, "", $_search);

if($_updatetime != "") html_updated($_updatetime);
html_footer();


?>