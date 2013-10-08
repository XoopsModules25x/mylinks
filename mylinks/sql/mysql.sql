#
# Table structure for table `mylinks_broken`
#

CREATE TABLE mylinks_broken (
  reportid int(5) NOT NULL auto_increment,
  lid int(11) unsigned NOT NULL default '0',
  sender int(11) unsigned NOT NULL default '0',
  ip varchar(20) NOT NULL default '',
  PRIMARY KEY  (reportid),
  KEY lid (lid),
  KEY sender (sender),
  KEY ip (ip)
) ENGINE=MyISAM;
# --------------------------------------------------------

#
# Table structure for table `mylinks_cat`
#

CREATE TABLE mylinks_cat (
  cid int(5) unsigned NOT NULL auto_increment,
  pid int(5) unsigned NOT NULL default '0',
  title varchar(50) NOT NULL default '',
  imgurl varchar(150) NOT NULL default '',
  PRIMARY KEY  (cid),
  KEY pid (pid)
) ENGINE=MyISAM;
# --------------------------------------------------------

#
# Table structure for table `mylinks_links`
#

CREATE TABLE mylinks_links (
  lid int(11) unsigned NOT NULL auto_increment,
  cid int(5) unsigned NOT NULL default '0',
  title varchar(100) NOT NULL default '',
  url varchar(250) NOT NULL default '',
  logourl varchar(60) NOT NULL default '',
  submitter int(11) unsigned NOT NULL default '0',
  status tinyint(2) NOT NULL default '0',
  date int(10) NOT NULL default '0',
  hits int(11) unsigned NOT NULL default '0',
  rating double(6,4) NOT NULL default '0.0000',
  votes int(11) unsigned NOT NULL default '0',
  comments int(11) unsigned NOT NULL default '0',
  PRIMARY KEY  (lid),
  KEY cid (cid),
  KEY status (status),
  KEY title (title(40))
) ENGINE=MyISAM;
# --------------------------------------------------------

#
# Table structure for table `mylinks_mod`
#

CREATE TABLE mylinks_mod (
  requestid int(11) unsigned NOT NULL auto_increment,
  lid int(11) unsigned NOT NULL default '0',
  cid int(5) unsigned NOT NULL default '0',
  title varchar(100) NOT NULL default '',
  url varchar(250) NOT NULL default '',
  logourl varchar(150) NOT NULL default '',
  description text NOT NULL,
  modifysubmitter int(11) unsigned NOT NULL default '0',
  PRIMARY KEY  (requestid)
) ENGINE=MyISAM;
# --------------------------------------------------------

#
# Table structure for table `mylinks_text`
#

CREATE TABLE mylinks_text (
  lid int(11) unsigned NOT NULL default '0',
  description text NOT NULL,
  KEY lid (lid)
) ENGINE=MyISAM;
# --------------------------------------------------------

#
# Table structure for table `mylinks_votedata`
#

CREATE TABLE mylinks_votedata (
  ratingid int(11) unsigned NOT NULL auto_increment,
  lid int(11) unsigned NOT NULL default '0',
  ratinguser int(11) unsigned NOT NULL default '0',
  rating tinyint(3) unsigned NOT NULL default '0',
  ratinghostname varchar(60) NOT NULL default '',
  ratingtimestamp int(10) NOT NULL default '0',
  PRIMARY KEY  (ratingid),
  KEY ratinguser (ratinguser),
  KEY ratinghostname (ratinghostname)
) ENGINE=MyISAM;
