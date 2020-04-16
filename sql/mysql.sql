#
# Table structure for table `mylinks_broken`
#

CREATE TABLE mylinks_broken (
  reportid INT(5)           NOT NULL AUTO_INCREMENT,
  lid      INT(11) UNSIGNED NOT NULL DEFAULT '0',
  sender   INT(11) UNSIGNED NOT NULL DEFAULT '0',
  ip       VARCHAR(20)      NOT NULL DEFAULT '',
  PRIMARY KEY (reportid),
  KEY lid (lid),
  KEY sender (sender),
  KEY ip (ip)
)
  ENGINE = MyISAM;
# --------------------------------------------------------

#
# Table structure for table `mylinks_cat`
#

CREATE TABLE mylinks_cat (
  cid    INT(5) UNSIGNED NOT NULL AUTO_INCREMENT,
  pid    INT(5) UNSIGNED NOT NULL DEFAULT '0',
  title  VARCHAR(50)     NOT NULL DEFAULT '',
  imgurl VARCHAR(150)    NOT NULL DEFAULT '',
  PRIMARY KEY (cid),
  KEY pid (pid)
)
  ENGINE = MyISAM;
# --------------------------------------------------------

#
# Table structure for table `mylinks_links`
#

CREATE TABLE mylinks_links (
  lid       INT(11) UNSIGNED NOT NULL AUTO_INCREMENT,
  cid       INT(5) UNSIGNED  NOT NULL DEFAULT '0',
  title     VARCHAR(100)     NOT NULL DEFAULT '',
  url       VARCHAR(250)     NOT NULL DEFAULT '',
  logourl   VARCHAR(60)      NOT NULL DEFAULT '',
  submitter INT(11) UNSIGNED NOT NULL DEFAULT '0',
  status    TINYINT(2)       NOT NULL DEFAULT '0',
  date      INT(10)          NOT NULL DEFAULT '0',
  hits      INT(11) UNSIGNED NOT NULL DEFAULT '0',
  rating    DOUBLE(6, 4)     NOT NULL DEFAULT '0.0000',
  votes     INT(11) UNSIGNED NOT NULL DEFAULT '0',
  comments  INT(11) UNSIGNED NOT NULL DEFAULT '0',
  PRIMARY KEY (lid),
  KEY cid (cid),
  KEY status (status),
  KEY title (title(40))
)
  ENGINE = MyISAM;
# --------------------------------------------------------

#
# Table structure for table `mylinks_mod`
#

CREATE TABLE mylinks_mod (
  requestid       INT(11) UNSIGNED NOT NULL AUTO_INCREMENT,
  lid             INT(11) UNSIGNED NOT NULL DEFAULT '0',
  cid             INT(5) UNSIGNED  NOT NULL DEFAULT '0',
  title           VARCHAR(100)     NOT NULL DEFAULT '',
  url             VARCHAR(250)     NOT NULL DEFAULT '',
  logourl         VARCHAR(150)     NOT NULL DEFAULT '',
  description     TEXT             NOT NULL,
  modifysubmitter INT(11) UNSIGNED NOT NULL DEFAULT '0',
  PRIMARY KEY (requestid)
)
  ENGINE = MyISAM;
# --------------------------------------------------------

#
# Table structure for table `mylinks_text`
#

CREATE TABLE mylinks_text (
  lid         INT(11) UNSIGNED NOT NULL DEFAULT '0',
  description TEXT             NOT NULL,
  KEY lid (lid)
)
  ENGINE = MyISAM;
# --------------------------------------------------------

#
# Table structure for table `mylinks_votedata`
#

CREATE TABLE mylinks_votedata (
  ratingid        INT(11) UNSIGNED    NOT NULL AUTO_INCREMENT,
  lid             INT(11) UNSIGNED    NOT NULL DEFAULT '0',
  ratinguser      INT(11) UNSIGNED    NOT NULL DEFAULT '0',
  rating          TINYINT(3) UNSIGNED NOT NULL DEFAULT '0',
  ratinghostname  VARCHAR(60)         NOT NULL DEFAULT '',
  ratingtimestamp INT(10)             NOT NULL DEFAULT '0',
  PRIMARY KEY (ratingid),
  KEY ratinguser (ratinguser),
  KEY ratinghostname (ratinghostname)
)
  ENGINE = MyISAM;
