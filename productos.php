<?php

@include 'config.php';

if(isset($_POST['add_to_cart'])){

   $product_name = $_POST['product_name'];
   $product_price = $_POST['product_price'];
   $product_image = $_POST['product_image'];
   $product_quantity = 1;

   $select_cart = mysqli_query($conn, "SELECT * FROM `cart` WHERE name = '$product_name'");

   if(mysqli_num_rows($select_cart) > 0){
      $message[] = 'El producto ya ha sido añadido';
   }else{
      $insert_product = mysqli_query($conn, "INSERT INTO `cart`(name, price, image, quantity) VALUES('$product_name', '$product_price', '$product_image', '$product_quantity')");
      $message[] = 'Producto Añadido!';
   }

}

$search_name = '';
$search_price = '';
$where_clauses = [];

if (isset($_POST['search'])) {
    if (!empty($_POST['name'])) {
        $search_name = $_POST['name'];
        $where_clauses[] = "name LIKE '%$search_name%'";
    }
    if (!empty($_POST['price'])) {
        $search_price = $_POST['price'];
        $where_clauses[] = "price <= $search_price";
    }
}

$where_sql = '';
if (count($where_clauses) > 0) {
    $where_sql = 'WHERE ' . implode(' AND ', $where_clauses);
}

?>

<!DOCTYPE html>
<html lang="en">
<head>
   <meta charset="UTF-8">
   <meta http-equiv="X-UA-Compatible" content="IE=edge">
   <meta name="viewport" content="width=device-width, initial-scale=1.0">
   <title>Productos</title>
   <link rel="shortcut icon" href="chef.png">
   <script src="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.13.0/js/all.min.js"></script>
   <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
   <link rel="stylesheet" href="estilo.css">
   <link rel="stylesheet" href="estilo2.css">
   <script src="https://kit.fontawesome.com/eb496ab1a0.js" crossorigin="anonymous"></script>
   <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.2.1/css/all.min.css" integrity="sha512-MV7K8+y+gLIBoVD59lQIYicR65iaqukzvf/nwasF0nqhPay5w/9lJmVM2hMDcnK1OnMGCdVK+iQrJ7lzPJQd1w==" crossorigin="anonymous" referrerpolicy="no-referrer" />

</head>
<body>
   
<?php
if(isset($message)){
   foreach($message as $message){
      echo '<div class="message"><span>'.$message.'</span> <i class="fas fa-times" onclick="this.parentElement.style.display = `none`;"></i> </div>';
   };
};

?>


<?php include 'header2.php'; ?>

<div class="container">

<section class="filters">
        <form action="" method="POST">
            <input type="text" name="name" placeholder="Buscar por nombre" value="<?php echo $search_name; ?>">
            <input type="number" name="price" placeholder="Precio máximo" value="<?php echo $search_price; ?>" min="0">
            <input type="submit" name="search" value="Buscar">
        </form>
    </section>

    <section class="products">

        <h1 class="heading">Productos más recientes</h1>

        <div class="box-container">

            <?php
            $select_products = mysqli_query($conn, "SELECT * FROM `products` $where_sql");
            if(mysqli_num_rows($select_products) > 0){
                while($fetch_product = mysqli_fetch_assoc($select_products)){
            ?>

            <form action="" method="post">
                <div class="box">
                    <img src="uploaded_img/<?php echo $fetch_product['image']; ?>" alt="">
                    <h3><?php echo $fetch_product['name']; ?></h3>
                    <div class="price">$<?php echo $fetch_product['price']; ?>/-</div>
                    <input type="hidden" name="product_name" value="<?php echo $fetch_product['name']; ?>">
                    <input type="hidden" name="product_price" value="<?php echo $fetch_product['price']; ?>">
                    <input type="hidden" name="product_image" value="<?php echo $fetch_product['image']; ?>">
                    <input type="submit" class="btn" value="Añadir al carrito" name="add_to_cart">
                </div>
            </form>

            <?php
                };
            } else {
                echo '<p>No se encontraron productos.</p>';
            }
            ?>

        </div>

    </section>

</div>

<footer class="pie">
        <div class="grupo">
            <div class="box">
                <figure>
                    <a href="#">
                        <img class="logo" src="cheff.png">
                    </a>
                </figure>
            </div>
            <div class="box">
                <h2>SOBRE NOSOTROS</h2>
                <p>SmartBite es la plataforma que conecta a estudiantes y trabajadores del Politécnico con opciones de comida rápida, deliciosa y accesible. Ofrecemos un servicio práctico que facilita tus pedidos desde cualquier lugar del campus, garantizando calidad y variedad en cada platillo.
                </p>
                <p>Con SmartBite, apoyamos a negocios locales mientras hacemos que disfrutar de tus comidas favoritas sea más fácil y rápido.
</p>
            </div>
            <div class="box">
                <h2 class="titulo">SIGUENOS</h2>
                <div class="social">
            <a href="#"><i class="fab fa-instagram"></i></a>
            <a href="#"><i class="fab fa-snapchat"></i></a>
            <a href="#"><i class="fab fa-twitter"></i></a>
            <a href="#"><i class="fab fa-facebook-f"></i></a>
            </div>
                 <img class="logo2" src="gif.gif" width="200px">

            </div>
        </div>
        <div class="grupo2">
            <small>&copy; 2024 <b>SmartBite Company</b> - Todos los Derechos Reservados.</small>
        </div>
    </footer>

<script src="jscript.js"></script>

</body>
</html>

