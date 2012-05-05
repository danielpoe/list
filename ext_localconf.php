<?php
if (!defined('TYPO3_MODE')) {
	die ('Access denied.');
}

$extbaseObjectContainer = t3lib_div::makeInstance('Tx_Extbase_Object_Container_Container'); // Singleton
$extbaseObjectContainer->registerImplementation('Tx_List_Service_ListConfigurationProviderInterface', 'Tx_List_Service_ListConfigurationProvider');
//$extbaseObjectContainer->registerImplementation('Tx_Extbase_Persistence_QuerySettingsInterface', 'Tx_Extbase_Persistence_Typo3QuerySettings');
unset($extbaseObjectContainer);

//Tx_Extbase_Utility_Extension::registerTypeConverter('Tx_List_System_Property_ListItemRequestTypeConverter');


?>