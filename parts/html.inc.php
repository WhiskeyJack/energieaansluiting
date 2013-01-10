<?php

function html_header($page, $objectid = "", $obj_ref = "", $searchopt = "", $params = "", $searchstr = ""){
	global $cfg; 
	$buf = "";
	$js = "";
	$active_tab['obj'] = "";
	$active_tab['ene'] = "";
	$active_tab['net'] = "";
	$active_tab['adr'] = "";
	$body_option = "";
	if ($objectid != "") $showtabs = true;
	else $showtabs = false;
	if ($searchopt > 2) $searchopt = 1;
	$searchoptions[1] = "               <option value=\"1\">EAN code / interne code</option>\n";
	$searchoptions[2] = "               <option value=\"2\">Omschrijving</option>\n";
	if ($searchopt != "") {
		$searchoptions[$searchopt] = str_replace("\">", "\" SELECTED>", $searchoptions[$searchopt]);
		$searchlinko = "&o=$searchopt";
	}
	if ($searchstr != "") {
		$searchlinks = "&s=$searchstr";
	}
	
	
	$obja = "<a href=\"". $cfg['object_page'] ."?id=$objectid$searchlinko$searchlinks\">";
	$objax = "</a>";
	$neta = "<a href=\"". $cfg['netbeheer_page'] ."?id=$objectid$searchlinko$searchlinks\">";
	$netax = "</a>";
	$enea = "<a href=\"". $cfg['energie_page'] ."?id=$objectid$searchlinko$searchlinks\">";
	$eneax = "</a>";
	$adra = "<a href=\"". $cfg['adres_page'] ."?id=$objectid$searchlinko$searchlinks\">";
	$adrax = "</a>";
	
	
	switch($page) {
		case "index":
			$showtabs = false;
			break;
		case "zoek":
			$showtabs = false;
			break;			
		case "object":
			$active_tab['obj'] = " class=\"active\"";
			break;
		case "net":
			$active_tab['net'] = " class=\"active\"";
			break;
		case "net_edit":
			$active_tab['net'] = " class=\"active\"";
			$js = get_js($page, $params);  
			break;
		case "config":
			$js = get_js($page, $params);  
			break;			
		case "energie":
			$active_tab['ene'] = " class=\"active\"";
			break;
		case "energie_edit":
			$active_tab['ene'] = " class=\"active\"";
			$js = get_js($page, $params);  
			break;
    case "adres":
			$active_tab['adr'] = " class=\"active\"";
			break;		
    case "adres_edit":
			$active_tab['adr'] = " class=\"active\"";
			$js = get_js($page, $params);  
			break;	
			case "object_edit":
			$js = get_js($page, $params);  
			$active_tab['obj'] = " class=\"active\"";
			break;
		case "fatal-error":
			$showtabs = false;
			break;
	}
	$buf .= "<!DOCTYPE html PUBLIC \"-//W3C//DTD XHTML 1.0 Strict//EN\" \"http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd\">\n\n";
	$buf .= "<html xmlns=\"http://www.w3.org/1999/xhtml\" lang=\"en\" xml:lang=\"en\">\n";
	$buf .= "  <head>\n";
  $buf .= "    <meta name=\"Bert Santema\" content=\"Energie Aansluiting\" />\n";
  $buf .= "    <meta http-equiv=\"content-type\" content=\"text/html;charset=utf-8\" />\n";
  $buf .= "    <link rel=\"stylesheet\" href=\"css/main.css\" type=\"text/css\" />\n";
	// http://www.cssbuttons.net/
  $buf .= "    <link rel=\"stylesheet\" href=\"css/cssbuttons.css\" type=\"text/css\" media=\"all\" />\n";
	$buf .= "    <!--[if lte IE 7]>  \n";
	$buf .= "      <style type=\"text/css\" media=\"all\"> \n"; 
	$buf .= "        @import url(\"css/ieBrowserHacks.css\");\n";
	$buf .= "      </style>\n";
	$buf .= "    <![endif]-->\n";
  
  $buf .= $js;
  $buf .= "    <title>" . $cfg['title'] . "</title>\n";
  $buf .= "  </head>\n\n";
  $buf .= "  <body$body_option>\n";
  $buf .= "    <div id=\"page\">\n\n";
  $buf .= "      <div id=\"header\">\n";
	$buf .= "        <div id=\"searchbox\">\n";
	$buf .= "          <form method=\"get\" action=\"zoek.php\">\n";
	$buf .= "            <p>Zoeken: <input type=\"text\" size=\"20\" maxlength=\"50\" name=\"searchtext\" value=\"$searchstr\"/> in \n";
	$buf .= "             <select name=\"searchfields\">\n";
	$buf .= $searchoptions[1]; 
	$buf .= $searchoptions[2];
	// $buf .= "               <option value=\"3\">Netbeheerder/leverancier</option>\n";
	// $buf .= "               <option value=\"4\">Energie gegevens</option>\n";
	// $buf .= "               <option value=\"5\">Adres gegevens</option>\n";
	$buf .= "              </select>\n";
	$buf .= "              <input type=\"submit\" value=\"\" class=\"submitButton\"></input>\n            </p>\n";
	$buf .= "          </form>\n";
	$buf .= "        </div>\n\n";
  $buf .= "        <div id=\"logo\">\n";
	$buf .= "          <h1><a href=\"" . $cfg['index_page'] . "\">" . $cfg['title'] . "</a></h1>\n";
	$buf .= "        </div>\n\n";
	$buf .= "        <ul id=\"mainmenu\">\n";
	$buf .= "          <li><a href=\"". $cfg['config_page'] ."\">Configuratie</a></li>\n";
	$buf .= "          <li><a href=\"". $cfg['logout_page'] ."\">Uitloggen</a></li>\n";
	$buf .= "        </ul>\n\n";
	$buf .= "      </div>\n\n";
	if ($obj_ref != "") $buf .= "      <div id=\"object_reference\">$obj_ref</div>\n";
	if ($showtabs) {
		$buf .= "      <div id=\"tabs\">\n";
		$buf .= "        <ul class=\"tab\">\n";
		$buf .= "          <li". $active_tab['obj'] .">$obja<span>Object gegevens</span>$objax</li>\n";
		$buf .= "          <li". $active_tab['net'] .">$neta<span>Netbeheerder/Leverancier</span>$netax</li>\n";
		$buf .= "          <li". $active_tab['ene'] .">$enea<span>Energie gegevens</span>$eneax</li>\n";
		$buf .= "          <li". $active_tab['adr'] .">$adra<span>Adres gegevens</span>$adrax</li>\n";
		$buf .= "        </ul>\n";
		$buf .= "      </div>\n\n";
	}
	$buf .= "      <div id=\"content\">\n";
	
	echo $buf;
}


function html_footer() { 
	global $cfg;
	$buf  = "      </div>\n\n";
	$buf .= "      <div id=\"footer\">\n";
	$buf .= "        <p class=\"right\">Desysion / InThere</p>\n";
	$buf .= "        <p>Energie Aansluiting</p>\n";
	$buf .= "      </div>\n\n";
	$buf .= "    </div>\n";
	$buf .= "  </body>\n";
	$buf .= "</html>\n";
	echo $buf;
}

function get_js($page="object_edit", $params) {
	switch ($page) {
		case "object_edit":		
			$js  = "    <script type=\"text/javascript\">\n";
			$js .= "      //<![CDATA[ \n\n";
			$js .= "      function showUser(div, str, next)\n";
			$js .= "      {\n";
			//$js .= "   alert(\"div \" + div +  \"-- str \" + str + \"-- next \" + next);\n";		
			$js .= "      if (str==\"\")\n";
			$js .= "        {\n";
			$js .= "        document.getElementById(div).innerHTML=\"\";\n";
			$js .= "        return;\n";
			$js .= "        }\n";
			$js .= "      if (window.XMLHttpRequest)\n";
			$js .= "        {// code for IE7+, Firefox, Chrome, Opera, Safari\n";
			$js .= "        xmlhttp=new XMLHttpRequest();\n";
			$js .= "        }\n";
			$js .= "      else\n";
			$js .= "        {// code for IE6, IE5\n";
			$js .= "        xmlhttp=new ActiveXObject(\"Microsoft.XMLHTTP\");\n";
			$js .= "        }\n";
			$js .= "      xmlhttp.onreadystatechange=function()\n";
			$js .= "        {\n";
		  $js .= "        if (xmlhttp.readyState==4 && xmlhttp.status==200)\n";
			$js .= "          {\n";
		  //$js .= "          alert(\"div: \" + div + \" response: \" + xmlhttp.responseText); \n";
			$js .= "          document.getElementById(div).innerHTML=xmlhttp.responseText;\n";
			$js .= "          }\n";
			$js .= "        }\n";
			//$js .= "        alert(\"GET\" + \" ajax/get_organization.php?q=\"+str);\n";
			$js .= "      xmlhttp.open(\"GET\",\"ajax/get_organization.php?q=\"+str,true);\n";
			$js .= "      xmlhttp.send();\n";
			$js .= "      }\n";
			$js .= "      // ]]>\n";
			$js .= "    </script>\n";
		break;
		
		case "net_edit":	
			$js  = "    <script type=\"text/javascript\">\n";
			$js .= "      //<![CDATA[ \n\n";
			$js .= "      function showDiv(div, str,typestr)\n";
			$js .= "      {\n";
			//$js .= "   alert(\"div \" + div +  \"-- str \" + str + \"-- next \" + next);\n";		
			$js .= "      if (str==\"\")\n";
			$js .= "        {\n";
			$js .= "        document.getElementById(div).innerHTML=\"\";\n";
			$js .= "        return;\n";
			$js .= "        }\n";
			$js .= "      if (window.XMLHttpRequest)\n";
			$js .= "        {// code for IE7+, Firefox, Chrome, Opera, Safari\n";
			$js .= "        xmlhttp=new XMLHttpRequest();\n";
			$js .= "        }\n";
			$js .= "      else\n";
			$js .= "        {// code for IE6, IE5\n";
			$js .= "        xmlhttp=new ActiveXObject(\"Microsoft.XMLHTTP\");\n";
			$js .= "        }\n";
			$js .= "      xmlhttp.onreadystatechange=function()\n";
			$js .= "        {\n";
		  $js .= "        if (xmlhttp.readyState==4 && xmlhttp.status==200)\n";
			$js .= "          {\n";
		  //$js .= "          alert(\"div: \" + div + \" response: \" + xmlhttp.responseText); \n";
			$js .= "          document.getElementById(div).innerHTML=xmlhttp.responseText;\n";
			$js .= "          }\n";
			$js .= "        }\n";
			//$js .= "        alert(\"ajax/get_net.php?q=\"+str+\"&v=\"+typestr);\n";
			$js .= "      xmlhttp.open(\"GET\",\"ajax/get_net.php?q=\"+str+\"&v=\"+typestr,true);\n";
			$js .= "      xmlhttp.send();\n";
			$js .= "      }\n";
			$js .= "      // ]]>\n";
			$js .= "    </script>\n";
		break;

		case "energie_edit":	
			$js  = "    <script type=\"text/javascript\">\n";
			$js .= "      //<![CDATA[ \n\n";
      $js .= "      function show_end_date_select(div, day, month, year) {\n";
      //$js .= "        var mnames = new Array('januari', 'februari', 'maart', 'april', 'mei', 'juni', 'juli', 'augustus', 'september', 'oktober', 'november', 'december');\n";
      $js .= "        var mnames = new Array('jan', 'feb', 'mrt', 'apr', 'mei', 'jun', 'jul', 'aug', 'sep', 'okt', 'nov', 'dec');\n";
      $js .= "        var now = new Date();\n";
      $js .= "        var chk = document.energie_edit.end_check;\n\n";
      $js .= "        if (chk.checked == false) {\n";
      $js .= "          document.getElementById(div).innerHTML='';\n";
      $js .= "        } else {\n";
      $js .= "          var out = \"<select id='date_day_end' name='date_day_end'>\";\n\n";
      $js .= "          for(i = 1; i < 32; i++) {\n";
      $js .= "            out = out + \"<option selected value=\" + i + \">\" + i + \"<\/option>\";\n";
      $js .= "          }\n";
      $js .= "          out = out + \"<\/select>&nbsp;\";\n\n";
      $js .= "          out = out + \"<select id='date_month_end' name='date_month_end'>\";\n";
      $js .= "          for(i = 1; i < 13; i++) {\n";
      $js .= "            out = out + \"<option selected value=\" + i + \">\" + mnames[i-1] + \"<\/option>\"; \n";
      $js .= "          }\n";
      $js .= "          out = out + \"<\/select>&nbsp;\";\n\n";
      $js .= "          out = out + \"<select name='date_year_end' id='date_year_end'>\";\n";
      $js .= "          for(i = now.getFullYear()+2; i > 1950; i--) {\n";
      $js .= "            out = out + \"<option selected value=\" + i + \">\" + i + \"<\/option>\";\n";
      $js .= "          }\n";
      $js .= "          out = out + \"<\/select>\";\n\n";
      $js .= "          document.getElementById(div).innerHTML=out;\n\n";
      $js .= "          var list = document.getElementById('date_day_end');\n";
      $js .= "          if (day == '') list.selectedIndex = now.getDate()-1;\n";
      $js .= "          else list.selectedIndex = day-1;\n";
      //$js .= "          list.selectedIndex = now.getDate()-1;\n";
      $js .= "          list = document.getElementById('date_month_end');\n";
      $js .= "          if (month == '') list.selectedIndex = now.getMonth();\n";
      $js .= "          else list.selectedIndex = month-1;\n";
      $js .= "          list = document.getElementById('date_year_end');\n";
      $js .= "          if (year == '') list.selectedIndex = 2;\n";
      $js .= "          else list.selectedIndex = now.getFullYear()+2-year;\n";
      $js .= "        }\n";
      $js .= "      }\n";
			$js .= "      // ]]>\n";
			$js .= "    </script>\n";
		break;
		
		case "adres_edit":		
			$js  = "    <script type=\"text/javascript\">\n";
			$js .= "      //<![CDATA[ \n\n";
			$js .= "      function showAddress(div, str,atype)\n";
			$js .= "      {\n";
			//$js .= "   alert(\"div \" + div +  \"-- str \" + str + \"-- next \" + next);\n";		
			$js .= "      if (str==\"\")\n";
			$js .= "        {\n";
			$js .= "        document.getElementById(div).innerHTML=\"\";\n";
			$js .= "        return;\n";
			$js .= "        }\n";
			$js .= "      if (window.XMLHttpRequest)\n";
			$js .= "        {// code for IE7+, Firefox, Chrome, Opera, Safari\n";
			$js .= "        xmlhttp=new XMLHttpRequest();\n";
			$js .= "        }\n";
			$js .= "      else\n";
			$js .= "        {// code for IE6, IE5\n";
			$js .= "        xmlhttp=new ActiveXObject(\"Microsoft.XMLHTTP\");\n";
			$js .= "        }\n";
			$js .= "      xmlhttp.onreadystatechange=function()\n";
			$js .= "        {\n";
		  $js .= "        if (xmlhttp.readyState==4 && xmlhttp.status==200)\n";
			$js .= "          {\n";
		  //$js .= "          alert(\"div: \" + div + \" response: \" + xmlhttp.responseText); \n";
			$js .= "          document.getElementById(div).innerHTML=xmlhttp.responseText;\n";
			$js .= "          }\n";
			$js .= "        }\n";
			//$js .= "        alert(\"GET\" + \" ajax/get_organization.php?q=\"+str+\"v=\"+atype);\n";
			$js .= "      xmlhttp.open(\"GET\",\"ajax/get_address.php?q=\"+str+\"&v=\"+atype,true);\n";
			$js .= "      xmlhttp.send();\n";
			$js .= "      }\n";
			$js .= "      // ]]>\n";
			$js .= "    </script>\n";
		break;

		case "config":	
			$js  = "    <script type=\"text/javascript\">\n";
			$js .= "      //<![CDATA[ \n\n";	
			$js .= $params . ";\n";
			$js .= "var maxCount = 6;\n";
			$js .= "var minCount = 1;\n";
			$js .= "function CountChecks(isBox){\n";
			$js .= "if (isBox.checked){currCount++;}\n";
			$js .= "	else {currCount--;}\n";
			$js .= "	if (currCount > maxCount) {\n";
			$js .= "		alert('Er mogen maximaal ' + maxCount + ' velden geselecteerd worden.');\n";
			$js .= "		currCount--;\n";
			$js .= "		isBox.checked = false;\n";
			$js .= "	}\n";
			$js .= "	if (currCount < minCount) {\n";
			$js .= "		alert('Er moet minimaal 1 veld geselecteerd zijn.');\n";
			$js .= "		currCount++;\n";
			$js .= "		isBox.checked = true;\n";
			$js .= "	}\n";
			$js .= "} \n";				
			$js .= "      // ]]>\n";
			$js .= "    </script>\n";
		break;
		
		
	}
	return $js;
}


function html_header_login($page, $showbox = true){
	global $cfg; 
	$buf = "";
	$js = "";
	$active_tab['obj'] = "";
	$active_tab['ene'] = "";
	$active_tab['net'] = "";
	$active_tab['adr'] = "";
	$body_option = "";
	if ($objectid != "") $showtabs = true;
	else $showtabs = false;	

	$buf .= "<!DOCTYPE html PUBLIC \"-//W3C//DTD XHTML 1.0 Strict//EN\" \"http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd\">\n\n";
	$buf .= "<html xmlns=\"http://www.w3.org/1999/xhtml\" lang=\"en\" xml:lang=\"en\">\n";
	$buf .= "  <head>\n";
  $buf .= "    <meta name=\"Bert Santema\" content=\"Energie Aansluiting\" />\n";
  $buf .= "    <meta http-equiv=\"content-type\" content=\"text/html;charset=utf-8\" />\n";
  $buf .= "    <link rel=\"stylesheet\" href=\"css/main.css\" type=\"text/css\" />\n";
  	// http://www.cssbuttons.net/
  $buf .= "    <link rel=\"stylesheet\" href=\"css/cssbuttons.css\" type=\"text/css\" media=\"all\" />\n";
	$buf .= "    <!--[if lte IE 7]>  \n";
	$buf .= "      <style type=\"text/css\" media=\"all\"> \n"; 
	$buf .= "        @import url(\"css/ieBrowserHacks.css\");\n";
	$buf .= "      </style>\n";
	$buf .= "    <![endif]-->\n";
  $buf .= $js;
  $buf .= "    <title>" . $cfg['title'] . "</title>\n";
  $buf .= "  </head>\n\n";
  $buf .= "  <body$body_option>\n";
  $buf .= "    <div id=\"page\">\n\n";
  $buf .= "      <div id=\"header\">\n";
  if ($showbox) {
		$buf .= "        <div id=\"loginbox\">\n";
		$buf .= "          <form method=\"post\" action=\"login.php\">\n";
    $buf .= "            <fieldset><input name=\"mode\" type=\"hidden\" value=\"login\" /></fieldset>\n";
		$buf .= "            <div class=\"login_name\">Login  naam: <input type=\"text\" size=\"20\" maxlength=\"50\" name=\"username\" /></div>\n";
	  $buf .= "              <div class=\"login_pass\">Wachtwoord: <input type=\"password\" size=\"20\" maxlength=\"50\" name=\"password\" /></div>\n";
	  $buf .= "                <div class=\"cssbutton loginb a\"><input type=\"submit\" value=\"Login\" ></input></div>\n";
	  $buf .= "          </form>\n";
		$buf .= "        </div>\n\n";
  }
  $buf .= "        <div id=\"logo\">\n";
	$buf .= "          <h1><a href=\"" . $cfg['index_page'] . "\">" . $cfg['title'] . "</a></h1>\n";
	$buf .= "        </div>\n\n";
	$buf .= "      </div>\n\n";
	if ($obj_ref != "") $buf .= "      <div id=\"object_reference\">$obj_ref</div>\n";
	if ($showtabs) {
		$buf .= "      <div id=\"tabs\">\n";
		$buf .= "        <ul class=\"tab\">\n";
		$buf .= "          <li". $active_tab['obj'] .">$obja<span>Object gegevens</span>$objax</li>\n";
		$buf .= "          <li". $active_tab['net'] .">$neta<span>Netbeheerder/Leverancier</span>$netax</li>\n";
		$buf .= "          <li". $active_tab['ene'] .">$enea<span>Energie gegevens</span>$eneax</li>\n";
		$buf .= "          <li". $active_tab['adr'] .">$adra<span>Adres gegevens</span>$adrax</li>\n";
		$buf .= "        </ul>\n";
		$buf .= "      </div>\n\n";
	}
	$buf .= "      <div id=\"content\">\n";
	
	echo $buf;
}



?>
