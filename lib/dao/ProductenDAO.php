<?php

// Producten Data Access Object
class ProductenDAO extends BaseDAO {
	var $SQL_SELECT = "SELECT * FROM `producten` ";
	var $SQL_COUNT = "SELECT count(*) AS cnt FROM `producten` ";
	// insert with no value for an auto_increment field.
	var $SQL_INSERT = "INSERT INTO `producten` (ProductNaam,ProductEenheid) VALUES ('%A','%B')";
	var $SQL_UPDATE = "UPDATE `producten` SET ";
	var $SQL_DELETE = "DELETE FROM `producten` WHERE ProductID=%A";

	// default constructor
	function ProductenDAO($dbserver="", $dbname="", $dbuser="", $dbpass="") {
		// calls the parent constructor which
		// makes the database connection.
		parent::BaseDAO($dbserver, $dbname, $dbuser, $dbpass);
	}

	// returns a single ProductenVO obeject
	function findByPK($ProductID) {    
	$this->sql = $this->SQL_SELECT . "WHERE (ProductID='$ProductID')";
		$this->exec($this->sql);
		if($this->numRows() > 0 ) {
			$row = $this->getObject();
			$vo = new ProductenVO(
				$row->ProductID, 
				$row->ProductNaam, 
				$row->ProductEenheid
			);
			return $vo;
		} else {
			return null;    
		}
	}

	// returns an array of ProductenVO objects
	// given a complete SQL query 
	function findBySQL($sql) {
		$voList = array();
		$this->sql = $sql;
		$this->exec($this->sql);
		while($row = $this->getObject()) {
			$vo = new ProductenVO(
				$row->ProductID, 
				$row->ProductNaam, 
				$row->ProductEenheid
			);
			array_push($voList, $vo);
		}
		return $voList;
	}

	// returns an array of ProductenVO objects
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
			$vo = new ProductenVO(
				$row->ProductID, 
				$row->ProductNaam, 
				$row->ProductEenheid
			);
			array_push($voList, $vo);
		}
		return $voList;
	}

	// insert a record from a vo
	function insertVO($vo) {
		$this->sql = $this->SQL_INSERT;
		$this->sql = str_replace("%A", $vo->ProductNaam, $this->sql);
		$this->sql = str_replace("%B", $vo->ProductEenheid, $this->sql);

		$this->exec($this->sql);
		return $this->affectedRows();
	}

	// update a record from a vo
	function updateVO($vo) {
		$this->sql = $this->SQL_UPDATE;
		$this->sql .= "ProductNaam = '" . $vo->ProductNaam . "', ";
		$this->sql .= "ProductEenheid = '" . $vo->ProductEenheid . "' ";

		$this->sql .= "WHERE ProductID=" . $vo->ProductID;

		$this->exec($this->sql);
		return $this->affectedRows();
	}

	// delete a record from a vo
	function deleteVO($vo) {
		$this->sql = $this->SQL_DELETE;
		$this->sql = str_replace("%A", $vo->ProductID, $this->sql);
		$this->exec($this->sql);
		return $this->affectedRows();
	}

}
?>