<?php

/* * *************************************************************
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
 * ************************************************************* */
require_once(PATH_tslib. 'class.tslib_pibase.php');
require_once(t3lib_extMgm::extPath('nkwlib') . 'class.tx_nkwlib.php');

/**
 * Plugin 'Keywordpage' for the 'nkwkeywords' extension.
 *
 * @author	Nils K. Windisch <windisch@sub.uni-goettingen.de>
 * @package	TYPO3
 * @subpackage	tx_nkwkeywords
 */
class tx_nkwkeywords_pi3 extends tslib_pibase {

	var $prefixId = 'tx_nkwkeywords_pi3';
	var $scriptRelPath = 'pi3/class.tx_nkwkeywords_pi3.php';
	var $extKey = 'nkwkeywords';
	var $pi_checkCHash = true;

	protected $keyWordId;
	protected $lang;

	function main($content, $conf) {
			// basics
		$this->conf = $conf;
		$this->pi_setPiVarDefaults();
		$this->pi_loadLL();
		$this->lang = tx_nkwlib::getLanguage();
			// get vars
		$getVars = t3lib_div::_GP("tx_nkwkeywords");
			// get pages with keyword
		if (t3lib_div::testInt($getVars['id'])) {
			$this->keyWordId = $getVars['id'];
				// get data
			$res1 = $GLOBALS['TYPO3_DB']->exec_SELECTquery(
					'*',
					'pages',
					'FIND_IN_SET(' . $this->keyWordId . ', tx_nkwkeywords_keywords) AND hidden = 0 AND deleted = 0 AND doktype != 254 AND pid > 0 AND pid != 21 AND pid != 108 AND pid != 107 AND pid != 105 AND pid != 106',
					'',
					'title ASC',
					'');
				// helper
			$i = 0;
				// get data
			while ($row1 = $GLOBALS['TYPO3_DB']->sql_fetch_assoc($res1)) {
				$arrPages[$i]['uid'] = $row1['uid'];
				$arrPages[$i]['title'] = $row1['title'];
					// get page title for any language other than 0
				if ($this->lang != 0) {
					$arrPages[$i]['title'] = tx_nkwlib::getPageTitle($row1['uid'], $this->lang);
				}
				$arrPages[$i]['pid'] = $row1['pid'];
				$i++;
			}
		}
			// are there any associated pages?
		if (sizeof($arrPages) >= 1) {
			
			$tmpContent = '<h2>' . $this->getKeyword() . '</h2>';
			$tmpContent .= '<ul>';
			foreach ($arrPages AS $key1 => $value1) {
				$tmpContent .= '<li>';
				$saveATagParams = $GLOBALS['TSFE']->ATagParams; // evil T3 URL hack
				$GLOBALS['TSFE']->ATagParams = ' title = "' . $value1['title'] . '"'; // evil T3 URL hack
				$tmpContent .= $this->pi_LinkToPage($value1['title'], $value1['uid'], '', '');
				$GLOBALS['TSFE']->ATagParams = $saveATagParams; // evil T3 URL hack
					// show parent page only if there is a valid one
				if ($value1['pid']) {
					$parent = tx_nkwlib::pageInfo($value1['pid'], $this->lang);
					if ($parent['title']) {
						$tmpContent .= ' (' . $parent['title'] . ')';
						// no foreign parent page, so get the fallback page title instead
					} else {
						$parent = tx_nkwlib::pageInfo($value1['pid'], 0);
						$tmpContent .= ' (' . $parent['title'] . ')';
					}
				}
				$tmpContent .= '</li>';
			}
			$tmpContent .= '</ul>';
			// no content and tell so
		} else {
			$tmpContent .= '<p>' . $this->pi_getLL('nocontent') . '</p>';
		}
			// return
		$content = $tmpContent;
		return $this->pi_wrapInBaseClass($content);
	}

	/**
	 * get the KeywordTitle for a specified KewordId
	 *
	 * @return mixed
	 */
	protected function getKeyword() {
		$keywordQuery = $GLOBALS['TYPO3_DB']->exec_SELECTquery(
							'title_de, title_en, uid',
							'tx_nkwkeywords_keywords',
							'uid = ' . $this->keyWordId,
							'',
							'',
							'');

		$keywordResult = $GLOBALS['TYPO3_DB']->sql_fetch_assoc($keywordQuery);

		$this->lang === 0 ? $return = $keywordResult['title_de'] : $return = $keywordResult['title_en'];

		return $return;
	}

}

if (defined('TYPO3_MODE')
		&& $TYPO3_CONF_VARS[TYPO3_MODE]['XCLASS']['ext/nkwkeywords/pi3/class.tx_nkwkeywords_pi3.php']) {
	include_once($TYPO3_CONF_VARS[TYPO3_MODE]['XCLASS']['ext/nkwkeywords/pi3/class.tx_nkwkeywords_pi3.php']);
}
?>