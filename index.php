<?php
require_once 'lib/base.inc.php';

$_page="index";

if (!$user) $userid = 1;
else $userid = $user->data['user_id'];

$limit = 10;
$dao = new ObjectenBasisDAO();

// findWherePlus also fetches organization names
$volist = $dao->findWherePlus("", "GewijzigdOp DESC", $limit);
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
  $dbfields = array("ObjectID","EanCode","ObjectNaam","InterneCodering","OpNaamVanNaam","Eigenaar","JuridischEigenaarNaam","GebruikerNaam","BudgetHouderNaam","DoelOmschrijving","Bouwjaar","GewijzigdOp");

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
		$rowclass == "odd" ? $rowclass = "even" : $rowclass = "odd";
		$link = "<a href=\"object.php?id=" . $vo->ObjectID . "\">"; 
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

if ($vocount < $limit) $nr = $vocount;
else $nr = $limit;	
$text  = "        <p>Welkom op Energie Aansluiting.</p>\n";
if ($vocount == 0) {
  $table = "";
  $text .= "        <p>Er zijn geen objecten gevonden.</p>\n";
} else {
  $text .= "        <p>Dit zijn de $nr meest recent gewijzigde objecten:</p>\n";
}

/**** START HTML OUTPUT *****/


html_header($_page);
echo $text;
echo $table;
html_footer();


?>