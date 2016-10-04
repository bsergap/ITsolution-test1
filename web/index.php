<?php
// mb_internal_encoding("ISO-8859-1");
// if(!empty($_GET['test'])) die("Ok!");
require_once __DIR__.'/../init.server.php';
//////////////////////////////////////////////////
define('V', '1.1');
include __DIR__.'/inc/header.php';
//////////////////////////////////////////////////
// echo '<pre>'; var_dump($_SESSION); echo '</pre>'; //exit;
?>

<?php
define('CNT', 100); // Determining the size of a square matrix
define('MAX', 99999); // Determining the size of a random value
define('TABLE', 'test1');

switch($_GET['action']) { // Switch of tasks, 4testing
	case 'migrate':
		require __DIR__.'/../migrations.php';
		break;

	case 'clear':
		\Core\DB\Adapter::runQuery("DROP TABLE IF EXISTS `test1`");
		break;
	
	default;
}
?>

<form action="" method="POST" id="data-form">
	<input type="hidden" name="csrf_token" value="<?=$_SESSION['csrf'];?>">
	<table>
<?php
$cnt = 0;
$table_name = TABLE;
$res = \Core\DB\Adapter::runQuery("SELECT * FROM `$table_name`");
if($res) {
	while($obj = $res->fetch_object()) {
		if($_SESSION['csrf-is-valid']) {
			$num = $_POST['data'][$obj->id];
			if($num != $obj->num) {
				\Core\DB\Adapter::runQuery("UPDATE `$table_name` SET num = ".
					(empty($num) ? 'NULL' : $num)." WHERE id = {$obj->id}");
				$obj->num = $num;
			}
		}

		if($cnt++ % CNT == 0) echo '<tr>';
		echo '<td><input type="text" name="data['.$obj->id.']" value="'.$obj->num.'" class="data-cell"></td>';
		if($cnt % CNT == 0) echo '</tr>'.PHP_EOL;
	}
	$res->close();
}
?>
	</table>
	<input type="submit">
</form>

<?php
//////////////////////////////////////////////////
include __DIR__.'/inc/footer.php';
// die('Ok!');
