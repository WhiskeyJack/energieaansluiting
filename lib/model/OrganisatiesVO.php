<?php

// organisaties Value Object
class OrganisatiesVO extends BaseVO {
	var $OrganisatieID;
	var $OrganisatieNaam;
	var $OrgansatieAfkorting;
	var $ContactPersoon;
	var $Telefoon;
	var $AdresRegel1;
	var $StraatNaam;
	var $Huisnummer;
	var $HuisnummerToevoeging;
	var $Postcode;
	var $Plaats;
	var $Land;

	// create a new VO
	function organisatiesVO(
		$OrganisatieID= 0,
		$OrganisatieNaam= "",
		$OrgansatieAfkorting= "",
		$ContactPersoon= 0,
		$Telefoon= 0,
		$AdresRegel1= 0,
		$StraatNaam= "",
		$Huisnummer= 0,
		$HuisnummerToevoeging= "",
		$Postcode= "",
		$Plaats= "",
		$Land= 0
	) {
		$this->OrganisatieID = $OrganisatieID;
		$this->OrganisatieNaam = $OrganisatieNaam;
		$this->OrgansatieAfkorting = $OrgansatieAfkorting;
		$this->ContactPersoon = $ContactPersoon;
		$this->Telefoon = $Telefoon;
		$this->AdresRegel1 = $AdresRegel1;
		$this->StraatNaam = $StraatNaam;
		$this->Huisnummer = $Huisnummer;
		$this->HuisnummerToevoeging = $HuisnummerToevoeging;
		$this->Postcode = $Postcode;
		$this->Plaats = $Plaats;
		$this->Land = $Land;
	}

	// compare to another VO
	function equals($vo) {
		return $this->OrganisatieID == $vo->OrganisatieID &&
			$this->OrganisatieNaam == $vo->OrganisatieNaam &&
			$this->OrgansatieAfkorting == $vo->OrgansatieAfkorting &&
			$this->ContactPersoon == $vo->ContactPersoon &&
			$this->Telefoon == $vo->Telefoon &&
			$this->AdresRegel1 == $vo->AdresRegel1 &&
			$this->StraatNaam == $vo->StraatNaam &&
			$this->Huisnummer == $vo->Huisnummer &&
			$this->HuisnummerToevoeging == $vo->HuisnummerToevoeging &&
			$this->Postcode == $vo->Postcode &&
			$this->Plaats == $vo->Plaats &&
			$this->Land == $vo->Land;
	}
	// copies another VO
	function copy($vo) {
		$this->OrganisatieID = $vo->OrganisatieID;
		$this->OrganisatieNaam = $vo->OrganisatieNaam;
		$this->OrgansatieAfkorting = $vo->OrgansatieAfkorting;
		$this->ContactPersoon = $vo->ContactPersoon;
		$this->Telefoon = $vo->Telefoon;
		$this->AdresRegel1 = $vo->AdresRegel1;
		$this->StraatNaam = $vo->StraatNaam;
		$this->Huisnummer = $vo->Huisnummer;
		$this->HuisnummerToevoeging = $vo->HuisnummerToevoeging;
		$this->Postcode = $vo->Postcode;
		$this->Plaats = $vo->Plaats;
		$this->Land = $vo->Land;
	}

	// output as a string
	function toString() {
		return $this->OrganisatieID . "," . $this->OrganisatieNaam . "," . $this->OrgansatieAfkorting . "," . $this->ContactPersoon . "," . $this->Telefoon . "," . $this->AdresRegel1 . "," . $this->StraatNaam . "," . $this->Huisnummer . "," . $this->HuisnummerToevoeging . "," . $this->Postcode . "," . $this->Plaats . "," . $this->Land;
	}

	// output as XML node
	function toXML() {
		return "<row>\n" .
		"<OrganisatieID>$this->OrganisatieID</OrganisatieID>\n" .
		"<OrganisatieNaam>$this->OrganisatieNaam</OrganisatieNaam>\n" .
		"<OrgansatieAfkorting>$this->OrgansatieAfkorting</OrgansatieAfkorting>\n" .
		"<ContactPersoon>$this->ContactPersoon</ContactPersoon>\n" .
		"<Telefoon>$this->Telefoon</Telefoon>\n" .
		"<AdresRegel1>$this->AdresRegel1</AdresRegel1>\n" .
		"<StraatNaam>$this->StraatNaam</StraatNaam>\n" .
		"<Huisnummer>$this->Huisnummer</Huisnummer>\n" .
		"<HuisnummerToevoeging>$this->HuisnummerToevoeging</HuisnummerToevoeging>\n" .
		"<Postcode>$this->Postcode</Postcode>\n" .
		"<Plaats>$this->Plaats</Plaats>\n" .
		"<Land>$this->Land</Land>\n" .
		"</row>\n";
	}

	// read from an html form
	function readForm() {
		$this->OrganisatieID = $this->formHelper("OrganisatieID", 0);
		$this->OrganisatieNaam = $this->formHelper("OrganisatieNaam", "");
		$this->OrgansatieAfkorting = $this->formHelper("OrgansatieAfkorting", "");
		$this->ContactPersoon = $this->formHelper("ContactPersoon", 0);
		$this->Telefoon = $this->formHelper("Telefoon", 0);
		$this->AdresRegel1 = $this->formHelper("AdresRegel1", 0);
		$this->StraatNaam = $this->formHelper("StraatNaam", "");
		$this->Huisnummer = $this->formHelper("Huisnummer", 0);
		$this->HuisnummerToevoeging = $this->formHelper("HuisnummerToevoeging", "");
		$this->Postcode = $this->formHelper("Postcode", "");
		$this->Plaats = $this->formHelper("Plaats", "");
		$this->Land = $this->formHelper("Land", 0);
	}

	// read from the query string
	function readQuery() {
		$this->OrganisatieID = $this->queryHelper("OrganisatieID", 0);
		$this->OrganisatieNaam = $this->queryHelper("OrganisatieNaam", "");
		$this->OrgansatieAfkorting = $this->queryHelper("OrgansatieAfkorting", "");
		$this->ContactPersoon = $this->queryHelper("ContactPersoon", 0);
		$this->Telefoon = $this->queryHelper("Telefoon", 0);
		$this->AdresRegel1 = $this->queryHelper("AdresRegel1", 0);
		$this->StraatNaam = $this->queryHelper("StraatNaam", "");
		$this->Huisnummer = $this->queryHelper("Huisnummer", 0);
		$this->HuisnummerToevoeging = $this->queryHelper("HuisnummerToevoeging", "");
		$this->Postcode = $this->queryHelper("Postcode", "");
		$this->Plaats = $this->queryHelper("Plaats", "");
		$this->Land = $this->queryHelper("Land", 0);
	}

	// extra functions here
	function getPK() {
		return $this->OrganisatieID;
	}
  
  function sort($order="asc") {
  new dBug($this);
  }

}