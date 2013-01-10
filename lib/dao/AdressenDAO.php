<?php

// Adressen Data Access Object
class AdressenDAO extends BaseDAO {
	var $SQL_SELECT = "SELECT * FROM `adressen` ";
	var $SQL_COUNT = "SELECT count(*) AS cnt FROM `adressen` ";
	// insert with no value for an auto_increment field.
	//var $SQL_INSERT = "INSERT INTO `adressen` (AdresRegel1,StraatNaam,Huisnummer,HuisnummerToevoeging,Postcode,Plaats,Land,GewijzigdDoor,GewijzigdOp) VALUES (%A,'%B',%C,'%D','%E','%F',%G,%H,'%I')";
	var $SQL_INSERT = "INSERT INTO `adressen` (AdresRegel1,StraatNaam,Huisnummer,HuisnummerToevoeging,Postcode,Plaats,Land,GewijzigdDoor,GewijzigdOp) VALUES ('%A','%B',%C,'%D','%E','%F',%G,%H,NOW())";
	var $SQL_UPDATE = "UPDATE `adressen` SET ";
	var $SQL_DELETE = "DELETE FROM `adressen` WHERE AdresID=%A";

	// default constructor
	function AdressenDAO($dbserver="", $dbname="", $dbuser="", $dbpass="") {
		// calls the parent constructor which
		// makes the database connection.
		parent::BaseDAO($dbserver, $dbname, $dbuser, $dbpass);
	}

	// returns a single AdressenVO obeject
	function findByPK($AdresID) {    
	$this->sql = $this->SQL_SELECT . "WHERE (AdresID='$AdresID')";
		$this->exec($this->sql);
		if($this->numRows() > 0 ) {
			$row = $this->getObject();
			$vo = new AdressenVO(
				$row->AdresID, 
				$row->AdresRegel1, 
				$row->StraatNaam, 
				$row->Huisnummer, 
				$row->HuisnummerToevoeging, 
				$row->Postcode, 
				$row->Plaats, 
				$row->Land, 
				$row->GewijzigdDoor, 
				$row->GewijzigdOp
			);
			return $vo;
		} else {
			return null;    
		}
	}

	// returns an array of AdressenVO objects
	// given a complete SQL query 
	function findBySQL($sql) {
		$voList = array();
		$this->sql = $sql;
		$this->exec($this->sql);
		while($row = $this->getObject()) {
			$vo = new AdressenVO(
				$row->AdresID, 
				$row->AdresRegel1, 
				$row->StraatNaam, 
				$row->Huisnummer, 
				$row->HuisnummerToevoeging, 
				$row->Postcode, 
				$row->Plaats, 
				$row->Land, 
				$row->GewijzigdDoor, 
				$row->GewijzigdOp
			);
			array_push($voList, $vo);
		}
		return $voList;
	}

	// returns an array of AdressenVO objects
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
			$vo = new AdressenVO(
				$row->AdresID, 
				$row->AdresRegel1, 
				$row->StraatNaam, 
				$row->Huisnummer, 
				$row->HuisnummerToevoeging, 
				$row->Postcode, 
				$row->Plaats, 
				$row->Land, 
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
		if (!empty($vo->AdresRegel1)) $this->sql = str_replace("%A", $vo->AdresRegel1, $this->sql);
		else $this->sql = str_replace("%A", NULL, $this->sql);
		if (!empty($vo->StraatNaam)) $this->sql = str_replace("%B", $vo->StraatNaam, $this->sql);
		else $this->sql = str_replace("%B", NULL, $this->sql);
		if (!empty($vo->Huisnummer)) $this->sql = str_replace("%C", $vo->Huisnummer, $this->sql);
		else $this->sql = str_replace("%C", NULL, $this->sql);
		if (!empty($vo->HuisnummerToevoeging)) $this->sql = str_replace("%D", $vo->HuisnummerToevoeging, $this->sql);
		else $this->sql = str_replace("%D", NULL, $this->sql);
		if (!empty($vo->Postcode)) $this->sql = str_replace("%E", $vo->Postcode, $this->sql);
		else $this->sql = str_replace("%E", NULL, $this->sql);
		if (!empty($vo->Plaats)) $this->sql = str_replace("%F", $vo->Plaats, $this->sql);
		else $this->sql = str_replace("%F", NULL, $this->sql);
		if (!empty($vo->Land)) $this->sql = str_replace("%G", $vo->Land, $this->sql);
		else $this->sql = str_replace("%G", NULL, $this->sql);
		if (!empty($vo->GewijzigdDoor))$this->sql = str_replace("%H", $vo->GewijzigdDoor, $this->sql);
		else $this->sql = str_replace("%H", NULL, $this->sql);
		//$this->sql = str_replace("%I", $vo->GewijzigdOp, $this->sql);
		//echo "<br>" . $this->sql . "<br>";
		$this->exec($this->sql);
		//return $this->affectedRows();
		//echo "UPDATED: " . $this->affectedRows();
		return $this->lastOID();
	}

	// update a record from a vo
	function updateVO($vo) {
		$this->sql = $this->SQL_UPDATE;
		$this->sql .= "AdresRegel1 = '" . $vo->AdresRegel1 . "', ";
		$this->sql .= "StraatNaam = '" . $vo->StraatNaam . "', ";
		$this->sql .= "Huisnummer = '" . $vo->Huisnummer . "', ";
		$this->sql .= "HuisnummerToevoeging = '" . $vo->HuisnummerToevoeging . "', ";
		$this->sql .= "Postcode = '" . $vo->Postcode . "', ";
		$this->sql .= "Plaats = '" . $vo->Plaats . "', ";
		$this->sql .= "Land = '" . $vo->Land . "', ";
		$this->sql .= "GewijzigdDoor = '" . $vo->GewijzigdDoor . "', ";
		$this->sql .= "GewijzigdOp = '" . $vo->GewijzigdOp . "' ";

		$this->sql .= "WHERE AdresID=" . $vo->AdresID;

		$this->exec($this->sql);
		return $this->affectedRows();
	}

	// delete a record from a vo
	function deleteVO($vo) {
		$this->sql = $this->SQL_DELETE;
		$this->sql = str_replace("%A", $vo->AdresID, $this->sql);
		$this->exec($this->sql);
		return $this->affectedRows();
	}

}



?>