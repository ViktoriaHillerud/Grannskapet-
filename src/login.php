<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);
session_start();

include 'db.php';
include 'User.php';

$database = new Database();
$db = $database->getConnection();

$user = new User($db);

if(isset($_SESSION["userName"])) {
    header("Location: index.php");
    exit();
} 

if (isset($_POST["login"])) {
    if (empty($_POST["userName"]) || empty($_POST["password"])) {
        echo "<center><h1>Please fill all the fields</h1></center>";
    } else {
        $userDetails = $user->login($_POST["userName"], $_POST["password"]);
        if ($userDetails) {
            $_SESSION["userName"] = $userDetails['userName'];
            $_SESSION["id"] = $userDetails['id'];
            header("Location: index.php");
            exit();
        } else {
            echo "<center><h1>Invalid userName or password</h1></center>";
        }
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<title>Login</title>
</head>
<body>
	<div class="wrapper">
	<form method="POST" action="">
		<div>
		<label for="userName">Användarnamn</label>
		<input type="text" name="userName" id="userName">
		</div>
		<div>
		<label for="password">Lösenord</label>
		<input type="text" name="password" id="password">
		</div>
		<button type="submit" name="login">Login</button>
	</form>
	</div>
</body>
</html>
