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
            <h1 class="display-4 fw-bold lh-1 mb-3">Regístrate para comenzar</h1>
            <p class="col-lg-10 fs-5">Al crear una cuenta de usuario solo podrás empezar a crear y mantener tu lista de la compra organizada. EYSL te ayudará a ahorrar tiempo a la hora de ir a hacer los recados y tener más tiempo para tí.
            </p>
        </div>
        <div class="col-md-10 mx-auto col-lg-5">
            <form method="POST" class="p-4 p-md-5 border rounded-3 bg-light" >
                <div class="form-floating mb-3">
                    <input type="text" class="form-control" id="usuario" minlength="2" name="usuario" placeholder="usuario"
                        required />
                    <label for="usuario">Usuario <span class="required-indicator">*</span>
                    </label>
                </div>
                <div class="form-floating mb-3">
                    <input type="text" class="form-control" id="nombre" minlength="2" name="nombre" placeholder="nombre"
                        required>
                    <label for="nombre">
                        Nombre <span class="required-indicator">*</span>
                    </label>
                </div>
                <div class="form-floating mb-3">
                    <input type="text" class="form-control" id="apellidos" minlength="2" name="apellidos"
                        placeholder="apellidos" required>
                    <label for="apellidos">
                        Apellidos <span class="required-indicator">*</span>
                    </label>
                </div>
                <div class="form-floating mb-3">
                    <input type="email" class="form-control" id="email" name="email" placeholder="email" required>
                    <label for="email">
                        Email <span class="required-indicator">*</span>
                    </label>
                </div>
                <div class="form-floating mb-3">
                    <input type="password" class="form-control" id="password" minlength="8" name="password"
                        placeholder="contraseña" required>
                    <label for="password">
                        Contraseña <span class="required-indicator">*</span>
                    </label>
                </div>
                <div class="form-floating mb-3">
                    <input type="password" class="form-control" id="password2" minlength="8" name="password2"
                        placeholder="contraseña" required>
                    <label for="password2">
                        Confirmar contraseña <span class="required-indicator">*</span>
                    </label>
                </div>

                <div class="checkbox mb-3">
                    <label>
                        <input type="checkbox" required> He leído y acepto los términos y condiciones.
                    </label>
                </div>
                <button name="crearUsuario" class="w-100 btn btn-lg btn-primary" type="submit" value="create">Crear cuenta</button>
                <hr class="my-4">
                <small class="text-muted">¿Ya tienes una cuenta?
                    <a href="./login.php"> Inicia sesión aquí.</a>
                </small>
            </form>
        </div>
    </div>
</div>

<!-- FIN CONTENIDO -->

<?php include("./includes/footer.php") ?>