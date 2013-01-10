<?php

require_once 'lib/base.inc.php';

$_page="login";


$text  = "        <p>Welkom op Energie Aansluiting.</p>\n";
// $text .= "        <p>U kunt bovenaan de pagina inloggen.</p>\n";

$text .= "Hier kunt u al uw energieaansluitingen vastleggen in een webbased tool waarmee uw organisatie in een keer een onafhankelijk overzicht opbouwt. U kunt alle informatie kwijt per energieaansluiting wat voor uw organisatie van belang is. ";
$text .= "Wat is het verbruik, wat is de kostenplaats, aanvraagdatum, welke leverancier, EAN-code, wat is het voorschot, factuuradres, locatie op basis van GPS, etc.<br /><br />";
$text .= "Dit biedt vele voordelen ten opzichte van de 'gewone' onhandige Excel lijsten. Met energieaansluiting.nl kunt u eenvoudig rapportages maken en hebben alle medewerkers van uw organisatie toegang tot de informatie. ";
$text .= "Alle afdelingen binnen uw organisatie hebben er voordeel bij: inkoop, uitvoering, energiemanager, milieu, facilitaire dienst en management.<br \><br \>";
$text .= "Aanvragen via info@ecoestate.nl.";

/**** START HTML OUTPUT *****/


html_header_login($_page);
echo $text;
html_footer();


?>
