<?php 

//Some Handy configuration for debugging - will display all PHP errors and warnings if any 
error_reporting(E_ALL); 
ini_set("display_errors",0); 

// Connect to DB
$link = mysql_connect($cfg['db']['host'], $cfg['db']['user'], $cfg['db']['pass']) or die(mysql_error()); 
mysql_select_db($cfg['db']['db']) or die(mysql_error());
mysql_set_charset('utf8',$link);

if (!$cfg['disable_login']) {

  if (isset($_POST['mode']) && $_POST['mode'] == "login") $user = new uFlex($_POST['username'],$_POST['password'],1);
  else $user = new uFlex(); 

  // logout must be done from here or cookie cannot be deleted
  if ($_SERVER['PHP_SELF'] == DIR . $cfg['logout_page'])  $user->logout();

  if($user->signed){ 
    // user is validated, no login required
    // if we are on the login page, sent through to default page
    if ($_SERVER['PHP_SELF'] == DIR . $cfg['login_page'] ) {
      $host  = $_SERVER['HTTP_HOST'];
      $uri   = rtrim(dirname($_SERVER['PHP_SELF']), '/\\');
      $extra = $cfg['index_page'];
      header("Location: http://$host$uri/$extra");
      exit;
    }
  } else {
    // user is not signed in, direct to login page if not already there
    // exception is the about page & register page
    //if (($_SERVER['PHP_SELF'] == DIR . $cfg['about_page']) || $_SERVER['PHP_SELF'] == DIR . $cfg['register_page']) {
    	if (($_SERVER['PHP_SELF'] == DIR . $cfg['about_page'])) {
    	// continue
    } elseif ($cfg['public_login'] && $_SERVER['PHP_SELF'] == DIR . $cfg['register_page'] ) { 
    	// continue
    
    } elseif ($_SERVER['PHP_SELF'] != DIR . $cfg['login_page']) {
      $host  = $_SERVER['HTTP_HOST'];
      $uri   = rtrim(dirname($_SERVER['PHP_SELF']), '/\\');
      $extra = $cfg['login_page'];
      header("Location: http://$host$uri/$extra");
      exit;
    }
  } 
  // save page in page history
  //save_page_history($_SERVER['REQUEST_URI']);
} else {
  if ($_SERVER['PHP_SELF'] == DIR . $cfg['logout_page']) {
      $host  = $_SERVER['HTTP_HOST'];
      $uri   = rtrim(dirname($_SERVER['PHP_SELF']), '/\\');
      $extra = $cfg['index_page'];
      header("Location: http://$host$uri/$extra");
      exit;
  }
  elseif ($_SERVER['PHP_SELF'] == DIR . $cfg['login_page']) {
      $host  = $_SERVER['HTTP_HOST'];
      $uri   = rtrim(dirname($_SERVER['PHP_SELF']), '/\\');
      $extra = $cfg['index_page'];
      header("Location: http://$host$uri/$extra");
      exit;
  }  

}

?>