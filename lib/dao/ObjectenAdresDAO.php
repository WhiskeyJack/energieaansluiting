<?php

// ObjectenAdres Data Access Object
class ObjectenAdresDAO extends BaseDAO {
	//var $SQL_SELECT = "SELECT * FROM `objecten_adres` ";
	var $SQL_SELECT = "SELECT `objecten_adres`.*, `objecten_basis`.EanCode, `objecten_basis`.InterneCodering, `objecten_basis`.ObjectNaam 
                     FROM `objecten_adres`, `objecten_basis`
											WHERE `objecten_basis`.ObjectID = `objecten_adres`.ObjectID";
	var $SQL_COUNT = "SELECT count(*) AS cnt FROM `objecten_adres` ";
	// insert with no value for an auto_increment field.
	var $SQL_INSERT = "INSERT INTO `objecten_adres` (ObjectID,ObjectAdres,LokatieNrNetwerkBeheerder,AansluitRegisterAdres,FactuurTenaamStelling,FactuurMoment,FactuurAdres,FactuurVerzameling,BetalingsWijze,GewijzigdDoor,GewijzigdOp) VALUES (%A,%B,'%C',%D,%E,'%F',%G,%H,'%I',%J,'%K')";
	var $SQL_UPDATE = "UPDATE `objecten_adres` SET ";
	var $SQL_DELETE = "DELETE FROM `objecten_adres` WHERE ObjectID=%A";

	// default constructor
	function ObjectenAdresDAODAO($dbserver="", $dbname="", $dbuser="", $dbpass="") {
		// calls the parent constructor which
		// makes the database connection.
		parent::BaseDAO($dbserver, $dbname, $dbuser, $dbpass);
	}

	// returns a single ObjectenAdresDAOVO obeject
	function findByPK($ObjectID) {    
	$this->sql = $this->SQL_SELECT . " AND (`objecten_adres`.ObjectID='$ObjectID')";
    $this->exec($this->sql);
		if($this->numRows() > 0 ) {
			$row = $this->getObject();
			$vo = new ObjectenAdresVO(
				$row->ObjectID, 
				$row->ObjectAdres, 
				$row->LokatieNrNetwerkBeheerder, 
				$row->AansluitRegisterAdres, 
				$row->FactuurTenaamStelling, 
				$row->FactuurMoment, 
				$row->FactuurAdres, 
				$row->FactuurVerzameling, 
				$row->BetalingsWijze, 
				$row->GewijzigdDoor, 
				$row->GewijzigdOp,
        $row->EanCode,
				$row->InterneCodering,
				$row->ObjectNaam
			);
			return $vo;
		} else {
			return null;    
		}
	}

	// returns an array of ObjectenAdresDAOVO objects
	// given a complete SQL query 
	function findBySQL($sql) {
		$voList = array();
		$this->sql = $sql;
		$this->exec($this->sql);
		while($row = $this->getObject()) {
			$vo = new ObjectenAdresDAOVO(
				$row->ObjectID, 
				$row->ObjectAdres, 
				$row->LokatieNrNetwerkBeheerder, 
				$row->AansluitRegisterAdres, 
				$row->FactuurTenaamStelling, 
				$row->FactuurMoment, 
				$row->FactuurAdres, 
				$row->FactuurVerzameling, 
				$row->BetalingsWijze, 
				$row->GewijzigdDoor, 
				$row->GewijzigdOp
			);
			array_push($voList, $vo);
		}
		return $voList;
	}

	// returns an array of ObjectenAdresDAOVO objects
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
			$vo = new ObjectenAdresDAOVO(
				$row->ObjectID, 
				$row->ObjectAdres, 
				$row->LokatieNrNetwerkBeheerder, 
				$row->AansluitRegisterAdres, 
				$row->FactuurTenaamStelling, 
				$row->FactuurMoment, 
				$row->FactuurAdres, 
				$row->FactuurVerzameling, 
				$row->BetalingsWijze, 
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
		$this->sql = str_replace("%A", $vo->ObjectID, $this->sql);
		$this->sql = str_replace("%B", $vo->ObjectAdres, $this->sql);
		$this->sql = str_replace("%C", $vo->LokatieNrNetwerkBeheerder, $this->sql);
		$this->sql = str_replace("%D", $vo->AansluitRegisterAdres, $this->sql);
		$this->sql = str_replace("%E", $vo->FactuurTenaamStelling, $this->sql);
		$this->sql = str_replace("%F", $vo->FactuurMoment, $this->sql);
		$this->sql = str_replace("%G", $vo->FactuurAdres, $this->sql);
		$this->sql = str_replace("%H", $vo->FactuurVerzameling, $this->sql);
		$this->sql = str_replace("%I", $vo->BetalingsWijze, $this->sql);
		$this->sql = str_replace("%J", $vo->GewijzigdDoor, $this->sql);
		$this->sql = str_replace("%K", $vo->GewijzigdOp, $this->sql);

		$this->exec($this->sql);
		return $this->affectedRows();
	}

	// update a record from a vo
	function updateVO($vo) {
		$this->sql = $this->SQL_UPDATE;
		$this->sql .= "ObjectAdres = '" . $vo->ObjectAdres . "', ";
		$this->sql .= "LokatieNrNetwerkBeheerder = '" . $vo->LokatieNrNetwerkBeheerder . "', ";
		$this->sql .= "AansluitRegisterAdres = '" . $vo->AansluitRegisterAdres . "', ";
		$this->sql .= "FactuurTenaamStelling = '" . $vo->FactuurTenaamStelling . "', ";
		$this->sql .= "FactuurMoment = '" . $vo->FactuurMoment . "', ";
		$this->sql .= "FactuurAdres = '" . $vo->FactuurAdres . "', ";
		$this->sql .= "FactuurVerzameling = '" . $vo->FactuurVerzameling . "', ";
		$this->sql .= "BetalingsWijze = '" . $vo->BetalingsWijze . "', ";
		$this->sql .= "GewijzigdDoor = '" . $vo->GewijzigdDoor . "', ";
		//$this->sql .= "GewijzigdOp = '" . $vo->GewijzigdOp . "' ";
		$this->sql .= "GewijzigdOp = NOW() ";

		$this->sql .= "WHERE ObjectID=" . $vo->ObjectID;

		$this->exec($this->sql);
		return $this->affectedRows();
	}

	// delete a record from a vo
	function deleteVO($vo) {
		$this->sql = $this->SQL_DELETE;
		$this->sql = str_replace("%A", $vo->ObjectID, $this->sql);
		$this->exec($this->sql);
		return $this->affectedRows();
	}

}

?>