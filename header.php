<header class="header">

   <div class="flex">

      <a href="products.php" class="logo">SmartBite</a>

      <nav class="navbar">
         <a href="admin.php">Añadir productos</a>
         <a href="products.php">Ver productos</a>
         <a href="Pedidos.php">Ver pedidos</a>
         <a href="logout.php">Cerrar Sesión</a>

      </nav>

      <?php
      
      $select_rows = mysqli_query($conn, "SELECT * FROM `cart`") or die('query failed');
      $row_count = mysqli_num_rows($select_rows);

      ?>

      <a href="cart.php" class="cart">Carrito <span><?php echo $row_count; ?></span> </a>

      <div id="menu-btn" class="fas fa-bars"></div>
      

   </div>

</header>