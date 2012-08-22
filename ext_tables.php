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
t3lib_extMgm::addStaticFile($_EXTKEY, 'Configuration/TypoScript/', 'nkwkeywords');

Tx_Extbase_Utility_Extension::registerPlugin(
		$_EXTKEY, 'list', 'Keywordslist (EF)'
);

Tx_Extbase_Utility_Extension::registerPlugin(
		$_EXTKEY, 'keyword', 'Keyword Details (EF)'
);

$TCA['tx_nkwkeywords_domain_model_keywords'] = array(
		'ctrl' => array(
		'title' => 'LLL:EXT:nkwkeywords/Resources/Private/Language/locallang_db.xml:tx_nkwkeywords_domain_model_keywords',
		'label' => 'title',
		'tstamp' => 'tstamp',
		'crdate' => 'crdate',
		'cruser_id' => 'cruser_id',
		'default_sortby' => 'ORDER BY title',
		'dynamicConfigFile' => t3lib_extMgm::extPath($_EXTKEY) . 'Configuration/TCA/Keywords.php',
		'iconfile' => t3lib_extMgm::extRelPath($_EXTKEY) . '/Resources/Public/Img/icon_tx_nkwkeywords_domain_model_keywords.gif',
		'searchFields' => 'title',
		'versioningWS' => TRUE,
		'versioning_followPages' => TRUE,
		'origUid' => 't3_origuid',
		'languageField' => 'sys_language_uid',
		'transOrigPointerField' => 'l18n_parent',
		'transOrigDiffSourceField' => 'l18n_diffsource',
	),
);

t3lib_div::loadTCA('pages');

$tempColumns = array(
	'keywords' => array(
		'exclude' => 1,
		'label' => 'LLL:EXT:nkwkeywords/Resources/Private/Language/locallang_db.xml:pages.tx_nkwkeywords_domain_model_keywords',
		'config' => array(
			'type' => 'select',
			'foreign_table' => 'tx_nkwkeywords_domain_model_keywords',
			'foreign_field' => 'title',
			'foreign_table_where' => ' AND sys_language_uid = 0 ORDER BY tx_nkwkeywords_domain_model_keywords.title ASC',
			'MM' => 'tx_nkwkeywords_pages_keywords_mm',
			'maxitems' => 9999,
			'size'=> 10,
			'appearance' => array(
				'collapse' => 0,
				'levelLinksPosition' => 'both',
				'showSynchronizationLink' => 1,
				'showPossibleLocalizationRecords' => 1,
				'showAllLocalizationLink' => 1
			),
		),
	),
);
t3lib_extMgm::addTCAcolumns('pages', $tempColumns, 1);
?>