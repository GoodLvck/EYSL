<?php 

    include("./includes/db.php");

    // REGISTRO
    if(isset($_POST['crearUsuario'])){
        $usuario = $_POST["usuario"];
        $nombre = $_POST['nombre'];
        $apellidos = $_POST['apellidos'];
        $email = $_POST['email'];
        $password = $_POST['password'];
        $password2 = $_POST['password2'];

        if($password === $password2){
            $password = password_hash($_POST['password'], PASSWORD_BCRYPT);

            $sql = "INSERT INTO `usuariosEYSL` (`usuario`, `nombre`, `apellidos`, `email`, `contraseña`, `admin`) VALUES ('$usuario', '$nombre', '$apellidos', '$email', '$password', '0')";
            
            $resultado = mysqli_query($conn,$sql);

            header("Location: index.php");
        } else {
            $_SESSION['mensaje'] = 'Las contraseñas no coinciden';
            $_SESSION['tipoMensaje'] = 'danger';
            
            header("Location: registro.php");
        }
    }


    // LOGIN
    if(isset($_POST['iniciarSesion'])){
        $usuario = $_POST["usuario"];

        $sql = "SELECT * FROM `usuariosEYSL` WHERE `usuario` like '$usuario'";
        
        $resultado = mysqli_query($conn,$sql);

        if($resultado){
            $resultado = mysqli_fetch_array($resultado);
            $goodPassword = password_verify($_POST['password'], $resultado['contraseña']);

            if($goodPassword){
                $_SESSION['id_usuario'] = $resultado['id'];
                $_SESSION['mensaje'] = 'Se ha iniciado sesión correctamente';
                $_SESSION['tipoMensaje'] = 'success';

                if($resultado['admin'] == 1){
                    $_SESSION['admin'] = true;
                }

                header("Location: index.php");
            } else {
                $_SESSION['mensaje'] = 'La contraseña no es correcta para este usuario';
                $_SESSION['tipoMensaje'] = 'danger';
                
                header("Location: login.php");
            }

        } else {
            $_SESSION['mensaje'] = 'No existe un usuario con estas credenciales';
            $_SESSION['tipoMensaje'] = 'danger';

            header("Location: login.php");
        }
    }


    // LOGOUT
    if(isset($_POST['cerrarSesion'])){
        session_unset();
        session_destroy();
    
        header("Location: index.php");
    }


    // ELIMINAR LISTA
    if(isset($_POST['eliminarLista'])){

        $lista = $_POST['id_lista'];
        $sql = "DELETE FROM `listasEYSL` WHERE id = $lista";

        $resultado = mysqli_query($conn, $sql);

        if(!$resultado){
            die("Consulta fallida");
        }

        $_SESSION['mensaje'] = 'Lista eliminada correctamente';
        $_SESSION['tipoMensaje'] = 'success';

        header("Location: listas.php");

    }


    // CREAR LISTA
    if(isset($_POST['crearLista'])){
        
        $nombre = $_POST["nombre"];
        $descripcion = $_POST['descripcion'];
        $usuario = $_SESSION['id_usuario'];

        $sql = "INSERT INTO `listasEYSL`(`nombre`,`descripcion`,`usuario`) VALUES ('$nombre', '$descripcion', '$usuario')";
                
        $resultado = mysqli_query($conn,$sql);

        if(!$resultado){
            die("No se ha podido realizar el insert<br>");
        }

        $_SESSION['mensaje'] = 'Lista creada correctamente';
        $_SESSION['tipoMensaje'] = 'success';

        header("Location: listas.php");

    }


    // EDITAR LISTA
    if(isset($_POST['editarLista'])){
        
        $lista = $_POST['id_lista'];
        $nombre = $_POST["nombre"];
        $descripcion = $_POST['descripcion'];
    
        $sql = "UPDATE `listasEYSL` SET nombre = '$nombre', descripcion = '$descripcion' WHERE id = $lista";
        mysqli_query($conn, $sql);
        
        $_SESSION['mensaje'] = 'Lista actualizada correctamente';
        $_SESSION['tipoMensaje'] = 'success';
        
        header("Location: listas.php");

    }


?>