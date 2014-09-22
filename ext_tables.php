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
\TYPO3\CMS\Core\Utility\ExtensionManagementUtility::addStaticFile($_EXTKEY, 'Configuration/TypoScript/', 'nkwkeywords');
if (TYPO3_MODE == 'BE') {
	\TYPO3\CMS\Core\Utility\ExtensionManagementUtility::addModulePath('web_txnkwkeywordsM1', \TYPO3\CMS\Core\Utility\ExtensionManagementUtility::extPath($_EXTKEY) . 'mod1/');
	\TYPO3\CMS\Core\Utility\ExtensionManagementUtility::addModule('web', 'txnkwkeywordsM1', '', \TYPO3\CMS\Core\Utility\ExtensionManagementUtility::extPath($_EXTKEY) . 'mod1/');
}
$TCA['tx_nkwkeywords_keywords'] = array(
		'ctrl' => array(
				'title' => 'LLL:EXT:nkwkeywords/locallang_db.xml:tx_nkwkeywords_keywords',
				'label' => 'title',
				'tstamp' => 'tstamp',
				'crdate' => 'crdate',
				'cruser_id' => 'cruser_id',
				'type' => 'title',
				'default_sortby' => 'ORDER BY title',
				'dynamicConfigFile' => \TYPO3\CMS\Core\Utility\ExtensionManagementUtility::extPath($_EXTKEY) . 'Configuration/TCA/Keywords.php',
				'iconfile' => \TYPO3\CMS\Core\Utility\ExtensionManagementUtility::extRelPath($_EXTKEY) . 'Resources/Public/Icons/icon_tx_nkwkeywords_keywords.gif',
		),
);

$TCA['tt_content']['types']['list']['subtypes_excludelist'][$_EXTKEY . '_pi2'] = 'layout,select_key,pages';
$TCA['tt_content']['types']['list']['subtypes_excludelist'][$_EXTKEY . '_pi3'] = 'layout,select_key,pages';
$TCA['tt_content']['types']['list']['subtypes_addlist'][$_EXTKEY . '_pi2'] = 'pi_flexform';
\TYPO3\CMS\Core\Utility\ExtensionManagementUtility::addPiFlexFormValue($_EXTKEY . '_pi2', 'FILE:EXT:nkwkeywords/Configuration/FlexForms/KeywordListFlexform.xml');
\TYPO3\CMS\Core\Utility\ExtensionManagementUtility::addPlugin(
		array(
				'LLL:EXT:nkwkeywords/locallang_db.xml:tt_content.list_type_pi2',
				$_EXTKEY . '_pi2',
				\TYPO3\CMS\Core\Utility\ExtensionManagementUtility::extRelPath($_EXTKEY) . 'Resources/Public/Icons/ext_icon.gif'), 'list_type');
\TYPO3\CMS\Core\Utility\ExtensionManagementUtility::addPlugin(
		array(
				'LLL:EXT:nkwkeywords/locallang_db.xml:tt_content.list_type_pi3',
				$_EXTKEY . '_pi3',
				\TYPO3\CMS\Core\Utility\ExtensionManagementUtility::extRelPath($_EXTKEY) . 'Resources/Public/Icons/ext_icon.gif'), 'list_type');
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

\TYPO3\CMS\Core\Utility\ExtensionManagementUtility::addTCAcolumns('pages', $tempColumns, 1);
\TYPO3\CMS\Core\Utility\ExtensionManagementUtility::addToAllTCAtypes('pages', 'tx_nkwkeywords_keywords;;;;1-1-1');
