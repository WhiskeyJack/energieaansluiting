<?php
/* TODO: paginate search results if >10 hits */
/* TODO: check if only digits are submitted for search on eanCode */
 
require_once 'lib/base.inc.php';
$_page = "zoek";
if (!$user) $userid = 1;
else $userid = $user->data['user_id'];
$debug = false;

/*if ($debug) $_searchtext = 1;	// for xhtml validator
else {
	// Get search text & fields
	if (!isset($_POST['searchfields'])) {
		// we did not get here via the search form
		fatal_error("Geen zoekcriteria gevonden.");
	} else {
		$_searchtext   = secure_string($_POST['searchtext']);
		$_searchfields = secure_string($_POST['searchfields']);
	} 
}
*/
if ($debug) $_searchtext = 1;	// for xhtml validator
else {
	// Get search text & fields
	if (isset($_POST['searchfields'])) {
		$_searchtext   = secure_string($_POST['searchtext']);
		$_searchfields = secure_string($_POST['searchfields']);
	} elseif (isset($_GET['searchfields'])){
		$_searchtext   = secure_string($_GET['searchtext']);
		$_searchfields = secure_string($_GET['searchfields']);
	} else {
		fatal_error("Geen zoekcriteria gevonden.");
	}
}


if ($_searchfields == "") $_searchfields = 1;
if ($_searchtext == "" ) $limit = 10;
else $limit = 100;

// check if only letters have been submitted, if so force name search
if(preg_match("/[A-Za-z\+\(\)\/]/", $_searchtext)){
	$_searchfields = 2; 
}

$dao = new ObjectenBasisDAO();
if ($_searchfields == 1) {
	// check if only numbers entered
	// if (preg_match("/[A-Za-z]/", $_searchtext)) fatal_error("Geen letters mogelijk in de EAN of interne code.")
	if (preg_match("/ /", $_searchtext)) $_searchtextz = str_replace(" ","",$_searchtext);
	else $_searchtextz = $_searchtext; 
	$volist = $dao->findWherePlus("EANCode LIKE '%$_searchtextz%' OR InterneCodering LIKE '%$_searchtextz%'", "GewijzigdOp DESC", $limit);
} elseif ($_searchfields == 2)  
	$volist = $dao->findWherePlus("ObjectNaam LIKE '%$_searchtext%' OR doelen.Omschrijving LIKE '%$_searchtext%'", "GewijzigdOp DESC", $limit);
else
	fatal_error("Er waren geen correcte zoekcriteria gespecificeerd.");

///////////////////

	// findWherePlus also fetches organization names
//$volist = $dao->findWherePlus("", "GewijzigdOp DESC", $limit);
//new dBug($volist);
// Fetch user selected fields
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

  $cols = array ("Object ID","EAN Code","Omschrijving","Interne codering","Op naam van","Eigenaar","Juridisch eigenaar","Gebruiker","Budgethouder","Doel","Bouwjaar","Gewijzigd Op");
  $dbfields = array("ObjectID","EanCode","ObjectNaam","InterneCodering","OpNaamVanNaam","Eigenaar","JuridischEigenaarNaam","GebruikerNaam","BudgethouderNaam","DoelOmschrijving","Bouwjaar","GewijzigdOp");

  $_n = 8;
$rowclass = "even";
//	$rowclass == "odd" ? $rowclass = "even" : $rowclass = "odd";

$table =  n($_n+0) . "<table id=\"table_searchresults\">\n";
$table .= n($_n+2) . "<thead>\n";
$table .= n($_n+4) . "<tr>\n";
foreach ($field_array as $key=>$value) {
	$table .= n($_n+6) . "<th>" . $cols[$value] . "</th>\n";
}
//new dBug($user);


// $table .= n($_n+6) . "<th>EAN code</th>\n";
// $table .= n($_n+6) . "<th>Interne code</th>\n";
// $table .= n($_n+6) . "<th>Naam</th>\n";
// $table .= n($_n+6) . "<th>Doel</th>\n";


$table .= n($_n+4) . "</tr>\n";
$table .= n($_n+2) . "</thead>\n";
$table .= n($_n+2) . "<tbody>\n";
$vocount = 0;
if ($volist) {
	foreach($volist as $vo) {
		$vocount +=1;
		if (!empty($_searchtext)) $searchlink = "&s=" . urlencode($_searchtext);
		if (!empty($_searchfields)) $searchfields = "&o=" . $_searchfields;
		$rowclass == "odd" ? $rowclass = "even" : $rowclass = "odd";
		$link = "<a href=\"object.php?id=" . $vo->ObjectID . $searchlink . $searchfields . "\">"; 
		$table .= n($_n+4) . "<tr class=\"$rowclass\">\n";
		
		foreach ($field_array as $key=>$value) {
			if ($value==1) $itemv = format_EAN(($vo->$dbfields[$value]));
			elseif ($value==4) $itemv = format_Internal_Code(($vo->$dbfields[$value]));
			elseif ($value==11) $itemv = format_mysql_timestamp($vo->$dbfields[$value],$cfg['format']['strf_time_list']);
			
			else $itemv = $vo->$dbfields[$value];
			$table .= n($_n+6) . "<td>$link". $itemv . "</a></td>\n";
		}
		
		/*
		$table .= n($_n+6) . "<td>$link". format_EAN($vo->EanCode) . "</a></td>\n";
		$table .= n($_n+6) . "<td class=\"td_internalcode\">$link". format_Internal_Code($vo->InterneCodering) . "</a></td>\n";
		$table .= n($_n+6) . "<td class=\"td_objectname\">$link". $vo->ObjectNaam . "</a></td>\n";
		$table .= n($_n+6) . "<td>$link". $vo->DoelOmschrijving . "</a></td>\n";
		*/
		$table .= n($_n+4) . "</tr>\n";
	}
}
$table .= n($_n+2) . "</tbody>\n";
$table .= n($_n+0) . "</table>\n";
	
	
	
	/*
$_n = 8;
$rowclass = "even";
//	$rowclass == "odd" ? $rowclass = "even" : $rowclass = "odd";

$table =  n($_n+0) . "<table id=\"table_searchresults\">\n";
$table .= n($_n+2) . "<thead>\n";
$table .= n($_n+4) . "<tr>\n";
$table .= n($_n+6) . "<th>EAN code</th>\n";
$table .= n($_n+6) . "<th>Interne code</th>\n";
$table .= n($_n+6) . "<th>Naam</th>\n";
$table .= n($_n+6) . "<th>Doel</th>\n";
$table .= n($_n+4) . "</tr>\n";
$table .= n($_n+2) . "</thead>\n";
$table .= n($_n+2) . "<tbody>\n";
$vocount = 0;
if ($volist) {
	foreach($volist as $vo) {
		$vocount +=1;
		$rowclass == "odd" ? $rowclass = "even" : $rowclass = "odd";
		$link = "<a href=\"object.php?id=" . $vo->ObjectID . "\">"; 
		$table .= n($_n+4) . "<tr class=\"$rowclass\">\n";
		$table .= n($_n+6) . "<td>$link". format_EAN($vo->EanCode) . "</a></td>\n";
		$table .= n($_n+6) . "<td class=\"td_internalcode\">$link". format_Internal_Code($vo->InterneCodering) . "</a></td>\n";
		$table .= n($_n+6) . "<td class=\"td_objectname\">$link". $vo->ObjectNaam . "</a></td>\n";
		$table .= n($_n+6) . "<td>$link". $vo->DoelOmschrijving . "</a></td>\n";
		$table .= n($_n+4) . "</tr>\n";
	}
}
$table .= n($_n+2) . "</tbody>\n";
$table .= n($_n+0) . "</table>\n"; 
*/

if ($vocount == 0) {
	// no results found
	$table = "";
	$text = "        <p>Er zijn geen resultaten gevonden voor de zoekterm \"" . $_searchtext . "\".</p>\n";
}
elseif ($_searchtext == "" ) {
	if ($vocount < $limit) $nr = $vocount;
	else $nr = $limit;	
	$text = "        <p>Er was geen zoekterm opgegeven, maar dit zijn de $nr meest recent gewijzigde objecten:</p>\n";
} else {	
	// check if 1 or more results 
	$vocount > 1 ? $rstr = "zijn $vocount resultaten" : $rstr = "is $vocount resultaat";
	$text = "        <p>Er $rstr gevonden voor de zoekterm \" ". $_searchtext . " \":</p>\n";
}


/**** START HTML OUTPUT *****/


html_header($_page,"","",$_searchfields,"",$_searchtext);
echo $text;
echo $table;
html_footer();


?>