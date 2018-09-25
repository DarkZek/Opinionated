CREATE TABLE IF NOT EXISTS `poll_skips` (
	`id` int(10) NOT NULL auto_increment,
	`poll_id` int(10),
	`user_id` int(10),
	PRIMARY KEY( `id` )
);
