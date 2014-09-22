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