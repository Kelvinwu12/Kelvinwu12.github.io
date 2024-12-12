<?php 
include 'connect.php';

if(isset($_POST['signUp'])){
    $firstName = $_POST['fName'];
    $lastName = $_POST['lName'];
    $email = $_POST['email'];
    $password = $_POST['password'];
    $password = md5($password);
    $role = 'usuario'; 

    $checkEmail = "SELECT * FROM usuarios WHERE Correo='$email'";
    $result = $conn->query($checkEmail);
    if($result->num_rows > 0){
        echo "El correo electrónico ya existe!";
    } else {
        $insertQuery = "INSERT INTO usuarios (Primer_Nombre, Apellido, Correo, Contraseña, rol) 
                        VALUES ('$firstName', '$lastName', '$email', '$password', '$role')";
        if($conn->query($insertQuery) == TRUE){
            header("Location: products.php"); // Redirigir al usuario a la página de productos
        } else {
            echo "Error: ".$conn->error;
        }
    }
}

if(isset($_POST['signIn'])){
    $email = $_POST['email'];
    $password = $_POST['password'];
    $password = md5($password);

    $sql = "SELECT * FROM usuarios WHERE Correo='$email' AND Contraseña='$password'";
    $result = $conn->query($sql);
    if($result->num_rows > 0){
        session_start();
        $row = $result->fetch_assoc();
        $_SESSION['email'] = $row['Correo'];
        $_SESSION['role'] = $row['rol']; 

        if ($_SESSION['role'] == 'administrador') {
            header("Location: products.php"); 
        } else {
            header("Location: productos.php"); 
        }
        exit();
    } else {
        echo "Error, Correo o Contraseña incorrectos";
    }
}
?>
