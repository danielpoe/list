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
 * We use an own Query - only to use the custom persitence with custom datamapper
 * Usage and concept is like extbase query object
 * 
 * @author Daniel Pötzinger
 */
class Tx_List_System_Typo3_Persitence_Query extends Tx_Extbase_Persistence_Query {
	
	/**
	 * Constructs a query object working on the given class name
	 * We use the table as $type
	 *
	 * @param string $type
	 */
	public function __construct($table) {
		$this->type = $table;
	}
	
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
	 * Injects the persistence manager, used to fetch the CR session
	 *
	 * @param Tx_List_System_Typo3_DbBackend $persistenceManager
	 * @return void
	 */
	public function injectPersistenceManager(Tx_List_System_Typo3_Persitence_DbBackend $persistenceManager) {
		$this->persistenceManager = $persistenceManager;
	}

}
?>