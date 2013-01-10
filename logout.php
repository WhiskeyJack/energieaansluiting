<?php

require_once 'lib/base.inc.php';

$_page = "energie";
$_obj_ref = "";
$_searchfield = "";
$_objectid = "";

$user->logout();
// dump($user->report(), "uFlex report"); 
$txt = "       <p>U bent uitgelogd.</p>\n";

/**** START HTML OUTPUT *****/



html_header_login($_page,false);
echo $txt;
//html_updated($updatetime);
html_footer();





?>