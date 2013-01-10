<?php

// organisaties Data Access Object
class OrganisatiesDAO extends BaseDAO {
	var $SQL_SELECT = "SELECT * FROM `organisaties` ";
	var $SQL_COUNT = "SELECT count(*) AS cnt FROM `organisaties` ";
	// insert with no value for an auto_increment field.
	var $SQL_INSERT = "INSERT INTO `organisaties` (OrganisatieNaam,OrgansatieAfkorting,ContactPersoon,Telefoon,AdresRegel1,StraatNaam,Huisnummer,HuisnummerToevoeging,Postcode,Plaats,Land) VALUES ('%A','%B',%C,%D,%E,'%F',%G,'%H','%I','%J',%K)";
	var $SQL_UPDATE = "UPDATE `organisaties` SET ";
	var $SQL_DELETE = "DELETE FROM `organisaties` WHERE OrganisatieID=%A";

	// default constructor
	function organisatiesDAO($dbserver="", $dbname="", $dbuser="", $dbpass="") {
		// calls the parent constructor which
		// makes the database connection.
		parent::BaseDAO($dbserver, $dbname, $dbuser, $dbpass);
	}

	// returns a single organisatiesVO obeject
	function findByPK($OrganisatieID) {    
	$this->sql = $this->SQL_SELECT . "WHERE (OrganisatieID='$OrganisatieID')";
		$this->exec($this->sql);
		if($this->numRows() > 0 ) {
			$row = $this->getObject();
			$vo = new organisatiesVO(
				$row->OrganisatieID, 
				$row->OrganisatieNaam, 
				$row->OrgansatieAfkorting, 
				$row->ContactPersoon, 
				$row->Telefoon, 
				$row->AdresRegel1, 
				$row->StraatNaam, 
				$row->Huisnummer, 
				$row->HuisnummerToevoeging, 
				$row->Postcode, 
				$row->Plaats, 
				$row->Land
			);
			return $vo;
		} else {
			return null;    
		}
	}

	// returns an array of organisatiesVO objects
	// given a complete SQL query 
	function findBySQL($sql) {
		$voList = array();
		$this->sql = $sql;
		$this->exec($this->sql);
		while($row = $this->getObject()) {
			$vo = new organisatiesVO(
				$row->OrganisatieID, 
				$row->OrganisatieNaam, 
				$row->OrgansatieAfkorting, 
				$row->ContactPersoon, 
				$row->Telefoon, 
				$row->AdresRegel1, 
				$row->StraatNaam, 
				$row->Huisnummer, 
				$row->HuisnummerToevoeging, 
				$row->Postcode, 
				$row->Plaats, 
				$row->Land
			);
			array_push($voList, $vo);
		}
		return $voList;
	}

	// returns an array of organisatiesVO objects
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
			$vo = new organisatiesVO(
				$row->OrganisatieID, 
				$row->OrganisatieNaam, 
				$row->OrgansatieAfkorting, 
				$row->ContactPersoon, 
				$row->Telefoon, 
				$row->AdresRegel1, 
				$row->StraatNaam, 
				$row->Huisnummer, 
				$row->HuisnummerToevoeging, 
				$row->Postcode, 
				$row->Plaats, 
				$row->Land
			);
			array_push($voList, $vo);
		}
		return $voList;
	}

	// insert a record from a vo
	function insertVO($vo) {
		$this->sql = $this->SQL_INSERT;
		$this->sql = str_replace("%A", $vo->OrganisatieNaam, $this->sql);
		$this->sql = str_replace("%B", $vo->OrgansatieAfkorting, $this->sql);
		$this->sql = str_replace("%C", $vo->ContactPersoon, $this->sql);
		$this->sql = str_replace("%D", $vo->Telefoon, $this->sql);
		$this->sql = str_replace("%E", $vo->AdresRegel1, $this->sql);
		$this->sql = str_replace("%F", $vo->StraatNaam, $this->sql);
		$this->sql = str_replace("%G", $vo->Huisnummer, $this->sql);
		$this->sql = str_replace("%H", $vo->HuisnummerToevoeging, $this->sql);
		$this->sql = str_replace("%I", $vo->Postcode, $this->sql);
		$this->sql = str_replace("%J", $vo->Plaats, $this->sql);
		$this->sql = str_replace("%K", $vo->Land, $this->sql);

		$this->exec($this->sql);
		return $this->affectedRows();
	}

	// update a record from a vo
	function updateVO($vo) {
		$this->sql = $this->SQL_UPDATE;
		$this->sql .= "OrganisatieNaam = '" . $vo->OrganisatieNaam . "', ";
		$this->sql .= "OrgansatieAfkorting = '" . $vo->OrgansatieAfkorting . "', ";
		$this->sql .= "ContactPersoon = '" . $vo->ContactPersoon . "', ";
		$this->sql .= "Telefoon = '" . $vo->Telefoon . "', ";
		$this->sql .= "AdresRegel1 = '" . $vo->AdresRegel1 . "', ";
		$this->sql .= "StraatNaam = '" . $vo->StraatNaam . "', ";
		$this->sql .= "Huisnummer = '" . $vo->Huisnummer . "', ";
		$this->sql .= "HuisnummerToevoeging = '" . $vo->HuisnummerToevoeging . "', ";
		$this->sql .= "Postcode = '" . $vo->Postcode . "', ";
		$this->sql .= "Plaats = '" . $vo->Plaats . "', ";
		$this->sql .= "Land = '" . $vo->Land . "' ";

		$this->sql .= "WHERE OrganisatieID=" . $vo->OrganisatieID;

		$this->exec($this->sql);
		return $this->affectedRows();
	}

	// delete a record from a vo
	function deleteVO($vo) {
		$this->sql = $this->SQL_DELETE;
		$this->sql = str_replace("%A", $vo->OrganisatieID, $this->sql);
		$this->exec($this->sql);
		return $this->affectedRows();
	}

}

?>