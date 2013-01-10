<?php


// ObjectenBeheerder Data Access Object
class ObjectenBeheerderDAO extends BaseDAO {
	//var $SQL_SELECT = "SELECT * FROM `objecten_beheerder` ";
	/*var $SQL_SELECT = "SELECT *, `objecten_basis`.EanCode, `objecten_basis`.InterneCodering, `objecten_basis`.ObjectNaam 
		                 FROM `objecten_beheerder`, `objecten_basis` 
		                 WHERE `objecten_basis`.ObjectID = `objecten_beheerder`.ObjectID"; */
	
	var $SQL_SELECT = "SELECT `objecten_beheerder`.* , `objecten_basis`.EanCode, `objecten_basis`.InterneCodering, `objecten_basis`.ObjectNaam, 
										 `leveranciers`.LeverancierEAN, `leveranciers`.LeverancierNaam, `netbeheerders`.NetbeheerderEAN, `netbeheerders`.NetbeheerderNaam
											FROM `objecten_beheerder` , `objecten_basis` , `leveranciers` , `netbeheerders`
											WHERE `objecten_basis`.ObjectID = `objecten_beheerder`.ObjectID
											AND `objecten_beheerder`.LeverancierID = `leveranciers`.LeverancierID
											AND `objecten_beheerder`.NetbeheerderID = `netbeheerders`.NetbeheerderID";
	
	var $SQL_COUNT = "SELECT count(*) AS cnt FROM `objecten_beheerder` ";
	// insert with no value for an auto_increment field.
	var $SQL_INSERT = "INSERT INTO `objecten_beheerder` (ObjectID,NetBeheerderID,LeverancierID,IngangsDatumLeverancier,StroomType,ContractNummerNetbeheerder,ContractNummerLeverancier,GewijzigdDoor,GewijzigdOp) VALUES (%A,%B,%C,'%D',%E,'%F','%G',%H,'%I')";
	var $SQL_UPDATE = "UPDATE `objecten_beheerder` SET ";
	var $SQL_DELETE = "DELETE FROM `objecten_beheerder` WHERE ObjectID=%A";

	// default constructor
	function ObjectenBeheerderDAO($dbserver="", $dbname="", $dbuser="", $dbpass="") {
		// calls the parent constructor which
		// makes the database connection.
		parent::BaseDAO($dbserver, $dbname, $dbuser, $dbpass);
	}

	// returns a single ObjectenBeheerderVO obeject
	function findByPK($ObjectID) {    
	$this->sql = $this->SQL_SELECT . " AND (`objecten_beheerder`.ObjectID='$ObjectID')";
	$this->exec($this->sql);
		if($this->numRows() > 0 ) {
			$row = $this->getObject();
			$vo = new ObjectenBeheerderVO(
				$row->ObjectID, 
				$row->NetBeheerderID, 
				$row->LeverancierID, 
				$row->IngangsDatumLeverancier, 
				$row->StroomType, 
				$row->ContractNummerNetbeheerder, 
				$row->ContractNummerLeverancier, 
				$row->GewijzigdDoor, 
				$row->GewijzigdOp,
				$row->EanCode,
				$row->InterneCodering,
				$row->ObjectNaam,
				$row->LeverancierEAN,
				$row->LeverancierNaam,
				$row->NetbeheerderEAN,
				$row->NetbeheerderNaam
			);
			return $vo;
		} else {
			return null;    
		}
	}

	// returns an array of ObjectenBeheerderVO objects
	// given a complete SQL query 
	function findBySQL($sql) {
		$voList = array();
		$this->sql = $sql;
		$this->exec($this->sql);
		while($row = $this->getObject()) {
			$vo = new ObjectenBeheerderVO(
				$row->ObjectID, 
				$row->NetBeheerderID, 
				$row->LeverancierID, 
				$row->IngangsDatumLeverancier, 
				$row->StroomType, 
				$row->ContractNummerNetbeheerder, 
				$row->ContractNummerLeverancier, 
				$row->GewijzigdDoor, 
				$row->GewijzigdOp,
				$row->EanCode,
				$row->InterneCodering,
				$row->ObjectNaam
			);
			array_push($voList, $vo);
		}
		return $voList;
	}

	// returns an array of ObjectenBeheerderVO objects
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
			$vo = new ObjectenBeheerderVO(
				$row->ObjectID, 
				$row->NetBeheerderID, 
				$row->LeverancierID, 
				$row->IngangsDatumLeverancier, 
				$row->StroomType, 
				$row->ContractNummerNetbeheerder, 
				$row->ContractNummerLeverancier, 
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
		$this->sql = str_replace("%B", $vo->NetBeheerderID, $this->sql);
		$this->sql = str_replace("%C", $vo->LeverancierID, $this->sql);
		$this->sql = str_replace("%D", $vo->IngangsDatumLeverancier, $this->sql);
		$this->sql = str_replace("%E", $vo->StroomType, $this->sql);
		$this->sql = str_replace("%F", $vo->ContractNummerNetbeheerder, $this->sql);
		$this->sql = str_replace("%G", $vo->ContractNummerLeverancier, $this->sql);
		$this->sql = str_replace("%H", $vo->GewijzigdDoor, $this->sql);
		$this->sql = str_replace("%I", $vo->GewijzigdOp, $this->sql);

		$this->exec($this->sql);
		return $this->affectedRows();
	}

	// update a record from a vo
	function updateVO($vo) {
		$this->sql = $this->SQL_UPDATE;
		$this->sql .= "NetBeheerderID = '" . $vo->NetBeheerderID . "', ";
		$this->sql .= "LeverancierID = '" . $vo->LeverancierID . "', ";
		$this->sql .= "IngangsDatumLeverancier = '" . $vo->IngangsDatumLeverancier . "', ";
		$this->sql .= "StroomType = '" . $vo->StroomType . "', ";
		$this->sql .= "ContractNummerNetbeheerder = '" . $vo->ContractNummerNetbeheerder . "', ";
		$this->sql .= "ContractNummerLeverancier = '" . $vo->ContractNummerLeverancier . "', ";
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