<?php
class db
{
    private $host = 'localhost';
    private $database = 'db_kims';
    private $username = 'root';
    private $password = '';

    public function InsertInvoices($user_id, $xendit_id, $invoice_id)
    {
        $connection = new PDO("mysql:host=$this->host;dbname=$this->database", $this->username, $this->password);
        $connection->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        $query = "INSERT INTO invoices (user_id, xendit_id,invoice_id) VALUES (:user_id, :xendit_id,:invoice_id)";
        try {
            $statement = $connection->prepare($query);
            $statement->bindParam(':user_id', $user_id);
            $statement->bindParam(':xendit_id', $xendit_id);
            $statement->bindParam(':invoice_id', $invoice_id);
            $statement->execute();
            return true;
        } catch (PDOException $e) {
            die("Error: " . $e->getMessage());
        }
        return $statement;
    }

    public function readItem($id = null)
    {
        $connection = new PDO("mysql:host=$this->host;dbname=$this->database", $this->username, $this->password);
        $connection->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        if (!isset($id)) {
            try {
                $stmt = $connection->query("SELECT * FROM item_post");
                $item = $stmt->fetchAll(PDO::FETCH_ASSOC);

                return $item;
            } catch (PDOException $e) {
                echo "Error: " . $e->getMessage();
                return [];
            }
        } else {
            try {
                $stmt = $connection->prepare("SELECT * FROM item_post WHERE id =:id");
                $stmt->bindParam(':id', $id);
                $stmt->execute();
                $item = $stmt->fetchAll(PDO::FETCH_ASSOC);

                return $item;
            } catch (PDOException $e) {
                echo "Error: " . $e->getMessage();
                return [];
            }
        }
    }
}
