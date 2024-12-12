<?php
include('conexion.php'); 

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $order_id = $_POST['order_id'];
    $status = $_POST['status'];

    $query = "UPDATE `order` SET `status` = :status WHERE `id` = :id";
    $stmt = $pdo->prepare($query);
    $stmt->bindParam(':status', $status);
    $stmt->bindParam(':id', $order_id);
    $stmt->execute();

    echo "Estado actualizado correctamente";
}
?>
