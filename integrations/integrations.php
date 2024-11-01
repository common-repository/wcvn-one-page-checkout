<?php

require_once WCVN_OPC_PATH . 'includes/class-onepagecheckout-integrations.php';


// Theme Integrations
require_once WCVN_OPC_PATH . 'integrations/themes/flatsome.php';
new WCVN_OnePageCheckout_Integrations_Flatsome();

require_once WCVN_OPC_PATH . 'integrations/themes/avada.php';
new WCVN_OnePageCheckout_Integrations_Avada();

require_once WCVN_OPC_PATH . 'integrations/themes/electro.php';
new WCVN_OnePageCheckout_Integrations_Electro();
