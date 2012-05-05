<?php

/***************************************************************
 *  Copyright notice
 *
 *  (c) 2012 Daniel Pötzinger <dev@aoemedia.de>, AOE media
 *  
 *  All rights reserved
 *
 *  This script is part of the TYPO3 project. The TYPO3 project is
 *  free software; you can redistribute it and/or modify
 *  it under the terms of the GNU General Public License as published by
 *  the Free Software Foundation; either version 3 of the License, or
 *  (at your option) any later version.
 *
 *  The GNU General Public License can be found at
 *  http://www.gnu.org/copyleft/gpl.html.
 *
 *  This script is distributed in the hope that it will be useful,
 *  but WITHOUT ANY WARRANTY; without even the implied warranty of
 *  MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
 *  GNU General Public License for more details.
 *
 *  This copyright notice MUST APPEAR in all copies of the script!
 ***************************************************************/

/**
 * The Main ListConfiguration Provider
 * @todo - concept to register more than the TYPO3 ListConfiguration Provider
 * 
 * @package list
 * @license http://www.gnu.org/licenses/gpl.html GNU General Public License, version 3 or later
 * @author Daniel Pötzinger 
 */
class Tx_List_Service_ListConfigurationProvider implements Tx_List_Service_ListConfigurationProviderInterface {
	
	/**
	 * @var Tx_Extbase_Object_ObjectManager
	 */
	protected $objectManager;
	
	/**
	 * @param Tx_Extbase_Object_ObjectManager $objectManager
	 */
	public function injectObjectManager(Tx_Extbase_Object_ObjectManager $objectManager) {
		$this->objectManager = $objectManager;
	}
	
	/**
	 * Gets all list configurations for a given pageNode
	 * @param integer $pageId
	 * @return Tx_List_Core_ListConfiguration[]
	 */
	public function getForPageNode($pageId) {
		$listConfigurations = array();
		foreach ($this->getAllRegisteredListConfigurationProvider() as $provider) {
			$listConfigurations = array_merge($listConfigurations,$provider->getForPageNode($pageId));
		}
		return $listConfigurations;
	}
	
	/**
	 * Gets list configurations for a given configurationKey
	 * @param integer $pageId
	 * @param string $configurationKey
	 * @return Tx_List_Core_ListConfiguration
	 */
	public function getForConfigurationKey($pageId, $configurationKey) {
		foreach ($this->getAllRegisteredListConfigurationProvider() as $provider) {
			try {
				return $provider->getForConfigurationKey($pageId, $configurationKey);
			}
			catch (Tx_List_Service_Exception_NoSuchRecordType $e) {
				continue;
			}
		}
		throw new Tx_List_Service_Exception_NoSuchRecordType('ListConfiguration for RecordType "'.$configurationKey.'" not found in any registered provider.');
	}
	
	/**
	 * @return Tx_List_Service_ListConfigurationProviderInterface[]
	 */
	protected function getAllRegisteredListConfigurationProvider() {
		return array(
			 $this->objectManager->create('Tx_List_Typo3_ListConfigurationProvider')
		);
	}
	

}
?>