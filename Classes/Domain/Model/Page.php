<?php

/* * *************************************************************
 *  Copyright notice
 *
 *  (c) 2012 Ingo Pfennigstorf <pfennigstorf@sub-goettingen.de>
 *      Goettingen State Library
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
 * ************************************************************* */

/**
 * Model for Pages
 *
 * @author Ingo Pfennigstorf <pfennigstorf@sub-goettingen.de>, Goettingen State Library
 * $Id$
 */
class Tx_Nkwkeywords_Domain_Model_Page extends Tx_Extbase_DomainObject_AbstractEntity {

	/**
	 * @var string
	 */
	protected $title;

	/**
	 * @var Tx_Nkwkeywords_Domain_Model_Page $parentPage
	 */
	protected $parentPage;

	/**
	 * @var Tx_Extbase_Persistence_ObjectStorage<Tx_Nkwkeywords_Domain_Model_Keywords> $keyword
	 */
	protected $keywords;

	/**
	 * constructor
	 */
	public function __construct() {
		$this->initStorageObjects();
	}

	/**
	 * initializes Extbase storage objects
	 */
	protected function initStorageObjects() {
		$this->keywords = new Tx_Extbase_Persistence_ObjectStorage();
	}

	/**
	 * @param string $title
	 */
	public function setTitle($title) {
		$this->title = $title;
	}

	/**
	 * @return string
	 */
	public function getTitle() {
		return $this->title;
	}

	/**
	 * @param Tx_Extbase_Persistence_ObjectStorage<Tx_Nkwkeywords_Domain_Model_Keywords> $keywords
	 */
	public function setKeywords($keywords) {
		$this->keywords = $keywords;
	}

	/**
	 * @return Tx_Extbase_Persistence_ObjectStorage<Tx_Nkwkeywords_Domain_Model_Keywords>
	 */
	public function getKeywords() {
		return $this->keywords;
	}

	/**
	 * @param Tx_Nkwkeywords_Domain_Model_Page $parentPage
	 */
	public function setParentPage($parentPage) {
		$this->parentPage = $parentPage;
	}

	/**
	 * @return Tx_Nkwkeywords_Domain_Model_Page
	 */
	public function getParentPage() {
		return $this->parentPage;
	}


}