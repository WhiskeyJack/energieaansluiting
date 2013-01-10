<?php
require_once 'lib/base.inc.php';

$_page = "net";
$_obj_ref = "";
$_searchfield = "";
$_updatetime = "";

if (isset($_GET['id'])) $_objectid = $_GET['id'];
else fatal_error("Er is geen object gespecificeerd.");

// get message id if available
if (isset($_GET['m'])) $_messid = $_GET['m'];
elseif (isset($_POST['m'])) $_messid = $_POST['m'];

$_search = get_search_fields();

check_permission($_objectid, "view");


$dao_obj = new ObjectenBeheerderDAO();
$vo = $dao_obj->findByPK($_objectid);
if (!$vo) fatal_error("Er is een fout opgetreden bij het ophalen van de netbeheer gegevens voor ObjectID $_objectid.");


$_obj_ref = "Object: ". format_EAN($vo->EanCode) . " (" . format_Internal_Code($vo->InterneCodering) . ") - " .$vo->ObjectNaam;
$_updatetime = $vo->GewijzigdOp;


$_n = 8;
$table = n($_n+0) . "<form method=\"post\" action=\"" . $_SERVER['PHP_SELF'] . "\">\n";
$_n = 10;
$table =  n($_n+0) . "<table id=\"table_main\">\n";
$table .= n($_n+2) . "<tr>\n";
$table .= n($_n+4) . "<td class=\"td_main_title\">Leverancier:</td>\n";
$table .= n($_n+4) . "<td class=\"td_main\">". $vo->LeverancierNaam . "</td>\n";
$table .= n($_n+4) . "<td class=\"td_spacer\"></td>\n";
$table .= n($_n+4) . "<td class=\"td_main_title\">Contractnummer:</td>\n";
$table .= n($_n+4) . "<td class=\"td_main\">". $vo->ContractNummerLeverancier . "</td>\n";
$table .= n($_n+4) . "<td class=\"td_main_spacer\"></td>\n";
$table .= n($_n+4) . "<td class=\"td_main_title\">Type stroom:</td>\n";
$table .= n($_n+4) . "<td class=\"td_main\">". $vo->StroomType . "</td>\n";
$table .= n($_n+2) . "</tr>\n";
$table .= n($_n+2) . "<tr>\n";
$table .= n($_n+4) . "<td class=\"td_main_title\">EAN leverancier:</td>\n";
$table .= n($_n+4) . "<td class=\"td_main\">". format_EAN($vo->LeverancierEAN) . "</td>\n";
$table .= n($_n+4) . "<td class=\"td_main_spacer\"></td>\n";
$table .= n($_n+4) . "<td class=\"td_main_title\">Ingangsdatum:</td>\n";
$table .= n($_n+4) . "<td class=\"td_main\">". format_mysql_timestamp($vo->IngangsDatumLeverancier, $cfg['format']['strf_time_date_full']) . "</td>\n";
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
$table .= n($_n+4) . "<td class=\"td_main_title\">Netbeheerder:</td>\n";
$table .= n($_n+4) . "<td class=\"td_main\">". $vo->NetbeheerderNaam . "</td>\n";
$table .= n($_n+4) . "<td class=\"td_spacer\"></td>\n";
$table .= n($_n+4) . "<td class=\"td_main_title\">Contractnummer:</td>\n";
$table .= n($_n+4) . "<td class=\"td_main\">". $vo->ContractNummerNetbeheerder . "</td>\n";
$table .= n($_n+4) . "<td class=\"td_main_spacer\"></td>\n";
$table .= n($_n+4) . "<td class=\"td_main_title\"></td>\n";
$table .= n($_n+4) . "<td class=\"td_main\"></td>\n";
$table .= n($_n+2) . "</tr>\n";
$table .= n($_n+2) . "<tr>\n";
$table .= n($_n+4) . "<td class=\"td_main_title\">EAN netbeheerder:</td>\n";
$table .= n($_n+4) . "<td class=\"td_main\">". format_EAN($vo->NetbeheerderEAN) . "</td>\n";
$table .= n($_n+4) . "<td class=\"td_spacer\"></td>\n";
$table .= n($_n+4) . "<td class=\"td_main_title\"></td>\n";
$table .= n($_n+4) . "<td class=\"td_main\"></td>\n";
$table .= n($_n+4) . "<td class=\"td_main_spacer\"></td>\n";
$table .= n($_n+4) . "<td class=\"td_main_title\"></td>\n";
$table .= n($_n+4) . "<td class=\"td_main\"></td>\n";
$table .= n($_n+2) . "</tr>\n";
$table .= n($_n+0) . "</table>\n";

/**** START HTML OUTPUT *****/

//html_header($_page, $_objectid, $_obj_ref, $_searchfield);
html_header($_page, $_objectid, $_obj_ref,$_search['opt'],"",$_search['str']);
if (isset($_messid)) echo display_message("", false, $_messid);

echo $table;
echo edit_button($_objectid, "netbeheer_edit.php", $_search);



if($_updatetime != "") html_updated($_updatetime, $_objectid);
html_footer();


?>