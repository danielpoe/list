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
 * @package list
 * @license http://www.gnu.org/licenses/gpl.html GNU General Public License, version 3 or later
 *
 */
class Tx_List_ViewHelpers_Widget_Controller_ListWidgetController extends Tx_Fluid_Core_Widget_AbstractWidgetController {

	/**
	 * initialisation
	 * @todo - flexible templating and partial concept - so that other can modify only certain parts of a certain widget easily
	 */
	public function initializeAction() {
		
		//$extbaseFrameworkConfiguration = $this->configurationManager->getConfiguration(Tx_Extbase_Configuration_ConfigurationManagerInterface::CONFIGURATION_TYPE_FRAMEWORK);
		//$widgetViewHelperClassName = $this->request->getWidgetContext()->getWidgetViewHelperClassName();		
		//var_dump($extbaseFrameworkConfiguration);
		// $extbaseFrameworkConfiguration['view']['widget'][$widgetViewHelperClassName]['templateRootPath'];
	}
	
	/**
	 * @dontverifyrequesthash
	 * @param Tx_List_Core_ListItemRequest $listItemRequest
	 * @param integer $currentPage
	 * @param string $sort
	 * @param boolean $sortDesc
	 */
	public function indexAction(Tx_List_Core_ListItemRequest $listItemRequest = NULL, $currentPage = 1, $sort = NULL, $sortDesc = NULL) {		
		
		if (!empty($this->widgetConfiguration['renderLayout'])) {
			$this->view->assign('renderLayout', $this->widgetConfiguration['renderLayout']);
		}
		
		/* @var Tx_List_Core_ListConfiguration */
		$listConfiguration = $this->widgetConfiguration['configuration'];		
		if (is_null($listItemRequest)) {
			$listItemRequest = $this->getDefaultListItemRequest();
		}
		
		$this->mapActiveColumns($listConfiguration, $listItemRequest);
		
		$viewArguments = array(
			'listConfiguration' => $listConfiguration,
			'listItems' => $listConfiguration->getListItemProvider()->getListItems($listItemRequest),
			'defaultRecordType' => $listConfiguration->getDefaultRecordType(),
			'listItemRequest' => $listItemRequest,
			'widgetIdentifier' => $this->request->getWidgetContext()->getWidgetIdentifier(),
			'parameterNameSpace' => $this->request->getWidgetContext()->getParentPluginNamespace()
		);
		$this->assignViewArguments($viewArguments);			
	}
	
	protected function mapActiveColumns(Tx_List_Core_ListConfiguration $listConfiguration, Tx_List_Core_ListItemRequest $listItemRequest) {
		foreach ($listConfiguration->getAvailableColumns() as $column) {
			if ($listItemRequest->isColumnActive($column)) {
				$listConfiguration->addAsActiveColumn($column);
			}
		}
	}
	
	/**
	 * @param array $arguments
	 */
	protected function assignViewArguments(array $arguments) {
		$this->view->assign('arguments', $arguments);
		foreach ($arguments as $k => $v) {
			$this->view->assign($k,$v);			
		}	
	}
	
	/**
	 * @todo - load from session before creating new if not mapped to arguments (sessionkey = recordName+viewKey)
	 */
	protected function getDefaultListItemRequest() {
		return $this->objectManager->create('Tx_List_Core_ListItemRequest');
	}
	

}

?>