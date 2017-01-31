<?php 

require_once('functions.php');

$id = $_GET['id'];

$dbh = connectDB();
$sql = "select * from input_info where id = :id";
$stmt = $dbh->prepare($sql);
$stmt->bindParam(":id", $id);
$stmt->execute();

$row = $stmt->fetch();

// var_dump($row);
// die;

if (!$row)
{
	header('Location: index.php');
	exit;
}
if ($_SERVER['REQUEST_METHOD'] == 'POST')
{
	$action = $_POST['action'];
	$starttime = $_POST['starttime'];
	$endtime = $_POST['endtime'];
	$created_at = $row['created_at'];
	
	$errors = array();

	// バリデーション
	if ($starttime == '')
	{
		$errors['starttime'] = '開始時間が未入力です。';
	}

	if ($endtime == '')
	{
		$errors['endtime'] = '終了時間が未入力です。';
	}

	// バリデーション突破後
	if (empty($errors))
	{
		$dbh = connectDB();
		$sql = "update input_info set action = :action, start_time = :starttime, end_time = :endtime,  created_at = :created_at where id = :id";
		$stmt = $dbh->prepare($sql);
		$stmt->bindParam(":id", $id);
		$stmt->bindParam(":action", $action);
		$stmt->bindParam(":starttime", $starttime);
		$stmt->bindParam(":endtime", $endtime);
		$stmt->bindParam(":created_at", $created_at);
		$stmt->execute();

		header('Location: index.php');
		exit;
	}
}

?>

<!DOCTYPE html>
<html>
  <head>
    <meta charset="utf-8">
    <title>timetracking - edit</title>
              <link rel="stylesheet" href="css/reset.css">
              <link rel="stylesheet" href="css/signup.css">
  </head>
  <body>
<div align="center">
<br><br>
<h1>工事中☆ </h1><br>
<a href="timer.php">タイムトラッキング画面に戻る</a><br>
<br>
<a href="http://proglamour.hatenablog.com/entry/2016/07/18/201545">プレゼンはつまらないので漫画を読む</a><br>
</div>
  </body>
</html>
