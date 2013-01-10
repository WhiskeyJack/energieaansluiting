<?php

// ObjectenEnergie Value Object
class ObjectenEnergieVO extends BaseVO {
	var $ObjectID;
	var $ProductID;
	var $StandaardJaarVerbruik;
	var $MeterNummer;
	var $MeterSoort;
	var $MeetdienstContractNummer;
	var $GrootKleinVerbruik;
	var $AansluitingType;
	var $ContractWaarde;
	var $InBedrijf;
	var $RealisatieDatumStart;
	var $RealisatieDatumEinde;
	var $BrutoVloerOppervlak;
	var $EnergieScan;
	var $EnergieLabel;
	var $EnergieLabelAfmelding;
	var $LED;
	var $BijzondereAansluiting;
	var $FiscaalGroepID;
	var $EnergieBelasting;
	var $EnergieOpmerkingen;
	var $GewijzigdDoor;
	var $GewijzigdOp;
  var $EanCode;
	var $InterneCodering;
	var $ObjectNaam;
  var $FiscaalGroupType;
	var $ProductNaam;
	var $ProductEenheid;

	// create a new VO
	function ObjectenEnergieVO(
		$ObjectID= 0,
		$ProductID= 0,
		$StandaardJaarVerbruik= 0,
		$MeterNummer= 0,
		$MeterSoort= "",
		$MeetdienstContractNummer= 0,
		$GrootKleinVerbruik= 0,
		$AansluitingType= "",
		$ContractWaarde= 0,
		$InBedrijf= 0,
		$RealisatieDatumStart= "",
		$RealisatieDatumEinde= "",
		$BrutoVloerOppervlak= 0,
		$EnergieScan= 0,
		$EnergieLabel= 0,
		$EnergieLabelAfmelding= 0,
		$LED= 0,
		$BijzondereAansluiting= 0,
		$FiscaalGroepID= 0,
		$EnergieBelasting= 0,
		$EnergieOpmerkingen= "",
		$GewijzigdDoor= 0,
		$GewijzigdOp= "",
    $EanCode= "",
    $InterneCodering= "",
    $ObjectNaam= "",
    $FiscaalGroupType = "",
    $ProductNaam = "",
    $ProductEenheid = ""
	) {
		$this->ObjectID = $ObjectID;
		$this->ProductID = $ProductID;
		$this->StandaardJaarVerbruik = $StandaardJaarVerbruik;
		$this->MeterNummer = $MeterNummer;
		$this->MeterSoort = $MeterSoort;
		$this->MeetdienstContractNummer = $MeetdienstContractNummer;
		$this->GrootKleinVerbruik = $GrootKleinVerbruik;
		$this->AansluitingType = $AansluitingType;
		$this->ContractWaarde = $ContractWaarde;
		$this->InBedrijf = $InBedrijf;
		$this->RealisatieDatumStart = $RealisatieDatumStart;
		$this->RealisatieDatumEinde = $RealisatieDatumEinde;
		$this->BrutoVloerOppervlak = $BrutoVloerOppervlak;
		$this->EnergieScan = $EnergieScan;
		$this->EnergieLabel = $EnergieLabel;
		$this->EnergieLabelAfmelding = $EnergieLabelAfmelding;
		$this->LED = $LED;
		$this->BijzondereAansluiting = $BijzondereAansluiting;
		$this->FiscaalGroepID = $FiscaalGroepID;
		$this->EnergieBelasting = $EnergieBelasting;
		$this->EnergieOpmerkingen = $EnergieOpmerkingen;
		$this->GewijzigdDoor = $GewijzigdDoor;
		$this->GewijzigdOp = $GewijzigdOp;
    $this->EanCode = $EanCode;
		$this->InterneCodering = $InterneCodering;
		$this->ObjectNaam = $ObjectNaam;
    $this->FiscaalGroupType = $FiscaalGroupType;
    $this->ProductNaam = $ProductNaam;
    $this->ProductEenheid = $ProductEenheid;
	}

	// compare to another VO
	function equals($vo) {
		return $this->ObjectID == $vo->ObjectID &&
			$this->ProductID == $vo->ProductID &&
			$this->StandaardJaarVerbruik == $vo->StandaardJaarVerbruik &&
			$this->MeterNummer == $vo->MeterNummer &&
			$this->MeterSoort == $vo->MeterSoort &&
			$this->MeetdienstContractNummer == $vo->MeetdienstContractNummer &&
			$this->GrootKleinVerbruik == $vo->GrootKleinVerbruik &&
			$this->AansluitingType == $vo->AansluitingType &&
			$this->ContractWaarde == $vo->ContractWaarde &&
			$this->InBedrijf == $vo->InBedrijf &&
			$this->RealisatieDatumStart == $vo->RealisatieDatumStart &&
			$this->RealisatieDatumEinde == $vo->RealisatieDatumEinde &&
			$this->BrutoVloerOppervlak == $vo->BrutoVloerOppervlak &&
			$this->EnergieScan == $vo->EnergieScan &&
			$this->EnergieLabel == $vo->EnergieLabel &&
			$this->EnergieLabelAfmelding == $vo->EnergieLabelAfmelding &&
			$this->LED == $vo->LED &&
			$this->BijzondereAansluiting == $vo->BijzondereAansluiting &&
			$this->FiscaalGroepID == $vo->FiscaalGroepID &&
			$this->EnergieBelasting == $vo->EnergieBelasting &&
			$this->EnergieOpmerkingen == $vo->EnergieOpmerkingen &&
			$this->GewijzigdDoor == $vo->GewijzigdDoor &&
			$this->GewijzigdOp == $vo->GewijzigdOp;
	}
	// copies another VO
	function copy($vo) {
		$this->ObjectID = $vo->ObjectID;
		$this->ProductID = $vo->ProductID;
		$this->StandaardJaarVerbruik = $vo->StandaardJaarVerbruik;
		$this->MeterNummer = $vo->MeterNummer;
		$this->MeterSoort = $vo->MeterSoort;
		$this->MeetdienstContractNummer = $vo->MeetdienstContractNummer;
		$this->GrootKleinVerbruik = $vo->GrootKleinVerbruik;
		$this->AansluitingType = $vo->AansluitingType;
		$this->ContractWaarde = $vo->ContractWaarde;
		$this->InBedrijf = $vo->InBedrijf;
		$this->RealisatieDatumStart = $vo->RealisatieDatumStart;
		$this->RealisatieDatumEinde = $vo->RealisatieDatumEinde;
		$this->BrutoVloerOppervlak = $vo->BrutoVloerOppervlak;
		$this->EnergieScan = $vo->EnergieScan;
		$this->EnergieLabel = $vo->EnergieLabel;
		$this->EnergieLabelAfmelding = $vo->EnergieLabelAfmelding;
		$this->LED = $vo->LED;
		$this->BijzondereAansluiting = $vo->BijzondereAansluiting;
		$this->FiscaalGroepID = $vo->FiscaalGroepID;
		$this->EnergieBelasting = $vo->EnergieBelasting;
		$this->EnergieOpmerkingen = $vo->EnergieOpmerkingen;
		$this->GewijzigdDoor = $vo->GewijzigdDoor;
		$this->GewijzigdOp = $vo->GewijzigdOp;
	}

	// output as a string
	function toString() {
		return "ObjectID: " .$this->ObjectID . "\nProductID: " . $this->ProductID . "\nStandaardJaarVerbruik: " . $this->StandaardJaarVerbruik . "\nMeterNummer: " . $this->MeterNummer . "\nMeterSoort: " . $this->MeterSoort . "\nMeetdienstContractNummer: " . $this->MeetdienstContractNummer . "\nGrootKleinVerbruik: " . $this->GrootKleinVerbruik . "\nAansluitingType: " . $this->AansluitingType . "\nContractWaarde: " . $this->ContractWaarde . "\nInBedrijf: " . $this->InBedrijf . "\nRealisatieDatumStart: " . $this->RealisatieDatumStart . "\nRealisatieDatumEinde: " . $this->RealisatieDatumEinde . "\nBrutoVloerOppervlak: " . $this->BrutoVloerOppervlak . "\nEnergieScan: " . $this->EnergieScan . "\nEnergieLabel: " . $this->EnergieLabel . "\nEnergieLabelAfmelding: " . $this->EnergieLabelAfmelding . "\nLED: " . $this->LED . "\nBijzondereAansluiting: " . $this->BijzondereAansluiting . "\nFiscaalGroepID: " . $this->FiscaalGroepID . "\nEnergieBelasting: " . $this->EnergieBelasting . "\nEnergieOpmerkingen: " . $this->EnergieOpmerkingen . "\nGewijzigdDoor: " . $this->GewijzigdDoor . "\nGewijzigdOp: " . $this->GewijzigdOp . "\nEanCode: " . $this->EanCode . "\nInterneCodering: " . $this->InterneCodering . "\nObjectNaam: " . $this->ObjectNaam . "\nFiscaalGroupType: " . $this->FiscaalGroupType . "\nProductNaam: " . $this->ProductNaam . "\nProductEenheid: " . $this->ProductEenheid;
	}

      
  
	// output as XML node
	function toXML() {
		return "<row>\n" .
		"<ObjectID>$this->ObjectID</ObjectID>\n" .
		"<ProductID>$this->ProductID</ProductID>\n" .
		"<StandaardJaarVerbruik>$this->StandaardJaarVerbruik</StandaardJaarVerbruik>\n" .
		"<MeterNummer>$this->MeterNummer</MeterNummer>\n" .
		"<MeterSoort>$this->MeterSoort</MeterSoort>\n" .
		"<MeetdienstContractNummer>$this->MeetdienstContractNummer</MeetdienstContractNummer>\n" .
		"<GrootKleinVerbruik>$this->GrootKleinVerbruik</GrootKleinVerbruik>\n" .
		"<AansluitingType>$this->AansluitingType</AansluitingType>\n" .
		"<ContractWaarde>$this->ContractWaarde</ContractWaarde>\n" .
		"<InBedrijf>$this->InBedrijf</InBedrijf>\n" .
		"<RealisatieDatumStart>$this->RealisatieDatumStart</RealisatieDatumStart>\n" .
		"<RealisatieDatumEinde>$this->RealisatieDatumEinde</RealisatieDatumEinde>\n" .
		"<BrutoVloerOppervlak>$this->BrutoVloerOppervlak</BrutoVloerOppervlak>\n" .
		"<EnergieScan>$this->EnergieScan</EnergieScan>\n" .
		"<EnergieLabel>$this->EnergieLabel</EnergieLabel>\n" .
		"<EnergieLabelAfmelding>$this->EnergieLabelAfmelding</EnergieLabelAfmelding>\n" .
		"<LED>$this->LED</LED>\n" .
		"<BijzondereAansluiting>$this->BijzondereAansluiting</BijzondereAansluiting>\n" .
		"<FiscaalGroepID>$this->FiscaalGroepID</FiscaalGroepID>\n" .
		"<EnergieBelasting>$this->EnergieBelasting</EnergieBelasting>\n" .
		"<EnergieOpmerkingen>$this->EnergieOpmerkingen</EnergieOpmerkingen>\n" .
		"<GewijzigdDoor>$this->GewijzigdDoor</GewijzigdDoor>\n" .
		"<GewijzigdOp>$this->GewijzigdOp</GewijzigdOp>\n" .
		"</row>\n";
	}

	// read from an html form
	function readForm() {
		$this->ObjectID = $this->formHelper("ObjectID", 0);
		$this->ProductID = $this->formHelper("ProductID", 0);
		$this->StandaardJaarVerbruik = $this->formHelper("StandaardJaarVerbruik", 0);
		$this->MeterNummer = $this->formHelper("MeterNummer", 0);
		$this->MeterSoort = $this->formHelper("MeterSoort", "");
		$this->MeetdienstContractNummer = $this->formHelper("MeetdienstContractNummer", 0);
		$this->GrootKleinVerbruik = $this->formHelper("GrootKleinVerbruik", 0);
		$this->AansluitingType = $this->formHelper("AansluitingType", "");
		$this->ContractWaarde = $this->formHelper("ContractWaarde", 0);
		$this->InBedrijf = $this->formHelper("InBedrijf", 0);
		$this->RealisatieDatumStart = $this->formHelper("RealisatieDatumStart", "");
		$this->RealisatieDatumEinde = $this->formHelper("RealisatieDatumEinde", "");
		$this->BrutoVloerOppervlak = $this->formHelper("BrutoVloerOppervlak", 0);
		$this->EnergieScan = $this->formHelper("EnergieScan", 0);
		$this->EnergieLabel = $this->formHelper("EnergieLabel", 0);
		$this->EnergieLabelAfmelding = $this->formHelper("EnergieLabelAfmelding", 0);
		$this->LED = $this->formHelper("LED", 0);
		$this->BijzondereAansluiting = $this->formHelper("BijzondereAansluiting", 0);
		$this->FiscaalGroepID = $this->formHelper("FiscaalGroepID", 0);
		$this->EnergieBelasting = $this->formHelper("EnergieBelasting", 0);
		$this->EnergieOpmerkingen = $this->formHelper("EnergieOpmerkingen", "");
		$this->GewijzigdDoor = $this->formHelper("GewijzigdDoor", 0);
		$this->GewijzigdOp = $this->formHelper("GewijzigdOp", "");
	}

	// read from the query string
	function readQuery() {
		$this->ObjectID = $this->queryHelper("ObjectID", 0);
		$this->ProductID = $this->queryHelper("ProductID", 0);
		$this->StandaardJaarVerbruik = $this->queryHelper("StandaardJaarVerbruik", 0);
		$this->MeterNummer = $this->queryHelper("MeterNummer", 0);
		$this->MeterSoort = $this->queryHelper("MeterSoort", "");
		$this->MeetdienstContractNummer = $this->queryHelper("MeetdienstContractNummer", 0);
		$this->GrootKleinVerbruik = $this->queryHelper("GrootKleinVerbruik", 0);
		$this->AansluitingType = $this->queryHelper("AansluitingType", "");
		$this->ContractWaarde = $this->queryHelper("ContractWaarde", 0);
		$this->InBedrijf = $this->queryHelper("InBedrijf", 0);
		$this->RealisatieDatumStart = $this->queryHelper("RealisatieDatumStart", "");
		$this->RealisatieDatumEinde = $this->queryHelper("RealisatieDatumEinde", "");
		$this->BrutoVloerOppervlak = $this->queryHelper("BrutoVloerOppervlak", 0);
		$this->EnergieScan = $this->queryHelper("EnergieScan", 0);
		$this->EnergieLabel = $this->queryHelper("EnergieLabel", 0);
		$this->EnergieLabelAfmelding = $this->queryHelper("EnergieLabelAfmelding", 0);
		$this->LED = $this->queryHelper("LED", 0);
		$this->BijzondereAansluiting = $this->queryHelper("BijzondereAansluiting", 0);
		$this->FiscaalGroepID = $this->queryHelper("FiscaalGroepID", 0);
		$this->EnergieBelasting = $this->queryHelper("EnergieBelasting", 0);
		$this->EnergieOpmerkingen = $this->queryHelper("EnergieOpmerkingen", "");
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
		// ProductID must be an integer
		if (!(ereg("^[0-9]+$", $this->ProductID))) $errors["ProductID"] = "Product is niet correct";
		// StandaardJaarVerbruik must be an integer
		if (!(ereg("^[0-9]+$", $this->StandaardJaarVerbruik))) $errors["StandaardJaarVerbruik"] = "Standaard jaarverbruik is niet correct";
		// MeterNummer must be an integer
		if (!(ereg("^[0-9]+$", $this->MeterNummer))) $errors["MeterNummer"] = "Meternummer is niet correct";
 		// MeterSoort must be < 30 characters
		if (strlen($this->MeterSoort) > 30 ) $errors["MeterSoort"] = "Metersoort is niet correct";
 		// MeetdienstContractNummer must be < 30 characters and not empty
		if (strlen($this->MeetdienstContractNummer) > 30 ) $errors["MeetdienstContractNummer"] = "Meetdienst contractnummer is niet correct";
		// GrootKleinVerbruik must be an array key
		if (!array_key_exists($this->GrootKleinVerbruik,$cfg['values']['grootkleinverbruik'])) $errors["GrootKleinVerbruik"] = "Groot/klein verbruik is niet correct";
		// EnergieOpmerkingen must be < 250 characters
		if (strlen($this->EnergieOpmerkingen) > 250 ) $errors["EnergieOpmerkingen"] = "Opmerkingen veld is niet correct";
 		// AansluitingType must be < 9 characters
		if (strlen($this->AansluitingType) > 8 ) $errors["AansluitingType"] = "Aansluiting type is niet correct";
		// ContractWaarde must be an integer
		if (!(ereg("^[0-9]+$", $this->ContractWaarde))) $errors["ContractWaarde"] = "Contractwaarde is niet correct";
		// InBedrijf must be an array key
		if (!array_key_exists($this->InBedrijf,$cfg['values']['inbedrijf'])) $errors["InBedrijf"] = "In bedrijf is niet correct";
		// RealisatieDatumStart must be a valid date (http://php.net/manual/en/function.checkdate.php)
		if  (date('Y-n-j', strtotime($this->RealisatieDatumStart)) != $this->RealisatieDatumStart) $errors["RealisatieDatumStart"] = "Realisatie datum is niet correct";
		// RealisatieDatumEinde must be a valid date (http://php.net/manual/en/function.checkdate.php)
		if  (date('Y-n-j', strtotime($this->RealisatieDatumEinde)) != $this->RealisatieDatumEinde && !empty($this->RealisatieDatumEinde)) $errors["RealisatieDatumEinde"] = "Be&euml;indigingsdatum is niet correct";
    // RealisatieDatumEinde must be after RealisatieDatumStart
    if (strtotime($this->RealisatieDatumEinde) < strtotime($this->RealisatieDatumStart) && !empty($this->RealisatieDatumEinde) ) $errors["RealisatieDatumEinde"] = "Be&euml;indigingsdatum is vroeger dan de realisatie datum";
		// BrutoVloerOppervlak must be an integer
		if (!(ereg("^[0-9]+$", $this->BrutoVloerOppervlak))) $errors["BrutoVloerOppervlak"] = "Bruto vloeroppervlak is niet correct";
		// EnergieScan must be an array key
		if (!array_key_exists($this->EnergieScan,$cfg['values']['energiescan'])) $errors["EnergieScan"] = "Energiescan is niet correct";
		// EnergieLabel must be an array key
		if (!array_key_exists($this->EnergieLabel,$cfg['values']['energielabel'])) $errors["EnergieLabel"] = "Label codering is niet correct";
		// EnergieLabelAfmelding must be an array key
		if (!array_key_exists($this->EnergieLabelAfmelding,$cfg['values']['energielabelafmelding'])) $errors["EnergieLabelAfmelding"] = "Label afmelding is niet correct";
		// LED must be an array key
		if (!array_key_exists($this->LED,$cfg['values']['LED'])) $errors["LED"] = "LED is niet correct";
		// BijzondereAansluiting must be an array key
		if (!array_key_exists($this->BijzondereAansluiting,$cfg['values']['bijzondereaansluiting'])) $errors["BijzondereAansluiting"] = "Bijzondere aansluiting is niet correct";
		// FiscaalGroepID must be an integer
		if (!(ereg("^[0-9]+$", $this->FiscaalGroepID))) $errors["FiscaalGroepID"] = "Fiscale groep is niet correct";
		// EnergieBelasting must be an array key
		if (!array_key_exists($this->EnergieBelasting,$cfg['values']['energiebelasting'])) $errors["EnergieBelasting"] = "Energie belasting is niet correct";
		// GewijzigdDoor must be an integer
		if (!(ereg("^[0-9]+$", $this->GewijzigdDoor))) $errors["GewijzigdDoor"] = "Gebruiker die wijzigt is niet correct";		
		// GewijzigdOp is inserted at time of query
    
  	return($errors);
	}

}

















?>