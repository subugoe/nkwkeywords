<?php
tslib_eidtools::connectDB();

$table = 'pages';

$query = $GLOBALS['TYPO3_DB']->exec_SELECTQuery(
	'*',
	$table,
	'',
	'uid ASC',
	''
);

$keywords = array();

	// put all keywords and page uids into an array
while ($row = $GLOBALS['TYPO3_DB']->sql_fetch_assoc($query)) {

	if ($row['tx_nkwkeywords_keywords']) {
		$pid = $row['uid'];
		$keys = t3lib_div::trimExplode(',', $row['tx_nkwkeywords_keywords']);

		$keywords[$pid] = array();
		$keywords[$pid] = $keys;
	}

}

foreach ($keywords as $key => $val) {
	foreach ($val as $keyword) {
		$insert =  'INSERT INTO tx_nkwkeywords_pages_keywords_mm (uid_local, uid_foreign) VALUES (' . $key . ', ' . $keyword . ');';
		
		$insertFields = array(
			'uid_local' => $key,
			'uid_foreign' => $keyword
		);
		
		$GLOBALS['TYPO3_DB']->exec_INSERTquery (
			'tx_nkwkeywords_pages_keywords_mm',
			$insertFields
		);
	}
}
