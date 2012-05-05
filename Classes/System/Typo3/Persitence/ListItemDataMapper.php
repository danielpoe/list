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
 * We use an own Data Mapper that is able to map a record to a ListItem Object
 * 
 * @author Daniel Pötzinger
 */
class Tx_List_System_Typo3_Persitence_ListItemDataMapper  {
	
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
	 * Returns the selector (table) name for a given class name.
	 * Called in the Query Object
	 * 
	 * In our case the classname == tablename
	 *
	 * @param string $className
	 * @return string The selector name
	 */
	public function convertClassNameToTableName($className = NULL) {	
		return $className;
	}
	
	
	/**
	 * Maps the given rows on objects
	 *
	 * @param array $rows An array of arrays with field_name => value pairs
	 * @param string $table
	 * 
	 * @return Tx_List_Core_ListItem[]
	 */
	public function map(array $rows, $table) {
		$objects = array();
		$recordProperty = $this->objectManager->create('Tx_List_System_Typo3_RecordTypeProperties', $table);
		foreach ($rows as $row) {
			$objects[] = $this->mapSingleRow($row, $recordProperty);
		}
		return $objects;
	}
	
	/**
	 * @param array $row
	 * @param Tx_List_System_Typo3_RecordTypeProperties $recordProperties
	 * @return Tx_List_Core_ListItem
	 */
	protected function mapSingleRow(array $row, Tx_List_System_Typo3_RecordTypeProperties $recordProperties) {
		$listItem = $this->objectManager->create('Tx_List_Core_ListItem');
		$listItem->setColumnData($row);
		$listItem->setLabel($this->getLabel($row, $recordProperties));
		$listItem->setRecordType($recordProperties->getTable());
		return $listItem;
	}
	
	/**
	 * @param array $row
	 * @param Tx_List_System_Typo3_RecordTypeProperties $recordProperties
	 * @return string
	 */
	protected function getLabel(array $row,Tx_List_System_Typo3_RecordTypeProperties $recordProperties) {
		//Could be refactored later (moved from core?)
		return t3lib_befunc::getRecordTitle($recordProperties->getTable(), $row);
	}
}
?>