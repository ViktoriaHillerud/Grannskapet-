<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);
session_start();

include 'db.php';
include 'User.php';

$database = new Database();
$db = $database->getConnection();

$user = new User($db);

if (isset($_POST["register"])) {
    session_unset();

    if (empty($_POST["userName"]) || empty($_POST["email"]) || empty($_POST["password"])) {
        $message = "<center><h1>Fyll i alla fält för att fortsätta!</h1></center>";
    } else {
        $id = $user->register($_POST["userName"], $_POST["email"], $_POST["password"], $_POST["role"]);
        if ($id) {
            $_SESSION["userName"] = $_POST["userName"];
			$_SESSION["role"] = $_POST["role"];
            $_SESSION["id"] = $id;


            header("Location: index.php");
            exit();
        } else {
            $message = "<center><h1>Registrering misslyckades</h1></center>";
        }
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<title>Register</title>
</head>
<body>
	<div class="wrapper">
	<form method="POST" action="">
		<div>
		<label for="userName">Användarnamn</label>
		<input type="text" name="userName" id="userName">
		</div>
		<div>
		<label for="email">E-post</label>
		<input type="text" name="email" id="email">
		</div>
		<div>
		<label for="password">Lösenord</label>
		<input type="text" name="password" id="password">
		<input type="hidden" name="role" id="role" value="1">
		</div>
		<button type="submit" name="register">Registrera</button>
	</form>
	</div>
</body>
</html>
