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
 *
 *
 * @package list
 * @license http://www.gnu.org/licenses/gpl.html GNU General Public License, version 3 or later
 *
 */
interface  Tx_List_Service_ListConfigurationProviderInterface  {
	
	
	/**
	 * Gets all list configurations for a given pageNode
	 * @param integer $pageId
	 * @return Tx_List_Core_ListConfiguration[]
	 */
	public function getForPageNode($pageId);
	
	/**
	 * Gets list configurations for a given configurationkey (which can be the recordType for example)
	 * @param integer $pageId
	 * @param string $configurationKey
	 * @throws Tx_List_Service_Exception_NoSuchRecordType
	 * @return Tx_List_Core_ListConfiguration
	 */
	public function getForConfigurationKey($pageId, $configurationKey);

}
?>