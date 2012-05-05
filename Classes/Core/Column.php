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
 * Used in the Column Collection. A column value object represents informations on how to render a column
 * @Todo: support diffrent renderings (date...)
 *
 * @package list
 * @license http://www.gnu.org/licenses/gpl.html GNU General Public License, version 3 or later
 *
 */
class Tx_List_Core_Column  {

	protected $fieldName;
	
	protected $label;
	
	/**
	 * @return the $fieldName
	 */
	public function getFieldName() {
		return $this->fieldName;
	}

	/**
	 * @return the $label
	 */
	public function getLabel() {
		return $this->label;
	}

	/**
	 * @param $fieldName the $fieldName to set
	 */
	public function setFieldName($fieldName) {
		$this->fieldName = $fieldName;
	}

	/**
	 * @param $label the $label to set
	 */
	public function setLabel($label) {
		$this->label = $label;
	}

	

}
?>