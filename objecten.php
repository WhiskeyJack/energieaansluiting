<?php

require_once 'lib/base.inc.php';

$dao = new ObjectenDAO();
$volist = $dao->findWhere();


html_header();
html_menu();
  
echo html_objectenTable($volist);

html_footer();

?>

