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
 */
class Tx_List_System_Typo3_BackendPageRendererService {
	
	/**
	 * TODO: check if we can use core better here and/or injection pagerenderer. For now that fails due to pagerenderer being singleton
	 * 
	 * - The default injected pagerender is already initialized by the TYPO3 backend and "polluted" with unrequired JS and CSS (like extjs, prototype) etc...
	 * - if there is no clean way to get a clean pagerenderer we should find better solution.
	 * - currently we create a fresh pagerendere here to not use the singleton one
	 */
	public function getBackendInitializedPageRenderer() {
		$pageRenderer = new t3lib_PageRenderer();

		if ($GLOBALS['TBE_STYLES']['stylesheet'])	$pageRenderer->addCssFile($GLOBALS['BACK_PATH'].$GLOBALS['TBE_STYLES']['stylesheet']);
		if ($GLOBALS['TBE_STYLES']['stylesheet2'])	$pageRenderer->addCssFile($GLOBALS['BACK_PATH'].$GLOBALS['TBE_STYLES']['stylesheet2']);
		if ($GLOBALS['TBE_STYLES']['styleSheetFile_post'])	$pageRenderer->addCssFile($GLOBALS['BACK_PATH'].$GLOBALS['TBE_STYLES']['styleSheetFile_post']);
		
		// include all stylesheets
		$template = new template();
		foreach ($template->getSkinStylesheetDirectories() as $stylesheetDirectory) {
			$this->addStylesheetDirectory($stylesheetDirectory, $pageRenderer);
		}
		return $pageRenderer;
	}
	
	/**
	 * Add all *.css files of the directory $path to the stylesheets
	 *
	 * @param	string		directory to add
	 * @param	t3lib_PageRenderer	$pageRenderer
	 * @return	void
	 */
	protected function addStyleSheetDirectory($path, t3lib_PageRenderer $pageRenderer) {
			// calculation needed, when TYPO3 source is used via a symlink
			// absolute path to the stylesheets
		$filePath = dirname(t3lib_div::getIndpEnv('SCRIPT_FILENAME')) . '/' . $GLOBALS['BACK_PATH'] . $path;
			// clean the path
		$resolvedPath = t3lib_div::resolveBackPath($filePath);
			// read all files in directory and sort them alphabetically
		$files = t3lib_div::getFilesInDir($resolvedPath, 'css', FALSE, 1);
		foreach ($files as $file) {
			$pageRenderer->addCssFile($GLOBALS['BACK_PATH'] . $path . $file, 'stylesheet', 'all');
		}
	}


}
?>