<?php
tslib_eidtools::connectDB();

	// mapping fields to their equivalents
$table = array(
	'tx_nkwkeywords_keywords' => array(
		'title_de' => 'title_en',
	),
);

$mapping = array();

foreach ($table as $tableName => $mapping) {

		// just for development purposes
	deleteRecords($tableName);

		// rename tables
	$tableMap = renameTables($tableName);

	fixTable($tableName, $mapping);

echo '<hr />';
}


/**
 * Create new tables according to extbase style
 *
 * @param $table
 */
function renameTables($table) {

	$originalTable = $table;

	$table = getNewTableNames($originalTable);
	$query = 'CREATE TABLE ' . $table . ' LIKE ' . $originalTable . ';';
	$GLOBALS['TYPO3_DB']->sql_query($query);
	echo $originalTable . ' copied to ' . $table . '<br />';

}


/**
 * @param $table
 * @param $fieldMapping
 */
function fixTable($table, $fieldMapping) {

	$newTableName = getNewTableNames($table);

	// first of all add a 'title'-field to all tables if not existing
	addFields($newTableName, $fieldMapping);

    $records = 0;
	$i = 0;
	do {
		$abfrage = $GLOBALS['TYPO3_DB']->exec_SELECTQuery(
			'*',
			$table,
			'',
			'',
			''
		);

		while ($row = $GLOBALS['TYPO3_DB']->sql_fetch_assoc($abfrage)) {
			$records++;

			$loc = array();
			// Felder die in jeder Tabelle passen
			$loc['sys_language_uid'] = $i;
			if ($i === 1) {
				$loc['l18n_parent'] = $row['uid'];
				$loc['t3_origuid'] = $row['uid'];
			} else {
				$loc['uid'] = $row['uid'];
			}
			$loc['tstamp'] = time();
			$loc['crdate'] = time();
			$loc['cruser_id'] = $row['cruser_id'];
			$loc['pid'] = $row['pid'];
			if ($row['deleted']) {
				$loc['deleted'] = $row['deleted'];
			}
			if ($row['hidden']) {
				$loc['hidden'] = $row['hidden'];
			}
			if ($row['t3ver_oid']) {
				$loc['t3ver_oid'] = $row['t3ver_oid'];
				$loc['t3ver_id'] = $row['t3ver_id'];
				$loc['t3ver_wsid'] = $row['t3ver_wsid'];
				$loc['t3ver_label'] = $row['t3ver_label'];
				$loc['t3ver_state'] = $row['t3ver_state'];
				$loc['t3ver_stage'] = $row['t3ver_stage'];
				$loc['t3ver_count'] = $row['t3ver_count'];
				$loc['t3ver_tstamp'] = $row['t3ver_tstamp'];
				$loc['t3_origuid'] = $row['t3_origuid'];
			}

			$match = '/(.*)_(de|en)/';

			// kind of merge the mapping of custom to default typo3 fields
			foreach ($fieldMapping as $key => $val) {

				$newField = preg_replace($match, '$1', $key);
				$suffix = array('de', 'en');

				if (preg_match($match, $key)) {
					$oldField = $newField . '_' . $suffix[$i];
					$loc[$newField] = $row[$oldField];
				//	echo $oldField . ' - ' . $newField . ' - ' . $i . '<br />';
				} else {
					$loc[$key] = $row[$key];
				}
			}

		 $locInsert = $GLOBALS['TYPO3_DB']->exec_INSERTQuery(
				$newTableName,
				$loc
			);
		}
		$i++;
	}
	while ($i <= 1);
	echo  $records . ' records updated<br>';
}

/**
 * @param $table
 * @param $mapping
 */
function alterTables($table, $mapping) {

	$pattern = '/(.*?)_de/';
	$replace = '$1';

	foreach ($mapping as $key => $val) {
		$oldField = $key;
		$field = preg_replace($pattern, $replace, $key);
	}


}

/**
 * Delete new tables to start a fresh import
 *
 * @param $table
 */
function deleteRecords($table) {

	$originalTable = $table;

	$table = getNewTableNames($originalTable);
	$query = 'DROP TABLE ' . $table . ';';
	echo $table . ' deleted <br />';
	$GLOBALS['TYPO3_DB']->sql_query($query);
}


/**
 * Get new table names
 *
 * @param $table
 * @return mixed
 */
function getNewTableNames($table) {
	$pattern = '/tx_(.*?)_(.*)/';
	$replace = 'tx_$1_domain_model_$2';

	$table = preg_replace($pattern, $replace, $table);

	return $table;
}


/**
 * Adds and renames fields to fit the new tables
 *
 * @param $table
 */
function addFields($table, $fieldMapping) {
	$originalTable = $table;

	$query[] = 'ALTER TABLE ' . $table . ' ADD title VARCHAR(255);';
	$query[] = 'ALTER TABLE ' . $table . ' CHANGE COLUMN l10n_parent l18n_parent int(11);';
	$query[] = 'ALTER TABLE ' . $table . ' CHANGE COLUMN l10n_diffsource l18n_diffsource mediumblob;';
	$query[] = 'ALTER TABLE ' . $table . ' ADD t3ver_wsid int(11);';
	$query[] = 'ALTER TABLE ' . $table . ' ADD t3ver_id int(11);';
	$query[] = 'ALTER TABLE ' . $table . ' ADD t3ver_label varchar(30) DEFAULT \'\' NOT NULL';
	$query[] = 'ALTER TABLE ' . $table . ' ADD t3ver_state tinyint(4) DEFAULT \'0\' NOT NULL';
	$query[] = 'ALTER TABLE ' . $table . ' ADD t3ver_stage tinyint(4) DEFAULT \'0\' NOT NULL';
	$query[] = 'ALTER TABLE ' . $table . ' ADD t3ver_count int(11) DEFAULT \'0\' NOT NULL';
	$query[] = 'ALTER TABLE ' . $table . ' ADD t3ver_oid int(11) DEFAULT \'0\' NOT NULL';
	$query[] = 'ALTER TABLE ' . $table . ' ADD t3ver_tstamp int(11) DEFAULT \'0\' NOT NULL';
	$query[] = 'ALTER TABLE ' . $table . ' ADD t3_origuid int(11) DEFAULT \'0\' NOT NULL';
	$query[] = 'ALTER TABLE ' . $table . ' ADD deleted int(11) DEFAULT \'0\' NOT NULL';
	$query[] = 'ALTER TABLE ' . $table . ' ADD hidden int(11) DEFAULT \'0\' NOT NULL';

	$match = '/(.*)_de/';

		// add fields that contain localization
	foreach ($fieldMapping as $key => $val) {
		if (preg_match($match, $key) && $key != 'title_de') {

			$newField = preg_replace($match, '$1', $key);
			echo 'Added new field <strong>' . $newField .'</strong><br/>';
			$query[] = 'ALTER TABLE ' . $table . ' ADD '. $newField .' text;';
		}

	}


	foreach ($query as $statement) {
		$GLOBALS['TYPO3_DB']->sql_query($statement);
	}

	echo 'Fields altered in table ' . $table . '<br />';
}

?>