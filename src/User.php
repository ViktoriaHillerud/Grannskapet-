<?php
class User {
    private $conn;

    public function __construct($dbConnection) {
        $this->conn = $dbConnection; 
    }

    private function sanitize($input) {
        return htmlspecialchars(strip_tags($input)); 
    }

    public function userExists($email) {
        $email = $this->sanitize($email);
        $query = "SELECT COUNT(*) FROM users WHERE email = :email";

        try {
            $stmt = $this->conn->prepare($query);
            $stmt->bindParam(":email", $email, PDO::PARAM_STR);
            $stmt->execute();
            $count = $stmt->fetchColumn();
            return $count > 0;
        } catch (PDOException $error) {
            echo "Error: " . $error->getMessage();
            return false;
        }
    }

    public function register($userName, $email, $pass) {
        if ($this->userExists($email)) {
            echo "User " . htmlspecialchars($email) . " already exists.";
            return;
        }
        $userName = $this->sanitize($userName);
        $email = $this->sanitize($email);
        $pass = $this->sanitize($pass);
        $hashedPassword = password_hash($pass, PASSWORD_DEFAULT);

        try {
            $this->conn->beginTransaction();

            $query = "INSERT INTO users (userName, email, pass) 
                      VALUES (:userName, :email, :hashedPassword)";
            $stmt = $this->conn->prepare($query);
            $stmt->bindParam(":userName", $userName);
            $stmt->bindParam(":email", $email);
            $stmt->bindParam(":hashedPassword", $hashedPassword);
            $stmt->execute();

            $userId = $this->conn->lastInsertId();
            $this->conn->commit();
            return $userId;

        } catch (PDOException $error) {
            $this->conn->rollBack();
            echo "Error: " . $error->getMessage();
        }
    }

    public function login($userName, $password) {
        $userName = $this->sanitize($userName);
        $password = $this->sanitize($password);

        $query = "SELECT * FROM users WHERE userName = :userName";

        try {
            $stmt = $this->conn->prepare($query);
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
        } catch (PDOException $error) {
            echo "Error: " . $error->getMessage();
            return false;
        }
    }

    public function logout() {
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
}
