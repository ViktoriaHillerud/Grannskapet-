<?php
session_start();
include_once 'db.php';
include_once 'User.php';
include_once 'Message.php';
include_once 'Neighbourgroup.php';
include_once 'Incident.php';  
include_once 'Event.php';    
g
$db = new Database();
$conn = $db->getConnection();

$user = new User($conn);
$messages = new Message($conn);
$neighbourgroup = new Neighbourgroup($conn);
$incidents = new Incident($conn);  
$events = new Event($conn);       

if (isset($_SESSION['userName'])) {
    $userId = $_SESSION['id'];

    $userMessages = $messages->getMessagesForUserNeighbourGroups($userId);
    $userIncidents = $incidents->getIncidentsForUserNeighbourGroups($userId);
    $userEvents = $events->getEventsForUserNeighbourGroups($userId);
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Home</title>
    <link rel="stylesheet" href="CSS/index.css">
</head>
<body>
    <header>
        <?php include 'assets/logo.svg'; ?>
        <span class="header-span">. . . din bostadsförening</span>
    </header>

    <?php if (isset($_SESSION["userName"])): ?>
        <section class="home-section">
            <article>
                <h2>Meddelanden</h2>
                <?php if ($userMessages): ?>
                    <?php foreach ($userMessages as $message): ?>
                        <p><?php echo htmlspecialchars($message['content']); ?></p>
                    <?php endforeach; ?>
                <?php else: ?>
                    <p>Inga meddelanden att visa</p>
                <?php endif; ?>
            </article>
            
            <article>
                <h2>Rapporter</h2>
                <?php if ($userIncidents): ?>
                    <?php foreach ($userIncidents as $incident): ?>
                        <p><?php echo htmlspecialchars($incident['descr']); ?></p>
                    <?php endforeach; ?>
                <?php else: ?>
                    <p>Inga incidenter att visa</p>
                <?php endif; ?>
            </article>
            
            <article>
                <h2>Nyheter</h2>
                <?php if ($userEvents): ?>
                    <?php foreach ($userEvents as $event): ?>
                        <p><?php echo htmlspecialchars($event['EventName']); ?></p>
                    <?php endforeach; ?>
                <?php else: ?>
                    <p>Inga evenemang att visa</p>
                <?php endif; ?>
            </article>
        </section>
    <?php else: ?>
        <section class="home-section">
		<article>
				<h1>Välkommen till Grannskapet!</h1>
				<p>Här kan du hitta din bostadsförening för att läsa vad som pågår i just din förening!</p>
			</article>

			<article>
				<h3>Börja med att registrera dig för att hitta din förening</h3>
				<button><a href='register.php'>Registrera</a></button>
				<button><a href='login.php'>Logga in</a></button>
			</article>
        </section>
    <?php endif; ?>
</body>
</html>
