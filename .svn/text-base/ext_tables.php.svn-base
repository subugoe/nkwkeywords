<?php

/* * *************************************************************
 *  Copyright notice
 *
 *  (c) 2010 Nils K. Windisch <windisch@sub.uni-goettingen.de>
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
 * ************************************************************* */
if (!defined('TYPO3_MODE')) {
	die('Access denied.');
}
t3lib_extMgm::addStaticFile($_EXTKEY, 'setup', 'nkwkeywords');
if (TYPO3_MODE == 'BE') {
	t3lib_extMgm::addModulePath('web_txnkwkeywordsM1', t3lib_extMgm::extPath($_EXTKEY) . 'mod1/');
	t3lib_extMgm::addModule('web', 'txnkwkeywordsM1', '', t3lib_extMgm::extPath($_EXTKEY) . 'mod1/');
}
$TCA['tx_nkwkeywords_keywords'] = array(
	'ctrl' => array(
		'title' => 'LLL:EXT:nkwkeywords/locallang_db.xml:tx_nkwkeywords_keywords',
		'label' => 'title',
		'tstamp' => 'tstamp',
		'crdate' => 'crdate',
		'cruser_id' => 'cruser_id',
		'type' => 'title',
		#'languageField'            => 'sys_language_uid',
		#'transOrigPointerField'    => 'l10n_parent',
		#'transOrigDiffSourceField' => 'l10n_diffsource',
		#'default_sortby' => 'ORDER BY crdate',
		'default_sortby' => 'ORDER BY title',
		'dynamicConfigFile' => t3lib_extMgm::extPath($_EXTKEY) . 'tca.php',
		'iconfile' => t3lib_extMgm::extRelPath($_EXTKEY) . 'icon_tx_nkwkeywords_keywords.gif',
	),
);
t3lib_div::loadTCA('tt_content');
$TCA['tt_content']['types']['list']['subtypes_excludelist'][$_EXTKEY . '_pi2'] = 'layout,select_key,pages';
$TCA['tt_content']['types']['list']['subtypes_excludelist'][$_EXTKEY . '_pi3'] = 'layout,select_key,pages';
$TCA['tt_content']['types']['list']['subtypes_addlist'][$_EXTKEY . '_pi2'] = 'pi_flexform';
t3lib_extMgm::addPiFlexFormValue($_EXTKEY . '_pi2', 'FILE:EXT:nkwkeywords/pi2/flexform.xml');
t3lib_extMgm::addPlugin(
				array(
					'LLL:EXT:nkwkeywords/locallang_db.xml:tt_content.list_type_pi2',
					$_EXTKEY . '_pi2',
					t3lib_extMgm::extRelPath($_EXTKEY) . 'ext_icon.gif'), 'list_type');
t3lib_extMgm::addPlugin(
				array(
					'LLL:EXT:nkwkeywords/locallang_db.xml:tt_content.list_type_pi3',
					$_EXTKEY . '_pi3',
					t3lib_extMgm::extRelPath($_EXTKEY) . 'ext_icon.gif'), 'list_type');
$tempColumns = array(
	'tx_nkwkeywords_keywords' => array(
		'exclude' => 0,
		'label' => 'LLL:EXT:nkwkeywords/locallang_db.xml:pages.tx_nkwkeywords_keywords',
		'config' => array(
			'type' => 'select',
			'foreign_table' => 'tx_nkwkeywords_keywords',
			'foreign_table_where' => 'ORDER BY tx_nkwkeywords_keywords.title',
			'size' => 20,
			'minitems' => 1,
			'maxitems' => 99,
		)
	),
);
t3lib_div::loadTCA('pages');
t3lib_extMgm::addTCAcolumns('pages', $tempColumns, 1);
t3lib_extMgm::addToAllTCAtypes('pages', 'tx_nkwkeywords_keywords;;;;1-1-1');
?>