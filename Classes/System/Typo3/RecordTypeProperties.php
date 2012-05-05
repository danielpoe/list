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
 * Abstraction for TCA properties of TYPO3 records
 * 
 * @author Daniel Pötzinger
 */
class Tx_List_System_Typo3_RecordTypeProperties  {
	
	/**
	 * @var string
	 */
	protected $table;
	
	/**
	 * @param string $table
	 */
	public function __construct($table) {
		if (!is_string($table)) {
			throw new InvalidArgumentException('Table needs to be a string!');
		}
		$this->table = $table;
	}
	
	/**
	 * @return string
	 */
	public function getTable() {
		return $this->table;
	}
	
	/**
	 * @return string / FALSE
	 */
	public function getDeleteColumnName() {
		if (!$this->hasTCACtrlValue('delete')) {
			return FALSE;
		}
		return $this->getTCACtrlValue('delete');
	}
	
	/**
	 * Gets the value of the TCA configuration key
	 * @param string $key
	 * @return string
	 */
	protected function getTCACtrlValue($key) {
		return $GLOBALS['TCA']['ctrl'][$key];
	}
	/**
	 * @param string $key
	 * @return boolean
	 */
	protected function hasTCACtrlValue($key) {
		return isset($GLOBALS['TCA']['ctrl'][$key]);
	}

}
?>