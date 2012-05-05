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
 *  the Free Software Foundation; either version 2 of the License, or
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
 * Test case for class Tx_List_Domain_Model_Pages.
 *
 * @version $Id$
 * @copyright Copyright belongs to the respective authors
 * @license http://www.gnu.org/licenses/gpl.html GNU General Public License, version 3 or later
 *
 * @package TYPO3
 * @subpackage list renewed
 *
 * @author Daniel Pötzinger <dev@aoemedia.de>
 */
class Tx_List_Domain_Model_PagesTest extends Tx_Extbase_Tests_Unit_BaseTestCase {
	/**
	 * @var Tx_List_Domain_Model_Pages
	 */
	protected $fixture;

	public function setUp() {
		$this->fixture = new Tx_List_Domain_Model_Pages();
	}

	public function tearDown() {
		unset($this->fixture);
	}

	/**
	 * @test
	 */
	public function getPidReturnsInitialValueForInteger() { 
		$this->assertSame(
			0,
			$this->fixture->getPid()
		);
	}

	/**
	 * @test
	 */
	public function setPidForIntegerSetsPid() { 
		$this->fixture->setPid(12);

		$this->assertSame(
			12,
			$this->fixture->getPid()
		);
	}
	
	/**
	 * @test
	 */
	public function getDeletedReturnsInitialValueForBoolean() { 
		$this->assertSame(
			TRUE,
			$this->fixture->getDeleted()
		);
	}

	/**
	 * @test
	 */
	public function setDeletedForBooleanSetsDeleted() { 
		$this->fixture->setDeleted(TRUE);

		$this->assertSame(
			TRUE,
			$this->fixture->getDeleted()
		);
	}
	
	/**
	 * @test
	 */
	public function getIsSiterootReturnsInitialValueForBoolean() { 
		$this->assertSame(
			TRUE,
			$this->fixture->getIsSiteroot()
		);
	}

	/**
	 * @test
	 */
	public function setIsSiterootForBooleanSetsIsSiteroot() { 
		$this->fixture->setIsSiteroot(TRUE);

		$this->assertSame(
			TRUE,
			$this->fixture->getIsSiteroot()
		);
	}
	
	/**
	 * @test
	 */
	public function getStarttimeReturnsInitialValueForDateTime() { }

	/**
	 * @test
	 */
	public function setStarttimeForDateTimeSetsStarttime() { }
	
	/**
	 * @test
	 */
	public function getEndtimeReturnsInitialValueForDateTime() { }

	/**
	 * @test
	 */
	public function setEndtimeForDateTimeSetsEndtime() { }
	
	/**
	 * @test
	 */
	public function getNavTitleReturnsInitialValueForString() { }

	/**
	 * @test
	 */
	public function setNavTitleForStringSetsNavTitle() { 
		$this->fixture->setNavTitle('Conceived at T3CON10');

		$this->assertSame(
			'Conceived at T3CON10',
			$this->fixture->getNavTitle()
		);
	}
	
	/**
	 * @test
	 */
	public function getSubtitleReturnsInitialValueForString() { }

	/**
	 * @test
	 */
	public function setSubtitleForStringSetsSubtitle() { 
		$this->fixture->setSubtitle('Conceived at T3CON10');

		$this->assertSame(
			'Conceived at T3CON10',
			$this->fixture->getSubtitle()
		);
	}
	
	/**
	 * @test
	 */
	public function getTitleReturnsInitialValueForString() { }

	/**
	 * @test
	 */
	public function setTitleForStringSetsTitle() { 
		$this->fixture->setTitle('Conceived at T3CON10');

		$this->assertSame(
			'Conceived at T3CON10',
			$this->fixture->getTitle()
		);
	}
	
}
?>