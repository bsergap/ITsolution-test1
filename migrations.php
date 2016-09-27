<?php
$table_name = TABLE;

//////////////////////////////////////////////////
$sql = <<<SQL
	CREATE TABLE IF NOT EXISTS `$table_name`(
	`id` SMALLINT UNSIGNED PRIMARY KEY
) ENGINE=MyISAM DEFAULT CHARSET=latin1 PACK_KEYS=1
SQL;
\Core\DB\Adapter::runQuery($sql);

//////////////////////////////////////////////////
$sql = <<<SQL
	ALTER IGNORE TABLE `$table_name`
		ADD COLUMN `num` INT NULL AFTER `id`
		-- ,ADD INDEX `num` (`num` ASC)
SQL;
\Core\DB\Adapter::runQuery($sql);

//////////////////////////////////////////////////
$data = array();

\Core\DB\Adapter::runQuery("DELETE QUICK FROM `$table_name`");
$sql = "INSERT INTO `$table_name` (`id`,`num`) VALUES";
for($i = 0; $i < CNT*CNT; $i++) {
	$sql .= ' ('.$i.',NULL),';
	$data[] = $i;
} $sql = rtrim($sql, ',');
\Core\DB\Adapter::runQuery($sql);

for($i = 0; $i < CNT; $i++) {
	$key = array_rand($data);
	$sql = "UPDATE `$table_name`
			SET num = ".rand(0, MAX).'
			WHERE id = '.$data[$key];
	unset($data[$key]);
	\Core\DB\Adapter::runQuery($sql);
}
