<?php

@include 'config.php';

if (isset($_POST['update_update_btn'])) {
   $update_value = $_POST['update_quantity'];
   $update_id = $_POST['update_quantity_id'];
   $update_quantity_query = mysqli_query($conn, "UPDATE `cart` SET quantity = '$update_value' WHERE id = '$update_id'");
   if ($update_quantity_query) {
      header('location:cart.php');
   };
}

if (isset($_GET['remove'])) {
   $remove_id = $_GET['remove'];
   mysqli_query($conn, "DELETE FROM `cart` WHERE id = '$remove_id'");
   header('location:cart.php');
}

if (isset($_GET['delete_all'])) {
   mysqli_query($conn, "DELETE FROM `cart`");
   header('location:cart.php');
}

?>

<!DOCTYPE html>
<html lang="en">
<head>
   <meta charset="UTF-8">
   <meta http-equiv="X-UA-Compatible" content="IE=edge">
   <meta name="viewport" content="width=device-width, initial-scale=1.0">
   <title>shopping cart</title>

   <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
   <link rel="stylesheet" href="estilo.css">
   <link rel="shortcut icon" href="chef.png">


</head>
<body>

<?php include 'header.php'; ?>

<div class="container">

<section class="shopping-cart">

   <h1 class="heading">Carrito</h1>

   <table>

      <thead>
         <th>Imagen</th>
         <th>Nombre</th>
         <th>Precio</th>
         <th>Cantidad</th>
         <th>Precio Total</th>
         <th>Acción</th>
      </thead>

      <tbody>

         <?php 
         
         $select_cart = mysqli_query($conn, "SELECT * FROM `cart`");
         $grand_total = 0;
         if (mysqli_num_rows($select_cart) > 0) {
            while ($fetch_cart = mysqli_fetch_assoc($select_cart)) {
               $price = is_numeric($fetch_cart['price']) ? $fetch_cart['price'] : 0;
               $quantity = is_numeric($fetch_cart['quantity']) ? $fetch_cart['quantity'] : 0;
               $sub_total = $price * $quantity;
         ?>

         <tr>
            <td><img src="uploaded_img/<?php echo $fetch_cart['image']; ?>" height="100" alt=""></td>
            <td><?php echo $fetch_cart['name']; ?></td>
            <td>$<?php echo number_format($price, 2); ?>/-</td>
            <td>
               <form action="" method="post">
                  <input type="hidden" name="update_quantity_id" value="<?php echo $fetch_cart['id']; ?>">
                  <input type="number" name="update_quantity" min="1" max="100" value="<?php echo $quantity; ?>">
                  <input type="submit" value="Actualizar" name="update_update_btn">
               </form>   
            </td>
            <td>$<?php echo number_format($sub_total, 2); ?>/-</td>
            <td><a href="cart.php?remove=<?php echo $fetch_cart['id']; ?>" onclick="return confirm('Desea eliminar el producto del carrito?')" class="delete-btn"> <i class="fas fa-trash"></i> Eliminar</a></td>
         </tr>
         <?php
           $grand_total += $sub_total;  
            };
         };
         ?>
         <tr class="table-bottom">
            <td><a href="products.php" class="option-btn" style="margin-top: 0;">Continuar comprando</a></td>
            <td colspan="3">Total a pagar</td>
            <td>$<?php echo number_format($grand_total, 2); ?>/-</td>
            <td><a href="cart.php?delete_all" onclick="return confirm('Está seguro de eliminar todo?');" class="delete-btn"> <i class="fas fa-trash"></i> Vaciar </a></td>
         </tr>

      </tbody>

   </table>

   <div class="checkout-btn">
      <a href="checkout.php" class="btn <?= ($grand_total > 1) ? '' : 'disabled'; ?>">Proceder a pagar</a>
   </div>

</section>

</div>
   
<script src="jscript.js"></script>

</body>
</html>
