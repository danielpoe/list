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
 * @package list
 * @license http://www.gnu.org/licenses/gpl.html GNU General Public License, version 3 or later
 * @author Daniel Pötzinger
 */
class Tx_List_Typo3_ListConfigurationProvider implements Tx_List_Service_ListConfigurationProviderInterface {
	
	/**
	 * @var Tx_List_Typo3_ListConfigurationFactory
	 */
	protected $factory;
	
	/**
	 * @param Tx_List_Typo3_ListConfigurationFactory $factory
	 */
	public function injectFactory(Tx_List_Typo3_ListConfigurationFactory $factory) {
		$this->factory = $factory;
	}
	
	/**
	 * Gets all list configurations for a given pageNode
	 * @param integer $pageId
	 * @return Tx_List_Core_ListConfiguration[]
	 */
	public function getForPageNode($pageId) {
		return $this->factory->buildAllForPageNode($pageId);
	}
	
	/**
	 * Gets list configurations for a given recordType
	 * @param integer $pageId
	 * @param string $configurationKey
	 * @throws Tx_List_Service_Exception_NoSuchRecordType
	 * @return Tx_List_Core_ListConfiguration
	 */
	public function getForConfigurationKey($pageId, $configurationKey) {
		if (substr($configurationKey,0,strlen(Tx_List_Typo3_ListConfigurationFactory::CONFIGURATIONKEY_PREFIX)) != Tx_List_Typo3_ListConfigurationFactory::CONFIGURATIONKEY_PREFIX) {
			throw new Tx_List_Service_Exception_NoSuchRecordType('This provider do not support this type');
		}
		try {
			return $this->factory->buildListConfigurationForRecordType(substr($configurationKey,strlen(Tx_List_Typo3_ListConfigurationFactory::CONFIGURATIONKEY_PREFIX)), $pageId);
		}
		catch (Exception $e) {
			throw new Tx_List_Service_Exception_NoSuchRecordType('ListConfiguration for RecordType "'.$recordType.'" not available.');
		}
	}

}
?>