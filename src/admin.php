<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);
session_start();

include 'db.php';
include 'User.php';



?>

<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<link rel="stylesheet" href="CSS/index.css">
	<title>Adminpanel</title>

	<section class="admin">
		<a href="?id=incident" id="incident">Ny incident + </a>
		<a href="?id=event" id="event">Nytt evenemang + </a>

		<a href="?id=users" id="users">Hantera anslutna medlemmar</a>

		<?php
		if (isset($_GET['id']) && $_GET['id'] === 'users'): ?>
			<span>Users clicked</span>
			<?php elseif (isset($_GET['id']) && $_GET['id'] === 'event'): ?>
				<span>Event clicked</span>
			<?php elseif (isset($_GET['id']) && $_GET['id'] === 'incident'): ?>
				<span>incident clicked</span>
			<?php endif; ?>
	</section>
</head>
<body>
	
</body>
</html>