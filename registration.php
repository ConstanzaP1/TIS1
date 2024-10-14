<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Registro</title>
</head>
<body>
<?php
/*conectar la base de datos */
    require('db.php');
        if(isset($_REQUEST['username'])){
            $username = stripcslashes($_REQUEST['username']);
            $username = mysqli_real_escape_string($con,$username);

            $email = stripcslashes($_REQUEST['email']);
            $email = mysqli_real_escape_string($con,$email);
            
            $password = stripcslashes($_REQUEST['password']);
            $password = mysqli_real_escape_string($con,$password);

            $query = "INSERT INTO users (username, password, email) VAlUES ('$username', '"/*encritpta la contraseña*/.md5("$password")."', '$email')";
            $result = mysqli_query($con, $query);
            if($result){
                echo "<div class='form'><h3>Te has registrado correctamente!</h3><br/>Haz click aquí para <a href='login.php'>Logearte</a></div>";
            }
        }else{
  /*pide los datos*/
?>  
        <h1>Registrate aqui</h1>
        <form name="registration" action="" method="post">
        <input type="text" name="username" placeholder="Usuario" required />
        <input type="email" name="email" placeholder="Correo" required />
        <input type="password" name="password" placeholder="Contraseña" required />
        <input type="submit" name="submit" value="Registrarse" />
      </form>
    </div>
<?php
        }
?>
</body>
</html>
