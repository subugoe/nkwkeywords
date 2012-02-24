#
# Table structure for table 'tx_nkwkeywords_keywords'
#
CREATE TABLE tx_nkwkeywords_keywords (
	uid int(11) NOT NULL auto_increment,
	pid int(11) DEFAULT '0' NOT NULL,
	tstamp int(11) DEFAULT '0' NOT NULL,
	crdate int(11) DEFAULT '0' NOT NULL,
	cruser_id int(11) DEFAULT '0' NOT NULL,
	sys_language_uid int(11) DEFAULT '0' NOT NULL,
	l10n_parent int(11) DEFAULT '0' NOT NULL,
	l10n_diffsource mediumtext,
	title_de varchar(255) DEFAULT '' NOT NULL,
	title_en varchar(255) DEFAULT '' NOT NULL,
	title text,
	PRIMARY KEY (uid),
	KEY parent (pid)
);
#
# Table structure for table 'pages'
#
CREATE TABLE pages (
	tx_nkwkeywords_keywords text
);