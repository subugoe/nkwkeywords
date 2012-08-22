<?php
/***************************************************************
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
***************************************************************/
if (!defined ('TYPO3_MODE')) {
	die ('Access denied.');
}
$TCA['tx_nkwkeywords_domain_model_keywords'] = array(
	'ctrl' => $TCA['tx_nkwkeywords_domain_model_keywords']['ctrl'], 
	'interface' => array(
		'showRecordFieldList' => 'l18n_parent, l18n_diffsource, title, pages'
	),
	'feInterface' => $TCA['tx_nkwkeywords_domain_model_keywords']['feInterface'],
	'columns' => array(
		'sys_language_uid' => array(
			'exclude' => 1, 
			'label'  => 'LLL:EXT:lang/locallang_general.xml:LGL.language', 
			'config' => array(
				'type' => 'select', 
				'foreign_table' => 'sys_language', 
				'foreign_table_where' => 'ORDER BY sys_language.title', 
				'items' => array(
					array('LLL:EXT:lang/locallang_general.xml:LGL.allLanguages', -1), 
					array('LLL:EXT:lang/locallang_general.xml:LGL.default_value', 0)
				)
			)
		),
		'l18n_parent' => array(
			'displayCond' => 'FIELD:sys_language_uid:>:0',
			'exclude'     => 1,
			'label'       => 'LLL:EXT:lang/locallang_general.xml:LGL.l18n_parent',
			'config'      => array(
				'type'  => 'select',
				'items' => array(array('', 0)),
				'foreign_table'       => 'tx_nkwkeywords_domain_model_keywords',
				'foreign_table_where' => 'AND tx_nkwkeywords_domain_model_keywords.pid=###CURRENT_PID### AND tx_nkwkeywords_domain_model_keywords.sys_language_uid IN (-1,0)',
			)
		),
		'l18n_diffsource' => array(
			'config' => array(
				'type' => 'passthrough'
			)
		),
		'title' => array(
			'exclude' => 1,
			'label' => 'LLL:EXT:nkwkeywords/locallang_db.xml:tx_nkwkeywords_domain_model_keywords.title',
			'config' => array('type' => 'text', 'wrap' => 'OFF', 'cols' => '30', 'rows' => '1')
		),
		'pages' => array(
			'exclude' => 1,
			'label' => 'LLL:EXT:nkwkeywords/Resources/Private/Language/locallang_db.xml:pages.tx_nkwkeywords_domain_model_keywords',
			'config' => array(
				'type' => 'select',
				'MM_opposite_field' => 'keywords',
				'foreign_table' => 'pages',
				'foreign_table_where' => ' ORDER BY pages.title ASC',
				'sortby' => 'pages.title',
				'default_sortby' => ' ORDER BY pages.title ASC',
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
	),
	'types' => array(
		'0' => array('showitem' => 'l18n_parent, l18n_diffsource, title, pages')
	),
	'palettes' => array('1' => array('showitem' => ''))
);
?>