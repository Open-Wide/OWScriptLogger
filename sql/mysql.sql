CREATE TABLE `owscriptlogger` (
 `id` int(11) NOT NULL AUTO_INCREMENT,
 `identifier` varchar(100) NOT NULL,
 `date` datetime NOT NULL,
 `runtime` float DEFAULT NULL,
 `memory_usage` int(11) DEFAULT NULL,
 `memory_usage_peak` int(11) DEFAULT NULL,
 `notice_count` int(11) NOT NULL DEFAULT '0',
 PRIMARY KEY (`id`)
);

CREATE TABLE `owscriptlogger_log` (
 `owscriptlogger_id` int(11) NOT NULL,
 `level` varchar(100) NOT NULL,
 `action` varchar(100) NOT NULL,
 `date` datetime NOT NULL,
 `message` longtext NOT NULL
);

ALTER TABLE  `owscriptlogger` ADD  `notice_count` INT NOT NULL DEFAULT  '0';
ALTER TABLE  `owscriptlogger` ADD  `warning_count` INT NOT NULL DEFAULT  '0';
ALTER TABLE  `owscriptlogger` ADD  `error_count` INT NOT NULL DEFAULT  '0';
ALTER TABLE  `owscriptlogger` ADD  `status` varchar(100) NOT NULL DEFAULT  'running';