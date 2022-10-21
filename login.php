<?php 
    include("./includes/header.php");

    if(isset($_SESSION['id_usuario'])){
        header("Location: index.php");
    }
?>

<!-- CONTENIDO -->

<div class="container col-9 px-4">
    <div class="row align-items-center g-lg-5 py-5">
        <div class="col-lg-7 text-center text-lg-start">
            <h1 class="display-4 fw-bold lh-1 mb-3">Qué alegría verte de nuevo</h1>
            <p class="col-lg-10 fs-4">Inicia sesión para añadir nuevos productos a tu lista de la compra.</p>
        </div>
        <div class="col-md-10 mx-auto col-lg-5">
            <form method="POST" class="p-4 p-md-5 border rounded-3 bg-light" >
            <div class="form-floating mb-3">
                        <input type="text" class="form-control" id="usuario" name="usuario" minlength="2" value="" placeholder="Usuario" required>
                        <label for="usuario">Usuario<span class="required-indicator">*</span></label>
                    </div>
                    <div class="form-floating mb-3">
                        <input type="password" class="form-control" id="password" name="password" value="" placeholder="Contraseña" required>
                        <label for="password">Contraseña <span class="required-indicator">*</span></label>
                    </div>
                    <div class="checkbox mb-3">
                        <label>
                            <input type="checkbox" value="remember-me"> Recordar 
                        </label>
                    </div>
                    <button name="iniciarSesion" class="w-100 btn btn-lg btn-primary" type="submit">Iniciar sesión</button>
                    <hr class="my-4">
                    <small class="text-muted">¿Todavía no tienes una cuenta? <a href="./registro.php">Regístrate aquí.</a></small>
            </form>
        </div>
    </div>
</div>

<!-- FIN CONTENIDO -->

<?php include("./includes/footer.php") ?>