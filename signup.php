<?php
require_once('functions.php');

session_start;

if ($_SERVER['REQUEST_METHOD'] == 'POST')
{
		$name = $_POST['name'];
		$password = $_POST['password'];

		$error = array();
		
		// バリデーション
		if ($name == '')
		{
			$errors['name'] = 'ユーザ名が未入力です';
		}
		if ($password == '')
		{
			$errors['password'] = 'パスワードが未入力です';
		}

			// バリデーション突破後
			if (empty($errors))
			{
				$dbh = connectDB();
				$sql = "insert into users (user_name, password, created_at) values (:name, :password, now())";
				$stmt = $dbh->prepare($sql);
				$stmt->bindParam(":name", $name);
				$stmt->bindParam(":password", $password);
				$stmt->execute();

				header('Location: index.php');
				exit;
			}
}

?>
<!DOCTYPE html>
<html lang="ja">
<head>
	<meta charset="UTF-8">
	<title>新規登録画面</title>
                 <link rel="stylesheet" href="css/reset.css">
                 <link rel="stylesheet" href="css/signup.css">
</head>
<body>
<div align="center">
	<br>
	<br>
	<h1>新規登録</h1>
	<form action="" method="post">
		<font color="red">
		<?php if ($errors['name']): ?>
			<?php echo h($errors['name']) ?>
		<?php endif; ?>
		<br>
		<?php if ($errors['password']): ?>
			<?php echo h($errors['password']) ?>
		<?php endif; ?></font>
	<table>
		<tr>
		<td>ユーザー名:</td><td><input type="text" name="name"></td>
		</tr>
		<tr>
		<td>パスワード:</td><td><input type="text" name="password"></td>
		</tr>
	</table>
		<input type="submit" value="登録">
	</form>
	<br>
	<a href="index.php">ログインはこちら</a>
</div>
</body>
</html>
