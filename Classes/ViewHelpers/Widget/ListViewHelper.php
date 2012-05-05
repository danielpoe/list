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
 * Simple Widget ViewHelper - Logic is in WidgetController
 *
 */
class Tx_List_ViewHelpers_Widget_ListViewHelper extends Tx_Fluid_Core_Widget_AbstractWidgetViewHelper {

	/**
	 * @var Tx_List_ViewHelpers_Widget_Controller_ListWidgetController
	 */
	protected $controller;

	/**
	 * @param Tx_List_Controller_Widget_ListController $controller
	 * @return void
	 */
	public function injectController(Tx_List_ViewHelpers_Widget_Controller_ListWidgetController $controller) {
		$this->controller = $controller;
	}

	/**
	 *
	 * @param Tx_List_Core_ListConfiguration $objects
	 * @param string $renderLayout
	 * @return string
	 */
	public function render(Tx_List_Core_ListConfiguration $configuration, $renderLayout) {
		return $this->initiateSubRequest();
	}
}

?>
