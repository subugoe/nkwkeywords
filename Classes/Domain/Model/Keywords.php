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
 * Model for Project Keywords
 *
 * @author Ingo Pfennigstorf <pfennigstorf@sub-goettingen.de>, Goettingen State Library
 * $Id: Keywords.php 1684 2012-02-21 15:50:49Z pfennigstorf $
 */
class Tx_Nkwkeywords_Domain_Model_Keywords extends Tx_Extbase_DomainObject_AbstractEntity {

	/**
	 * @var string
	 */
	protected $title;

	/**
	 * @var Tx_Extbase_Persistence_ObjectStorage<Tx_Nkwkeywords_Domain_Model_Page>
	 */
	protected $pages;

	public function __construct() {
		$this->initStorageObjects();
	}

	protected function initStorageObjects() {
		$this->pages = new Tx_Extbase_Persistence_ObjectStorage();
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
	 * @param Tx_Extbase_Persistence_ObjectStorage<Tx_Nkwkeywords_Domain_Model_Page> $pages
	 */
	public function setPages(Tx_Nkwkeywords_Domain_Model_Page $pages) {
		$this->pages = $pages;
	}

	/**
	 * @return Tx_Extbase_Persistence_ObjectStorage<Tx_Nkwkeywords_Domain_Model_Page>
	 */
	public function getPages() {
		return $this->pages;
	}

}