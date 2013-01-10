<?php
require_once 'lib/base.inc.php';

$_page="index";

$limit = 10;
$dao = new ObjectenBasisDAO();
$volist = $dao->findWhere("", "GewijzigdOp DESC", $limit);


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


html_header_login($_page);
echo $text;
echo $table;
html_footer();


?>