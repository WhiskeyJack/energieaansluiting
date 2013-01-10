<?php
require_once 'lib/base.inc.php';

$_page = "energie";
$_obj_ref = "";
$_searchfield = "";
$_updatetime = "";

if (isset($_GET['id'])) $_objectid = $_GET['id'];
else fatal_error("Er is geen object gespecificeerd.");

// get message id if available
if (isset($_GET['m'])) $_messid = $_GET['m'];
elseif (isset($_POST['m'])) $_messid = $_POST['m'];


$_search = get_search_fields();

$dao_obj = new ObjectenEnergieDAO();
$vo = $dao_obj->findByPK($_objectid);
if (!$vo) fatal_error("Er is een fout opgetreden bij het ophalen van de energie gegevens voor ObjectID $_objectid.");


$_obj_ref = "Object: ". format_EAN($vo->EanCode) . " (" . format_Internal_Code($vo->InterneCodering) . ") - " .$vo->ObjectNaam;
$_updatetime = $vo->GewijzigdOp;


$_n = 8;
$table =  n($_n+0) . "<table id=\"table_main\">\n";
$table .= n($_n+2) . "<tr>\n";
$table .= n($_n+4) . "<td class=\"td_main_title_wide\">Product:</td>\n";
$table .= n($_n+4) . "<td class=\"td_main_wide\">". $vo->ProductNaam . "</td>\n";
$table .= n($_n+4) . "<td class=\"td_spacer\"></td>\n";
$table .= n($_n+4) . "<td class=\"td_main_title_wide\">Meternummer:</td>\n";
$table .= n($_n+4) . "<td class=\"td_main_wide\">". $vo->MeterNummer . "</td>\n";
$table .= n($_n+4) . "<td class=\"td_main_spacer\"></td>\n";
$table .= n($_n+4) . "<td class=\"td_main_title_wide\">Groot/klein verbruik:</td>\n";
$table .= n($_n+4) . "<td class=\"td_main_wide\">". $vo->GrootKleinVerbruik . "</td>\n";
$table .= n($_n+2) . "</tr>\n";
$table .= n($_n+2) . "<tr>\n";
$table .= n($_n+4) . "<td class=\"td_main_title_wide\">Standaard jaarverbruik:</td>\n";
$table .= n($_n+4) . "<td class=\"td_main_wide\">". $vo->StandaardJaarVerbruik . "</td>\n";
$table .= n($_n+4) . "<td class=\"td_main_spacer\"></td>\n";
$table .= n($_n+4) . "<td class=\"td_main_title_wide\">Soort meter:</td>\n";
$table .= n($_n+4) . "<td class=\"td_main_wide\">". $vo->MeterSoort . "</td>\n";
$table .= n($_n+4) . "<td class=\"td_spacer\"></td>\n";
$table .= n($_n+4) . "<td class=\"td_main_title_wide\" rowspan=\"4\">Opmerkingen:</td>\n";
$table .= n($_n+4) . "<td class=\"td_main_wide\" rowspan=\"4\">" . $vo->EnergieOpmerkingen . "</td>\n";
$table .= n($_n+2) . "</tr>\n";
$table .= n($_n+2) . "<tr>\n";
$table .= n($_n+4) . "<td class=\"td_main_title_wide\">In bedrijf:</td>\n";
$table .= n($_n+4) . "<td class=\"td_main_wide\">". $vo->InBedrijf . "</td>\n";
$table .= n($_n+4) . "<td class=\"td_spacer\"></td>\n";
$table .= n($_n+4) . "<td class=\"td_main_title_wide\">Meetdienst contract:</td>\n";
$table .= n($_n+4) . "<td class=\"td_main_wide\">". $vo->MeetdienstContractNummer . "</td>\n";
$table .= n($_n+4) . "<td class=\"td_main_spacer\"></td>\n";
$table .= n($_n+2) . "</tr>\n";
$table .= n($_n+2) . "<tr>\n";
$table .= n($_n+4) . "<td class=\"td_main_title_wide\">Realisatie aansluiting:</td>\n";
$table .= n($_n+4) . "<td class=\"td_main_wide\">". format_mysql_timestamp($vo->RealisatieDatumStart, $cfg['format']['strf_time_date_full']) . "</td>\n";
$table .= n($_n+4) . "<td class=\"td_spacer\"></td>\n";
$table .= n($_n+4) . "<td class=\"td_main_title_wide\">Contract waarde:</td>\n";
$table .= n($_n+4) . "<td class=\"td_main_wide\">". $vo->ContractWaarde . " " . $vo->ProductEenheid . "</td>\n";
$table .= n($_n+4) . "<td class=\"td_main_spacer\"></td>\n";
$table .= n($_n+2) . "</tr>\n";
$table .= n($_n+2) . "<tr>\n";
$table .= n($_n+4) . "<td class=\"td_main_title_wide\">Be&euml;indigd op:</td>\n";
$table .= n($_n+4) . "<td class=\"td_main_wide\">". format_mysql_timestamp($vo->RealisatieDatumEinde, $cfg['format']['strf_time_date_full']) . "</td>\n";
$table .= n($_n+4) . "<td class=\"td_spacer\"></td>\n";
$table .= n($_n+4) . "<td class=\"td_main_title_wide\">Aansluiting type:</td>\n";
$table .= n($_n+4) . "<td class=\"td_main_wide\">". $vo->AansluitingType . "</td>\n";
$table .= n($_n+4) . "<td class=\"td_main_spacer\"></td>\n";
$table .= n($_n+2) . "</tr>\n";

$table .= n($_n+2) . "<tr class=\"tr_small_empty_line \">\n";
$table .= n($_n+4) . "<td class=\"td_border_bottom\" colspan=\"8\"></td>\n";
$table .= n($_n+2) . "</tr>\n";
$table .= n($_n+2) . "<tr class=\"tr_small_empty_line \">\n";
$table .= n($_n+4) . "<td colspan=\"8\"></td>\n";
$table .= n($_n+2) . "</tr>\n";

$table .= n($_n+2) . "<tr>\n";
$table .= n($_n+4) . "<td class=\"td_main_title_wide\">Bruto vloeroppervlak:</td>\n";
$table .= n($_n+4) . "<td class=\"td_main_wide\">". $vo->BrutoVloerOppervlak . " m<sup>2</sup></td>\n";
$table .= n($_n+4) . "<td class=\"td_spacer\"></td>\n";
$table .= n($_n+4) . "<td class=\"td_main_title_wide\">Label codering:</td>\n";
$table .= n($_n+4) . "<td class=\"td_main_wide\">". $vo->EnergieLabel . "</td>\n";
$table .= n($_n+4) . "<td class=\"td_main_spacer\"></td>\n";
$table .= n($_n+4) . "<td class=\"td_main_title_wide\">LED:</td>\n";
$table .= n($_n+4) . "<td class=\"td_main_wide\">". $vo->LED . "</td>\n";
$table .= n($_n+2) . "</tr>\n";
$table .= n($_n+2) . "<tr>\n";
$table .= n($_n+4) . "<td class=\"td_main_title_wide\">Energiescan:</td>\n";
$table .= n($_n+4) . "<td class=\"td_main_wide\">". $vo->EnergieScan . "</td>\n";
$table .= n($_n+4) . "<td class=\"td_main_spacer\"></td>\n";
$table .= n($_n+4) . "<td class=\"td_main_title_wide\">Label afmelding:</td>\n";
$table .= n($_n+4) . "<td class=\"td_main_wide\">". $vo->EnergieLabelAfmelding . "</td>\n";
$table .= n($_n+4) . "<td class=\"td_spacer\"></td>\n";
$table .= n($_n+4) . "<td class=\"td_main_title_wide\"></td>\n";
$table .= n($_n+4) . "<td class=\"td_main_wide\"></td>\n";
$table .= n($_n+2) . "</tr>\n";

$table .= n($_n+2) . "<tr class=\"tr_small_empty_line \">\n";
$table .= n($_n+4) . "<td class=\"td_border_bottom\" colspan=\"8\"></td>\n";
$table .= n($_n+2) . "</tr>\n";
$table .= n($_n+2) . "<tr class=\"tr_small_empty_line \">\n";
$table .= n($_n+4) . "<td colspan=\"8\"></td>\n";
$table .= n($_n+2) . "</tr>\n";

$table .= n($_n+2) . "<tr>\n";
$table .= n($_n+4) . "<td class=\"td_main_title_wide\">Bijzondere aansluiting:</td>\n";
$table .= n($_n+4) . "<td class=\"td_main_wide\">". $vo->BijzondereAansluiting . "</td>\n";
$table .= n($_n+4) . "<td class=\"td_spacer\"></td>\n";
$table .= n($_n+4) . "<td class=\"td_main_title_wide\">Energie belasting:</td>\n";
$table .= n($_n+4) . "<td class=\"td_main_wide\">". $vo->EnergieBelasting . "</td>\n";
$table .= n($_n+4) . "<td class=\"td_main_spacer\"></td>\n";
$table .= n($_n+4) . "<td class=\"td_main_title_wide\"></td>\n";
$table .= n($_n+4) . "<td class=\"td_main_wide\"></td>\n";
$table .= n($_n+2) . "</tr>\n";
$table .= n($_n+2) . "<tr>\n";
$table .= n($_n+4) . "<td class=\"td_main_title_wide\">Fiscale groep:</td>\n";
$table .= n($_n+4) . "<td class=\"td_main_wide\">". $vo->FiscaalGroupType . "</td>\n";
$table .= n($_n+4) . "<td class=\"td_main_spacer\"></td>\n";
$table .= n($_n+4) . "<td class=\"td_main_title_wide\"></td>\n";
$table .= n($_n+4) . "<td class=\"td_main_wide\"></td>\n";
$table .= n($_n+4) . "<td class=\"td_spacer\"></td>\n";
$table .= n($_n+4) . "<td class=\"td_main_title_wide\"></td>\n";
$table .= n($_n+4) . "<td class=\"td_main_wide\"></td>\n";
$table .= n($_n+2) . "</tr>\n";
$table .= n($_n+0) . "</table>\n";

/**** START HTML OUTPUT *****/


//html_header($_page, $_objectid, $_obj_ref, $_searchfield);
html_header($_page, $_objectid, $_obj_ref,$_search['opt'],"",$_search['str']);
if (isset($_messid)) echo display_message("", false, $_messid);

//echo "<pre>" . $vo->toString() . "</pre>\n";
echo $table;
echo edit_button($_objectid, "energie_edit.php", $_search);

if($_updatetime != "") html_updated($_updatetime, $_objectid);
html_footer();




?>