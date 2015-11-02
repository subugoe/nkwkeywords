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
if (!defined('TYPO3_MODE')) {
    die ('Access denied.');
}
$TCA['tx_nkwkeywords_keywords'] = [
    'ctrl' => $TCA['tx_nkwkeywords_keywords']['ctrl'],
    'interface' => [
        'showRecordFieldList' => 'sys_language_uid,l10n_parent,l10n_diffsource,title_de,title_en,title'
    ],
    'feInterface' => $TCA['tx_nkwkeywords_keywords']['feInterface'],
    'columns' => [
        'sys_language_uid' => [
            'exclude' => 1,
            'label' => 'LLL:EXT:lang/locallang_general.xml:LGL.language',
            'config' => [
                'type' => 'select',
                'foreign_table' => 'sys_language',
                'foreign_table_where' => 'ORDER BY sys_language.title',
                'items' => [
                    ['LLL:EXT:lang/locallang_general.xml:LGL.allLanguages', -1],
                    ['LLL:EXT:lang/locallang_general.xml:LGL.default_value', 0]
                ]
            ]
        ],
        'l10n_parent' => [
            'displayCond' => 'FIELD:sys_language_uid:>:0',
            'exclude' => 1,
            'label' => 'LLL:EXT:lang/locallang_general.xml:LGL.l18n_parent',
            'config' => [
                'type' => 'select',
                'items' => [['', 0]],
                'foreign_table' => 'tx_nkwkeywords_keywords',
                'foreign_table_where' => 'AND tx_nkwkeywords_keywords.pid=###CURRENT_PID### AND tx_nkwkeywords_keywords.sys_language_uid IN (-1,0)',
            ]
        ],
        'l10n_diffsource' => ['config' => ['type' => 'passthrough']],
        'title_de' => [
            'exclude' => 1,
            'label' => 'LLL:EXT:nkwkeywords/locallang_db.xml:tx_nkwkeywords_keywords.title_de',
            'config' => ['type' => 'input', 'size' => '30', 'eval' => 'required,trim']
        ],
        'title_en' => [
            'exclude' => 1,
            'label' => 'LLL:EXT:nkwkeywords/locallang_db.xml:tx_nkwkeywords_keywords.title_en',
            'config' => ['type' => 'input', 'size' => '30', 'eval' => 'required,trim']
        ],
        'title' => [
            'exclude' => 1,
            'label' => 'LLL:EXT:nkwkeywords/locallang_db.xml:tx_nkwkeywords_keywords.title',
            'config' => ['type' => 'text', 'wrap' => 'OFF', 'cols' => '30', 'rows' => '1']
        ],
    ],
    'types' => [
        '0' => ['showitem' => 'sys_language_uid;;;;1-1-1, l10n_parent, l10n_diffsource, title_de, title_en, title;;;;2-2-2']
    ],
    'palettes' => ['1' => ['showitem' => '']]
];
?>
