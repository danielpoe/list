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
 * This object represents informations that are evaluated by the ListItemProvider. This can be really flexible and the supported properties depends on the capabilities of the ListItemProvider
 *
 * @package list
 * @license http://www.gnu.org/licenses/gpl.html GNU General Public License, version 3 or later
 * @author Daniel Pötzinger
 */
class Tx_List_Core_ListItemRequest  {

	protected $searchWord;
	
	protected $columnFilters;
	
	protected $generalFilters;
	
	protected $activeColumns;
	/**
	 * @return the $searchWord
	 */
	public function getSearchWord() {
		return $this->searchWord;
	}

	/**
	 * @return the $columnFilters
	 */
	public function getColumnFilters() {
		return $this->columnFilters;
	}

	/**
	 * @return the $generalFilters
	 */
	public function getGeneralFilters() {
		return $this->generalFilters;
	}
	
	/**
	 * @param Tx_List_Core_Column $column
	 * @return boolean
	 */
	public function isColumnActive(Tx_List_Core_Column $column) {
		return in_array($column->getFieldName(),$this->activeColumns);
	}
	
	/**
	 * @return the $activeColumns
	 */
	public function getActiveColumns() {
		return $this->activeColumns;
	}

	/**
	 * @param $searchWord the $searchWord to set
	 */
	public function setSearchWord($searchWord) {
		$this->searchWord = $searchWord;
	}

	/**
	 * @param $columnFilters the $columnFilters to set
	 */
	public function setColumnFilters($columnFilters) {
		$this->columnFilters = $columnFilters;
	}

	/**
	 * @param $generalFilters the $generalFilters to set
	 */
	public function setGeneralFilters($generalFilters) {
		$this->generalFilters = $generalFilters;
	}

	/**
	 * @param $activeColumns the $activeColumns to set
	 */
	public function setActiveColumns($activeColumns) {
		$this->activeColumns = $activeColumns;
	}


}
?>