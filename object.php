<?php
require_once 'lib/base.inc.php';

$_page = "object";
$_obj_ref = "";
$_updatetime = ""; 

if (isset($_GET['id'])) $_objectid = $_GET['id'];
elseif (isset($_POST['id'])) $_objectid = $_POST['id'];
else fatal_error("Er is geen object gespecificeerd.");

$_search = get_search_fields();

// get message id if available
if (isset($_GET['m'])) $_messid = $_GET['m'];
elseif (isset($_POST['m'])) $_messid = $_POST['m'];

check_permission($_objectid, "view");


$dao_obj = new ObjectenBasisDAO();
$vo = $dao_obj->findByPK($_objectid);
if (!$vo) fatal_error("Er is een fout opgetreden bij het ophalen van de object gegevens voor ObjectID $_objectid.");


$org = array('OpNaamVan' => "Op naam van:", 'JuridischEigenaar' => "Juridisch Eigenaar:", 'Gebruiker' => "Gebruiker:", 'BudgetHouder' => "Budgethouder:");
$dao_org = new OrganisatiesDAO();


$_obj_ref = "Object: ". format_EAN($vo->EanCode) . " (" . format_Internal_Code($vo->InterneCodering) . ") - " .$vo->ObjectNaam;
$_updatetime = $vo->GewijzigdOp;

$_n = 8;
$table =  n($_n+0) . "<table id=\"table_main\">\n";
$table .= n($_n+2) . "<tr>\n";
$table .= n($_n+4) . "<td class=\"td_main_title\">EAN code:</td>\n";
$table .= n($_n+4) . "<td class=\"td_main\">". format_EAN($vo->EanCode) . "</td>\n";
$table .= n($_n+4) . "<td class=\"td_spacer\"></td>\n";
$table .= n($_n+4) . "<td rowspan=\"3\" class=\"td_main_title\">Omschrijving:</td>\n";
$table .= n($_n+4) . "<td rowspan=\"3\" class=\"td_main\">". $vo->ObjectNaam . "</td>\n";
$table .= n($_n+4) . "<td class=\"td_main_spacer\"></td>\n";
$table .= n($_n+4) . "<td class=\"td_main_title\">Doel:</td>\n";
$table .= n($_n+4) . "<td class=\"td_main\">". $vo->DoelOmschrijving . "</td>\n";
$table .= n($_n+2) . "</tr>\n";
$table .= n($_n+2) . "<tr>\n";
$table .= n($_n+4) . "<td class=\"td_main_title\">Interne code:</td>\n";
$table .= n($_n+4) . "<td class=\"td_main\">". format_Internal_Code($vo->InterneCodering) . "</td>\n";
$table .= n($_n+4) . "<td class=\"td_main_spacer\"></td>\n";
// $table .= n($_n+4) . "<!-- <td> row 2, column 4 </td> -->\n";
// $table .= n($_n+4) . "<!-- <td> row 2, column 5 </td> -->\n";
$table .= n($_n+4) . "<td class=\"td_spacer\"></td>\n";
$table .= n($_n+4) . "<td class=\"td_main_title\">Bouwjaar:</td>\n";
$table .= n($_n+4) . "<td class=\"td_main\">". $vo->Bouwjaar . "</td>\n";
$table .= n($_n+2) . "</tr>\n";
$table .= n($_n+2) . "<tr>\n";
$table .= n($_n+4) . "<td class=\"td_main_title\">Eigenaar:</td>\n";
$table .= n($_n+4) . "<td class=\"td_main\">". $vo->Eigenaar . "</td>\n";
$table .= n($_n+4) . "<td class=\"td_main_spacer\"></td>\n";
// $table .= n($_n+4) . "<!-- <td> row 2, column 4 </td> -->\n";
// $table .= n($_n+4) . "<!-- <td> row 2, column 5 </td> -->\n";
$table .= n($_n+4) . "<td class=\"td_spacer\"></td>\n";
$table .= n($_n+4) . "<td class=\"td_main_title\"></td>\n";
$table .= n($_n+4) . "<td class=\"td_main\"></td>\n";
$table .= n($_n+2) . "</tr>\n";
$table .= n($_n+2) . "<tr class=\"tr_main_empty_line \">\n";
$table .= n($_n+4) . "<td></td>\n";
$table .= n($_n+2) . "</tr>\n";

// organization part
$table .= n($_n+2) . "<tr>\n";

$count = 0;
		$table .= n($_n+4) . "<td class=\"td_main_colspan8\" colspan=\"8\">\n";
		$table .= n($_n+6) . "<table class=\"table_organizations\">\n";
$table .= n($_n+8) . "<tr>\n"; 		// row with 2 organizations
foreach($org as $key=>$value) {
	  if ( ($count & 1) == 0) {  // print next title row
	  	$i = 0;
	  	foreach($org as $key2=>$value2) {	  		
	  		if ($i < $count+2) {
	  			if($i >= $count) {  		
			  		$table .= n($_n+10) . "<td class=\"td_org_title\">" . $value2  . "</td>\n";
						if ( ($i & 1) == 0 )   // if even number
							$table .= n($_n+10) . "<td class=\"td_org_spacer\"></td>\n";
						elseif($i != $count) {
							$table .= n($_n+8) . "</tr>\n";
							$table .= n($_n+8) . "<tr>\n";
							break;
						}
	  			}
					$i++;
	  		}
			}
	 }

	$count += 1;
	if (!$vo->$key) {	

			$table .= n($_n+10) . "<td>\n";		// first org
			$table .= n($_n+12) . "<div id=\"$key\">\n";
			//$_n = 8;
			$_n = 22;
			$table .= n($_n+0) . "<table class=\"table_org_details\">\n";
			$table .= n($_n+2) . "<tr>\n";
			$table .= n($_n+4) . "<td class=\"td_org_subtitle\">Onbekend.</td>\n";
			$table .= n($_n+4) . "<td class=\"td_org\"></td>\n";
			$table .= n($_n+2) . "</tr>\n";
			$table .= n($_n+2) . "<tr>\n";
			$table .= n($_n+4) . "<td class=\"td_org_subtitle\"></td>\n";
			$table .= n($_n+4) . "<td class=\"td_org\"></td>\n";
			$table .= n($_n+2) . "</tr>\n";
			$table .= n($_n+2) . "<tr>\n";
			$table .= n($_n+4) . "<td class=\"td_org_subtitle\"></td>\n";
			$table .= n($_n+4) . "<td class=\"td_org\"></td>\n";
			$table .= n($_n+2) . "</tr>\n";
			$table .= n($_n+0) . "</table>\n";
			$_n = 8;			
			$table .= n($_n+12) . "</div>\n";
			$table .= n($_n+10) . "</td>\n";	
	
			if ( ($count & 1) == 0) {
			$table .= n($_n+8) . "</tr>\n";
			if ( $count < sizeof($org)) {
				$table .= n($_n+8) . "<tr class=\"tr_main_empty_line \"><td></td></tr>\n";
				$table .= n($_n+8) . "<tr>\n";
			}
			} else {
				$table .= n($_n+10) . "<td></td>\n";
				if ( $count == sizeof($org)) {
					$table .= n($_n+10) . "<td></td>\n";
					$table .= n($_n+8) . "</tr>\n";
				}
			}
			
	} else { 

		$vo_array[$vo->$key] = $dao_org->findByPK($vo->$key);
			
			$table .= n($_n+10) . "<td>\n";		// first org
			$table .= n($_n+12) . "<div id=\"$key\">\n";
			//$_n = 8;
			$_n = 22;
			$table .= n($_n+0) . "<table class=\"table_org_details\">\n";
			$table .= n($_n+2) . "<tr>\n";
			$table .= n($_n+4) . "<td class=\"td_org_subtitle\">Naam:</td>\n";
			$table .= n($_n+4) . "<td class=\"td_org\">" . $vo_array[$vo->$key]->OrganisatieNaam . "</td>\n";
			$table .= n($_n+2) . "</tr>\n";
			$table .= n($_n+2) . "<tr>\n";
			$table .= n($_n+4) . "<td class=\"td_org_subtitle\">Contactpersoon:</td>\n";
			$table .= n($_n+4) . "<td class=\"td_org\">" . $vo_array[$vo->$key]->ContactPersoon . "</td>\n";
			$table .= n($_n+2) . "</tr>\n";
			$table .= n($_n+2) . "<tr>\n";
			$table .= n($_n+4) . "<td class=\"td_org_subtitle\">Telefoon:</td>\n";
			$table .= n($_n+4) . "<td class=\"td_org\">" . $vo_array[$vo->$key]->Telefoon . "</td>\n";
			$table .= n($_n+2) . "</tr>\n";
			$table .= n($_n+0) . "</table>\n";
			$_n = 8;			
			$table .= n($_n+12) . "</div>\n";
			$table .= n($_n+10) . "</td>\n";	

			if ( ($count & 1) == 0) {
	//	if ($count == 2) {
			$table .= n($_n+8) . "</tr>\n";
			if ( $count < sizeof($org)) {
				$table .= n($_n+8) . "<tr class=\"tr_main_empty_line \"><td></td></tr>\n";
				$table .= n($_n+8) . "<tr>\n";
			}
		} else {
			$table .= n($_n+10) . "<td></td>\n";
			if ( $count == sizeof($org)) {
				$table .= n($_n+10) . "<td></td>\n";
				$table .= n($_n+8) . "</tr>\n";
			}
		}
	}
}


$table .= n($_n+6) . "</table>\n";
$table .= n($_n+4) . "</td>\n";
$table .= n($_n+2) . "</tr>\n";
$table .= n($_n+0) . "</table>\n";



/**** START HTML OUTPUT *****/


html_header($_page, $_objectid, $_obj_ref,$_search['opt'],"",$_search['str']);

if (isset($_messid)) echo display_message("", false, $_messid);
	

echo $table;
echo edit_button($_objectid, "object_edit.php", $_search);

if($_updatetime != "") html_updated($_updatetime, $_objectid);
html_footer();


?>