<?php

/***************************************************************
 *  Copyright notice
 *
 *  (c) 2012 Daniel Pötzinger <daniel.poetzinger@aoemedia.de>, AOE media
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
 * Main List Controller displaying the lists in the backend
 * 
 * @package list
 * @license http://www.gnu.org/licenses/gpl.html GNU General Public License, version 3 or later
 *
 */
class Tx_List_Controller_ListController extends Tx_Extbase_MVC_Controller_ActionController {

	/**
	 * @var Tx_List_System_Typo3_BackendPageRendererService
	 */
	protected $pageRendererService;
	
	/**
	 * @var t3lib_PageRenderer
	 */
	protected $pageRenderer;
	
	/**
	 * @var Tx_List_Service_ListConfigurationProviderInterface
	 */
	protected $listConfigurationProvider;
	
	 /**
	  * @param Tx_List_System_Typo3_BackendPageRendererService $pageRendererService
	  */
	public function injectPageRenderService(Tx_List_System_Typo3_BackendPageRendererService $pageRendererService) {
		$this->pageRendererService = $pageRendererService;
	}
	
	/**
	 * @param Tx_List_Domain_ListConfigurationFactory $pagesRepository
	 * @return void
	 */
	public function injectConfigurationFactory(Tx_List_Service_ListConfigurationProviderInterface $configurationProvider) {
		$this->listConfigurationProvider = $configurationProvider;
	}
	
	/**
	 * Initializes the controller before invoking an action method.
	 *
	 * @return void
	 */
	protected function initializeAction() {		
		$this->pageId = intval(t3lib_div::_GP('id'));
		$this->pageRenderer = $this->pageRendererService->getBackendInitializedPageRenderer();
		$this->pageRenderer->addCssFile(t3lib_extMgm::extRelPath('list') . 'Resources/Public/Css/main.css');
			
		//Jquery UI - @TODO - make this configurable and or integrate with TYPO3 Skin settings
		$this->pageRenderer->addCssFile(t3lib_extMgm::extRelPath('list') . 'Resources/Public/Css/smoothness/jquery-ui-1.8.19.custom.css');
		$this->pageRenderer->addJsFile(t3lib_extMgm::extRelPath('list') . 'Resources/Public/JavaScript/Libs/jquery-1.7.2.min.js');
		$this->pageRenderer->addJsFile(t3lib_extMgm::extRelPath('list') . 'Resources/Public/JavaScript/Libs/jquery-ui-1.8.19.custom.min.js');
		//List
		$this->pageRenderer->addJsFile(t3lib_extMgm::extRelPath('list') . 'Resources/Public/JavaScript/Libs/simpleresizeabletables.js');
		$this->pageRenderer->addJsFile(t3lib_extMgm::extRelPath('list') . 'Resources/Public/JavaScript/Libs/jquery.dropdownPlain.js');
		$this->pageRenderer->addJsFile(t3lib_extMgm::extRelPath('list') . 'Resources/Public/JavaScript/list.js');
		$this->pageRenderer->addJsFile(t3lib_extMgm::extRelPath('list') . 'Resources/Public/JavaScript/typo3actions.js');
		
	}

	/**
	 * action list
	 *
	 * @return void
	 */
	public function indexAction() {		
		if (empty($this->pageId)) {
			$this->forward('error', NULL, NULL, array('messageKey' => 'No-Pageid-Set') );
		}		
		$this->view->assign('listConfigurations', $this->listConfigurationProvider->getForPageNode($this->pageId));
		$this->view->assign('pageId', $this->pageId);
		$this->view->assign('pagePath', t3lib_befunc::getRecordPath($this->pageId,'',''));		
	}
	
	/**
	 * 
	 * @param string $configurationKey
	 * @return void
	 */
	public function singleListAction($configurationKey) {		
		if (empty($this->pageId)) {
			$this->forward('error', NULL, NULL, array('messageKey' => 'No-Pageid-Set') );
		}
		try {
			$this->view->assign('listConfiguration', $this->listConfigurationProvider->getForConfigurationKey($this->pageId, $configurationKey));
			$this->view->assign('pageId', $this->pageId);
			$this->view->assign('pagePath', t3lib_befunc::getRecordPath($this->pageId,'',''));
		}
		catch (Tx_List_Service_Exception_NoSuchRecordType $e) {
			$this->forward('error', NULL, NULL, array('messageKey' => 'No-Record-of-Type', 'exceptionMessage' => $e->getMessage()) );
		}
		
	}
	
	/**
	 * @param string $messageKey
	 * @param string $exceptionMessage
	 */
	public function errorAction($messageKey = NULL, $exceptionMessage = '') {
		$this->view->assign('messageKey', $messageKey);
		$this->view->assign('exceptionMessage', $exceptionMessage);		
	}
	
	
	/**
	 * Processes a general request. The result can be returned by altering the given response.
	 * @TODO - remove all the unused stuff in pagerenderer (extjs, prototype...) or dont use the pagerenderer at all
	 * 
	 * @param Tx_Extbase_MVC_RequestInterface $request The request object
	 * @param Tx_Extbase_MVC_ResponseInterface $response The response, modified by this handler
	 * @throws Tx_Extbase_MVC_Exception_UnsupportedRequestType if the controller doesn't support the current request type
	 * @return void
	 */
	public function processRequest(Tx_Extbase_MVC_RequestInterface $request, Tx_Extbase_MVC_ResponseInterface $response) {
		parent::processRequest($request, $response);
		$this->pageRenderer->setBodyContent($response->getContent());
		$response->setContent( $this->pageRenderer->render() );
	}
	
		

}
?>