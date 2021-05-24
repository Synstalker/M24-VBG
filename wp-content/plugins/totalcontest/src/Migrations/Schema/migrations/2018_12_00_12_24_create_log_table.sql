CREATE TABLE IF NOT EXISTS `{{db.tables.log}}` (
  `id` BIGINT(20) UNSIGNED NOT NULL AUTO_INCREMENT,
  `ip` VARCHAR(45) DEFAULT NULL,
  `useragent` VARCHAR(512) NULL,
  `user_id` BIGINT(20) UNSIGNED DEFAULT NULL,
  `contest_id` BIGINT(20) UNSIGNED NOT NULL,
  `submission_id` BIGINT(20) UNSIGNED NOT NULL,
  `action` VARCHAR(100) NOT NULL,
  `status` VARCHAR(20) NOT NULL,
  `details` LONGTEXT NULL,
  `date` TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  KEY `IP` (`ip`),
  KEY `USER_ID` (`user_id`),
  KEY `CONTEST_ID` (`contest_id`),
  KEY `SUBMISSION_ID` (`submission_id`),
  KEY `ACTION` (`action`),
  KEY `STATUS` (`status`),
  KEY `DATE` (`date`)
) {{db.charset}};