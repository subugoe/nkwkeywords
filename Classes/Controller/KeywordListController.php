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

/**
 * Plugin 'Keywordlist' for the 'nkwkeywords' extension.
 */
class KeywordListController extends \TYPO3\CMS\Frontend\Plugin\AbstractPlugin {
	var $prefixId = 'tx_nkwkeywords_pi2';
	var $scriptRelPath = 'pi2/class.tx_nkwkeywords_pi2.php';
	var $extKey = 'nkwkeywords';
	var $pi_checkCHash = true;

	/**
	 * undocumented function
	 *
	 * @return void
	 **/
	function charset_decode_utf_8($string) {
		/* Only do the slow convert if there are 8-bit characters */
		/* avoid using 0xA0 (\240) in ereg ranges. RH73 does not like that */
		if (!preg_match("[\200-\237]", $string) and !preg_match("[\241-\377]", $string)) {
			return $string;
		}
		// decode three byte unicode characters 
		$string = preg_replace(
				"/([\340-\357])([\200-\277])([\200-\277])/e",
				"'&#'.((ord('\\1')-224)*4096 + (ord('\\2')-128)*64 + (ord('\\3')-128)).';'",
				$string);
		// decode two byte unicode characters 
		$string = preg_replace(
				"/([\300-\337])([\200-\277])/e",
				"'&#'.((ord('\\1')-192)*64+(ord('\\2')-128)).';'",
				$string);
		return $string;
	}

	/**
	 * @param $content
	 * @param $conf
	 * @return string
	 */
	public function main($content, $conf) {
		$this->conf = $conf;
		$this->pi_setPiVarDefaults();
		$this->pi_loadLL();
		$this->pi_initPIflexform();
		// basics
		$lang = $GLOBALS['TSFE']->sys_page->sys_language_uid;
		$targetPage = $this->pi_getFFvalue($this->cObj->data['pi_flexform'], 'target', 'sDEF');
		if ($lang == 0) {
			$sep = '_de';
		} else if ($lang == 1) {
			$sep = '_en';
		}
		// get data
		$res1 = $GLOBALS['TYPO3_DB']->exec_SELECTquery(
				'uid, title' . $sep . ' as sep',
				'tx_nkwkeywords_keywords',
				'',
				'',
				'title' . $sep . ' ASC',
				'');
		$i = 0;
		$arr = array();
		while ($row1 = $GLOBALS['TYPO3_DB']->sql_fetch_assoc($res1)) {
			$letter = strtoupper(mb_substr($row1['sep'], 0, 1, 'UTF-8'));
			if (!in_array($letter, $arr)) {
				$arr[] = $letter;
				$i = 0;
			}
			$keywords[$letter][$i]['id'] = $row1['uid'];
			$keywords[$letter][$i]['title'] = $row1['sep'];
			$i++;
		}
		// output
		// letter navigation
		$tmpContent = '<ul>';
		foreach ($arr AS $value) {
			$tmpContent .= '<li style="display: inline;"><a href="#' . $value . '">' . $value . '</a> </li>';
		}
		$tmpContent .= '</ul>';
		$tmpContent .= '<ul>';
		foreach ($keywords AS $key1 => $value1) {
			$tmpContent .= '<li style="list-style-type:none;"><a name="' . $key1 . '"></a>' . $key1;
			$tmpContent .= '<ul>';
			$tmpSizeof = sizeof($value1);
			for ($ii = 0; $ii < $tmpSizeof; $ii++) {
				$tmpContent .= '<li>';
				$this->cObj->typoLink(
						$value1[$ii]['title'],
						array(
								'parameter' => $targetPage,
								'useCacheHash' => true,
								'additionalParams' => '&tx_nkwkeywords[id]=' . $value1[$ii]['id']
						)
				);
				$tmpContent .= '<a title="' . $value1[$ii]['title'] . '" href="' . $this->cObj->lastTypoLinkUrl . '">' . $value1[$ii]['title'] . '</a>';
				$tmpContent .= '</li>';
			}
			$tmpContent .= '</ul>';
			$tmpContent .= '</li>';
		}
		$tmpContent .= '</ul>';
		$content = $tmpContent;

		return $this->pi_wrapInBaseClass($content);
	}
}
