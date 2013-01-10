<?php

include 'config.inc.php';
include 'functions.inc.php';

include("common/class.uFlex.php"); 
include("authenticate.php"); 

include 'common/common_functions.php';

if ($cfg['enable_debug']) {
  include 'common/array_dump.php';
  include 'common/dBug.php';
}

include 'dao/BaseDAO.php';
include 'model/BaseVO.php';

include 'dao/OrganisatiesDAO.php';
include 'model/OrganisatiesVO.php';

include 'dao/ObjectenBasisDAO.php';
include 'model/ObjectenBasisVO.php';
include 'model/ObjectenBasisVOplus.php';

include 'dao/ObjectenBeheerderDAO.php';
include 'model/ObjectenBeheerderVO.php';

include 'dao/ObjectenEnergieDAO.php';
include 'model/ObjectenEnergieVO.php';

include 'dao/ObjectenAdresDAO.php';
include 'model/ObjectenAdresVO.php';

include 'dao/AdressenDAO.php';
include 'model/AdressenVO.php';

include 'dao/DoelenDAO.php';
include 'model/DoelenVO.php';

include 'dao/LeveranciersDAO.php';
include 'model/LeveranciersVO.php';

include 'dao/NetbeheerdersDAO.php';
include 'model/NetbeheerdersVO.php';

include 'dao/ProductenDAO.php';
include 'model/ProductenVO.php';

include 'dao/FiscaleGroepenDAO.php';
include 'model/FiscaleGroepenVO.php';


include 'parts/html.inc.php';
include 'parts/html_functions.php';



?>