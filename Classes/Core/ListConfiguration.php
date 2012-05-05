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
 * This value object represents all informations required by the view to render the list
 *
 * @package list
 * @license http://www.gnu.org/licenses/gpl.html GNU General Public License, version 3 or later
 * @author Daniel Pötzinger
 */
class Tx_List_Core_ListConfiguration  {
	
	protected $label;
	
	protected $key;
	
	protected $defaultLimit;
	
	/**
	 * Optional the default Recordtype that is related to this configuration
	 * only used in view - no functional behaviour
	 * 
	 * @var string
	 */
	protected $defaultRecordType;
	
	/**
	 * @var Tx_List_Core_ListItemProviderInterface
	 */
	protected $listItemProvider;
	
	/**
	 * @var ArrayAccess[Tx_List_Core_Column]
	 */
	protected $availableColumns;
	
	/**
	 * @var ArrayAccess[Tx_List_Core_Column]
	 */
	protected $activeColumns;
	
	/**
	 * @return the $listItemProvider
	 */
	public function getListItemProvider() {
		return $this->listItemProvider;
	}

	/**
	 * @return the $availableColumns
	 */
	public function getAvailableColumns() {
		return $this->availableColumns;
	}

	/**
	 * @return the $activeColumns
	 */
	public function getActiveColumns() {
		return $this->activeColumns;
	}

	/**
	 * @param Tx_List_Core_ListItemProviderInterface $listItemProvider
	 */
	public function setListItemProvider(Tx_List_Core_ListItemProviderInterface $listItemProvider) {
		$this->listItemProvider = $listItemProvider;
	}

	/**
	 * @param $availableColumns the $availableColumns to set
	 */
	public function setAvailableColumns($availableColumns) {
		$this->availableColumns = $availableColumns;
	}

	/**
	 * @param Tx_List_Core_Column $activeColumns
	 */
	public function addAsActiveColumn(Tx_List_Core_Column $activeColumn) {
		$this->activeColumns[] = $activeColumn;
	}
	/**
	 * @return the $label
	 */
	public function getLabel() {
		return $this->label;
	}

	/**
	 * @return the $key
	 */
	public function getKey() {
		return $this->key;
	}

	/**
	 * @param $label the $label to set
	 */
	public function setLabel($label) {
		$this->label = $label;
	}

	/**
	 * @param $key the $key to set
	 */
	public function setKey($key) {
		$this->key = $key;
	}
	/**
	 * @return the $defaultRecordType
	 */
	public function getDefaultRecordType() {
		return $this->defaultRecordType;
	}

	/**
	 * @param $defaultRecordType the $defaultRecordType to set
	 */
	public function setDefaultRecordType($defaultRecordType) {
		$this->defaultRecordType = $defaultRecordType;
	}
	/**
	 * @return the $defaultLimit
	 */
	public function getDefaultLimit() {
		return $this->defaultLimit;
	}

	/**
	 * @param $defaultLimit the $defaultLimit to set
	 */
	public function setDefaultLimit($defaultLimit) {
		$this->defaultLimit = $defaultLimit;
	}



	

}
?>