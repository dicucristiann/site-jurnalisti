<?php

require_once "User.php";

class UserManager {
    private $db;

    public function __construct($db) {
        $this->db = $db;
    }

    public function getUserById($user_id) {
        $user = null;

        $stmt = $this->db->prepare("SELECT id, username, role FROM users WHERE id = ?");
        $stmt->bind_param("i", $user_id);

        if ($stmt->execute()) {
            $result = $stmt->get_result();

            if ($result->num_rows == 1) {
                $row = $result->fetch_assoc();
                $user = new User($row['id'], $row['username'], null, $row['role']);
            }
        }

        $stmt->close();
        return $user;
    }

    public function createUser($username, $password, $role) {
        $stmt = $this->db->prepare("INSERT INTO users (username, password, role) VALUES (?, ?, ?)");
        $stmt->bind_param("sss", $username, $password, $role);

        $result = $stmt->execute();

        $stmt->close();
        return $result;
    }
    public function authenticateUser($username, $password) {
        $user = null;

        $stmt = $this->db->prepare("SELECT id, username, role, password FROM users WHERE username = ?");
        $stmt->bind_param("s", $username);

        if ($stmt->execute()) {
            $result = $stmt->get_result();

            if ($result->num_rows == 1) {
                $row = $result->fetch_assoc();

                // Verify the password
                if ($password === $row['password']) {
                    $user = new User($row['id'], $row['username'],  null, $row['role']);
                }
            }
        }

        $stmt->close();
        return $user;
    }

    // Add more methods as needed, such as updateUser, deleteUser, etc.
}

?>