CREATE TABLE users (
  userid int(25) NOT NULL auto_increment,
  first_name varchar(25) NOT NULL default '',
  last_name varchar(25) NOT NULL default '',
  email_address varchar(25) NOT NULL default '',
  username varchar(25) NOT NULL default '',
  password varchar(255) NOT NULL default '',
  info text NOT NULL,
  user_level enum('0','1','2','3') NOT NULL default '0',
  signup_date datetime NOT NULL default '0000-00-00 00:00:00',
  last_login datetime NOT NULL default '0000-00-00 00:00:00',
  activated enum('0','1') NOT NULL default '0',
  PRIMARY KEY  (userid)
) TYPE=MyISAM COMMENT='Membership Information';
