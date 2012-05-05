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
 * This value object represents the data required to render a "row" in the list.
 *
 * @package list
 * @license http://www.gnu.org/licenses/gpl.html GNU General Public License, version 3 or later
 * @author Daniel Pötzinger
 */
class Tx_List_Core_ListItem  {

	protected $columnData;
	
	protected $label;
	
	protected $recordType;
	
	/**
	 * @return the $columnData
	 */
	public function getColumnData() {
		return $this->columnData;
	}

	/**
	 * @param array
	 */
	public function setColumnData(array $columnData) {
		$this->columnData = $columnData;
	}

	public function __call($methodName, $arguments) {
		if (substr($methodName,0,3) === 'get') {
			return $this->getData(strtolower(substr($methodName,3)));
		}
		throw new Exception('Invalid/Unexistend method called');		
	}
	
	public function getData($key) {
		if (!isset($this->columnData[$key])) {
			throw new InvalidArgumentException('ColumnData with the key "'.$key.'" does not exist.');
		}
		
		return $this->columnData[$key];
	}
	/**
	 * @return the $label
	 */
	public function getLabel() {
		return $this->label;
	}

	/**
	 * @param $label the $label to set
	 */
	public function setLabel($label) {
		$this->label = $label;
	}
	/**
	 * @return the $recordType
	 */
	public function getRecordType() {
		return $this->recordType;
	}

	/**
	 * @param $recordType the $recordType to set
	 */
	public function setRecordType($recordType) {
		$this->recordType = $recordType;
	}



}
?>