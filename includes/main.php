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

            // Iniciar sesión
            $sql = "SELECT * FROM `usuariosEYSL` WHERE `usuario` like '$usuario'";
            $resultado = mysqli_fetch_array(mysqli_query($conn,$sql));
            $_SESSION['id_usuario'] = $resultado['id'];
            $_SESSION['mensaje'] = 'Se ha registrado correctamente';
            $_SESSION['tipoMensaje'] = 'success';
            $_SESSION['paginaMensaje'] = 'index.php';

            header("Location: index.php");
        } else {
            $_SESSION['mensaje'] = 'Las contraseñas no coinciden';
            $_SESSION['tipoMensaje'] = 'danger';      
            $_SESSION['paginaMensaje'] = 'registro.php';      
        }
    }


    // LOGIN
    if(isset($_POST['iniciarSesion'])){
        $usuario = $_POST["usuario"];

        $sql = "SELECT * FROM `usuariosEYSL` WHERE `usuario` like '$usuario'";
        
        $resultado = mysqli_query($conn,$sql);

        if(mysqli_num_rows($resultado) == 1){
            $resultado = mysqli_fetch_array($resultado);
            $goodPassword = password_verify($_POST['password'], $resultado['contraseña']);

            if($goodPassword){
                $_SESSION['id_usuario'] = $resultado['id'];
                $_SESSION['mensaje'] = 'Se ha iniciado sesión correctamente';
                $_SESSION['tipoMensaje'] = 'success';
                $_SESSION['paginaMensaje'] = 'index.php';

                if($resultado['admin'] == 1){
                    $_SESSION['admin'] = true;
                }

                header("Location: index.php");
            } else {
                $_SESSION['mensaje'] = 'La contraseña no es correcta para este usuario';
                $_SESSION['tipoMensaje'] = 'danger';
            }

        } else {
            $_SESSION['mensaje'] = 'No existe un usuario con estas credenciales';
            $_SESSION['tipoMensaje'] = 'danger';
        }
    }


    // LOGOUT
    if(isset($_POST['cerrarSesion'])){
        session_unset();
        session_destroy();

        session_start();
        $_SESSION['mensaje'] = 'Se ha cerrado sesión correctamente';
        $_SESSION['tipoMensaje'] = 'success';
        $_SESSION['paginaMensaje'] = 'index.php';
    
        if(basename($_SERVER['PHP_SELF']) != 'index.php'){
            header("Location: index.php");
        }
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
        $_SESSION['paginaMensaje'] = 'listas.php';

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
        $_SESSION['paginaMensaje'] = 'listas.php';

        header("Location: listas.php?filtro=mis-listas");

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
        $_SESSION['paginaMensaje'] = 'listas.php';

        header("Location: listas.php?filtro=mis-listas");

    }

    // ELIMINAR PRODUCTO
    if(isset($_POST['eliminarProducto'])){

        $producto = $_POST['id_producto'];
        $lista = $_POST['id_lista'];
        $sql = "DELETE FROM `productosEYSL` WHERE id = $producto";

        $resultado = mysqli_query($conn, $sql);

        if(!$resultado){
            die("Consulta fallida");
        }

        $_SESSION['mensaje'] = 'Producto eliminado correctamente';
        $_SESSION['tipoMensaje'] = 'success';
        $_SESSION['paginaMensaje'] = 'productos.php';

    }

    // CREAR PRODUCTO
    if(isset($_POST['crearProducto'])){
        
        $producto = $_POST["producto"];
        $descripcion = $_POST['descripcion'];
        $tipo = $_POST['tipo'];
        $precio = $_POST['precio'];
        $cantidad = $_POST['cantidad'];
        $lista = $_POST['id_lista'];

        $sql = "INSERT INTO `productosEYSL`(`producto`,`tipo`,`descripcion`,`precio`,`cantidad`,`lista`) VALUES ('$producto', '$tipo', '$descripcion', '$precio', $cantidad, $lista)";
                
        $resultado = mysqli_query($conn,$sql);

        if(!$resultado){
            die("No se ha podido realizar el insert<br>");
        }

        $_SESSION['mensaje'] = 'Producto guardado correctamente';
        $_SESSION['tipoMensaje'] = 'success';
        $_SESSION['paginaMensaje'] = 'productos.php';

        header("Location: productos.php?lista=$lista");

    }

    // EDITAR PRODUCTO
    if(isset($_POST['editarProducto'])){
        $id_producto = $_POST['id_producto'];
        $producto = $_POST["producto"];
        $descripcion = $_POST['descripcion'];
        $precio = $_POST['precio'];
        $cantidad = $_POST['cantidad'];
        $lista = $_POST['id_lista'];
    
        $sql = "UPDATE `productosEYSL` SET producto = '$producto', descripcion = '$descripcion', cantidad = $cantidad, precio = $precio WHERE id = $id_producto";
        mysqli_query($conn, $sql);
        
        $_SESSION['mensaje'] = 'Producto actualizado correctamente';
        $_SESSION['tipoMensaje'] = 'success';
        $_SESSION['paginaMensaje'] = 'productos.php';

        header("Location: productos.php?lista=$lista");

    }


    // AÑADIR FAVORITO
    if(isset($_POST['nuevoFavorito'])){

        $usuario = $_SESSION["id_usuario"];
        $lista = $_POST['id_lista'];

        $sql = "INSERT INTO `favoritosEYSL`(`usuario`,`lista`) VALUES ('$usuario', '$lista')";
                
        $resultado = mysqli_query($conn,$sql);

        if(!$resultado){
            die("No se ha podido realizar el insert<br>");
        }

        $_SESSION['mensaje'] = 'Lista añadida a favoritos correctamente';
        $_SESSION['tipoMensaje'] = 'success';
        $_SESSION['paginaMensaje'] = 'listas.php';

    }

    // ELIMINAR FAVORITO
    if(isset($_POST['eliminarFavorito'])){
        $usuario = $_SESSION["id_usuario"];
        $lista = $_POST['id_lista'];

        if(isset($_POST['favoritos'])){
            $favoritos = true;
        }

        $sql = "DELETE FROM `favoritosEYSL` WHERE usuario = $usuario AND lista = $lista";
                
        $resultado = mysqli_query($conn,$sql);

        if(!$resultado){
            die("No se ha podido realizar el delete<br>");
        }

        $_SESSION['mensaje'] = 'Lista eliminada de favoritos correctamente';
        $_SESSION['tipoMensaje'] = 'success';
        $_SESSION['paginaMensaje'] = 'listas.php';
    }


?>