<?php
require_once '../lib/base.inc.php';


$q=$_GET["q"];

if (isset($q)) {
	$dao_org = new OrganisatiesDAO();
	//$vo_org = $dao_org->findWhere("OrganisatieID=$q");
  $vo_org = $dao_org->findByPK($q);
  
} else $vo_org = false;

	
	$buf = "";

	$_n = 8;
	if ($vo_org) {
      if ($vo_org->OrganisatieID == 0) {
        $buf = "<table class=\"table_org_details\">\n";
        $buf .= "<tr>";
        $buf .= "<td class=\"td_org_subtitle\">Onbekend.</td>\n";
        $buf .= "<td class=\"td_org\"></td>\n";
        $buf .= "</tr>\n";
        $buf .= "<tr>\n";
        $buf .= "<td class=\"td_org_subtitle\"></td>\n";
        $buf .= "<td class=\"td_org\"></td>\n";
        $buf .= "</tr>\n";
        $buf .= "<tr>\n";
        $buf .= "<td class=\"td_org_subtitle\"></td>\n";
        $buf .= "<td class=\"td_org\"></td>\n";
        $buf .= "</tr>\n</table>";
      } else {
        $buf = "<table class=\"table_org_details\">\n";
        $buf .= "<tr>";
        $buf .= "<td class=\"td_org_subtitle\">Naam:</td>\n";
        $buf .= "<td class=\"td_org\">" . $vo_org->OrganisatieNaam . "</td>\n";
        $buf .= "</tr>\n";
        $buf .= "<tr>\n";
        $buf .= "<td class=\"td_org_subtitle\">Contactpersoon:</td>\n";
        $buf .= "<td class=\"td_org\">" . $vo_org->ContactPersoon . "</td>\n";
        $buf .= "</tr>\n";
        $buf .= "<tr>\n";
        $buf .= "<td class=\"td_org_subtitle\">Telefoon:</td>\n";
        $buf .= "<td class=\"td_org\">" . $vo_org->Telefoon . "</td>\n";
        $buf .= "</tr>\n</table>";
      }

    
	} elseif ($q == -1) {
			// Add organization
			
			$buf = "<table class=\"table_org_details\">\n";
			$buf .= "<tr><td class=\"td_org_subtitle\">Naam:</td><td class=\"td_org\"><input type=\"text\" size=\"25\" maxlength=\"50\" value =\"\" /></td></tr>";
			//$buf .= "<tr><td class=\"td_org_title\">Afkorting:</td><td class=\"td_org\"><input type=\"text\" size=\"20\" maxlength=\"50\" value =\"\" /></td></tr>";
			$buf .= "<tr><td class=\"td_org_subtitle\">Contactpersoon:</td><td class=\"td_org\"><input type=\"text\" size=\"25\" maxlength=\"50\" value =\"\" /></td></tr>";
			$buf .= "<tr><td class=\"td_org_subtitle\">Telefoon:</td><td class=\"td_org\"><input type=\"text\" size=\"25\" maxlength=\"50\" value =\"\" /></td></tr>";
			$buf .= "</table>";
	} elseif ($q == -2) {
			// Same as 'op naam van'
			$buf = "<table class=\"table_org_details\">\n";
			$buf .= "<tr><td class=\"td_org_colspan\">Zelfde als 'Op naam van'</td></tr>";
			$buf .= "</table>";
	} elseif ($q == -3) {
			// Same as 'eigenaar'
		  $buf = "<table id=\"table_org_details\">\n";
			$buf .= "<tr><td class=\"td_org_colspan\">Zelfde als 'Eigenaar'</td></tr>";
			$buf .= "</table>";
	}
	
	echo $buf;