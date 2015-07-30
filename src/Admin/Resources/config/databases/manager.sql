CREATE TABLE fastd_manager(
  id INT UNSIGNED NOT NULL PRIMARY KEY AUTO_INCREMENT,
  nickname VARCHAR(20) NOT NULL ,
  username VARCHAR(20) NOT NULL,
  email VARCHAR(20) NOT NULL DEFAULT '',
  pwd CHAR(32) NOT NULL ,
  salt VARCHAR(32) NOT NULL DEFAULT '',
  roles VARCHAR(60) NOT NULL DEFAULT '',
  avatar VARCHAR(64) NOT NULL DEFAULT '',
  gender TINYINT(1) NOT NULL DEFAULT 1,
  ip_str VARCHAR(20) NOT NULL DEFAULT '',
  tel VARCHAR(20) NOT NULL DEFAULT '',
  create_at INT(10) NOT NULL DEFAULT 0,
  update_at INT(10) NOT NULL DEFAULT 0
)engine=innodb charset=utf8;