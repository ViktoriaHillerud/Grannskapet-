<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);
include 'crud.php';

if (isset($_POST["register"])) {
    session_unset();
    
    if (empty($_POST["userName"]) || empty($_POST["email"]) || empty($_POST["password"])) {
        $message = "<center><h1>Fyll i alla fält för att fortsätta!</h1></center>";
    } else {
        $id = register($_POST["userName"], $_POST["email"], $_POST["password"]);
        if ($id) {
            // Set the userName and id in the session
            $_SESSION["userName"] = $_POST["userName"];
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
		</div>
	
		<button type="submit" name="register">Registrera</button>
	</form>
	</div>
	
</body>
</html>