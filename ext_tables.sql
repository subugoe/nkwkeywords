#
# Table structure for table 'tx_nkwkeywords_keywords'
#
CREATE TABLE tx_nkwkeywords_domain_model_keywords (
	uid int(11) NOT NULL auto_increment,
	pid int(11) DEFAULT '0' NOT NULL,
	tstamp int(11) DEFAULT '0' NOT NULL,
	crdate int(11) DEFAULT '0' NOT NULL,
	cruser_id int(11) DEFAULT '0' NOT NULL,
	sys_language_uid int(11) DEFAULT '0' NOT NULL,

	t3ver_oid int(11) DEFAULT '0' NOT NULL,
	t3ver_id int(11) DEFAULT '0' NOT NULL,
	t3ver_wsid int(11) DEFAULT '0' NOT NULL,
	t3ver_label varchar(30) DEFAULT '' NOT NULL,
	t3ver_state tinyint(4) DEFAULT '0' NOT NULL,
	t3ver_stage tinyint(4) DEFAULT '0' NOT NULL,
	t3ver_count int(11) DEFAULT '0' NOT NULL,
	t3ver_tstamp int(11) DEFAULT '0' NOT NULL,
	t3_origuid int(11) DEFAULT '0' NOT NULL,
	l18n_parent int(11) DEFAULT '0' NOT NULL,
	l18n_diffsource mediumblob,
	title text,
	pages int(11) DEFAULT '0' NOT NULL,
	PRIMARY KEY (uid),
	KEY parent (pid)
);
#
# Table structure for table 'pages'
#
CREATE TABLE pages (
	tx_nkwkeywords_keywords int(11) DEFAULT '0' NOT NULL
);

#
# mm table for pages and keywords
#
CREATE TABLE tx_nkwkeywords_pages_keywords_mm (
  uid int(11) NOT NULL auto_increment,
  pid int(11) NOT NULL DEFAULT '0',
  uid_local int(11) NOT NULL DEFAULT '0',
  uid_foreign int(11) NOT NULL DEFAULT '0',
  sorting int(11) NOT NULL DEFAULT '0',
  sorting_foreign int(11) NOT NULL DEFAULT '0',
  tstamp int(11) NOT NULL DEFAULT '0',
  crdate int(11) NOT NULL DEFAULT '0',
  hidden tinyint(3) unsigned DEFAULT '0',

  PRIMARY KEY (uid),
  KEY parent (pid)
);