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


class BaseDAO {

    var $DEFAULT_HOST = "localhost";
    var $DEFAULT_DB = "mysql";
    var $DEFAULT_USER = "root";
    var $DEFAULT_PASS = "";

    var $DB = null;
    var $RS = null;
    var $sql = "";
    var $error_message = "";

    // default constructor
    function BaseDAO($dbserver = "", $dbname = "", $dbuser="", $dbpass="") {
        if(strlen($dbserver) == 0)     { $dbserver = $this->DEFAULT_HOST; }
        if(strlen($dbname) == 0)     { $dbname = $this->DEFAULT_DB; }
        if(strlen($dbuser) == 0)     { $dbuser=$this->DEFAULT_USER; }
        if(strlen($dbpass) == 0)     { $dbpass=$this->DEFAULT_PASS; }
        $this->connect($dbserver, $dbname, $dbuser, $dbpass);
        $this->searchCriteria = null;
    }

    ////////////////////////
    // Connection related
    ////////////////////////    
    function connect($dbserver, $dbname, $dbuser, $dbpass) {
        if($this->DB == null) {
            $this->RS = null;
            $this->DB = mysql_pconnect ($dbserver, $dbuser, $dbpass)
                or $error_message = mysql_errno().": ".mysql_error();
            if(!mysql_select_db($dbname, $this->DB)) {
                $error_message = mysql_errno().": ".mysql_error();
            }
        }        
    }
    function exec($sql) {
        if($this->DB != null) {
            $this->RS = mysql_query ($sql);
            $error_message = mysql_errno().": ".mysql_error();
        }    
        return $this->RS;
    }
    
    function query($sql) {
        return $this->exec($sql);    
    }

    function getSQL() {
        return $this->sql;    
    }
    
    
    function close() {
        if($this->DB != null) {
            mysql_close($this->DB);
            $this->DB = null;
            if($this->RS != null) {
                mysql_free_result($this->RS);
                $this->RS = null;
            }
        }    
    }

    ////////////////////////
    // Resultset related
    ////////////////////////    
    function getRow() {
        $obj = null;
        if($this->RS != null) {
            $obj = mysql_fetch_row ($this->RS);
        }            
        return $obj;
    }    
    function getObject() {
        $obj = null;
        if($this->RS != null) {
            $obj = mysql_fetch_object ($this->RS);
        }            
        return $obj;
    }
    function getArray() {
        $obj = null;
        if($this->RS != null) {
            $obj = mysql_fetch_array ($this->RS);
        }            
        return $obj;
    }    
    function getAssoc() {
        $obj = null;
        if($this->RS != null) {
            $obj = mysql_fetch_assoc ($this->RS);
        }            
        return $obj;
    }
    
    function numCols() {
        $r = 0;
        if($this->RS != null) {
            $r = mysql_num_fields($this->RS);    
        }    
        return $r;
    }
    
    function numRows() {
        $r = 0;
        if($this->RS != null) {
            $r = mysql_num_rows($this->RS);    
        }
        return $r;
    }
    
    function affectedRows() {
        $r = 0;
        if($this->RS != null) {
            $r = mysql_affected_rows();    
        }    
        return $r;
    }
    
    function lastOID() {
        $id = null;
        if ($this->RS != null) {
            $id = mysql_insert_id ($this->DB);
        }
        return $id;
    }
    
    // replaces unix wildcard chars with sql wildcard chars
    function sqlSearchStr($srch_str) {
        $srch_str = str_replace("*", "%", $srch_str);
        $srch_str = str_replace("?", "_", $srch_str);
        return $srch_str;
    }
    
    ////////////////////////
    // Transaction related
    ////////////////////////
    function beginTrans() {
        return @mysql_query($this->DB, "begin");
    }

    function commitTrans() {
        return @mysql_query($this->DB, "commit");
    }

    // returns true/false
    function rollbackTrans() {
        return @mysql_query($this->DB, "rollback");
    }
    
}

?> 