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
\TYPO3\CMS\Core\Utility\ExtensionManagementUtility::addStaticFile($_EXTKEY, 'Configuration/TypoScript/', 'Keywords');

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

// Extbase stuff
\TYPO3\CMS\Extbase\Utility\ExtensionUtility::registerPlugin(
	'Subugoe.' . $_EXTKEY,
	'list',
	'Keyword Listr'
);

// Keyword detail view
\TYPO3\CMS\Extbase\Utility\ExtensionUtility::registerPlugin(
	'Subugoe.' . $_EXTKEY,
	'detail',
	'Keyword Detail'
);

$GLOBALS['TYPO3_CONF_VARS']['SC_OPTIONS']['extbase']['commandControllers'][] = 'Subugoe\\Nkwkeywords\\Command\\CategoryCommandController';
