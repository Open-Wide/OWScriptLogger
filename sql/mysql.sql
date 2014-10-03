CREATE TABLE `owscriptlogger` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `identifier` varchar(100) NOT NULL,
  `owscriptlogger_script_id` int(11) NOT NULL DEFAULT '0',
  `date` datetime NOT NULL,
  `runtime` float DEFAULT NULL,
  `memory_usage` int(11) DEFAULT NULL,
  `memory_usage_peak` int(11) DEFAULT NULL,
  `notice_count` int(11) DEFAULT NULL,
  `warning_count` int(11) DEFAULT NULL,
  `error_count` int(11) DEFAULT NULL,
  `status` varchar(100) NOT NULL DEFAULT 'running',
  PRIMARY KEY (`id`)
);

CREATE TABLE `owscriptlogger_log` (
  `owscriptlogger_id` int(11) NOT NULL DEFAULT '0',
  `level` varchar(100) NOT NULL,
  `action` varchar(100) NOT NULL,
  `date` datetime NOT NULL,
  `message` longtext NOT NULL
);

CREATE TABLE `owscriptlogger_script` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `identifier` varchar(100) NOT NULL,
  `database_log_level` varchar(10) NOT NULL DEFAULT 'notive',
  `fatal_error_recipients` text,
  `max_age_error` int(11) DEFAULT '0',
  `max_age_finished` int(11) DEFAULT '0',
  `max_age_manually_stoped` int(11) DEFAULT '0',
  `no_db_log_actions` text,
  PRIMARY KEY (`id`)
);