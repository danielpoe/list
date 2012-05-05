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
 * We use an own Persitence Backend with our special datamapper
 * 
 * @author Daniel Pötzinger
 */
class Tx_List_System_Typo3_Persitence_DbBackend extends Tx_Extbase_Persistence_Storage_Typo3DbBackend {
	
	/**
	 * Injects the DataMapper to map nodes to objects
	 *
	 * @param Tx_List_System_Typo3_DataMapper $dataMapper
	 * @return void
	 */
	public function injectDataMapper(Tx_List_System_Typo3_Persitence_ListItemDataMapper $dataMapper) {
		$this->dataMapper = $dataMapper;
	}
	
	/**
	 * Adds a row to the storage
	 *
	 * @param string $tableName The database table name
	 * @param array $row The row to insert
	 * @param boolean $isRelation TRUE if we are currently inserting into a relation table, FALSE by default
	 * @return void
	 */
	public function addRow($tableName, array $row, $isRelation = FALSE) {
		throw new Exception('storage not supported by backend yet');
	}

	/**
	 * Updates a row in the storage
	 *
	 * @param string $tableName The database table name
	 * @param array $row The row to update
	 * @param boolean $isRelation TRUE if we are currently inserting into a relation table, FALSE by default
	 * @return void
	 */
	public function updateRow($tableName, array $row, $isRelation = FALSE) {
		throw new Exception('storage not supported by backend yet');
	}

	/**
	 * Deletes a row in the storage
	 *
	 * @param string $tableName The database table name
	 * @param array $identifier An array of identifier array('fieldname' => value). This array will be transformed to a WHERE clause
	 * @param boolean $isRelation TRUE if we are currently inserting into a relation table, FALSE by default
	 * @return void
	 */
	public function removeRow($tableName, array $identifier, $isRelation = FALSE) {
		throw new Exception('storage not supported by backend yet');
	}

	/**
	 * Returns the number of items matching the query.
	 *
	 * @param Tx_Extbase_Persistence_QueryInterface $query
	 * @return integer
	 * @api
	 */
	public function getObjectCountByQuery(Tx_Extbase_Persistence_QueryInterface $query) {
		return parent::getObjectCountByQuery($query);
	}

	/**
	 * Returns the object data matching the $query.
	 *
	 * @param Tx_Extbase_Persistence_QueryInterface $query
	 * @return array
	 * @api
	 */
	public function getObjectDataByQuery(Tx_Extbase_Persistence_QueryInterface $query) {
		$data = parent::getObjectDataByQuery($query);
		return $this->dataMapper->map($data, $query->getSource()->getNodeTypeName());
	}
	
	/**
	 * Transforms a Query Source into SQL and parameter arrays
	 *
	 * @param Tx_Extbase_Persistence_QOM_SourceInterface $source The source
	 * @param array &$sql
	 * @return void
	 */
	protected function parseSource(Tx_Extbase_Persistence_QOM_SourceInterface $source, array &$sql) {
		if ($source instanceof Tx_Extbase_Persistence_QOM_SelectorInterface) {
			$tableName = $source->getNodeTypeName();
			$sql['fields'][$tableName] = $tableName . '.*';
			$sql['tables'][$tableName] = $tableName;
		} elseif ($source instanceof Tx_Extbase_Persistence_QOM_JoinInterface) {
			$this->parseJoin($source, $sql);
		}
	}
	

}
?>