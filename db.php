<?php
$con = mysqli_connect("localhost", "root", "","register");
/*en caso de error */
if(mysqli_connect_error())
{
    echo "Fallo la concexion a mysqlo:", mysqli_connect_error();
}
?>