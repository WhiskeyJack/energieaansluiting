<?php

// Leveranciers Data Access Object
class LeveranciersDAO extends BaseDAO {
	var $SQL_SELECT = "SELECT * FROM `leveranciers` ";
	var $SQL_COUNT = "SELECT count(*) AS cnt FROM `leveranciers` ";
	// insert with no value for an auto_increment field.
	var $SQL_INSERT = "INSERT INTO `leveranciers` (LeverancierEAN,LeverancierNaam,LeverancierContactPersoon,LeverancierTelefoonNummer,GewijzigdDoor,GewijzigdOp) VALUES ('%A',%B,%C,%D,%E,'%F')";
	var $SQL_UPDATE = "UPDATE `leveranciers` SET ";
	var $SQL_DELETE = "DELETE FROM `leveranciers` WHERE LeverancierID=%A";

	// default constructor
	function LeveranciersDAO($dbserver="", $dbname="", $dbuser="", $dbpass="") {
		// calls the parent constructor which
		// makes the database connection.
		parent::BaseDAO($dbserver, $dbname, $dbuser, $dbpass);
	}

	// returns a single LeveranciersVO obeject
	function findByPK($LeverancierID) {    
	$this->sql = $this->SQL_SELECT . "WHERE (LeverancierID='$LeverancierID')";
		$this->exec($this->sql);
		if($this->numRows() > 0 ) {
			$row = $this->getObject();
			$vo = new LeveranciersVO(
				$row->LeverancierID, 
				$row->LeverancierEAN, 
				$row->LeverancierNaam, 
				$row->LeverancierContactPersoon, 
				$row->LeverancierTelefoonNummer, 
				$row->GewijzigdDoor, 
				$row->GewijzigdOp
			);
			return $vo;
		} else {
			return null;    
		}
	}

	// returns an array of LeveranciersVO objects
	// given a complete SQL query 
	function findBySQL($sql) {
		$voList = array();
		$this->sql = $sql;
		$this->exec($this->sql);
		while($row = $this->getObject()) {
			$vo = new LeveranciersVO(
				$row->LeverancierID, 
				$row->LeverancierEAN, 
				$row->LeverancierNaam, 
				$row->LeverancierContactPersoon, 
				$row->LeverancierTelefoonNummer, 
				$row->GewijzigdDoor, 
				$row->GewijzigdOp
			);
			array_push($voList, $vo);
		}
		return $voList;
	}

	// returns an array of LeveranciersVO objects
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
			$vo = new LeveranciersVO(
				$row->LeverancierID, 
				$row->LeverancierEAN, 
				$row->LeverancierNaam, 
				$row->LeverancierContactPersoon, 
				$row->LeverancierTelefoonNummer, 
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
		$this->sql = str_replace("%A", $vo->LeverancierEAN, $this->sql);
		$this->sql = str_replace("%B", $vo->LeverancierNaam, $this->sql);
		$this->sql = str_replace("%C", $vo->LeverancierContactPersoon, $this->sql);
		$this->sql = str_replace("%D", $vo->LeverancierTelefoonNummer, $this->sql);
		$this->sql = str_replace("%E", $vo->GewijzigdDoor, $this->sql);
		$this->sql = str_replace("%F", $vo->GewijzigdOp, $this->sql);

		$this->exec($this->sql);
		return $this->affectedRows();
	}

	// update a record from a vo
	function updateVO($vo) {
		$this->sql = $this->SQL_UPDATE;
		$this->sql .= "LeverancierEAN = '" . $vo->LeverancierEAN . "', ";
		$this->sql .= "LeverancierNaam = '" . $vo->LeverancierNaam . "', ";
		$this->sql .= "LeverancierContactPersoon = '" . $vo->LeverancierContactPersoon . "', ";
		$this->sql .= "LeverancierTelefoonNummer = '" . $vo->LeverancierTelefoonNummer . "', ";
		$this->sql .= "GewijzigdDoor = '" . $vo->GewijzigdDoor . "', ";
		$this->sql .= "GewijzigdOp = '" . $vo->GewijzigdOp . "' ";

		$this->sql .= "WHERE LeverancierID=" . $vo->LeverancierID;

		$this->exec($this->sql);
		return $this->affectedRows();
	}

	// delete a record from a vo
	function deleteVO($vo) {
		$this->sql = $this->SQL_DELETE;
		$this->sql = str_replace("%A", $vo->LeverancierID, $this->sql);
		$this->exec($this->sql);
		return $this->affectedRows();
	}

}

?>