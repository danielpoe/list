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
 * Token generator
 *
 */
class Tx_List_ViewHelpers_TCEForms_ShowHideLinkViewHelper extends Tx_Fluid_Core_ViewHelper_AbstractTagBasedViewHelper {
	
	/**
	 * Initialize the arguments.
	 *
	 * @return void
	 * @api
	 */
	public function initializeArguments() {
		parent::initializeArguments();
		$this->registerUniversalTagAttributes();
	}
	

	/**
	 * 
	 * @param Tx_List_Core_ListItem $listItem
	 * @param string $hideLabel
	 * @param string $showLabel
	 */
	public function render(Tx_List_Core_ListItem $listItem, $hideLabel = 'hide', $showLabel = 'show') {		
		if (!isset($GLOBALS['TCA'][$listItem->getRecordType()]['ctrl']['enablecolumns']['disabled'])) {
			return;
		}		
		
		$hiddenColumn = $GLOBALS['TCA'][$listItem->getRecordType()]['ctrl']['enablecolumns']['disabled'];
		$this->tag->setTagName('a');
		$this->tag->addAttribute('href', '#');
		
		if ($listItem->getData($hiddenColumn) == 1) {
			$this->tag->setContent($showLabel);
			$this->tag->addAttribute('onclick', 'TYPO3Actions.showRecord(\''.$listItem->getRecordType().'\',\''.$listItem->getUid().'\')');
		}
		else {
			$this->tag->setContent($hideLabel);
			$this->tag->addAttribute('onclick', 'TYPO3Actions.hideRecord(\''.$listItem->getRecordType().'\',\''.$listItem->getUid().'\')');	
		}
		return $this->tag->render();
	}
}

