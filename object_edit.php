<?php
require_once 'lib/base.inc.php';

$_page = "object_edit";
$_obj_ref = "";
$_updatetime = ""; 
$_errors = array();

if (isset($_GET['id'])) $_objectid = secure_string($_GET['id']);
elseif (isset($_POST['id'])) $_objectid = secure_string($_POST['id']);
else fatal_error("Er is geen object gespecificeerd.");

$_search = get_search_fields();

// Check permissions
check_permission($_objectid, "view");

// Get object basic details
$dao_obj = new ObjectenBasisDAO();


/**** Validation of form *****/
if ($_POST['mode'] == 'validate') {
	//new dBug($_POST);
	
	secure_post_data();
	
	// $vo_post = new ObjectenBasisVO();
	// $vo_post->readForm();
	// $errors = $vo_post->validate_fields();

	$vo = new ObjectenBasisVO();
	$vo->readForm();
	$errors = $vo->validate_fields();
		
		
	if (sizeof($errors) == 0) {
		if ($dao_obj->updateVO($vo) == 1) $m = 1;
		else $m = 2;
		$host  = $_SERVER['HTTP_HOST'];
		//$host  = '192.168.1.4';
    $uri   = rtrim(dirname($_SERVER['PHP_SELF']), '/\\');
    $extra = $cfg['object_page'];
    //echo "Location: http://$host$uri/$extra?id=$_objectid&m=$m";
    if ($_search) $searchlink = "&s=" . urlencode($_search['str']) . "&o=" . $_search['opt'];
    header("Location: http://$host$uri/$extra?id=$_objectid&m=$m$searchlink");
    exit;
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
//new dBug($errors);
//new dBug($vo_post);
//new dBug($vo);
//new dBug($_POST);

// Organization fields in object basic details  
$org = array('OpNaamVan' => "Op naam van:", 'JuridischEigenaar' => "Juridisch Eigenaar:", 'Gebruiker' => "Gebruiker:", 'BudgetHouder' => "Budgethouder:");

// Get list of organizations
$dao_org = new OrganisatiesDAO();
$org_volist = $dao_org->findWhere("","OrganisatieNaam ASC");

// Get doelen list
$doelen_dao = new DoelenDAO();
$doelen_volist = $doelen_dao->findWhere("", "Omschrijving ASC");





// Create main table
	$_n = 8;
	$table = n($_n+0) . "<form method=\"post\" action=\"" . $_SERVER['PHP_SELF'] . "\">\n";
	$_n = 10;
	$table .=  n($_n+0) . "<table id=\"table_main\">\n";
	$table .= n($_n+2) . "<tr>\n";
	
	$classname = red("td_main_title", "EanCode", $errors);
	$table .= n($_n+4) . "<td class=\"$classname\">EAN code:</td>\n";
	$table .= n($_n+4) . "<td class=\"td_main\">" . html_finput_text("EanCode", format_EAN($vo->EanCode), 25, 25) . "</td>\n";
	$table .= n($_n+4) . "<td class=\"td_spacer\"></td>\n";
	
	$classname = red("td_main_title", "ObjectNaam", $errors);
	$table .= n($_n+4) . "<td rowspan=\"3\" class=\"$classname\">Omschrijving:</td>\n";
	$table .= n($_n+4) . "<td rowspan=\"3\" class=\"td_main\">" . html_finput_textarea("ObjectNaam", $vo->ObjectNaam, 22, 3) . "</td>\n";
	$table .= n($_n+4) . "<td class=\"td_main_spacer\"></td>\n";
	
	$classname = red("td_main_title", "DoelID", $errors);
	$table .= n($_n+4) . "<td class=\"$classname\">Doel:</td>\n";
	$table .= n($_n+4) . "<td class=\"td_main\">" . html_select_list_vo("DoelID", $doelen_volist, "DoelID", "Omschrijving", $vo->DoelID, $_n+6) . n($_n+4) ."</td>\n";
	$table .= n($_n+2) . "</tr>\n";
	$table .= n($_n+2) . "<tr>\n";
	
	$classname = red("td_main_title", "InterneCodering", $errors);
	$table .= n($_n+4) . "<td class=\"$classname\">Interne code:</td>\n";
	$table .= n($_n+4) . "<td class=\"td_main\">" . html_finput_text("InterneCodering", format_Internal_Code($vo->InterneCodering), 25, 25) . "</td>\n";
	$table .= n($_n+4) . "<td class=\"td_main_spacer\"></td>\n";
	// $table .= n($_n+4) . "<!-- <td> row 2, column 4 </td> -->\n";
	// $table .= n($_n+4) . "<!-- <td> row 2, column 5 </td> -->\n";
	$table .= n($_n+4) . "<td class=\"td_spacer\"></td>\n";
	
	$classname = red("td_main_title", "Bouwjaar", $errors);
	$table .= n($_n+4) . "<td class=\"$classname\">Bouwjaar:</td>\n";
	$table .= n($_n+4) . "<td class=\"td_main\">" . html_finput_text("Bouwjaar", format_EAN($vo->Bouwjaar), 9, 8) . "</td>\n";
	$table .= n($_n+2) . "</tr>\n";
	$table .= n($_n+2) . "<tr>\n";
	
	$classname = red("td_main_title", "Eigenaar", $errors);
	$table .= n($_n+4) . "<td class=\"$classname\">Eigenaar:</td>\n";
	$table .= n($_n+4) . "<td class=\"td_main\">" . html_select_values("Eigenaar", $cfg['values']['eigenaar'], $vo->Eigenaar,  $_n+6) . n($_n+4) ."</td>\n";
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

// organization part in main table
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
	  				$onchange = "onchange=\"showUser('div_" . $key2 . "', this.value)\"";
			  		$table .= n($_n+10) . "<td class=\"td_org_title\">" . $value2 . "&nbsp;&nbsp;" . html_select_list_vo_ajax($key2, $org_volist, "OrganisatieID", "OrganisatieNaam", $onchange, $vo->$key2, 22);
			  		$table .= n($_n+10) . "</td>\n";
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
		$table .= n($_n+12) . "<div id=\"div_$key\">\n";
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
			$table .= n($_n+12) . "<div id=\"div_$key\">\n";
			//$_n = 8;
			$_n = 24;
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
$_n = 8;
//$table .= n($_n+0) . "</form>\n";




/**** START HTML OUTPUT *****/

//html_header($_page, $_objectid, $_obj_ref,$_search['opt'],$params,$_search['str']);
//html_header($_page, $_objectid, $_obj_ref, "", $params);
html_header($_page, $_objectid, $_obj_ref,$_search['opt'],$params,$_search['str']);

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
