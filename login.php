<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>login</title>
</head>
<body>
    <?php
    require('conexion.php');
    session_start();
        if(isset($_POST['username'])){
            //limipio los datos al insertar//
            $username = stripslashes($_REQUEST['username']);
            $username = mysqli_real_escape_string($con,$username);

            $password = stripslashes($_REQUEST['password']);
            $password = mysqli_real_escape_string($con,$password);
        //chequeo si el usuario esta en la abse de datos//    
        $query = "SELECT * FROM users WHERE username='$username' and password='".md5($password)."'";
        $result = mysqli_query($con,$query) ;
        $row = mysqli_num_rows($result);
        if($row==1){//el usuario existe podria preguntarse que tipo de usuario es y hacer el cambio de mandarlo a index clien, admin, bla bla bla//
            $_SESSION['username']  = $username;
            header("Location: index.php"); // redirigir a index.php
        }else{
      		echo "<div class='form'><h3>Usuario/Contraseña Incorrecto</h3><br/>Haz click aquí para <a href='login.php'>Logearte</a></div>";
      	}
        }else{
        ?>
	    <div class="form">
	      <h1>Inicia Sesión</h1>
	      <form action="" method="post" name="login">
	        <input type="text" name="username" placeholder="Usuario" required />
	        <input type="password" name="password" placeholder="Contraseña" required />
	        <input name="submit" type="submit" value="Entrar" />
	      </form>
	      <p>No estas registrado aún? <a href='registration.php'>Registrate Aquí</a></p>
	    </div>
    <?php } ?>
  </body>
</html>
