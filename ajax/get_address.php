<?php

require_once '../lib/base.inc.php';


$q=$_GET["q"];
$v=$_GET["v"];

if ($q == -2) {
	if ($v==1) $atype = "ObjectAdres";
	elseif ($v==2) $atype = "AansluitRegisterAdres";
	elseif ($v==3) $atype = "FactuurAdres";
	
	$table  = "<table>\n";
	if ($v != 3) $table .= "<tr><td></td></tr>\n";
	$table .= "<tr><td>T.a.v. adresregel:</td><td><input maxlength=\"50\" name=\"". $atype . "_AdresRegel1\" size=\"35\" type=\"text\" value=\"\" /></td></tr>\n";
	$table .= "<tr><td>Straatnaam:</td><td><input maxlength=\"50\" name=\"". $atype . "_StraatNaam\" size=\"35\" type=\"text\" value=\"\" /></td></tr>\n";
	$table .= "<tr><td>Huisnummer:</td><td><input maxlength=\"10\" name=\"". $atype . "_Huisnummer\" size=\"35\" type=\"text\" value=\"\" /></td></tr>\n";
	$table .= "<tr><td>Huisnr toevoeging:</td><td><input maxlength=\"20\" name=\"". $atype . "_HuisnummerToevoeging\" size=\"35\" type=\"text\" value=\"\" /></td></tr>\n";
	$table .= "<tr><td>Postcode:</td><td><input maxlength=\"7\" name=\"". $atype . "_Postcode\" size=\"35\" type=\"text\" value=\"\" /></td></tr>\n";
	$table .= "<tr><td>Plaats:</td><td><input maxlength=\"50\" name=\"". $atype . "_Plaats\" size=\"35\" type=\"text\" value=\"\" /></td></tr>\n";
	$table .= "</table>\n";
	echo $table;
	exit;
} elseif ($q == -3) {
	$table  = "<table>\n";
	$table .= "<tr><td></td></tr>\n";
	$table .= "<tr><td>Zelfde als het object adres.</td><td></td></tr>\n";
	$table .= "</table>\n";
	echo $table;
	exit;
}

// get address details
$dao_adr = new AdressenDAO();
$adr_vo = $dao_adr->findByPK($q);

if (!$adr_vo) exit;

//if ($adr_vo->AdresRegel1 != "") $adr_lines[] =  $adr_vo->AdresRegel1;
if($v==3) $adr_lines[] = $adr_vo->AdresRegel1;
else $adr_lines[] =  "" ;
$adr_lines[] = $adr_vo->StraatNaam . " " . $adr_vo->Huisnummer . " " . $adr_vo->HuisnummerToevoeging;
$adr_lines[] = $adr_vo->Postcode;
$adr_lines[] = $adr_vo->Plaats;
	
	
$table .= n($_n+14) . "<table>\n";
$table .= n($_n+16) . "<tr><td>" . $adr_lines[0] . "</td></tr>\n";
if (isset($adr_lines[1])) $table .= n($_n+16) . "<tr><td>" . $adr_lines[1] . "</td></tr>\n";
if (isset($adr_lines[2])) $table .= n($_n+16) . "<tr><td>" . $adr_lines[2] . "</td></tr>\n";
if (isset($adr_lines[3])) $table .= n($_n+16) . "<tr><td>" . $adr_lines[3] . "</td></tr>\n";
if (isset($adr_lines[4])) $table .= n($_n+16) . "<tr><td>" . $adr_lines[4] . "</td></tr>\n";

$table .= n($_n+14) . "</table>\n";
echo $table;

exit;
?>