<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

include_once 'db.php';

function sanitize($input)
{
    return htmlspecialchars(strip_tags($input)); 
}

function userExists($email) {
    $conn = connectDB();

    $email = sanitize($email);

    $query = "SELECT COUNT(*) FROM users WHERE email = :email";
    
    try {
        $stmt = $conn->prepare($query);
        $stmt->bindParam(":email", $email, PDO::PARAM_STR);
        $stmt->execute();

        $count = $stmt->fetchColumn();

        return $count > 0;
    }
    catch (PDOException $error) {
        echo "Error: " . $error->getMessage();
        return false; 
    }
}

function register($userName, $email, $pass) {
    $conn = connectDB();

    if (userExists($email)) {
        echo "User  " . htmlspecialchars($email) . " already exists.";
        return;
    }
    $userName = sanitize($userName);
    $email = sanitize($email);
    $pass = sanitize($pass);

    $hashedPassword = password_hash($pass, PASSWORD_DEFAULT);

    try {
        $conn->beginTransaction();

        $query = "INSERT INTO users (userName, email, pass) VALUES (:userName, :email, :hashedPassword)";
        $stmt = $conn->prepare($query);
        $stmt->bindParam(":userName", $userName);
        $stmt->bindParam(":email", $email);
        $stmt->bindParam(":hashedPassword", $hashedPassword); 
        $stmt->execute();

        $userId = $conn->lastInsertId();

        $conn->commit();

        return $userId;

    } catch (PDOException $error) {
        $conn->rollBack();
        echo "Error: " . $error->getMessage();
    }
}

function login($userName, $password) {
    $conn = connectDB();

    $userName = sanitize($userName);
    $password = sanitize($password);

    $query = "SELECT * FROM users WHERE userName = :userName";

    try {
        $stmt = $conn->prepare($query);
        $stmt->bindParam(":userName", $userName, PDO::PARAM_STR);
        $stmt->execute();

        $user = $stmt->fetch(PDO::FETCH_ASSOC);

        if ($user && password_verify($password, $user['pass'])) {
            $_SESSION["userName"] = $user['userName'];
            $_SESSION["id"] = $user['id'];
            return $user; 
        } else {
            return false;
        }
    }
    catch (PDOException $error) {
        echo "Error: " . $error->getMessage();
        return false;
    }
}

function logout() {
    $_SESSION = array();

    if (ini_get("session.use_cookies")) {
        $params = session_get_cookie_params();
        setcookie(session_name(), '', time() - 42000,
            $params["path"], $params["domain"],
            $params["secure"], $params["httponly"]
        );
    }
    session_destroy();
}

// Hämta alla meddelanden kopplade till grannskapsgrupper som användaren är medlem i
function getMessagesForUserNeighbourGroups($id) {
    $conn = connectDB();

    $query = "
        SELECT m.*
        FROM messages m
        JOIN message_neighbourgroup mng ON m.id = mng.message_id
        JOIN user_neighbourgroup ung ON ung.group_id = mng.group_id
        WHERE ung.user_id = :id;
    ";

    try {
        $stmt = $conn->prepare($query);
        $stmt->bindParam(":id", $id, PDO::PARAM_INT);
        $stmt->execute();

        $stmt->setFetchMode(PDO::FETCH_ASSOC);
        return $stmt->fetchAll();
    } catch (PDOException $error) {
        echo "Error: " . $error->getMessage();
        return [];
    }
}

// Hämta alla incidenter kopplade till grannskapsgrupper som användaren är medlem i
function getIncidentsForUserNeighbourGroups($id) {
    $conn = connectDB();

    $query = "
        SELECT i.*
        FROM incidents i
        JOIN incident_neighbourgroup ing ON i.id = ing.incident_id
        JOIN user_neighbourgroup ung ON ung.group_id = ing.group_id
        WHERE ung.user_id = :id;
    ";

    try {
        $stmt = $conn->prepare($query);
        $stmt->bindParam(":id", $id, PDO::PARAM_INT);
        $stmt->execute();

        $stmt->setFetchMode(PDO::FETCH_ASSOC);
        return $stmt->fetchAll();
    } catch (PDOException $error) {
        echo "Error: " . $error->getMessage();
        return [];
    }
}

// Hämta alla evenemang kopplade till grannskapsgrupper som användaren är medlem i
function getEventsForUserNeighbourGroups($id) {
    $conn = connectDB();

    $query = "
        SELECT e.*
        FROM events e
        JOIN event_neighbourgroup eng ON e.id = eng.event_id
        JOIN user_neighbourgroup ung ON ung.group_id = eng.group_id
        WHERE ung.user_id = :id;
    ";

    try {
        $stmt = $conn->prepare($query);
        $stmt->bindParam(":id", $id, PDO::PARAM_INT);
        $stmt->execute();

        $stmt->setFetchMode(PDO::FETCH_ASSOC);
        return $stmt->fetchAll();
    } catch (PDOException $error) {
        echo "Error: " . $error->getMessage();
        return [];
    }
}

