CREATE TABLE IF NOT EXISTS `#__ddcbi_account_types` (
  `ddcbi_account_type_id` int(11) NOT NULL AUTO_INCREMENT,
  `account_type` varchar(100) NOT NULL,
  `alias` varchar(100) NOT NULL,
  `account_nature` int(3) NOT NULL,
  `state` tinyint(3) NOT NULL,
  `created` DATETIME NOT NULL default '0000-00-00 00:00:00',
  `modified` DATETIME NOT NULL default '0000-00-00 00:00:00',
  PRIMARY KEY (`ddcbi_account_type_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=1;

CREATE TABLE IF NOT EXISTS `#__ddcbi_accounts` (
  `ddcbi_account_id` int(11) NOT NULL AUTO_INCREMENT,
  `account_name` varchar(100) NOT NULL,
  `alias` varchar(100) NOT NULL,
  `account_number` varchar(100) NOT NULL,
  `sort_code` varchar(100) NOT NULL,
  `account_type` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `interest_rate` double NOT NULL,
  `notes` text NOT NULL,
  `state` tinyint(3) NOT NULL,
  `created` DATETIME NOT NULL default '0000-00-00 00:00:00',
  `modified` DATETIME NOT NULL default '0000-00-00 00:00:00',
  PRIMARY KEY (`ddcbi_account_id`),
  KEY `account_type` (`account_type`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=1;

CREATE TABLE IF NOT EXISTS `#__ddcbi_balances` (
  `ddcbi_balance_id` int(11) NOT NULL AUTO_INCREMENT,
  `account_name` int(11) NOT NULL,
  `balance` double NOT NULL,
  `record_date` DATETIME NOT NULL default '0000-00-00 00:00:00',
  `state` tinyint(3) NOT NULL,
  `created` DATETIME NOT NULL default '0000-00-00 00:00:00',
  `modified` DATETIME NOT NULL default '0000-00-00 00:00:00',
  `catid` int(11) NOT NULL default '0',
  PRIMARY KEY (`ddcbi_balance_id`),
  KEY `account_name` (`account_name`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;

CREATE TABLE IF NOT EXISTS `#__ddcbi_targets` (
  `ddcbi_target_id` int(11) NOT NULL AUTO_INCREMENT,
  `target_balance` double NOT NULL,
  `target_date` DATETIME NOT NULL default '0000-00-00 00:00:00',
  `catid` int(11) NOT NULL default '0',
  `accounttype_id` int(11) NOT NULL,
  `account_id` int(11) NOT NULL,
  `state` tinyint(3) NOT NULL,
  `created` DATETIME NOT NULL default '0000-00-00 00:00:00',
  `modified` DATETIME NOT NULL default '0000-00-00 00:00:00',
  PRIMARY KEY (`ddcbi_target_id`),
  KEY `account_id` (`account_id`),
  KEY `accounttype_id` (`accounttype_id`),
  KEY `catid` (`catid`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;