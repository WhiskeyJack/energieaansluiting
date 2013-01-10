<?php

require_once '../lib/base.inc.php';


$q=$_GET["q"];
$v=$_GET["v"];



if (!isset($q) || !isset($v) || ($v != "lev" && $v != "net"))  exit;


 if ($v == "lev") {
 	// get leverancier details
	$dao_lev = new LeveranciersDAO();
	$lev_vo = $dao_lev->findByPK($q);
	echo format_EAN($lev_vo->LeverancierEAN);
	exit;
}
if ($v == "net") {
 	// get leverancier details
	$dao_net = new NetbeheerdersDAO();
	$net_vo = $dao_net->findByPK($q);
	echo format_EAN($net_vo->NetBeheerderEAN);
	exit;
}

exit;

	
?>