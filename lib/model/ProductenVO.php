<?php

// Producten Value Object
class ProductenVO extends BaseVO {
	var $ProductID;
	var $ProductNaam;
	var $ProductEenheid;

	// create a new VO
	function ProductenVO(
		$ProductID= 0,
		$ProductNaam= "",
		$ProductEenheid= ""
	) {
		$this->ProductID = $ProductID;
		$this->ProductNaam = $ProductNaam;
		$this->ProductEenheid = $ProductEenheid;
	}

	// compare to another VO
	function equals($vo) {
		return $this->ProductID == $vo->ProductID &&
			$this->ProductNaam == $vo->ProductNaam &&
			$this->ProductEenheid == $vo->ProductEenheid;
	}
	// copies another VO
	function copy($vo) {
		$this->ProductID = $vo->ProductID;
		$this->ProductNaam = $vo->ProductNaam;
		$this->ProductEenheid = $vo->ProductEenheid;
	}

	// output as a string
	function toString() {
		return $this->ProductID . "," . $this->ProductNaam . "," . $this->ProductEenheid;
	}

	// output as XML node
	function toXML() {
		return "<row>\n" .
		"<ProductID>$this->ProductID</ProductID>\n" .
		"<ProductNaam>$this->ProductNaam</ProductNaam>\n" .
		"<ProductEenheid>$this->ProductEenheid</ProductEenheid>\n" .
		"</row>\n";
	}

	// read from an html form
	function readForm() {
		$this->ProductID = $this->formHelper("ProductID", 0);
		$this->ProductNaam = $this->formHelper("ProductNaam", "");
		$this->ProductEenheid = $this->formHelper("ProductEenheid", "");
	}

	// read from the query string
	function readQuery() {
		$this->ProductID = $this->queryHelper("ProductID", 0);
		$this->ProductNaam = $this->queryHelper("ProductNaam", "");
		$this->ProductEenheid = $this->queryHelper("ProductEenheid", "");
	}

	// extra functions here
	function getPK() {
		return $this->ProductID;
	}
}

?>