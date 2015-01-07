<?php
namespace Subugoe\Nkwkeywords\Command;

/* * *************************************************************
 *  Copyright notice
 *
 *  (c) 2015 Ingo Pfennigstorf <pfennigstorf@sub-goettingen.de>
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

class CategoryCommandController extends \TYPO3\CMS\Extbase\Mvc\Controller\CommandController {

	/**
	 * @var \TYPO3\CMS\Core\Database\DatabaseConnection
	 */
	protected $db;

	/**
	 * Converts custom categories to system categories
	 */
	public function convertToCategoriesCommand() {
		$this->db = $GLOBALS['TYPO3_DB'];
		$this->deleteMigratedRecords();
		$this->getAllAvailableCustomCategories();
	}

	/**
	 * provides a clean migration
	 * @return void
	 */
	protected function deleteMigratedRecords() {
		$this->db->exec_DELETEquery('sys_category', '_migratedkeywordcatuid != 0');
		$this->db->exec_DELETEquery('sys_category_record_mm', '_migratedkeywordcatuid != 0');
	}

	/**
	 * @return int
	 */
	protected function getAllAvailableCustomCategories() {
		$categories = $this->db->exec_SELECTquery(
				'*',
				'tx_nkwkeywords_keywords',
				'',
				'',
				'title_de ASC'
		);

		$migratedCategoryCounter = 0;

		while ($category = $this->db->sql_fetch_assoc($categories)) {

			$category['items'] = $this->countPagesWithCategory($category['uid']);

			// german
			$category['title'] = $category['title_de'];
			$newUid = $this->createNewCategory($category, 0);

			// english
			$category['title'] = $category['title_en'];
			$category['l10n_parent'] = $newUid;
			$this->createNewCategory($category, 1);

			$this->addCategoryToPages($category['uid'], $newUid);

			$migratedCategoryCounter++;
		}

		return $migratedCategoryCounter;
	}

	/**
	 * @param int $oldId
	 * @param int $categoryUid
	 */
	protected function addCategoryToPages($oldId, $categoryUid) {
		// get all pages with category
		$pages = $this->db->exec_SELECTquery(
			'uid',
			'pages',
			'FIND_IN_SET(' . $oldId . ', tx_nkwkeywords_keywords)'
		);

		foreach ($pages as $page) {
			$categoryAssociation = array(
				'uid_local' => $categoryUid,
				'uid_foreign' => $page['uid'],
				'tablenames' => 'pages',
				'fieldname' => 'categories',
				'_migratedkeywordcatuid' => $oldId
			);

			$this->db->exec_INSERTquery('sys_category_record_mm', $categoryAssociation);
		}

	}

	/**
	 * Count all pages with a certain keyword
	 * Needed for sys_category items field
	 *
	 * @param $categoryUid
	 * @return int
	 */
	protected function countPagesWithCategory($categoryUid) {
		return $this->db->exec_SELECTcountRows('tx_nkwkeywords_keywords', 'pages', 'FIND_IN_SET(' . $categoryUid . ', tx_nkwkeywords_keywords)');
	}

	/**
	 * Adds new category in table sys_category. Requires the record array
	 * thanks to Benni Mack // Inspired by dam-falmigration
	 *
	 * @param $record
	 * @return integer
	 */
	protected function createNewCategory($record, $sys_language_uid) {
		$sysCategory = array(
			'pid' => $record['pid'],
			'sys_language_uid' => $sys_language_uid,
			'l10n_parent' => $record['l10n_parent'],
			'tstamp' => $record['tstamp'],
			'crdate' => $record['crdate'],
			'cruser_id' => $record['cruser_id'],
			'title' => $record['title'],
			'items' => $record['items'],
			'_migratedkeywordcatuid' => $record['uid']
		);

		$this->db->exec_INSERTquery('sys_category', $sysCategory);

		$newUid = $this->db->sql_insert_id();

		return $newUid;
	}

}
