<?php

// FiscaleGroepen Data Access Object
class FiscaleGroepenDAO extends BaseDAO {
	var $SQL_SELECT = "SELECT * FROM `fiscale_groepen` ";
	var $SQL_COUNT = "SELECT count(*) AS cnt FROM `fiscale_groepen` ";
	// insert with no value for an auto_increment field.
	var $SQL_INSERT = "INSERT INTO `fiscale_groepen` (FiscaalGroupType,GewijzigdDoor,GewijzigdOp) VALUES (%A,%B,'%C')";
	var $SQL_UPDATE = "UPDATE `fiscale_groepen` SET ";
	var $SQL_DELETE = "DELETE FROM `fiscale_groepen` WHERE FiscaalGroepID=%A";

	// default constructor
	function FiscaleGroepenDAO($dbserver="", $dbname="", $dbuser="", $dbpass="") {
		// calls the parent constructor which
		// makes the database connection.
		parent::BaseDAO($dbserver, $dbname, $dbuser, $dbpass);
	}

	// returns a single FiscaleGroepenVO obeject
	function findByPK($FiscaalGroepID) {    
	$this->sql = $this->SQL_SELECT . "WHERE (FiscaalGroepID='$FiscaalGroepID')";
		$this->exec($this->sql);
		if($this->numRows() > 0 ) {
			$row = $this->getObject();
			$vo = new FiscaleGroepenVO(
				$row->FiscaalGroepID, 
				$row->FiscaalGroupType, 
				$row->GewijzigdDoor, 
				$row->GewijzigdOp
			);
			return $vo;
		} else {
			return null;    
		}
	}

	// returns an array of FiscaleGroepenVO objects
	// given a complete SQL query 
	function findBySQL($sql) {
		$voList = array();
		$this->sql = $sql;
		$this->exec($this->sql);
		while($row = $this->getObject()) {
			$vo = new FiscaleGroepenVO(
				$row->FiscaalGroepID, 
				$row->FiscaalGroupType, 
				$row->GewijzigdDoor, 
				$row->GewijzigdOp
			);
			array_push($voList, $vo);
		}
		return $voList;
	}

	// returns an array of FiscaleGroepenVO objects
	// value for $where is some thing like "(xxx = 'abc') AND (zzz='123')"
	// value for $order_by is a comma separated list of columns "company, name"
	function findWhere($where = "", $orderby = "") {
		$this->sql = $this->SQL_SELECT;
		$voList = array();
		if(strlen($where) > 0 ) {
			$where = "WHERE (" . $where . ") ";
		}
		if(strlen($orderby) > 0) {
			$orderby = "ORDER BY " . $orderby;
		} else {
			$orderby = "ORDER BY 1";
		}
		$this->sql .= $where . " " . $orderby;
		$this->exec($this->sql);
		while($row = $this->getObject()) {
			$vo = new FiscaleGroepenVO(
				$row->FiscaalGroepID, 
				$row->FiscaalGroupType, 
				$row->GewijzigdDoor, 
				$row->GewijzigdOp
			);
			array_push($voList, $vo);
		}
		return $voList;
	}

	// insert a record from a vo
	function insertVO($vo) {
		$this->sql = $this->SQL_INSERT;
		$this->sql = str_replace("%A", $vo->FiscaalGroupType, $this->sql);
		$this->sql = str_replace("%B", $vo->GewijzigdDoor, $this->sql);
		$this->sql = str_replace("%C", $vo->GewijzigdOp, $this->sql);

		$this->exec($this->sql);
		return $this->affectedRows();
	}

	// update a record from a vo
	function updateVO($vo) {
		$this->sql = $this->SQL_UPDATE;
		$this->sql .= "FiscaalGroupType = '" . $vo->FiscaalGroupType . "', ";
		$this->sql .= "GewijzigdDoor = '" . $vo->GewijzigdDoor . "', ";
		$this->sql .= "GewijzigdOp = '" . $vo->GewijzigdOp . "' ";

		$this->sql .= "WHERE FiscaalGroepID=" . $vo->FiscaalGroepID;

		$this->exec($this->sql);
		return $this->affectedRows();
	}

	// delete a record from a vo
	function deleteVO($vo) {
		$this->sql = $this->SQL_DELETE;
		$this->sql = str_replace("%A", $vo->FiscaalGroepID, $this->sql);
		$this->exec($this->sql);
		return $this->affectedRows();
	}

}
?>