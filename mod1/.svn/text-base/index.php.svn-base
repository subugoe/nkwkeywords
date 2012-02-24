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
$LANG->includeLLFile('EXT:nkwkeywords/mod1/locallang.xml');
require_once(PATH_t3lib . 'class.t3lib_scbase.php');
$BE_USER->modAccess($MCONF, 1);	// This checks permissions and exits if the users has no permission for entry.
// DEFAULT initialization of a module [END]
/**
 * Module 'Keywords' for the 'nkwkeywords' extension.
 *
 * @author	Nils K. Windisch <windisch@sub.uni-goettingen.de>
 * @package	TYPO3
 * @subpackage	tx_nkwkeywords
 */
class tx_nkwkeywords_module1 extends t3lib_SCbase {
	var $pageinfo;
	/**
	 * Initializes the Module
	 * @return	void
	 */
	function init() {
		global $BE_USER, $LANG, $BACK_PATH, $TCA_DESCR, $TCA, $CLIENT, $TYPO3_CONF_VARS;
		parent::init();
		$modTSconfig = t3lib_BEfunc::getModTSconfig($id, 'mod.' . $GLOBALS['MCONF']['name']);
	}
	/**
	 * Adds items to the ->MOD_MENU array. Used for the function menu selector.
	 *
	 * @return	void
	 */
	function menuConfig() {
		global $LANG;
		$this->MOD_MENU = array(
			'function' => array(
				'1' => $LANG->getLL('function1'),
				'2' => $LANG->getLL('function2'),
				'3' => $LANG->getLL('function3'),
				'4' => $LANG->getLL('function4'),
			)
		);
		parent::menuConfig();
	}
	/**
	 * Main function of the module. Write the content to $this->content
	 * If you chose "web" as main module, you will need to consider the $this->id parameter which will contain the uid-number of the page clicked in the page tree
	 *
	 * @return	[type]		...
	 */
	function main()	{
		global $BE_USER, $LANG, $BACK_PATH, $TCA_DESCR, $TCA, $CLIENT, $TYPO3_CONF_VARS;
		// Access check!
		// The page will show only if there is a valid page and if this page may be viewed by the user
		$this->pageinfo = t3lib_BEfunc::readPageAccess($this->id, $this->perms_clause);
		$access = is_array($this->pageinfo) ? 1 : 0;
		// initialize doc
		$this->doc = t3lib_div::makeInstance('template');
		$this->doc->setModuleTemplate(t3lib_extMgm::extPath('nkwkeywords') . 'mod1/mod_template.html');
		$this->doc->backPath = $BACK_PATH;
		$docHeaderButtons = $this->getButtons();
		if (($this->id && $access) || ($BE_USER->user['admin'] && !$this->id))	{
			// Draw the form
			$this->doc->form = '<form action="" method="post" enctype="multipart/form-data">';
			// JavaScript
			$this->doc->JScode = '
				<script language="javascript" type="text/javascript">
					script_ended = 0;
					function jumpToUrl(URL)	{
						document.location = URL;
					}
				</script>
			';
			$this->doc->postCode='
				<script language="javascript" type="text/javascript">
					script_ended = 1;
					if (top.fsMod) top.fsMod.recentIds["web"] = 0;
				</script>
			';
			// Render content:
			$this->moduleContent();
		} else {
			// If no access or if ID == zero
			$docHeaderButtons['save'] = '';
			$this->content.=$this->doc->spacer(10);
		}
		// compile document
		$markers['FUNC_MENU'] = t3lib_BEfunc::getFuncMenu(
			1, 
			'SET[function]', 
			$this->MOD_SETTINGS['function'], 
			$this->MOD_MENU['function']);
		$markers['CONTENT'] = $this->content;
		// Build the <body> for the module
		$this->content = $this->doc->startPage($LANG->getLL('title'));
		$this->content.= $this->doc->moduleBody($this->pageinfo, $docHeaderButtons, $markers);
		$this->content.= $this->doc->endPage();
		$this->content = $this->doc->insertStylesAndJS($this->content);
	}
	/**
	 * Prints out the module HTML
	 *
	 * @return	void
	 */
	function printContent()	{
		$this->content.=$this->doc->endPage();
		echo $this->content;
	}
	/**
	 * Generates the module content
	 *
	 * @return	void
	 */
	function moduleContent()	{
		global $LANG;
		$confVars = $this->modTSconfig;
		$saveToDB = $confVars['properties']['savehere'];
			// keywordssavehere
		switch((string)$this->MOD_SETTINGS['function'])	{
			case 1:
				if (!is_numeric($confVars["properties"]["savehere"])) {
					$tmpContent .= '<p>' . $LANG->getLL('missingConf') . '</p>';
				} else {
					$res1 = $GLOBALS['TYPO3_DB']->exec_SELECTquery(
						'*', 
						'tx_nkwkeywords_keywords', 
						'', 
						'', 
						'title_de ASC', 
						'');
					$tmpContent .= '<table style="border:none; padding: 0; margin: 0;">';
					$tmpContent .= '<td style="border:1px solid black; width:100px;">';
					$tmpContent .= '<strong>DE</strong>';
					$tmpContent .= '</td>';
					$tmpContent .= '<td style="border:1px solid black; width:100px;">';
					$tmpContent .= '<strong>EN</strong>';
					$tmpContent .= '</td>';
					while($row1 = $GLOBALS['TYPO3_DB']->sql_fetch_assoc($res1)) {
						$tmpContent .= '<tr>';
						$tmpContent .= '<td style="border-bottom:1px solid black;">';
						$tmpContent .= $row1['title_de'];
						$tmpContent .= '</td>';
						$tmpContent .= '<td style="border-bottom:1px solid black;">';
						$tmpContent .= $row1['title_en'];
						$tmpContent .= '</td>';
						$tmpContent .= '</tr>';
					}
					$tmpContent .= '</table>';
				}
				$content = $tmpContent;
				$this->content.=$this->doc->section($LANG->getLL('allKeywords'), $content, 0, 1);
			break;
			case 2:
				if (!is_numeric($confVars['properties']['savehere'])) {
					$tmpContent .= '<p>' . $LANG->getLL('missingConf') . '</p>';
				} else {
					if ($_POST['tx_nkwkeywords']['keyword_de'] && $_POST['tx_nkwkeywords']['keyword_en']) {
						$values = array(
							'title' => $_POST['tx_nkwkeywords']['keyword_de'] . '/' 
								. $_POST['tx_nkwkeywords']['keyword_en'], 
							'title_de' => $_POST['tx_nkwkeywords']['keyword_de'], 
							'title_en' => $_POST['tx_nkwkeywords']['keyword_en'], 
							'crdate' => time(), 
							'tstamp' => time(), 
							'pid' => $confVars['properties']['savehere'],
						);
						$GLOBALS['TYPO3_DB']->exec_INSERTquery('tx_nkwkeywords_keywords', $values);
						$tmpContent .= '<p>';
						$tmpContent .= $LANG->getLL('keyword') . ' <strong>de: ' 
							. $_POST['tx_nkwkeywords']['keyword_de'] . ' - en: ' 
							. $_POST['tx_nkwkeywords']['keyword_en'] . '</strong> ' . $LANG->getLL('submitted');
						$tmpContent .= '.</p>';
						$tmpContent .= '<hr />';
					}
					$tmpContent .= '<form>';
					$tmpContent .= '<fieldset style="border:none;">';
					$tmpContent .= '<label for="nkwkeywords_keyword_de" style="font-weight:bold;">DE:</label>';
					$tmpContent .= ' <input type="text" id="nkwkeywords_keyword_de" name="tx_nkwkeywords[keyword_de]">';
					$tmpContent .= ' <label for="nkwkeywords_keyword_en" style="font-weight:bold;">EN:</label>';
					$tmpContent .= ' <input type="text" id="nkwkeywords_keyword_en" name="tx_nkwkeywords[keyword_en]">';
					$tmpContent .= '</fieldset>';
					$tmpContent .= '<input type="submit" name="' . $LANG->getLL('submit') . '">';
					$tmpContent .= '</form>';
				}
				$content = $tmpContent;
				$this->content .= $this->doc->section($LANG->getLL('addKeyword'), $content, 0, 1);
			break;
			case 3:
				if (!is_numeric($confVars['properties']['savehere'])) {
					$tmpContent .= '<p>' . $LANG->getLL('missingConf') . '</p>';
				} else {
					if ($_POST['tx_nkwkeywords']['keyword_de'] && $_POST['tx_nkwkeywords']['keyword_en'] 
						&& $_POST['tx_nkwkeywords']['uid']) {
						$values = array(
							'title' => $_POST['tx_nkwkeywords']['keyword_de'] . '/' 
							. $_POST['tx_nkwkeywords']['keyword_en'],
							'title_de' => $_POST['tx_nkwkeywords']['keyword_de'],
							'title_en' => $_POST['tx_nkwkeywords']['keyword_en'],
							'tstamp' => time(),
							'pid' => $confVars['properties']['savehere'],
						);
						$GLOBALS['TYPO3_DB']->exec_UPDATEquery(
							'tx_nkwkeywords_keywords', 
							'uid = ' . $GLOBALS['TYPO3_DB']->fullQuoteStr($_POST['tx_nkwkeywords']['uid'], 'tx_nkwkeywords_keywords'), 
							$values);
						$tmpContent .= '<p>';
						$tmpContent .= $LANG->getLL('keyword') . ' <strong>de: ' 
							. $_POST['tx_nkwkeywords']['keyword_de'] . ' - en: ' 
							. $_POST['tx_nkwkeywords']['keyword_en'] . '</strong> ' . $LANG->getLL('submitted');
						$tmpContent .= '.</p>';
						$tmpContent .= '<hr />';
					}
					$res1 = $GLOBALS['TYPO3_DB']->exec_SELECTquery(
						'*', 
						'tx_nkwkeywords_keywords', 
						'', 
						'', 
						'title_de ASC',
						'');
					while($row1 = $GLOBALS['TYPO3_DB']->sql_fetch_assoc($res1)) {
						$tmpContent .= '<form method="post">';
						$tmpContent .= '<label for="nkwkeywords_keyword_de" style="font-weight:bold;">DE:</label>';
						$tmpContent .= ' <input type="text" id="nkwkeywords_keyword_de" ' 
							. 'name="tx_nkwkeywords[keyword_de]" value="' . $row1['title_de'] . '">';
						$tmpContent .= ' <label for="nkwkeywords_keyword_en" style="font-weight:bold;">EN:</label>';
						$tmpContent .= ' <input type="text" id="nkwkeywords_keyword_en" ' 
							. 'name="tx_nkwkeywords[keyword_en]" value="' . $row1['title_en'] . '">';
						$tmpContent .= '<input type="hidden" name="tx_nkwkeywords[uid]" value="' . $row1['uid'] . '">';
						$tmpContent .= '<input type="submit" name="' . $LANG->getLL('submit') . '">';
						$tmpContent .= '</form>';
					}
					$tmpContent .= '</table>';
				}
				$content = $tmpContent;
				$this->content.=$this->doc->section($LANG->getLL('editKeywords'), $content, 0, 1);
			break;
			case 4:
				if (!is_numeric($confVars['properties']['savehere'])) {
					$tmpContent .= '<p>' . $LANG->getLL('missingConf') . '</p>';
				} else {
					if ($_POST['tx_nkwkeywords']['delete']) {
						$GLOBALS['TYPO3_DB']->exec_DELETEquery(
							'tx_nkwkeywords_keywords', 
							"uid='" . $_POST['tx_nkwkeywords']['delete'] . "'");
					}
					$res1 = $GLOBALS['TYPO3_DB']->exec_SELECTquery(
						'*', 
						'tx_nkwkeywords_keywords', 
						'', 
						'', 
						'title_de ASC',
						'');
					$tmpContent .= '<table style="border:none; padding: 0; margin: 0;">';
					$tmpContent .= '<td style="border:1px solid black; width:100px;"><strong>DE</strong></td>';
					$tmpContent .= '<td style="border:1px solid black; width:100px;"><strong>EN</strong></td><td></td>';
					while($row1 = $GLOBALS['TYPO3_DB']->sql_fetch_assoc($res1)) {
						$tmpContent .= '<tr>';
						$tmpContent .= '<td style="border-bottom:1px solid black;">' . $row1['title_de'] 
							. '</td><td style="border-bottom:1px solid black;">' . $row1['title_en'] . '</td>';
						$tmpContent .= '<td>';
						$tmpContent .= '<form method="post">';
						$tmpContent .= '<input type="hidden" name="tx_nkwkeywords[delete]" value="' 
							. $row1['uid'] . '">';
						$tmpContent .= '<input type="submit" value="' . $LANG->getLL('delete') . '">';
						$tmpContent .= '</form>';
						$tmpContent .= '</td>';
						$tmpContent .= '</tr>';
					}
					$tmpContent .= '</table>';
				}
				$content = $tmpContent;
				$this->content.=$this->doc->section($LANG->getLL('editKeywords'), $content, 0, 1);
			break;
		}
	}
	/**
	 * Create the panel of buttons for submitting the form or otherwise perform operations.
	 *
	 * @return	array	all available buttons as an assoc. array
	 */
	protected function getButtons()	{
		$buttons = array(
			'csh' => '',
			'shortcut' => '',
			'save' => ''
		);
			// CSH
		$buttons['csh'] = t3lib_BEfunc::cshItem('_MOD_web_func', '', $GLOBALS['BACK_PATH']);
			// SAVE button
		$buttons['save'] = '<input type="image" class="c-inputButton" name="submit" value="Update"' 
			. t3lib_iconWorks::skinImg($GLOBALS['BACK_PATH'], 'gfx/savedok.gif', '') 
			. ' title="' . $GLOBALS['LANG']->sL('LLL:EXT:lang/locallang_core.php:rm.saveDoc', 1) . '" />';
			// Shortcut
		if ($GLOBALS['BE_USER']->mayMakeShortcut())	{
			$buttons['shortcut'] = $this->doc->makeShortcutIcon('', 'function', $this->MCONF['name']);
		}
		return $buttons;
	}

}
if (defined('TYPO3_MODE') && $TYPO3_CONF_VARS[TYPO3_MODE]['XCLASS']['ext/nkwkeywords/mod1/index.php']) {
	include_once($TYPO3_CONF_VARS[TYPO3_MODE]['XCLASS']['ext/nkwkeywords/mod1/index.php']);
}
	// Make instance:
$SOBE = t3lib_div::makeInstance('tx_nkwkeywords_module1');
$SOBE->init();
	// Include files?
foreach($SOBE->include_once as $INC_FILE) {
	include_once($INC_FILE);
}
$SOBE->main();
$SOBE->printContent();
?>