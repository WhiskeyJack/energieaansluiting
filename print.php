<?php
require_once 'lib/base.inc.php';
include 'lib/common/pdf/class.ezpdf.php';

if (isset($_GET['id'])) $_objectid = secure_string($_GET['id']);
elseif (isset($_POST['id'])) $_objectid = secure_string($_POST['id']);
else fatal_error("Er is geen object gespecificeerd.");



// A4
$_cfg['pageWidth'] = 595.28;
$_cfg['pageHeigth'] = 841.89;  



$_fontsdir = 'lib/common/pdf/fonts';
$_cfg['mainFont'] = $_fontsdir .'/Helvetica.afm';
$_cfg['mainFontSize'] = 10;
$_cfg['headerFont'] = $_fontsdir .'/Helvetica.afm';
$_cfg['headerFontSize'] = 15;
$_cfg['footerFont'] = $_fontsdir .'/Helvetica.afm';
$_cfg['footerFontSize'] = 8;


//echo $_cfg['pdfInfo']['CreationDate'];
//exit;
$pdf = new Cezpdf();


// from manual: setup the helvetica font for use with german characters
$diff=array(196=>'Adieresis',228=>'adieresis',214=>'Odieresis',246=>'odieresis',220=>'Udieresis',252=>'udieresis',223=>'germandbls');

$pdf->selectFont($_cfg['mainFont'] ,array('encoding'=>'WinAnsiEncoding','differences'=>$diff));
$_cfg['mainFontSizeHeight'] = $pdf->getFontHeight($_cfg['mainFontSize']);

$pdf->selectFont($_headerFont ,array('encoding'=>'WinAnsiEncoding','differences'=>$diff));
$_cfg['headerFontSizeHeight'] = $pdf->getFontHeight($_cfg['headerFontSize']);


$_cfg['sectionbreakHeight'] = 1.8 * $_cfg['headerFontSizeHeight'];
$_cfg['headerSpaceAfter'] =  2 * $_cfg['mainFontSizeHeight'];
$_cfg['lineSpacing'] = 1.5 * $_cfg['mainFontSizeHeight'];

$_cfg['yPosFooter'] = 40;

$_cfg['offset'] = 40;
$yPos = 800;
$xPosCol1 = 30+$_cfg['offset'];
$xPosCol2 = 120+$_cfg['offset'];
$xPosCol3 = 300+$_cfg['offset'];
$xPosCol4 = 390+$_cfg['offset'];

$_title = "Energie Aansluiting - Object details";
$_titleX = $_cfg['pageWidth']/2 - ($pdf->getTextWidth($_cfg['headerFontSize'], $_title)/2) ;

$dao_obj = new ObjectenBasisDAO();
$vo = $dao_obj->findByPK($_objectid);
if (!$vo) fatal_error("Er is een fout opgetreden bij het ophalen van de object gegevens voor ObjectID $_objectid.");


$org = array('OpNaamVan' => "Op naam van:", 'JuridischEigenaar' => "Juridisch Eigenaar:", 'Gebruiker' => "Gebruiker:", 'BudgetHouder' => "Budgethouder:");
$dao_org = new OrganisatiesDAO();

$_obj_ref = "Object: ". format_EAN($vo->EanCode) . " (" . format_Internal_Code($vo->InterneCodering) . ") - " .$vo->ObjectNaam;
$_updatetime = $vo->GewijzigdOp;
$_cfg['pdfInfo']['Subject'] = 'Object details';

$_cfg['pdfInfo'] = array();
$_cfg['pdfInfo']['Title'] = 'Object details';
$_cfg['pdfInfo']['Subject'] = 'Object details';
$_cfg['pdfInfo']['Author'] = 'Desysion / InThere';
$_cfg['pdfInfo']['Creator'] = 'Energie Aansluiting';
$_cfg['pdfInfo']['CreationDate'] = $date='D:'.date('YmdHis');
$_cfg['pdfInfo']['Subject'] = utf2win1250($_obj_ref);
$pdf->addInfo($_cfg['pdfInfo']);


$pdf->addText($_titleX, $yPos, $_cfg['headerFontSize'], $_title);
$yPos = $yPos - 2*$_cfg['headerFontSizeHeight'];



/*********** Basis gegevens ***********/
 
$pdf->selectFont($_cfg['mainFont'] ,array('encoding'=>'WinAnsiEncoding','differences'=>$diff));
//$text = iconv("UTF-8","Windows-1250","žlutoucký kun")'; //text needs to be in win-150 encoding 

$col1 = array("Omschrijving:", "EAN code:","Interne code:","Eigenaar:", "Doel:", "Bouwjaar:");
$col2 = array($vo->ObjectNaam, format_EAN($vo->EanCode),format_Internal_Code($vo->InterneCodering),$vo->Eigenaar,$vo->DoelOmschrijving,$vo->Bouwjaar);

$pdf->addText($xPosCol1, $yPos, $_cfg['mainFontSize'], "<b>Basis gegevens</b>");
$yPos = $yPos - 2* $_cfg['mainFontSizeHeight'];
$i=0;
$posA = $xPosCol1;
$posB = $xPosCol2;
$yPosSave1 = $yPos;

$maxValWidth = 175;
foreach ($col1 as $key=>$val) {
  if ($i==3) {
  	$yPosSave2 = $yPos;
  	$yPos = $yPosSave1;
  	$posA = $xPosCol3;
		$posB = $xPosCol4;
  }
	$pdf->addText($posA, $yPos, $_cfg['mainFontSize'], $val);
  //$pdf->addText($posB, $yPos, $_cfg['mainFontSize'], utf2win1250($col2[$key]));
  $a = $pdf->addTextWrap($posB, $yPos, $maxValWidth, $_cfg['mainFontSize'], utf2win1250($col2[$key]));
  if (strlen($a)>0) {
    $yPos = $yPos - $_cfg['lineSpacing'];
    $pdf->addTextWrap($posB, $yPos, $maxValWidth, $_cfg['mainFontSize'], $a);
  }
  $yPos = $yPos - $_cfg['lineSpacing'];
  $i++;
}
$yPos = $yPosSave2;
//exit;
$yPos = $yPos +  $_cfg['lineSpacing'] - $_cfg['sectionbreakHeight'];

$count = 0;
foreach($org as $key=>$value) {
	if ( ($count & 1) == 0) {  // print next title row
		$posA = $xPosCol1;
		$posB = $xPosCol2;
		$yPos = $yPos - $_cfg['lineSpacing'];
	} else {
		$yPos = $yPos + 6.5*$_cfg['mainFontSizeHeight'];
		$posA = $xPosCol3;
		$posB = $xPosCol4;
		
	}
		
	$count += 1;
	$vo_array[$vo->$key] = $dao_org->findByPK($vo->$key);
	$pdf->addText($posA, $yPos, $_cfg['mainFontSize'], "<b>$value</b>");
	$yPos = $yPos - $_cfg['headerSpaceAfter'];
	$pdf->addText($posA, $yPos, $_cfg['mainFontSize'], "Naam:");
	$pdf->addTextWrap($posB, $yPos, $maxValWidth, $_cfg['mainFontSize'], utf2win1250($vo_array[$vo->$key]->OrganisatieNaam));
    
	$yPos = $yPos - $_cfg['lineSpacing'];
	$pdf->addText($posA, $yPos, $_cfg['mainFontSize'], "Contactpersoon:");
	$pdf->addTextWrap($posB, $yPos, $maxValWidth, $_cfg['mainFontSize'], utf2win1250($vo_array[$vo->$key]->ContactPersoon));
	$yPos = $yPos - $_cfg['lineSpacing'];	
	$pdf->addText($posA, $yPos, $_cfg['mainFontSize'], "Telefoon:");
	$pdf->addText($posB, $yPos, $_cfg['mainFontSize'], $vo_array[$vo->$key]->Telefoon);
	$yPos = $yPos - $_cfg['lineSpacing'];	
}


/*********** Netbeheer gegevens ***********/

$dao_obj = new ObjectenBeheerderDAO();
$vo = $dao_obj->findByPK($_objectid);


$yPos = $yPos - $_cfg['sectionbreakHeight'];
$yPosSave1 = $yPos;
// Leverancier
  $pdf->addText($xPosCol1, $yPos, $_cfg['mainFontSize'], "<b>Leverancier: " . utf2win1250($vo->LeverancierNaam) . "</b>");
  $yPos = $yPos - $_cfg['headerSpaceAfter'];
	$pdf->addText($xPosCol1, $yPos, $_cfg['mainFontSize'], "EAN leverancier:");
	$pdf->addText($xPosCol2, $yPos, $_cfg['mainFontSize'], format_EAN($vo->LeverancierEAN));
	$yPos = $yPos - $_cfg['lineSpacing'];
	$pdf->addText($xPosCol1, $yPos, $_cfg['mainFontSize'], "Contractnummer:");
	$pdf->addText($xPosCol2, $yPos, $_cfg['mainFontSize'], $vo->ContractNummerLeverancier);
	$yPos = $yPos - $_cfg['lineSpacing'];
	$pdf->addText($xPosCol1, $yPos, $_cfg['mainFontSize'], "Ingangsdatum:");
	$pdf->addText($xPosCol2, $yPos, $_cfg['mainFontSize'], format_mysql_timestamp($vo->IngangsDatumLeverancier, $cfg['format']['strf_time_date_full']) );
	$yPos = $yPos - $_cfg['lineSpacing'];
	$pdf->addText($xPosCol1, $yPos, $_cfg['mainFontSize'], "Type stroom:");
	$pdf->addText($xPosCol2, $yPos, $_cfg['mainFontSize'], $vo->StroomType);
	$yPosSave2 = $yPos;

// Netbeheerder
	$yPos = $yPosSave1;
  $pdf->addText($xPosCol3, $yPos, $_cfg['mainFontSize'], "<b>Netbeheerder: " . utf2win1250($vo->NetbeheerderNaam) . "</b>");
  $yPos = $yPos - $_cfg['headerSpaceAfter'];
	$pdf->addText($xPosCol3, $yPos, $_cfg['mainFontSize'], "EAN netbeheerder:");
	$pdf->addText($xPosCol4, $yPos, $_cfg['mainFontSize'], format_EAN($vo->NetbeheerderEAN));
	$yPos = $yPos - $_cfg['lineSpacing'];
	$pdf->addText($xPosCol3, $yPos, $_cfg['mainFontSize'], "Contractnummer:");
	$pdf->addText($xPosCol4, $yPos, $_cfg['mainFontSize'], $vo->ContractNummerNetbeheerder);

$yPos = $yPosSave2;
$yPos = $yPos - $_cfg['sectionbreakHeight'];	


/*********** Energie gegevens ***********/
$dao_obj = new ObjectenEnergieDAO();
$vo = $dao_obj->findByPK($_objectid);
$yPos = $yPos - $_cfg['sectionbreakHeight'];

  $pdf->addText($xPosCol1, $yPos, $_cfg['mainFontSize'], "<b>Product: $vo->ProductNaam</b>");
  $yPos = $yPos - $_cfg['headerSpaceAfter'];
	$yPosSave1 = $yPos;
	$off = 25;
	$pdf->addText($xPosCol1, $yPos, $_cfg['mainFontSize'], "Groot/klein verbruik:");
	$pdf->addText($xPosCol2+$off, $yPos, $_cfg['mainFontSize'], $vo->GrootKleinVerbruik);
	$yPos = $yPos - $_cfg['lineSpacing'];
	$pdf->addText($xPosCol1, $yPos, $_cfg['mainFontSize'], "Standaard jaarverbruik:");
	$pdf->addText($xPosCol2+$off, $yPos, $_cfg['mainFontSize'], $vo->StandaardJaarVerbruik. " " . $vo->ProductEenheid);
	$yPos = $yPos - $_cfg['lineSpacing'];
	$pdf->addText($xPosCol1, $yPos, $_cfg['mainFontSize'], "In bedrijf:");
	$pdf->addText($xPosCol2+$off, $yPos, $_cfg['mainFontSize'], $vo->InBedrijf);
	$yPos = $yPos - $_cfg['lineSpacing'];
	$pdf->addText($xPosCol1, $yPos, $_cfg['mainFontSize'], "Realisatie aansluiting:");
	$pdf->addText($xPosCol2+$off, $yPos, $_cfg['mainFontSize'], format_mysql_timestamp($vo->RealisatieDatumStart, $cfg['format']['strf_time_date_full']));
	$yPos = $yPos - $_cfg['lineSpacing'];
	$pdf->addText($xPosCol1, $yPos, $_cfg['mainFontSize'],  "Beëindigd op:");
	$pdf->addText($xPosCol2+$off, $yPos, $_cfg['mainFontSize'], format_mysql_timestamp($vo->RealisatieDatumEinde, $cfg['format']['strf_time_date_full']));
	$yPos = $yPos - 1.5*$_cfg['lineSpacing'];
	$pdf->addText($xPosCol1, $yPos, $_cfg['mainFontSize'],  "Opmerkingen:");
	//$zz = "Contractwaarde moet wellicht verhoogd worden.Contractwaarde moet wellicht verhoogd worden.Contractwaarde moet wellicht verhoogd worden.";
  $maxValWidth = 362;  
  $a = utf2win1250($vo->EnergieOpmerkingen);

	  
  while (strlen($a)>0) {
    $a = $pdf->addTextWrap($xPosCol2+$off, $yPos, $maxValWidth, $_cfg['mainFontSize'], $a);
    $yPos = $yPos - $_cfg['lineSpacing'];
  }
  
	$yPosSave2 = $yPos;
	$yPos = $yPosSave1; 
	$off = 10;
	$pdf->addText($xPosCol3, $yPos, $_cfg['mainFontSize'], "Meternummer:");
	$pdf->addText($xPosCol4+$off, $yPos, $_cfg['mainFontSize'], $vo->MeterNummer);
	$yPos = $yPos - $_cfg['lineSpacing'];
	$pdf->addText($xPosCol3, $yPos, $_cfg['mainFontSize'], "Soort meter:");
	$pdf->addText($xPosCol4+$off, $yPos, $_cfg['mainFontSize'], utf2win1250($vo->MeterSoort));	
	$yPos = $yPos - $_cfg['lineSpacing'];
	$pdf->addText($xPosCol3, $yPos, $_cfg['mainFontSize'], "Meetdienst contract:");
	$pdf->addText($xPosCol4+$off, $yPos, $_cfg['mainFontSize'], $vo->MeetdienstContractNummer );	
	$yPos = $yPos - $_cfg['lineSpacing'];
	$pdf->addText($xPosCol3, $yPos, $_cfg['mainFontSize'], "Contract waarde:");
	$pdf->addText($xPosCol4+$off, $yPos, $_cfg['mainFontSize'], $vo->ContractWaarde . " " . $vo->ProductEenheid);
	$yPos = $yPos - $_cfg['lineSpacing'];
	$pdf->addText($xPosCol3, $yPos, $_cfg['mainFontSize'], "Aansluiting type:");
	$pdf->addText($xPosCol4+$off, $yPos, $_cfg['mainFontSize'], $vo->AansluitingType);		
	
	$yPos = $yPosSave2;
	$yPos = $yPos - 2*$_cfg['lineSpacing'];
	$yPosSave1 = $yPos;
	$off = 25;
  if ($yPos < 83) {
    // next page
    pdfFooter(1,2);
    $pdf->newPage();
    $yPos = 800;
    $pdf->selectFont($_headerFont ,array('encoding'=>'WinAnsiEncoding','differences'=>$diff));
    $pdf->addText($_titleX, $yPos, $_cfg['headerFontSize'], $_title);
    $yPos = $yPos - 2*$_cfg['headerFontSizeHeight'];
    $yPosSave1 = $yPos;
    $pdf->selectFont($_cfg['mainFont'] ,array('encoding'=>'WinAnsiEncoding','differences'=>$diff));
    $curPage = 2;
  }
  
	$pdf->addText($xPosCol1, $yPos, $_cfg['mainFontSize'], "Bruto vloeroppervlak:");
	$pdf->addText($xPosCol2+$off, $yPos, $_cfg['mainFontSize'], $vo->BrutoVloerOppervlak);
	$yPos = $yPos - $_cfg['lineSpacing'];
	$pdf->addText($xPosCol1, $yPos, $_cfg['mainFontSize'], "Energiescan:");
	$pdf->addText($xPosCol2+$off, $yPos, $_cfg['mainFontSize'], $vo->EnergieScan);
	$yPos = $yPos - $_cfg['lineSpacing'];
	$pdf->addText($xPosCol1, $yPos, $_cfg['mainFontSize'], "Label codering:");
	$pdf->addText($xPosCol2+$off, $yPos, $_cfg['mainFontSize'], $vo->EnergieLabel);
	
	$yPosSave2 = $yPos;
	$yPos = $yPosSave1;
	$off = 10;
	$pdf->addText($xPosCol3, $yPos, $_cfg['mainFontSize'], "Label afmelding:");
	$pdf->addText($xPosCol4+$off, $yPos, $_cfg['mainFontSize'], $vo->EnergieLabelAfmelding);
	$yPos = $yPos - $_cfg['lineSpacing'];
	$pdf->addText($xPosCol3, $yPos, $_cfg['mainFontSize'], "LED:");
	$pdf->addText($xPosCol4+$off, $yPos, $_cfg['mainFontSize'], $vo->LED);	

	$yPos = $yPosSave2;
	$yPos = $yPos - 2*$_cfg['lineSpacing'];
	$yPosSave1 = $yPos;
	$off = 25;

    if ($yPos < 66) {
    // next page
    pdfFooter(1,2);
    $pdf->newPage();
    $yPos = 800;
    $pdf->selectFont($_headerFont ,array('encoding'=>'WinAnsiEncoding','differences'=>$diff));
    $pdf->addText($_titleX, $yPos, $_cfg['headerFontSize'], $_title);
    $yPos = $yPos - 2*$_cfg['headerFontSizeHeight'];
    $yPosSave1 = $yPos;
    $pdf->selectFont($_cfg['mainFont'] ,array('encoding'=>'WinAnsiEncoding','differences'=>$diff));
    $curPage = 2;
  }
  
	$pdf->addText($xPosCol1, $yPos, $_cfg['mainFontSize'], "Bijzondere aansluiting:");
	$pdf->addText($xPosCol2+$off, $yPos, $_cfg['mainFontSize'], $vo->BijzondereAansluiting);
	$yPos = $yPos - $_cfg['lineSpacing'];
	$pdf->addText($xPosCol1, $yPos, $_cfg['mainFontSize'], "Fiscale groep:");
	$pdf->addText($xPosCol2+$off, $yPos, $_cfg['mainFontSize'], $vo->FiscaalGroupType);

		$yPosSave2 = $yPos;
	$yPos = $yPosSave1;
	$off = 10;
	$pdf->addText($xPosCol3, $yPos, $_cfg['mainFontSize'], "Energie belasting:");
	$pdf->addText($xPosCol4+$off, $yPos, $_cfg['mainFontSize'], $vo->EnergieBelasting);

	$yPos = $yPosSave2;
	$yPos = $yPos - 2*$_cfg['lineSpacing'];
	$yPosSave1 = $yPos;

  
/*********** Adres gegevens (New page) ***********/

if ($curPage != 2) {
  pdfFooter(1,2);
  $pdf->newPage();
  $yPos = 800;
  $pdf->selectFont($_headerFont ,array('encoding'=>'WinAnsiEncoding','differences'=>$diff));
  $pdf->addText($_titleX, $yPos, $_cfg['headerFontSize'], $_title);
  $yPos = $yPos - 2*$_cfg['headerFontSizeHeight'];
  $pdf->selectFont($_cfg['mainFont'] ,array('encoding'=>'WinAnsiEncoding','differences'=>$diff));
}

unset($vo_array);

$adr = array('ObjectAdres' => "Adres object:", 'AansluitRegisterAdres' => "Aansluitregister:", 'FactuurAdres' => "Facturatie adres:");
$dao_adr = new AdressenDAO();

$dao_obj = new ObjectenAdresDAO();
$vo = $dao_obj->findByPK($_objectid);

$count = 0;
foreach($adr as $key=>$value) {
	

	$count=2;
	if ( ($count & 1) == 0) {  // print next title row
		$posA = $xPosCol1;
		$posB = $xPosCol2;
		$yPos = $yPos - $_cfg['lineSpacing'];
	} else {
		$yPos = $yPos + 6.5*$_cfg['mainFontSizeHeight'];
		$posA = $xPosCol3;
		$posB = $xPosCol4;
		
	}		
	$count += 1;
	
	$vo_array[$vo->$key] = $dao_adr->findByPK($vo->$key);

	$pdf->addText($posA, $yPos, $_cfg['mainFontSize'], "<b>$value</b>");
	$yPos = $yPos - $_cfg['headerSpaceAfter'];
	if ($key == "AansluitRegisterAdres" && $vo->AansluitRegisterAdres == $vo->ObjectAdres) {
		$pdf->addText($posA, $yPos, $_cfg['mainFontSize'], "Zelfde als het object adres.");
			$yPos = $yPos - $_cfg['lineSpacing'];
	} elseif ($key == "FactuurAdres" && $vo->AansluitRegisterAdres == $vo->ObjectAdres && empty($vo_array[$vo->$key]->AdresRegel1)) {
		$pdf->addText($posA, $yPos, $_cfg['mainFontSize'], "Zelfde als het object adres.");
			$yPos = $yPos - $_cfg['lineSpacing'];
	} else {
		if (!empty($vo_array[$vo->$key]->AdresRegel1)) {
			$pdf->addText($posA, $yPos, $_cfg['mainFontSize'], utf2win1250($vo_array[$vo->$key]->AdresRegel1));
				$yPos = $yPos - $_cfg['lineSpacing'];
		}
		$pdf->addText($posA, $yPos, $_cfg['mainFontSize'], utf2win1250($vo_array[$vo->$key]->StraatNaam . " " . $vo_array[$vo->$key]->Huisnummer . " " . $vo_array[$vo->$key]->HuisnummerToevoeging));
			$yPos = $yPos - $_cfg['lineSpacing'];
		$pdf->addText($posA, $yPos, $_cfg['mainFontSize'], utf2win1250($vo_array[$vo->$key]->Postcode));
			$yPos = $yPos - $_cfg['lineSpacing'];
		$pdf->addText($posA, $yPos, $_cfg['mainFontSize'], utf2win1250($vo_array[$vo->$key]->Plaats));
			$yPos = $yPos - $_cfg['lineSpacing'];
	}
}





/*********** Footer ***********/
pdfFooter(2,2);

$pdf->ezStream();





function pdfFooter($page,$pages) {	
	global $pdf;
  global $_cfg;
  /*********** Footer ***********/
  $pdf->setLineStyle(0.3);
  $pdf->line(15,$_cfg['yPosFooter'],$_cfg['pageWidth']-15,$_cfg['yPosFooter']);	
  $pdf->selectFont($_cfg['footerFont'] ,array('encoding'=>'WinAnsiEncoding','differences'=>$diff));
  $_cfg['footerFontSizeHeight'] = $pdf->getFontHeight($_cfg['footerFontSize']);
  $pdf->addText(25, $_cfg['yPosFooter']-$_cfg['lineSpacing'], $_cfg['footerFontSize'], "Print datum: " .format_mysql_timestamp());
  $_footX = $_cfg['pageWidth']/2 - ($pdf->getTextWidth($_cfg['footerFontSize'], "pagina $page van $pages")/2);
  $pdf->addText($_footX, $_cfg['yPosFooter']-$_cfg['lineSpacing'], $_cfg['footerFontSize'], "pagina $page van $pages");
  $pdf->addText(500, $_cfg['yPosFooter']-$_cfg['lineSpacing'], $_cfg['footerFontSize'], "Desysion / InThere");
}






//new dBug($data)
?>