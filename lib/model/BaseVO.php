<?php

class BaseVO {
    // css class names for HTML output
    var $css_th = "";
    var $css_td = "";
    var $css_tr = "";
    
    function BaseVO() {
        
    }
    
    // form reading helpers
    function formHelper($key, $default = "") {
        $rval = $default;
        if(array_key_exists($key, $_POST)) {
            if(strlen($_POST[$key]) > 0) {
                $rval = $_POST[$key];
                 if ($key == "EanCode"){
                	if (preg_match("/ /", $rval)) $rval = str_replace(" ","",$rval);
                }
            }
        }        
        return $rval;    
    }
    function formCheckBox($key) {
        if(array_key_exists($key, $_POST)) {            
            return strlen($_POST[$key]) > 0 ? 1 : 0;
        } else {
            return 0;
        }                    
    }
    function queryHelper($key, $default = "") {
        $rval = $default;
        if(array_key_exists($key, $_GET)) {
            if(strlen($_GET[$key]) > 0) {
                $rval = $_GET[$key];
            }
        }            
        return $rval;
    }
    function queryCheckBox($key) {
        if(array_key_exists($key, $_GET)) {
            return strlen($_GET[$key]) > 0 ? 1 : 0;
        } else {
            return 0;
        }                    
    }
        
    
}
?>