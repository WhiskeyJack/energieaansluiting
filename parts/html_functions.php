<?php

function html_updated($updatetime, $id="" ) {
	$time = format_mysql_timestamp($updatetime);	
	$buf = "\n        <div id=\"update-timestamp\">\n";
	$buf .= "          Laatst gewijzigd op $time\n";
	if (!empty($id))	$buf .= "          <a href=\"print.php?id=$id\" target=\"_blank\"><img border=\"0\" class=\"print_image\" src=\"images/print_small.png\"></a>\n";
	$buf .= "        </div>\n\n";
	echo $buf;
}


function html_finput_text($name,$value,$size=0,$maxlength=0) {
  // returns an input type=text form element
	global $cfg;
  if ($size == 0) $size = $cfg['form']['text_input']['size'];
  if ($maxlength == 0) $maxlength = $cfg['form']['text_input']['max_length'];
  return "<input maxlength=\"$maxlength\" name=\"$name\" size=\"$size\" type=\"text\" value=\"$value\" />";
}

function html_finput_textarea($name,$value,$cols=0,$rows=0) {
  // returns an input type=text form element
	global $cfg;
  if ($cols == 0) $cols = $cfg['form']['text_area']['cols'];
  if ($rows == 0) $rows = $cfg['form']['text_area']['rows'];
  return "<textarea name=\"$name\" cols=\"$cols\" rows=\"$rows\">$value</textarea>";
}

function html_select_list_vo($name, $volist, $val_key, $desc_key, $selected = false, $_n=0, $type=false) {
  // creates a dropdown list for a VO list with val_key as value and desc_key as description
  $buf = "\n". n($_n) . "<select name=\"$name\">\n";

  foreach($volist as $vo) {
  	$desc = '';
    if ( $vo->$val_key == $selected) $selectstr = " selected=\"selected\"";
    else $selectstr = "";
	  if ($type == 'address') {
	  	$desc = $vo->Plaats . ", " . $vo->StraatNaam . " " . $vo->Huisnummer . $vo->HuisnummerToevoeging;
	  } elseif (is_array($desc_key)) {
	  	foreach ($desc_key as $key =>$vkey) {
	  		$desc .= $vo->$vkey . ", ";
	  	}
	  	$desc = substr($desc,0,-2);
	  } else $desc = $vo->$desc_key;
	  if (strlen($desc)>40) $desc = substr($desc,0, 40) . "..."; 
    $buf .= n($_n+2) . "<option value=\"". $vo->$val_key . "\"$selectstr>" . $desc . "</option>\n";
  }
  $buf .= n($_n) . "</select>\n";
  return $buf;
}

function html_select_list_vo_ajax($name, $volist, $val_key, $desc_key, $onchange, $selected = false, $_n=0, $type=false, $new=false, $extraopts = false) {
  // creates a dropdown list for a VO list with val_key as value and desc_key as description
  $buf = "\n". n($_n) . "<select name=\"$name\" $onchange>\n";
  if ($new == true) {
  	$xx = true;
  	if ( $selected == -2) $selectstr = " selected=\"selected\"";
    else $selectstr = "";
  	$buf .= n($_n+2) . "<option value=\"-2\"$selectstr>Nieuw adres toevoegen</option>\n";
  }
  if (is_array($extraopts)) {
  	$xx = true;
  	foreach ($extraopts as $keyy => $vall) {
  		if ( $selected == $keyy) $selectstr = " selected=\"selected\"";
    	else $selectstr = "";
  		$buf .= n($_n+2) . "<option value=\"$keyy\"$selectstr>$vall</option>\n";
  	}
  }
  if ($xx) $buf .= n($_n+2) . "<option value=\"-1\">&nbsp;-- </option>\n";
  foreach($volist as $vo) {
    if ( $vo->$val_key == $selected) $selectstr = " selected=\"selected\"";
    else $selectstr = "";
	  if ($type == 'address') {
	  	$desc = $vo->Plaats . ", " . $vo->StraatNaam . " " . $vo->Huisnummer . $vo->HuisnummerToevoeging;
	  } elseif (is_array($desc_key)) {
	  	foreach ($desc_key as $key =>$vkey) {
	  		$desc .= $vo->$vkey . ", ";
	  	}
	  	$desc = substr($desc,0,-2);
	  } else $desc = $vo->$desc_key;
	  if (strlen($desc)>40) $desc = substr($desc,0, 40) . "..."; 
    $buf .= n($_n+2) . "<option value=\"". $vo->$val_key . "\"$selectstr>" . $desc . "</option>\n";
 
  }
  $buf .= n($_n) . "</select>\n";
  return $buf;
}

function html_select_values($name, $array, $selected=9999, $_n=0) {
  // creates a dropdown list for an array  with val_key as value and desc_key as description
  $buf = "\n". n($_n) . "<select name=\"$name\">\n";
  foreach($array as $key => $value) {
  $selectstr = "";
    if ( ($key == $selected && is_int($selected) ) || $value == $selected) $selectstr = " selected=\"selected\"";
    
    $buf .= n($_n+2) . "<option value=\"$key\"$selectstr>$value</option>\n";
  }
  $buf .= n($_n) . "</select>\n";
  return $buf;
}

function display_message($message="", $array=false, $mesid=0){
	if ($mesid > 0) $message = get_message($mesid);
	else {
		$message['txt'] = $message;
	}
	$html .= "        <div id=\"div_message\">\n";
	$html .= "          <p class=\"p_message". $message['color'] . "\">" . $message['txt'] . "</p>\n";
	if (is_array($array)) {
		$html .= "          <ul class=\"ul_message\">\n";
		foreach($array as $key => $value) {
     $html .= n(8) . "    <li>$value</li>\n" ;  
    }
		$html .= "          </ul>\n";
	}
	$html .= "        </div>\n\n";
	return $html;
}
	
function get_message($id){
	switch ($id) {
		case "1":
			$message['txt'] = "Object detail wijziging succesvol.";
			$message['color'] = "_green";
			break;
		case "2":
			$message['txt'] = "Object detail kon niet gewijzigd worden.";
			$message['color'] = "_red";
			break;
		case "3":
			$message['txt'] = "Gebruiker toegevoegd.";
			$message['color'] = "_green";
			break;			
	}
	return $message;
}

function edit_button($id, $target=false, $_search = false) {
	// form tag specifies target, this only returns the submit button and closes the form

	if ($_search) {
		$htmls = "              <input type=\"hidden\" name=\"o\" value=\"" . $_search['opt'] . "\" />\n";
		$htmls .= "              <input type=\"hidden\" name=\"s\" value=\"" . $_search['str'] . "\" />\n";
	}
	if ($target ) {
		$html  = "\n        <div id=\"edit_button\">\n";
		$html .= "          <div class=\"cssbutton editb b\">\n";
		$html .= "          <form method=\"post\" action=\"$target\">\n";
		$html .= "            <fieldset><input type=\"hidden\" name=\"id\" value=\"$id\" />\n";
		$html .= $htmls;
		$html .= "            <input type=\"submit\" value=\"Wijzigen\" ></input></fieldset>\n";
		$html .= "          </form>\n";
		$html .= "          </div>\n";
		$html .= "        </div>\n";
	} else {
		$html = "\n        <div id=\"edit_button\">\n";
		$html .= "          <div class=\"cssbutton editb b\">\n";
		$html .= "            <fieldset>\n";
		$html .= "              <input type=\"hidden\" name=\"id\" value=\"$id\" />\n";
		$html .= "              <input type=\"hidden\" name=\"ObjectID\" value=\"$id\" />\n";
		$html .= "              <input type=\"hidden\" name=\"mode\" value=\"validate\" />\n";
		$html .= $htmls;
		$html .= "              <input type=\"submit\" value=\"Opslaan\"></input>\n";
		$html .= "            </fieldset>\n";
		$html .= "          </div>\n";
		$html .= "        </div>\n\n";
		$html .= "        </form>\n";
	}
	return $html;
}

function date_dropdown($day_s=99,$month_s=99, $year_s=99, $_n=12, $ext='') {
	if ($day_s == 99) $day_s = date("j");
	if ($month_s == 99) $month_s = date("n");
	if ($year_s == 99) $year_s = date("Y");
	//$months = array (1 => 'januari', 'februari', 'maart', 'april', 'mei', 'juni', 'juli', 'augustus', 'september', 'oktober', 'november', 'december');
	$months = array (1 => 'jan', 'feb', 'mrt', 'apr', 'mei', 'jun', 'jul', 'aug', 'sept', 'okt', 'nov', 'dec');
	//$weekday = array('Sunday','Monday','Tuesday','Wednesday','Thursday','Friday','Saturday');
	$days = range (1, 31);
	$years = range ( date("Y")+1, 1950);
 	
	$buf  = n($_n) . "<select name=\"date_day$ext\">\n";
	foreach ($days as $value) {
		if ($value == $day_s) $selectstr = " selected=\"selected\"";
		else  $selectstr = "";
		$buf .= n($_n+2) . "<option value=\"".$value."\"$selectstr>".$value."</option>\n";	
	} 
	$buf .= n($_n) ."</select>\n";
	
	$buf .= n($_n) . "<select name=\"date_month$ext\">\n";
	foreach ($months as $key=>$value) {
		if ($key == $month_s) $selectstr = " selected=\"selected\"";
		else  $selectstr = "";
		$buf .= n($_n+2) . "<option value=\"".$key."\"$selectstr>".$value."</option>\n";	
	} 
	$buf .= n($_n) . "</select>\n";

	$buf  .= n($_n) . "<select name=\"date_year$ext\">\n";
	foreach ($years as $value) {
		if ($value == $year_s) $selectstr = " selected=\"selected\"";
		else  $selectstr = "";
		$buf .= n($_n+2) . "<option value=\"".$value."\"$selectstr>".$value."</option>\n";	
	} 
	$buf .= n($_n) . "</select>\n";
	
	return ($buf);
}

?>