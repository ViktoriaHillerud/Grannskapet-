<?php
session_start();
include_once 'db.php';
include_once 'crud.php';

$conn = connectDB();

if (!isset($_SESSION["id"])) {
    header("Location: login.php");
    exit();
}

$userId = $_SESSION["id"];
?>

<style>
<?php include 'CSS/index.css'; ?>
</style>

<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<title>Home</title>
</head>
<body>
	<header>
		<?php include 'assets/logo.svg'; ?>
		<span class="header-span">. . . din bostadsförening</span>
	</header>

	<section class="home-section">
		<article>
			<h2>Meddelanden</h2>
			<?php
			$messages = getMessagesForUserNeighbourGroups($userId);
			if (!empty($messages)):
				foreach ($messages as $message): ?>
					<p><?php echo htmlspecialchars($message['content']); ?></p>
				<?php endforeach;
			else: ?>
				<p>Inga meddelanden att visa</p>
			<?php endif; ?>
		</article>
		
		<article>
			<h2>Rapporter</h2>
			<?php
			$incidents = getIncidentsForUserNeighbourGroups($userId);
			if (!empty($incidents)):
				foreach ($incidents as $incident): ?>
					<p><?php echo htmlspecialchars($incident['descr']); ?></p>
				<?php endforeach;
			else: ?>
				<p>Inga rapporter att visa</p>
			<?php endif; ?>
		</article>
		
		<article>
			<h2>Nyheter</h2>
			<?php
			$events = getEventsForUserNeighbourGroups($userId);
			if (!empty($events)):
				foreach ($events as $event): ?>
					<p><?php echo htmlspecialchars($event['EventName']); ?></p>
				<?php endforeach;
			else: ?>
				<p>Inga evenemang att visa</p>
			<?php endif; ?>
		</article>
	</section>

	<footer></footer>
</body>
</html>
