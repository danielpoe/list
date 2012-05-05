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
 * Factory that has the main logic on how to build ListConfigurations from TCA tables
 * 
 * @TODO - implement configuration concept:
 * 	- load tsconfig in constructor and initialize internal configuration array
 *  - support all the old tsconfig configurations during building the configurations
 *  
 * @package list
 * @license http://www.gnu.org/licenses/gpl.html GNU General Public License, version 3 or later
 * @author Daniel Pötzinger
 */
class Tx_List_Typo3_ListConfigurationFactory  {
	
	const CONFIGURATIONKEY_PREFIX='TYPO3-';
	
	/**
	 * @var Tx_Extbase_Object_ObjectManager
	 */
	protected $objectManager;
	
	public function injectObjectManager(Tx_Extbase_Object_ObjectManager $objectManager) {
		$this->objectManager = $objectManager;
	}
	
	/**
	 * Gets all list configurations for a given pageNode
	 * @param integer $pageId
	 * @return Tx_List_Core_ListConfiguration[]
	 */
	public function buildAllForPageNode($pageId) {
		if (empty($pageId)) {
			throw new InvalidArgumentException('No pageid given');
		}
		$configurations = array();		
		foreach ($this->getAllRecordTypes($pageId) as $type) {	
			$recordProperties = $this->objectManager->create('Tx_List_System_Typo3_RecordTypeProperties', $type);		
			if ( $this->shouldRecordyTypeByShownOnPageNode($pageId, $recordProperties)) {
				$configurations[] = $this->buildListConfigurationForRecordType($type, $pageId);
			}
		}	
		return $configurations;	
	}
	
	/**
	 * Gets listconfigurations for a given pageNode
	 * @param string $table
	 * @param integer $pageId
	 * @return Tx_List_Core_ListConfiguration
	 */
	public function buildListConfigurationForRecordType($table, $pageId) {
		if (empty($table) && !in_array($table, $this->getAllRecordTypes())) {
			throw InvalidArgumentException('Recordtype '.$table.'  not configured');
		}
		$list = $this->objectManager->create('Tx_List_Core_ListConfiguration');
		$list->setLabel($GLOBALS['LANG']->sL($GLOBALS['TCA'][$table]['ctrl']['title'], TRUE));
		$list->setKey(self::CONFIGURATIONKEY_PREFIX.$table);
		$list->setDefaultRecordType($table);
		
		$list->setAvailableColumns($this->getAvailableColumns($table));
		
		/**TODO set default sort:
		 * $doSort = ($GLOBALS['TCA'][$table]['ctrl']['sortby'] && !$this->sortField); 
		 * 
		 * 
		 * TODO set limit
		 * // iLimit is set depending on whether we're in single- or multi-table mode
				if ($this->table)	{
					$this->iLimit= (isset($GLOBALS['TCA'][$tableName]['interface']['maxSingleDBListItems'])
						? intval($GLOBALS['TCA'][$tableName]['interface']['maxSingleDBListItems']) :
						$this->itemsLimitSingleTable);
				} else {
					$this->iLimit = (isset($GLOBALS['TCA'][$tableName]['interface']['maxDBListItems'])
						? intval($GLOBALS['TCA'][$tableName]['interface']['maxDBListItems'])
						: $this->itemsLimitPerTable);
				}
				if ($this->showLimit)	$this->iLimit = $this->showLimit;

		 */
		
		$listItemProvider = $this->objectManager->create('Tx_List_Typo3_ListItemProvider', $table, $pageId);
		$list->setListItemProvider($listItemProvider);
		
		
		return $list;		
	}
	
	/**
	 * Detects all relevant recordType for a certain pageid
	 * @param $pageId
	 */
	protected function getAllRecordTypes($pageId) {
		$tables = array();
		foreach (array_keys($GLOBALS['TCA']) as $tableName) {
			
				// Don't show table if hidden by TCA ctrl section
				$hideTable = $GLOBALS['TCA'][$tableName]['ctrl']['hideTable'] ? TRUE : FALSE;
					// Don't show table if hidden by pageTSconfig mod.web_list.hideTables
				if (in_array($tableName, t3lib_div::trimExplode(',', $this->hideTables))) {
					$hideTable = TRUE;
				}
				
				
				/* stuff from old listmodule -@todo: make it work with configuratuion concept
				// Override previous selection if table is enabled or hidden by TSconfig TCA override mod.web_list.table
				if (isset($this->tableTSconfigOverTCA[$tableName.'.']['hideTable'])) {
					$hideTable = $this->tableTSconfigOverTCA[$tableName.'.']['hideTable'] ? TRUE : FALSE;
				}
				*/
				if ($hideTable) {
					continue;
				}
				$tables[] = $tableName;
		}
						
		return $tables;
	}
	
	protected function getAvailableColumns($table) {
		$columns = array();
		foreach ($this->makeFieldList($table) as $fieldName) {
			$column = $this->objectManager->create('Tx_List_Core_Column');
			$column->setFieldName($fieldName);
			$label = (is_array($GLOBALS['TCA'][$table]['columns'][$fieldName])
				? rtrim($GLOBALS['LANG']->sL($GLOBALS['TCA'][$table]['columns'][$fieldName]['label']), ':')
				: '[' . $fieldName . ']');
			$column->setLabel($label);
			$columns[$fieldName] = $column;
		}
		
		return $columns;
	}
	
	/**
	 * Makes the list of fields to select for a table. Taken from good old class.db_list_extra.inc
	 *
	 * @param	string		Table name
	 * @return	array		Array, where values are fieldnames to include in query
	 */
	protected function makeFieldList($table)	{

			// Init fieldlist array:
		$fieldListArr = array();
		if (is_array($GLOBALS['TCA'][$table])) {
			t3lib_div::loadTCA($table);
		}

			// Check table:
		if (isset($GLOBALS['TCA'][$table]['columns']) && is_array($GLOBALS['TCA'][$table]['columns'])) {
				// Traverse configured columns and add them to field array, if available for user.
			foreach($GLOBALS['TCA'][$table]['columns'] as $fN => $fieldValue) {
				if ($dontCheckUser ||
						((!$fieldValue['exclude'] || $GLOBALS['BE_USER']->check('non_exclude_fields', $table . ':' . $fN))
								&& $fieldValue['config']['type']!='passthrough')) {
					$fieldListArr[]=$fN;
				}
			}

			// Add special fields:
			if ($dontCheckUser || $GLOBALS['BE_USER']->isAdmin()) {
				$fieldListArr[]='uid';
				$fieldListArr[]='pid';
			}

			// Add date fields
			if ($dontCheckUser || $GLOBALS['BE_USER']->isAdmin() || $addDateFields) {
				if ($GLOBALS['TCA'][$table]['ctrl']['tstamp']) {
					$fieldListArr[]=$GLOBALS['TCA'][$table]['ctrl']['tstamp'];
				}
				if ($GLOBALS['TCA'][$table]['ctrl']['crdate']) {
					$fieldListArr[]=$GLOBALS['TCA'][$table]['ctrl']['crdate'];
				}
			}

			// Add more special fields:
			if ($dontCheckUser || $GLOBALS['BE_USER']->isAdmin()) {
				if ($GLOBALS['TCA'][$table]['ctrl']['cruser_id']) {
					$fieldListArr[]=$GLOBALS['TCA'][$table]['ctrl']['cruser_id'];
				}
				if ($GLOBALS['TCA'][$table]['ctrl']['sortby']) {
					$fieldListArr[]=$GLOBALS['TCA'][$table]['ctrl']['sortby'];
				}
				if ($GLOBALS['TCA'][$table]['ctrl']['versioningWS']) {
					$fieldListArr[]='t3ver_id';
					$fieldListArr[]='t3ver_state';
					$fieldListArr[]='t3ver_wsid';
					if ($table==='pages')	{
						$fieldListArr[]='t3ver_swapmode';
					}
				}
			}
		} else {
			throw new Exception('TCA broken for table '.$table);
		}
		return $fieldListArr;
	}
	
	protected function shouldRecordyTypeByShownOnPageNode($pageId, $recordProperties) {
		$where = 'pid='.intval($pageId);
		if ( ($deleteColumn = $recordProperties->getDeleteColumnName()) !== FALSE ) {
			$where .= 'AND '.$deleteColumn.'=0';
		}
		$res = $GLOBALS['TYPO3_DB']->exec_SELECTquery('uid', $recordProperties->getTable(), $where , '', '', 1);
		$row = $GLOBALS['TYPO3_DB']->sql_fetch_row($res);
		return is_array($row) && count($row)>0;
	}

}
?>