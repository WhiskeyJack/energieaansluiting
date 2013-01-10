<?php 

if (substr($_SERVER['SERVER_ADDR'],0,8) == "192.168.") {
  // in dev environment, use this directory
  define("DIR","/energie/");  
} else {
  define("DIR","/");
}

include('secret.inc.php');
// $cfg['db']['host'] = 'localhost'; 
// $cfg['db']['db'] = ''; 
// $cfg['db']['user'] = ''; 
// $cfg['db']['pass'] = ''; 

$cfg['enable_reg'] = true;
$cfg['disable_login'] = false;
$cfg['public_login'] = false;						// if true allows non-registered users to register on register page
$cfg['enable_debug'] = true;


$cfg['title'] = 'Energie Aansluiting';
$cfg['config_page'] = 'configuratie.php';
$cfg['logout_page'] = 'logout.php';
$cfg['index_page'] = 'index.php';
$cfg['login_page'] = 'login.php';
$cfg['about_page'] = 'about.php';
$cfg['register_page'] = 'register.php';
$cfg['object_page'] = 'object.php';
$cfg['netbeheer_page'] = 'netbeheer.php';
$cfg['energie_page'] = 'energie.php';
$cfg['adres_page'] = 'adres.php';

$cfg['format']['strf_time_updated'] = "%e %B %G %H:%M";
$cfg['format']['strf_time_default'] = "%e %B %G %H:%M";
$cfg['format']['strf_time_list'] = "%d %b %G %H:%M";
$cfg['format']['strf_time_date_full'] = "%e %B %G";

$cfg['form']['text_input']['max_length'] = 50;
$cfg['form']['text_input']['size'] = 25;
$cfg['form']['text_area']['cols'] = 22;
$cfg['form']['text_area']['rows'] = 2;

$cfg['values']['eigenaar']['eigen'] = 'eigen';
$cfg['values']['eigenaar']['derde'] = 'derde';
$cfg['values']['eigenaar']['huur'] = 'huur';
$cfg['values']['eigenaar']['onbekend'] = 'onbekend';

$cfg['values']['stroomtype']['groen'] = 'groen';
$cfg['values']['stroomtype']['grijs'] = 'grijs';
$cfg['values']['stroomtype']['onbekend'] = 'onbekend';

$cfg['values']['grootkleinverbruik']['KVB'] = 'KVB';
$cfg['values']['grootkleinverbruik']['GVB'] = 'GVB';

$cfg['values']['inbedrijf']['ja'] = 'ja';
$cfg['values']['inbedrijf']['nee'] = 'nee';
$cfg['values']['inbedrijf']['onbekend'] = 'onbekend';

$cfg['values']['energiescan']['ja'] = 'ja';
$cfg['values']['energiescan']['nee'] = 'nee';
$cfg['values']['energiescan']['onbekend'] = 'onbekend';

$cfg['values']['energielabel']['A'] = 'A';
$cfg['values']['energielabel']['B'] = 'B';
$cfg['values']['energielabel']['C'] = 'C';
$cfg['values']['energielabel']['D'] = 'D';
$cfg['values']['energielabel']['E'] = 'E';
$cfg['values']['energielabel']['F'] = 'F';
$cfg['values']['energielabel']['G'] = 'G';
$cfg['values']['energielabel']['onbekend'] = 'onbekend';

$cfg['values']['LED']['ja'] = 'ja';
$cfg['values']['LED']['nee'] = 'nee';
$cfg['values']['LED']['onbekend'] = 'onbekend';

$cfg['values']['energielabelafmelding']['ja'] = 'ja';
$cfg['values']['energielabelafmelding']['nee'] = 'nee';
$cfg['values']['energielabelafmelding']['onbekend'] = 'onbekend';

$cfg['values']['bijzondereaansluiting']['ja'] = 'ja';
$cfg['values']['bijzondereaansluiting']['nee'] = 'nee';
$cfg['values']['bijzondereaansluiting']['onbekend'] = 'onbekend';

$cfg['values']['energiebelasting']['groep'] = 'groep';
$cfg['values']['energiebelasting']['normaal'] = 'normaal';
$cfg['values']['energiebelasting']['onbekend'] = 'onbekend';

$cfg['values']['factuurmoment']['maandelijks'] = 'maandelijks';
$cfg['values']['factuurmoment']['januari'] = 'januari';
$cfg['values']['factuurmoment']['februari'] = 'februari';
$cfg['values']['factuurmoment']['maart'] = 'maart';
$cfg['values']['factuurmoment']['april'] = 'april';
$cfg['values']['factuurmoment']['mei'] = 'mei';
$cfg['values']['factuurmoment']['juni'] = 'juni';
$cfg['values']['factuurmoment']['juli'] = 'juli';
$cfg['values']['factuurmoment']['augustus'] = 'augustus';
$cfg['values']['factuurmoment']['september'] = 'september';
$cfg['values']['factuurmoment']['oktober'] = 'oktober';
$cfg['values']['factuurmoment']['november'] = 'november';
$cfg['values']['factuurmoment']['december'] = 'december';

$cfg['values']['factuurverzameling']['ja'] = 'ja';
$cfg['values']['factuurverzameling']['nee'] = 'nee';
$cfg['values']['factuurverzameling']['onbekend'] = 'onbekend';

$cfg['values']['betalingswijze']['factuur'] = 'factuur';
$cfg['values']['betalingswijze']['incasso'] = 'incasso';

?>
