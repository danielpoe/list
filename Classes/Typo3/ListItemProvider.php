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
class Tx_List_Typo3_ListItemProvider implements Tx_List_Core_ListItemProviderInterface  {
	
	/**
	 * @var integer
	 */
	protected $pageId;
	
	/**
	 * @var Tx_List_System_Typo3_RecordTypeProperties
	 */
	protected $recordProperties;
	
	/**
	 * @var Tx_List_System_Typo3_Persitence_DbBackend
	 */
	protected $persitenceBackend;
	
	/**
	 * @var Tx_Extbase_Object_ObjectManager
	 */
	protected $objectManager;
	
	public function __construct($table, $pageId, Tx_Extbase_Object_ObjectManager $objectManager) {
		if (!is_numeric($pageId)) {
			throw new InvalidArgumentException('No pageId given for Provider');
		}
		if (empty($table)) {
			throw new InvalidArgumentException('No table given for Provider');
		}
		$this->pageId = $pageId;
		$this->objectManager = $objectManager;
		$this->recordProperties = $this->objectManager->create('Tx_List_System_Typo3_RecordTypeProperties', $table);
	}
	
	/**
	 * @param Tx_List_System_Typo3_Persitence_DbBackend $persitenceBackend
	 */
	public function injectPersitenceBackend(Tx_List_System_Typo3_Persitence_DbBackend $persitenceBackend) {
		$this->persitenceBackend = $persitenceBackend;	
	}
	
	/**
	 * @param Tx_List_Core_ListItemRequest $request
	 * @param integer $offset
	 * @param integer $limit
	 */
	public function getListItems(Tx_List_Core_ListItemRequest $request, $offset = 0,$limit = 20) {		
		$query = $this->createQuery();
		$query->setOffset($offset);
		$query->setLimit($limit);
		return $this->persitenceBackend->getObjectDataByQuery($query);
	}
	
	/**
	 * @return Tx_List_System_Typo3_Persitence_Query
	 */
	protected function createQuery() {		
		$query = $this->objectManager->create('Tx_List_System_Typo3_Persitence_Query', $this->recordProperties->getTable());
		$querySettings = $this->objectManager->create('Tx_Extbase_Persistence_QuerySettingsInterface');
		$querySettings->setStoragePageIds(array($this->getPageId()));
		$querySettings->setRespectEnableFields(FALSE);
		$query->setQuerySettings($querySettings);		

		if ( ($deleteColumn = $this->recordProperties->getDeleteColumnName()) !== FALSE ) {
			$query->matching($query->equals($deleteColumn, 0));
		}
		return $query;
	}
	
	/**
	 * @return the $pageId
	 */
	public function getPageId() {
		return $this->pageId;
	}
}
?>