<?php
class Message {
    private $conn;

    public function __construct($dbConnection) {
        $this->conn = $dbConnection;
    }

    public function createMessage($content, $type, $userId) {
        try {
            $query = "INSERT INTO messages (content, type, time, user_id) VALUES (:content, :type, NOW(), :userId)";
            $stmt = $this->conn->prepare($query);
            $stmt->bindParam(":content", $content);
            $stmt->bindParam(":type", $type);
            $stmt->bindParam(":userId", $userId);
            $stmt->execute();
        } catch (PDOException $error) {
            echo "Error: " . $error->getMessage();
        }
    }

    public function getMessagesForUserNeighbourGroups($id) {
        $query = "
            SELECT m.*
            FROM messages m
            JOIN message_neighbourgroup mng ON m.id = mng.message_id
            JOIN user_neighbourgroup ung ON ung.group_id = mng.group_id
            WHERE ung.user_id = :id;
        ";
        try {
            $stmt = $this->conn->prepare($query);
            $stmt->bindParam(":id", $id);
            $stmt->execute();
            return $stmt->fetchAll(PDO::FETCH_ASSOC);
        } catch (PDOException $error) {
            echo "Error: " . $error->getMessage();
			return [];
        }
    }
}
?>
