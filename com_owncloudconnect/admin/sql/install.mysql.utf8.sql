DROP TABLE IF EXISTS `#__owncloudconnect_utilisateurs`;
DROP TABLE IF EXISTS `#__owncloudconnect`;

CREATE TABLE `#__owncloudconnect_utilisateurs` (
	id int(11) NOT NULL AUTO_INCREMENT,
	user_id int(11) NOT NULL,
	admin char(1) NOT NULL,
	forbid_admin char(1) NOT NULL,
	forbid_public char(1) NOT NULL,
	oc_login varchar(255) NOT NULL,
	oc_password varchar(255) NOT NULL,
	created datetime DEFAULT '0000-00-00 00:00:00' NOT NULL,
	modified datetime DEFAULT '0000-00-00 00:00:00' NOT NULL,
	PRIMARY KEY id (`id`)
) DEFAULT CHARSET=utf8;

 
CREATE TABLE `#__owncloudconnect` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `asset_id` INT(10) NOT NULL DEFAULT '0',  `greeting` varchar(25) NOT NULL,
  `catid` int(11) NOT NULL DEFAULT '0',
  `params` TEXT NOT NULL DEFAULT '',
   PRIMARY KEY  (`id`)
);
 
INSERT INTO `#__owncloudconnect` (`greeting`) VALUES
        ('Hello World!'),
        ('Good bye World!');