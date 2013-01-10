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
    var $DEFAULT_PORT = "5432";

    var $DB = null;
    var $RS = null;
    var $sql = "";
    var $error_message = "";

    // default constructor
    function BaseDAO($dbserver = "", $dbname = "", $dbuser="", $dbpass="", $dbport="") {
        if(strlen($dbserver) == 0)     { $dbserver = $this->DEFAULT_HOST; }
        if(strlen($dbname) == 0)     { $dbname = $this->DEFAULT_DB; }
        if(strlen($dbuser) == 0)     { $dbuser=$this->DEFAULT_USER; }
        if(strlen($dbpass) == 0)     { $dbpass=$this->DEFAULT_PASS; }
        $conn_str = "host=$dbserver port=$dbport dbname=$dbname user=$dbuser password=$dbpass";
        $this->connect($dbserver, $dbname, $dbuser, $dbpass);
        $this->searchCriteria = null;
    }

    ////////////////////////
    // Connection related
    ////////////////////////    
    function connect($dbserver, $dbname, $dbuser, $dbpass) {
        if($this->DB == null) {
            $this->RS = null;
            $this->DB = pg_pconnect ($dbserver, $dbuser, $dbpass)
                or $error_message = pg_errormessage();
            if(!mysql_select_db($dbname, $this->DB)) {
                $error_message = pg_errormessage();
            }
        }        
    }
    function exec($sql) {
        if($this->DB != null) {
            $this->RS = pg_exec ($this->DB, $sql);
            $error_message = pg_errormessage();
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
            pg_close($this->DB);
            $this->DB = null;
            if($this->RS != null) {
                pg_freeresult($this->RS);
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
            $obj = pg_fetch_row ($this->RS);
        }            
        return $obj;
    }    
    function getObject() {
        $obj = null;
        if($this->RS != null) {
            $obj = pg_fetch_object ($this->RS);
        }            
        return $obj;
    }
    function getArray() {
        $obj = null;
        if($this->RS != null) {
            $obj = pg_fetch_array ($this->RS);
        }            
        return $obj;
    }    

    function getAssoc() {
        $obj = null;
        if($this->RS != null) {
            $obj = pg_fetch_array ($this->RS);
        }            
        return $obj;
    }
    
    function numCols() {
        $r = 0;
        if($this->RS != null) {
            $r = pg_numfields($this->RS);    
        }    
        return $r;
    }
    
    function numRows() {
        $r = 0;
        if($this->RS != null) {
            $r = pg_numrows($this->RS);    
        }
        return $r;
    }

    
    function affectedRows() {
        $r = 0;
/*  no available method
        if($this->RS != null) {
            $r = mysql_affected_rows();    
        }    
*/
        return $r;
    }
    
    function lastOID() {
        $id = null;
        if ($this->RS != null) {
            $id = pg_getlastoid ($this->RS);
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
/*  no available method
        return @mysql_query($this->DB, "begin");
*/
    }

    function commitTrans() {
/*  no available method
        return @mysql_query($this->DB, "commit");
*/
    }

    // returns true/false
    function rollbackTrans() {
/*  no available method
        return @mysql_query($this->DB, "rollback");
*/
    }
    
}

?> 