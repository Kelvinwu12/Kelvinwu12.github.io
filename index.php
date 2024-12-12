<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Registro e Inicio de Sesión</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">
    <link rel="stylesheet" href="style.css">
    <link rel="shortcut icon" href="chef.png">
</head>
<body>
    <div class="container" id="signup" style="display:none;">
      <h1 class="form-title">Registrarse</h1>
      <form method="post" action="register.php">
        <div class="input-group">
           <i class="fas fa-user"></i>
           <input type="text" name="fName" id="fName" placeholder="First Name" required>
           <label for="fname">Primer Nombre</label>
        </div>
        <div class="input-group">
            <i class="fas fa-user"></i>
            <input type="text" name="lName" id="lName" placeholder="Last Name" required>
            <label for="lName">Apellido</label>
        </div>
        <div class="input-group">
            <i class="fas fa-envelope"></i>
            <input type="email" name="email" id="email" placeholder="Email" required>
            <label for="email">Correo</label>
        </div>
        <div class="input-group">
            <i class="fas fa-lock"></i>
            <input type="password" name="password" id="password" placeholder="Password" required>
            <label for="password">Contraseña</label>
        </div>
       <input type="submit" class="btn" value="Registrarse" name="signUp">
      </form>
      
      <div class="links">
        <p>Ya tienes una cuenta?</p>
        <button id="signInButton">Iniciar Sesión</button>
      </div>
    </div>

    <div class="container" id="signIn">
    <img src="chef.png" width= "50px">

        <h1 class="form-title">Iniciar Sesión</h1>
        <form method="post" action="register.php">
          <div class="input-group">
              <i class="fas fa-envelope"></i>
              <input type="email" name="email" id="email" placeholder="Email" required>
              <label for="email">Correo</label>
          </div>
          <div class="input-group">
              <i class="fas fa-lock"></i>
              <input type="password" name="password" id="password" placeholder="Password" required>
              <label for="password">Contraseña</label>
          </div>
          
         <input type="submit" class="btn" value="Iniciar Sesión" name="signIn">
        </form>       
        <div class="links">
          <p>¿No tienes una cuenta?</p>
          <button id="signUpButton">Regístrate</button>
        </div>
      </div>
      <script src="script.js"></script>
</body>
</html>