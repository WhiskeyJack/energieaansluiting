<?php

require_once 'lib/base.inc.php';

$dao = new OrganisatiesDAO();
$volist = $dao->findWhere();


html_header("net");

  
echo html_organisatieTable($volist);

html_footer();

?>

