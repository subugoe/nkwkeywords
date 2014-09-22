<?php
/***************************************************************
 *  Copyright notice
 *
 *  (c) 2009 Nils K. Windisch <windisch@sub.uni-goettingen.de>
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

require_once(t3lib_extMgm::extPath('nkwlib') . 'class.tx_nkwlib.php');
class displayKeywords {

	/**
	 * Get Keywords for a page
	 *
	 * @param int $id
	 * @param int $lang
	 * @param boolean $mode
	 * @param boolean $landingpage
	 * @return string
	 */
	protected function keywordsForPage($id, $lang, $mode = FALSE, $landingpage = FALSE) {

		/** @var \TYPO3\CMS\Frontend\ContentObject\ContentObjectRenderer $cObj */
		$cObj = \TYPO3\CMS\Core\Utility\GeneralUtility::makeInstance('tslib_cObj');

		if ($lang == 0) {
			$sep = '_de';
		} elseif ($lang == 1) {
			$sep = '_en';
		}
		$pageInfo = tx_nkwlib::pageInfo($id, $lang);
		if (!empty($pageInfo['tx_nkwkeywords_keywords'])) {
			if ($mode == 'header') {
				$tmp = explode(',', $pageInfo['tx_nkwkeywords_keywords']);
				foreach ($tmp AS $key => $value) {
					$res1 = $GLOBALS['TYPO3_DB']->exec_SELECTquery(
									'*',
									'tx_nkwkeywords_keywords',
									"uid = '" . $value . "'",
									'',
									'',
									'');
					while ($row1 = $GLOBALS['TYPO3_DB']->sql_fetch_assoc($res1)) {
						$tmpList .= $row1['title' . $sep] . ',';
					}
				}
				$str .= substr($tmpList, 0, -1);
			} elseif ($mode == 'infobox') {
				$tmp = explode(',', $pageInfo['tx_nkwkeywords_keywords']);
				foreach ($tmp AS $key => $value) {
					$res1 = $GLOBALS['TYPO3_DB']->exec_SELECTquery(
									'*',
									'tx_nkwkeywords_keywords',
									'uid = ' . $GLOBALS['TYPO3_DB']->fullQuoteStr($value, 'tx_nkwkeywords_keywords'),
									'',
									'',
									'');
					while ($row1 = $GLOBALS['TYPO3_DB']->sql_fetch_assoc($res1)) {
						$str .= '<li>';

						$cObj->typoLink(
							$row1['title' . $sep],
							array(
								'parameter' => $landingpage,
								'useCacheHash' => TRUE,
								'additionalParams' => '&tx_nkwkeywords[id]=' . $value
								)
							);
						$str .= '<a title="' . $row1['title' . $sep] . '" href="' . $cObj->lastTypoLinkUrl . '">' . $row1['title' . $sep] . '</a>';
						$str .= '</li>';
					}
				}
			}
		}
		return $str;
	}

	public function doStuff() {
		$str = $this->keywordsForPage($GLOBALS['TSFE']->id, $GLOBALS['TSFE']->sys_page->sys_language_uid, 'header');
		return "\n" . '<meta name="keywords" content="' . $str . '" />' . "\n";
	}

	public function rawKeywords() {
		$str = $this->keywordsForPage($GLOBALS['TSFE']->id, $GLOBALS['TSFE']->sys_page->sys_language_uid, 'header');
		return $str;
	}

	public function listKeywords() {
		$str = $this->keywordsForPage($GLOBALS['TSFE']->id, $GLOBALS['TSFE']->sys_page->sys_language_uid, 'header');
		$str = explode(',', $str);
		foreach ($str AS $val) {
			$asdf .= $val . ' / ';
		}
		$asdf = substr($asdf, 0, -3);
		return $asdf;
	}
}

function user_displayKeywords() {
	$displayKeywords = new displayKeywords();
	return $displayKeywords->doStuff();
}

function user_rawKeywords() {
	$displayKeywords = new displayKeywords();
	return $displayKeywords->rawKeywords();
}

function user_listKeywords() {
	$displayKeywords = new displayKeywords();
	return $displayKeywords->listKeywords();
}
