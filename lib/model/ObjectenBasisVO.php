<?php

// ObjectBasis Value Object
class ObjectenBasisVO extends BaseVO {
	var $ObjectID;
	var $EanCode;
	var $ObjectNaam;
	var $InterneCodering;
	var $OpNaamVan;
	var $Eigenaar;
	var $JuridischEigenaar;
	var $Gebruiker;
	var $BudgetHouder;
	var $DoelID;
	var $Bouwjaar;
	var $GewijzigdDoor;
	var $GewijzigdOp;
	var $DoelOmschrijving;

	// create a new VO
	function ObjectenBasisVO(
		$ObjectID= 0,
		$EanCode= "",
		$ObjectNaam= 0,
		$InterneCodering= "",
		$OpNaamVan= 0,
		$Eigenaar= 0,
		$JuridischEigenaar= 0,
		$Gebruiker= 0,
		$BudgetHouder= 0,
		$DoelID= 0,
		$Bouwjaar= 0,
		$GewijzigdDoor= 0,
		$GewijzigdOp= "",
		$DoelOmschrijving = ""
	) {
		$this->ObjectID = $ObjectID;
		$this->EanCode = $EanCode;
		$this->ObjectNaam = $ObjectNaam;
		$this->InterneCodering = $InterneCodering;
		$this->OpNaamVan = $OpNaamVan;
		$this->Eigenaar = $Eigenaar;
		$this->JuridischEigenaar = $JuridischEigenaar;
		$this->Gebruiker = $Gebruiker;
		$this->BudgetHouder = $BudgetHouder;
		$this->DoelID = $DoelID;
		if (is_null($Bouwjaar)) $this->Bouwjaar = "onbekend";
		else $this->Bouwjaar = $Bouwjaar;
		$this->GewijzigdDoor = $GewijzigdDoor;
		$this->GewijzigdOp = $GewijzigdOp;
		$this->DoelOmschrijving = $DoelOmschrijving;
	}

	// compare to another VO
	function equals($vo) {
		return $this->ObjectID == $vo->ObjectID &&
			$this->EanCode == $vo->EanCode &&
			$this->ObjectNaam == $vo->ObjectNaam &&
			$this->InterneCodering == $vo->InterneCodering &&
			$this->OpNaamVan == $vo->OpNaamVan &&
			$this->Eigenaar == $vo->Eigenaar &&
			$this->JuridischEigenaar == $vo->JuridischEigenaar &&
			$this->Gebruiker == $vo->Gebruiker &&
			$this->BudgetHouder == $vo->BudgetHouder &&
			$this->DoelID == $vo->DoelID &&
			$this->Bouwjaar == $vo->Bouwjaar &&
			$this->GewijzigdDoor == $vo->GewijzigdDoor &&
			$this->GewijzigdOp == $vo->GewijzigdOp;
	}
	// copies another VO
	function copy($vo) {
		$this->ObjectID = $vo->ObjectID;
		$this->EanCode = $vo->EanCode;
		$this->ObjectNaam = $vo->ObjectNaam;
		$this->InterneCodering = $vo->InterneCodering;
		$this->OpNaamVan = $vo->OpNaamVan;
		$this->Eigenaar = $vo->Eigenaar;
		$this->JuridischEigenaar = $vo->JuridischEigenaar;
		$this->Gebruiker = $vo->Gebruiker;
		$this->BudgetHouder = $vo->BudgetHouder;
		$this->DoelID = $vo->DoelID;
		$this->Bouwjaar = $vo->Bouwjaar;
		$this->GewijzigdDoor = $vo->GewijzigdDoor;
		$this->GewijzigdOp = $vo->GewijzigdOp;
	}


	// output as a string
	function toString() {
		return "ObjectID: " . $this->ObjectID . ",\nEANcode: " . $this->EanCode . ",\nObjectNaam: " . $this->ObjectNaam . ",\nInterneCodering: " . $this->InterneCodering . ",\nOpNaamVan: " . $this->OpNaamVan . ",\nEigenaar: " . $this->Eigenaar . ",\nJuridisch Eigenaar ID: " . $this->JuridischEigenaar . ",\nGebruikerID: " . $this->Gebruiker . ",\nBudgetHouderID: " . $this->BudgetHouder . ",\nDoelID: " . $this->DoelID . ",\nBouwjaar: " . $this->Bouwjaar . ",\nDoelOmschrijving: " . $this->DoelOmschrijving . "\nGewijzigdDoorID: " . $this->GewijzigdDoor . ",\nGewijzigdOp: " . $this->GewijzigdOp . "\n";
	}

	// output as XML node
	function toXML() {
		return "<row>\n" .
		"<ObjectID>$this->ObjectID</ObjectID>\n" .
		"<EanCode>$this->EanCode</EanCode>\n" .
		"<ObjectNaam>$this->ObjectNaam</ObjectNaam>\n" .
		"<InterneCodering>$this->InterneCodering</InterneCodering>\n" .
		"<OpNaamVan>$this->OpNaamVan</OpNaamVan>\n" .
		"<Eigenaar>$this->Eigenaar</Eigenaar>\n" .
		"<JuridischEigenaar>$this->JuridischEigenaar</JuridischEigenaar>\n" .
		"<Gebruiker>$this->Gebruiker</Gebruiker>\n" .
		"<BudgetHouder>$this->BudgetHouder</BudgetHouder>\n" .
		"<DoelID>$this->DoelID</DoelID>\n" .
		"<Bouwjaar>$this->Bouwjaar</Bouwjaar>\n" .
		"<GewijzigdDoor>$this->GewijzigdDoor</GewijzigdDoor>\n" .
		"<GewijzigdOp>$this->GewijzigdOp</GewijzigdOp>\n" .
		"</row>\n";
	}

	// read from an html form
	function readForm() {
		$this->ObjectID = $this->formHelper("ObjectID", 0);
		$this->EanCode = $this->formHelper("EanCode", "");
		$this->ObjectNaam = $this->formHelper("ObjectNaam", 0);
		$this->InterneCodering = $this->formHelper("InterneCodering", "");
		$this->OpNaamVan = $this->formHelper("OpNaamVan", 0);
		$this->Eigenaar = $this->formHelper("Eigenaar", 0);
		$this->JuridischEigenaar = $this->formHelper("JuridischEigenaar", 0);
		$this->Gebruiker = $this->formHelper("Gebruiker", 0);
		$this->BudgetHouder = $this->formHelper("BudgetHouder", 0);
		$this->DoelID = $this->formHelper("DoelID", 0);
		$this->Bouwjaar = $this->formHelper("Bouwjaar", 0);
		$this->GewijzigdDoor = $this->formHelper("GewijzigdDoor", 0);
		$this->GewijzigdOp = $this->formHelper("GewijzigdOp", "");
	}

	// read from the query string
	function readQuery() {
		$this->ObjectID = $this->queryHelper("ObjectID", 0);
		$this->EanCode = $this->queryHelper("EanCode", "");
		$this->ObjectNaam = $this->queryHelper("ObjectNaam", 0);
		$this->InterneCodering = $this->queryHelper("InterneCodering", "");
		$this->OpNaamVan = $this->queryHelper("OpNaamVan", 0);
		$this->Eigenaar = $this->queryHelper("Eigenaar", 0);
		$this->JuridischEigenaar = $this->queryHelper("JuridischEigenaar", 0);
		$this->Gebruiker = $this->queryHelper("Gebruiker", 0);
		$this->BudgetHouder = $this->queryHelper("BudgetHouder", 0);
		$this->DoelID = $this->queryHelper("DoelID", 0);
		$this->Bouwjaar = $this->queryHelper("Bouwjaar", 0);
		$this->GewijzigdDoor = $this->queryHelper("GewijzigdDoor", 0);
		$this->GewijzigdOp = $this->queryHelper("GewijzigdOp", "");
	}

	// extra functions here
	function getPK() {
		return $this->ObjectID;
	}
	
	function validate_fields() {
		global $cfg;
		// check validity of all the VO fields
		// ObjectID must be an integer
		if (!(ereg("^[0-9]+$", $this->ObjectID))) $errors["ObjectID"] = "Object ID is niet correct";
		// EanCode must be 18 long and integer
		if (strlen($this->EanCode) !=18 || !(ereg("^[0-9]+$", $this->EanCode) )) $errors["EanCode"] = "EAN code is niet correct"; 
		// ObjectNaam must be < 250 characters and not empty 
		if (strlen($this->ObjectNaam) > 250 || $this->ObjectNaam == "") $errors["ObjectNaam"] = "Omschrijving is niet correct";
		// InterneCodering must be < 10 characters and not empty
		if (strlen($this->InterneCodering) > 250 || $this->InterneCodering == "") $errors["InterneCodering"] = "Interne codering is niet correct";
		// OpNaamVan must be an integer
		if (!(ereg("^[0-9]+$", $this->OpNaamVan))) $errors["OpNaamVan"] = "Op naam van organisatie is niet correct";
		// Eigenaar must be an array key
		if (!array_key_exists($this->Eigenaar,$cfg['values']['eigenaar'])) $errors["Eigenaar"] = "Eigenaar is niet correct";
		// JuridischEigenaar must be an integer
		if (!(ereg("^[0-9]+$", $this->JuridischEigenaar))) $errors["JuridischEigenaar"] = "Juridisch Eigenaar organisatie is niet correct";
		// Gebruiker must be an integer
		if (!(ereg("^[0-9]+$", $this->Gebruiker))) $errors["Gebruiker"] = "Gebruiker organisatie is niet correct";
		// BudgetHouder must be an integer
		if (!(ereg("^[0-9]+$", $this->BudgetHouder))) $errors["BudgetHouder"] = "BudgetHouder organisatie is niet correct";
		// DoelID must be an integer
		if (!(ereg("^[0-9]+$", $this->DoelID))) $errors["DoelID"] = "Doel is niet correct";		
		// Bouwjaar must be integer between 1800 and 2050 or "onbekend"
		if ( (!(ereg("^[0-9]+$", $this->Bouwjaar)) && $this->Bouwjaar != "onbekend") 
				|| ( ereg("^[0-9]+$", $this->Bouwjaar) && ($this->Bouwjaar < 1800 || $this->Bouwjaar > 2050 ))) $errors["Bouwjaar"] = "Bouwjaar is niet correct";		
		// GewijzigdDoor must be an integer
		if (!(ereg("^[0-9]+$", $this->GewijzigdDoor))) $errors["GewijzigdDoor"] = "Gebruiker die wijzigt is niet correct";		
		// GewijzigdOp is inserted at time of query
	
	return($errors);
	}
	

}