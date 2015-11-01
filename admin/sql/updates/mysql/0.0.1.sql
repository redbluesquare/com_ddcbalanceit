ALTER TABLE `#__ddci_accounts` 
ADD COLUMN `alias` varchar(100) NULL DEFAULT '' AFTER `account_name`;
