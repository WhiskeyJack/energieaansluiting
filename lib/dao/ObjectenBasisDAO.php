<?php


/*
TODO: findBySQL & FindWhere update for doel omschrijving join
*/

// ObjectBasis Data Access Object
class ObjectenBasisDAO extends BaseDAO {
	//var $SQL_SELECT = "SELECT * FROM `objecten_basis` ";
	var $SQL_SELECT = "SELECT `objecten_basis`.*, `doelen`.Omschrijving AS DoelOmschrijving FROM `objecten_basis`, `doelen` WHERE `objecten_basis`.DoelID = `doelen`.DoelID";
	var $SQL_COUNT = "SELECT count(*) AS cnt FROM `objecten_basis` ";
	// insert with no value for an auto_increment field.
	var $SQL_INSERT = "INSERT INTO `objecten_basis` (EanCode,ObjectNaam,InterneCodering,OpNaamVan,Eigenaar,JuridischEigenaar,Gebruiker,BudgetHouder,DoelID,Bouwjaar,GewijzigdDoor,GewijzigdOp) VALUES ('%A',%B,'%C',%D,%E,%F,%G,%H,%I,%J,%K,'%L')";
	var $SQL_UPDATE = "UPDATE `objecten_basis` SET ";
	var $SQL_DELETE = "DELETE FROM `objecten_basis` WHERE ObjectID=%A";

	var $SQL_SELECT_PLUS = "SELECT `objecten_basis`.*, `doelen`.Omschrijving AS DoelOmschrijving,
	 										o1.OrganisatieNaam AS OpNaamVanNaam, o2.OrganisatieNaam AS JuridischEigenaarNaam, 
	 										o3.OrganisatieNaam AS GebruikerNaam, o4.OrganisatieNaam AS BudgetHouderNaam
										  FROM `doelen`, `objecten_basis`
											LEFT OUTER JOIN (organisaties o1) ON (o1.OrganisatieID = objecten_basis.OpNaamVan)
											LEFT OUTER JOIN (organisaties o2) ON (o2.OrganisatieID = objecten_basis.JuridischEigenaar)
											LEFT OUTER JOIN (organisaties o3) ON (o3.OrganisatieID = objecten_basis.Gebruiker)
											LEFT OUTER JOIN (organisaties o4) ON (o4.OrganisatieID = objecten_basis.BudgetHouder)
										  WHERE `objecten_basis`.DoelID = `doelen`.DoelID";
	
	// default constructor
	function ObjectenBasisDAO($dbserver="", $dbname="", $dbuser="", $dbpass="") {
		// calls the parent constructor which
		// makes the database connection.
		parent::BaseDAO($dbserver, $dbname, $dbuser, $dbpass);
	}

	// returns a single ObjectenBasisVO obeject
	function findByPK($ObjectID) {    
	//$this->sql = $this->SQL_SELECT . "WHERE (ObjectID='$ObjectID')";
	$this->sql = $this->SQL_SELECT . " AND (ObjectID='$ObjectID')";
		$this->exec($this->sql);
		if($this->numRows() > 0 ) {
			$row = $this->getObject();
			$vo = new ObjectenBasisVO(
				$row->ObjectID, 
				$row->EanCode, 
				$row->ObjectNaam, 
				$row->InterneCodering, 
				$row->OpNaamVan, 
				$row->Eigenaar, 
				$row->JuridischEigenaar, 
				$row->Gebruiker, 
				$row->BudgetHouder, 
				$row->DoelID, 
				$row->Bouwjaar, 
				$row->GewijzigdDoor, 
				$row->GewijzigdOp,
				$row->DoelOmschrijving
			);
			return $vo;
		} else {
			return null;
		}
	}

	// returns an array of ObjectenBasisVO objects
	// given a complete SQL query 
	function findBySQL($sql) {
		$voList = array();
		$this->sql = $sql;
		$this->exec($this->sql);
		while($row = $this->getObject()) {
			$vo = new ObjectenBasisVO(
				$row->ObjectID, 
				$row->EanCode, 
				$row->ObjectNaam, 
				$row->InterneCodering, 
				$row->OpNaamVan, 
				$row->Eigenaar, 
				$row->JuridischEigenaar, 
				$row->Gebruiker, 
				$row->BudgetHouder, 
				$row->DoelID, 
				$row->Bouwjaar, 
				$row->GewijzigdDoor, 
				$row->GewijzigdOp
			);
			array_push($voList, $vo);
		}
		return $voList;
	}

	// returns an array of ObjectenBasisVO objects
	// value for $where is some thing like "(xxx = 'abc') AND (zzz='123')"
	// value for $order_by is a comma separated list of columns "company, name"
	function findWhere($where = "", $orderby = "", $limit = "") {
		$this->sql = $this->SQL_SELECT;
		$voList = array();
		if(strlen($where) > 0 ) {
			$where = " AND (" . $where . ") ";
		}
		if(strlen($orderby) > 0) {
			$orderby = "ORDER BY " . $orderby;
		} else {
			$orderby = "ORDER BY 1";
		}
		if(strlen($limit) > 0) {
			$limit = " LIMIT 0, " . $limit;
		} 
		$this->sql .= $where . " " . $orderby . $limit;
		//echo $this->sql;
		$this->exec($this->sql);
		while($row = $this->getObject()) {
			$vo = new ObjectenBasisVO(
				$row->ObjectID, 
				$row->EanCode, 
				$row->ObjectNaam, 
				$row->InterneCodering, 
				$row->OpNaamVan, 
				$row->Eigenaar, 
				$row->JuridischEigenaar, 
				$row->Gebruiker, 
				$row->BudgetHouder, 
				$row->DoelID, 
				$row->Bouwjaar, 
				$row->GewijzigdDoor, 
				$row->GewijzigdOp,
				$row->DoelOmschrijving
			);
			array_push($voList, $vo);
		}
		return $voList;
	}

	// insert a record from a vo
	function insertVO($vo) {
		$this->sql = $this->SQL_INSERT;
		$this->sql = str_replace("%A", $vo->EanCode, $this->sql);
		$this->sql = str_replace("%B", $vo->ObjectNaam, $this->sql);
		$this->sql = str_replace("%C", $vo->InterneCodering, $this->sql);
		$this->sql = str_replace("%D", $vo->OpNaamVan, $this->sql);
		$this->sql = str_replace("%E", $vo->Eigenaar, $this->sql);
		$this->sql = str_replace("%F", $vo->JuridischEigenaar, $this->sql);
		$this->sql = str_replace("%G", $vo->Gebruiker, $this->sql);
		$this->sql = str_replace("%H", $vo->BudgetHouder, $this->sql);
		$this->sql = str_replace("%I", $vo->DoelID, $this->sql);
		$this->sql = str_replace("%J", $vo->Bouwjaar, $this->sql);
		$this->sql = str_replace("%K", $vo->GewijzigdDoor, $this->sql);
		$this->sql = str_replace("%L", $vo->GewijzigdOp, $this->sql);

		$this->exec($this->sql);
		return $this->affectedRows();
	}

	// update a record from a vo
	function updateVO($vo) {
		$this->sql = $this->SQL_UPDATE;
		$this->sql .= "EanCode = '" . $vo->EanCode . "', ";
		$this->sql .= "ObjectNaam = '" . $vo->ObjectNaam . "', ";
		$this->sql .= "InterneCodering = '" . $vo->InterneCodering . "', ";
		$this->sql .= "OpNaamVan = '" . $vo->OpNaamVan . "', ";
		$this->sql .= "Eigenaar = '" . $vo->Eigenaar . "', ";
		$this->sql .= "JuridischEigenaar = '" . $vo->JuridischEigenaar . "', ";
		$this->sql .= "Gebruiker = '" . $vo->Gebruiker . "', ";
		$this->sql .= "BudgetHouder = '" . $vo->BudgetHouder . "', ";
		$this->sql .= "DoelID = '" . $vo->DoelID . "', ";
		$this->sql .= "Bouwjaar = '" . $vo->Bouwjaar . "', ";
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

	// returns an array of ObjectenBasisVO objects
	// value for $where is some thing like "(xxx = 'abc') AND (zzz='123')"
	// value for $order_by is a comma separated list of columns "company, name"
	function findWherePlus($where = "", $orderby = "", $limit = "") {
		$this->sql = $this->SQL_SELECT_PLUS;
		$voList = array();
		if(strlen($where) > 0 ) {
			$where = " AND (" . $where . ") ";
		}
		if(strlen($orderby) > 0) {
			$orderby = "ORDER BY " . $orderby;
		} else {
			$orderby = "ORDER BY 1";
		}
		if(strlen($limit) > 0) {
			$limit = " LIMIT 0, " . $limit;
		} 
		$this->sql .= $where . " " . $orderby . $limit;
		//echo $this->sql;
		$this->exec($this->sql);
		while($row = $this->getObject()) {
			$vo = new ObjectenBasisVOplus(
			//$vo = new ObjectenBasisVO(
				$row->ObjectID, 
				$row->EanCode, 
				$row->ObjectNaam, 
				$row->InterneCodering, 
				$row->OpNaamVan, 
				$row->Eigenaar, 
				$row->JuridischEigenaar, 
				$row->Gebruiker, 
				$row->BudgetHouder, 
				$row->DoelID, 
				$row->Bouwjaar, 
				$row->GewijzigdDoor, 
				$row->GewijzigdOp,
				$row->DoelOmschrijving,
				$row->OpNaamVanNaam,
				$row->JuridischEigenaarNaam,
				$row->GebruikerNaam,
				$row->BudgetHouderNaam
			);
			array_push($voList, $vo);
		}
		return $voList;
	}
	
}

