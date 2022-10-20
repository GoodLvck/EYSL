<?php include("./includes/main.php"); ?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Tienda</title>
    <link rel="shortcut icon" href="./assets/img/logo.ico" type="image/x-icon">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.9.1/font/bootstrap-icons.css">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-Zenh87qX5JnK2Jl0vWa8Ck2rdkQ2Bzep5IDxbcnCeuOxjzrPF/et3URy9Bv1WTRi" crossorigin="anonymous">
    <link rel="stylesheet" href="./assets/css/style.css">
</head>

<body>
    <header
        class="sticky-top bg-white d-flex flex-wrap align-items-center justify-content-center justify-content-md-between py-3 px-5 border-bottom shadow-sm">
        <a href="../index.php" class="d-flex align-items-center col-md-3 mb-2 mb-md-0 text-dark text-decoration-none">
            <img src="./assets/img/logo.png" alt="Logo" />
        </a>

        <div class="col-md-auto mb-2 justify-content-center mb-md-0">
            <a class="navbar-brand" style="font-size:22.5px" href="../index.php">Evolve Your Shopping List</a>
        </div>

            <?php if(isset($_SESSION['id_usuario'])){ ?>
                <div class="col-md-3 dropdown text-end">
                    <a href="#" class="link-dark hand-cursor text-decoration-none dropdown-toggle show"
                        data-bs-toggle="dropdown" aria-expanded="true">
                        <i class="bi bi-person-circle text-success fs-3"></i>
                    </a>
                    <ul class="dropdown-menu text-small" data-popper-placement="bottom-end"
                        style="position: absolute; inset: 0px 0px auto auto; margin: 0px; transform: translate(0px, 34px);">

                        <?php if(isset($_SESSION['admin'])){?>
                            <li><a class="dropdown-item" href="./listas.php?filtro=mis-listas">Mis listas</a></li>
                            <li><a class="dropdown-item" href="./crear-lista.php">Nueva lista</a></li>
                        <?php } else { ?>
                            <li><a class="dropdown-item" href="./listas.php?filtro=favoritos">Favoritos</a></li>
                        <?php }?>

                        <li><a class="dropdown-item" href="./listas.php">Ver listas</a></li>
                        <li>
                            <hr class="dropdown-divider">
                        </li>
                        <li><form method="POST"><button class="dropdown-item" name="cerrarSesion">Cerrar sesión</button></form></li>
                    </ul>
                </div>
            <?php } else { ?>
                <div class="col-md-3 text-end">
                    <a href="../login.php" class="btn btn-outline-primary">Log in</a>
                    <a href="../registro.php" class="btn btn-primary">Registro</a>
                </div>
            <?php }?>
        </div>
    </header>

    <?php if(isset($_SESSION['mensaje'])){ ?>
        <div class="m-3 alert alert-<?= $_SESSION['tipoMensaje'] ?> alert-dismissible fade show" role="alert">
            <?= $_SESSION['mensaje'] ?>
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    <?php unset($_SESSION['mensaje']);} ?>