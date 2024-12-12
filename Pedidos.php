<?php
include('conexion.php');

$query = "SELECT * FROM `order`";
$stmt = $pdo->query($query);
$orders = $stmt->fetchAll(PDO::FETCH_ASSOC);
?>

<?php
@include 'config.php';
?>

<?php include 'header.php'; ?>


<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Gestión de Pedidos</title>
    <link rel="shortcut icon" href="chef.png">
    <link rel="stylesheet" href="estilo.css">
    <style>

      table {
    width: 90%; 
    margin: 0 auto;
    border-collapse: collapse;
}

th, td {
    border: 1px solid #ddd;
    padding: 12px;  
    text-align: center;
}

th {
    background-color: #2980b9;
    color: white;
    font-size: 1.3rem; 
}

td {
    font-size: 1.1rem;  
    color: #555;
}


        .status-button {
            padding: 6px 12px;
            font-size: 1rem;
            border-radius: 5px;
            cursor: pointer;
            border: none;
        }

        .pending {
            background-color: #f39c12;
            color: white;
        }

        .delivered {
            background-color: #27ae60;  
            color: white;
        }
    </style>
</head>
<body>
    <div class="container">
        <section>
            <h2 class="heading">Gestión de Pedidos</h2>
                <?php if (count($orders) > 0): ?>
                    <table>
                        <thead>
                            <tr>
                                <th>ID</th>
                                <th>Nombre</th>
                                <th>Número</th>
                                <th>Email</th>
                                <th>Método</th>
                                <th>Dirección</th>
                                <th>Código Postal</th>
                                <th>Total Productos</th>
                                <th>Total Precio</th>
                                <th>Estado</th>  
                            </tr>
                        </thead>
                        <tbody>
                            <?php foreach ($orders as $order): ?>
                                <tr>
                                    <td><?php echo $order['id']; ?></td>
                                    <td><?php echo $order['name']; ?></td>
                                    <td><?php echo $order['number']; ?></td>
                                    <td><?php echo $order['email']; ?></td>
                                    <td><?php echo $order['method']; ?></td>
                                    <td><?php echo $order['flat'] . ', ' . $order['street']; ?></td>
                                    <td><?php echo $order['pin_code']; ?></td>
                                    <td><?php echo $order['total_products']; ?></td>
                                    <td><?php echo '$' . number_format($order['total_price'], 2); ?></td>
                                    <td>
                                        <button class="status-button <?php echo $order['status'] == 'Pendiente' ? 'pending' : 'delivered'; ?>" 
                                                data-order-id="<?php echo $order['id']; ?>" 
                                                data-current-status="<?php echo $order['status']; ?>">
                                            <?php echo $order['status'] == 'Pendiente' ? 'Pendiente' : 'Entregado'; ?>
                                        </button>
                                    </td>
                                </tr>
                            <?php endforeach; ?>
                        </tbody>
                    </table>
                <?php else: ?>
                    <p>No hay pedidos registrados.</p>
                <?php endif; ?>
        </section>
    </div>

    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script>
        $(document).ready(function() {
            $('.status-button').on('click', function() {
                var button = $(this);
                var orderId = button.data('order-id');
                var currentStatus = button.data('current-status');
                var newStatus = currentStatus == 'Pendiente' ? 'Entregado' : 'Pendiente';

                $.ajax({
                    url: 'update_status.php',
                    type: 'POST',
                    data: {
                        order_id: orderId,
                        status: newStatus
                    },
                    success: function(response) {
                        if (newStatus == 'Entregado') {
                            button.removeClass('pending').addClass('delivered').text('Entregado');
                        } else {
                            button.removeClass('delivered').addClass('pending').text('Pendiente');
                        }

                        button.data('current-status', newStatus);
                    },
                    error: function() {
                        alert('Hubo un error al actualizar el estado.');
                    }
                });
            });
        });
    </script>
</body>
</html>
