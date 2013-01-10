<?php

// ObjectenEnergie Data Access Object
class ObjectenEnergieDAO extends BaseDAO {
	//var $SQL_SELECT = "SELECT * FROM `objecten_energie` ";
	var $SQL_SELECT = "SELECT `objecten_energie`.*, `objecten_basis`.EanCode, `objecten_basis`.InterneCodering, `objecten_basis`.ObjectNaam, 
										 `fiscale_groepen`.FiscaalGroupType, `producten`.ProductNaam, `producten`.ProductEenheid
										 FROM `objecten_energie`, `objecten_basis`, `fiscale_groepen`, `producten` 
										 WHERE `objecten_basis`.ObjectID = `objecten_energie`.ObjectID
										 AND `objecten_energie`.FiscaalGroepID = `fiscale_groepen`.FiscaalGroepID
										 AND `objecten_energie`.ProductID = `producten`.ProductID";
	var $SQL_COUNT = "SELECT count(*) AS cnt FROM `objecten_energie` ";
	// insert with no value for an auto_increment field.
	var $SQL_INSERT = "INSERT INTO `objecten_energie` (ObjectID,Product,StandaardJaarVerbruik,MeterNummer,MeterSoort,MeetdienstContractNummer,GrootKleinVerbruik,AansluitingType,ContractWaarde,InBedrijf,RealisatieDatumStart,RealisatieDatumEinde,BrutoVloerOppervlak,EnergieScan,EnergieLabel,EnergieLabelAfmelding,LED,BijzondereAansluiting,FiscaalGroepID,EnergieBelasting,EnergieOpmerkingen,GewijzigdDoor,GewijzigdOp) VALUES (%A,%B,%C,%D,'%E',%F,%G,'%H',%I,%J,'%K','%L',%M,%N,%O,%P,%Q,%R,%S,%T,'%U',%V,'%W')";
	var $SQL_UPDATE = "UPDATE `objecten_energie` SET ";
	var $SQL_DELETE = "DELETE FROM `objecten_energie` WHERE ObjectID=%A";

	// default constructor
	function ObjectenEnergieDAO($dbserver="", $dbname="", $dbuser="", $dbpass="") {
		// calls the parent constructor which
		// makes the database connection.
		parent::BaseDAO($dbserver, $dbname, $dbuser, $dbpass);
	}

	// returns a single ObjectenEnergieVO obeject
	function findByPK($ObjectID) {    
	$this->sql = $this->SQL_SELECT . " AND (`objecten_energie`.ObjectID='$ObjectID')";
		$this->exec($this->sql);
		if($this->numRows() > 0 ) {
			$row = $this->getObject();
			$vo = new ObjectenEnergieVO(
				$row->ObjectID, 
				$row->ProductID, 
				$row->StandaardJaarVerbruik, 
				$row->MeterNummer, 
				$row->MeterSoort, 
				$row->MeetdienstContractNummer, 
				$row->GrootKleinVerbruik, 
				$row->AansluitingType, 
				$row->ContractWaarde, 
				$row->InBedrijf, 
				$row->RealisatieDatumStart, 
				$row->RealisatieDatumEinde, 
				$row->BrutoVloerOppervlak, 
				$row->EnergieScan, 
				$row->EnergieLabel, 
				$row->EnergieLabelAfmelding, 
				$row->LED, 
				$row->BijzondereAansluiting, 
				$row->FiscaalGroepID, 
				$row->EnergieBelasting, 
				$row->EnergieOpmerkingen, 
				$row->GewijzigdDoor, 
				$row->GewijzigdOp,
        $row->EanCode,
				$row->InterneCodering,
				$row->ObjectNaam,
        $row->FiscaalGroupType,
				$row->ProductNaam,
				$row->ProductEenheid
			);
			return $vo;
		} else {
			return null;    
		}
	}

	// returns an array of ObjectenEnergieVO objects
	// given a complete SQL query 
	function findBySQL($sql) {
		$voList = array();
		$this->sql = $sql;
		$this->exec($this->sql);
		while($row = $this->getObject()) {
			$vo = new ObjectenEnergieVO(
				$row->ObjectID, 
				$row->ProductID, 
				$row->StandaardJaarVerbruik, 
				$row->MeterNummer, 
				$row->MeterSoort, 
				$row->MeetdienstContractNummer, 
				$row->GrootKleinVerbruik, 
				$row->AansluitingType, 
				$row->ContractWaarde, 
				$row->InBedrijf, 
				$row->RealisatieDatumStart, 
				$row->RealisatieDatumEinde, 
				$row->BrutoVloerOppervlak, 
				$row->EnergieScan, 
				$row->EnergieLabel, 
				$row->EnergieLabelAfmelding, 
				$row->LED, 
				$row->BijzondereAansluiting, 
				$row->FiscaalGroepID, 
				$row->EnergieBelasting, 
				$row->EnergieOpmerkingen, 
				$row->GewijzigdDoor, 
				$row->GewijzigdOp
			);
			array_push($voList, $vo);
		}
		return $voList;
	}

	// returns an array of ObjectenEnergieVO objects
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
			$vo = new ObjectenEnergieVO(
				$row->ObjectID, 
				$row->ProductID, 
				$row->StandaardJaarVerbruik, 
				$row->MeterNummer, 
				$row->MeterSoort, 
				$row->MeetdienstContractNummer, 
				$row->GrootKleinVerbruik, 
				$row->AansluitingType, 
				$row->ContractWaarde, 
				$row->InBedrijf, 
				$row->RealisatieDatumStart, 
				$row->RealisatieDatumEinde, 
				$row->BrutoVloerOppervlak, 
				$row->EnergieScan, 
				$row->EnergieLabel, 
				$row->EnergieLabelAfmelding, 
				$row->LED, 
				$row->BijzondereAansluiting, 
				$row->FiscaalGroepID, 
				$row->EnergieBelasting, 
				$row->EnergieOpmerkingen, 
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
		$this->sql = str_replace("%B", $vo->ProductID, $this->sql);
		$this->sql = str_replace("%C", $vo->StandaardJaarVerbruik, $this->sql);
		$this->sql = str_replace("%D", $vo->MeterNummer, $this->sql);
		$this->sql = str_replace("%E", $vo->MeterSoort, $this->sql);
		$this->sql = str_replace("%F", $vo->MeetdienstContractNummer, $this->sql);
		$this->sql = str_replace("%G", $vo->GrootKleinVerbruik, $this->sql);
		$this->sql = str_replace("%H", $vo->AansluitingType, $this->sql);
		$this->sql = str_replace("%I", $vo->ContractWaarde, $this->sql);
		$this->sql = str_replace("%J", $vo->InBedrijf, $this->sql);
		$this->sql = str_replace("%K", $vo->RealisatieDatumStart, $this->sql);
		$this->sql = str_replace("%L", $vo->RealisatieDatumEinde, $this->sql);
		$this->sql = str_replace("%M", $vo->BrutoVloerOppervlak, $this->sql);
		$this->sql = str_replace("%N", $vo->EnergieScan, $this->sql);
		$this->sql = str_replace("%O", $vo->EnergieLabel, $this->sql);
		$this->sql = str_replace("%P", $vo->EnergieLabelAfmelding, $this->sql);
		$this->sql = str_replace("%Q", $vo->LED, $this->sql);
		$this->sql = str_replace("%R", $vo->BijzondereAansluiting, $this->sql);
		$this->sql = str_replace("%S", $vo->FiscaalGroepID, $this->sql);
		$this->sql = str_replace("%T", $vo->EnergieBelasting, $this->sql);
		$this->sql = str_replace("%U", $vo->EnergieOpmerkingen, $this->sql);
		$this->sql = str_replace("%V", $vo->GewijzigdDoor, $this->sql);
		$this->sql = str_replace("%W", $vo->GewijzigdOp, $this->sql);

		$this->exec($this->sql);
		return $this->affectedRows();
	}

	// update a record from a vo
	function updateVO($vo) {
		$this->sql = $this->SQL_UPDATE;
		$this->sql .= "ProductID = '" . $vo->ProductID . "', ";
		$this->sql .= "StandaardJaarVerbruik = '" . $vo->StandaardJaarVerbruik . "', ";
		$this->sql .= "MeterNummer = '" . $vo->MeterNummer . "', ";
		$this->sql .= "MeterSoort = '" . $vo->MeterSoort . "', ";
		$this->sql .= "MeetdienstContractNummer = '" . $vo->MeetdienstContractNummer . "', ";
		$this->sql .= "GrootKleinVerbruik = '" . $vo->GrootKleinVerbruik . "', ";
		$this->sql .= "AansluitingType = '" . $vo->AansluitingType . "', ";
		$this->sql .= "ContractWaarde = '" . $vo->ContractWaarde . "', ";
		$this->sql .= "InBedrijf = '" . $vo->InBedrijf . "', ";
		$this->sql .= "RealisatieDatumStart = '" . $vo->RealisatieDatumStart . "', ";
		if (empty($vo->RealisatieDatumEinde)) $this->sql .= "RealisatieDatumEinde = NULL, ";
		else $this->sql .= "RealisatieDatumEinde = '" . $vo->RealisatieDatumEinde . "', ";
		$this->sql .= "BrutoVloerOppervlak = '" . $vo->BrutoVloerOppervlak . "', ";
		$this->sql .= "EnergieScan = '" . $vo->EnergieScan . "', ";
		$this->sql .= "EnergieLabel = '" . $vo->EnergieLabel . "', ";
		$this->sql .= "EnergieLabelAfmelding = '" . $vo->EnergieLabelAfmelding . "', ";
		$this->sql .= "LED = '" . $vo->LED . "', ";
		$this->sql .= "BijzondereAansluiting = '" . $vo->BijzondereAansluiting . "', ";
		$this->sql .= "FiscaalGroepID = '" . $vo->FiscaalGroepID . "', ";
		$this->sql .= "EnergieBelasting = '" . $vo->EnergieBelasting . "', ";
		$this->sql .= "EnergieOpmerkingen = '" . $vo->EnergieOpmerkingen . "', ";
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