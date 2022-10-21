<?php 
    include("includes/header.php");

    if(!isset($_SESSION['id_usuario'])){
        $_SESSION['mensaje'] = 'Inicia sesión para poder ver todo el contenido';
        $_SESSION['tipoMensaje'] = 'warning';
        $_SESSION['paginaMensaje'] = 'login.php';
        header("Location: login.php");
    }
?>

<?php 

    if(isset($_GET['lista'])){
        $lista = $_GET['lista'];
        $datosLista = mysqli_fetch_array(mysqli_query($conn, "SELECT `nombre`, `usuario` FROM `listasEYSL` WHERE `id` like '$lista'"));
        $nombreLista = $datosLista['nombre'];
        $usuarioLista = $datosLista['usuario'];

        if(isset($_POST['filtrarProductos']) && ($_POST['search'] != null || $_POST['tipo'] != "Todos")){
            $busqueda = $_POST['search'];
            $categoria = $_POST['tipo'];
            
            if($_POST['search'] != null && $_POST['tipo'] != "Todos"){
                $sql = "SELECT * FROM `productosEYSL` WHERE (`descripcion` LIKE '%$busqueda%' OR `producto` LIKE '%$busqueda%') AND `tipo` LIKE '$categoria' AND `lista` LIKE '$lista' ORDER BY `id` DESC";
            } elseif ($_POST['search'] != null){
                $sql = "SELECT * FROM `productosEYSL` WHERE (`descripcion` LIKE '%$busqueda%' OR `producto` LIKE '%$busqueda%') AND `lista` LIKE '$lista' ORDER BY `id` DESC";
            } else {
                $sql = "SELECT * FROM `productosEYSL` WHERE `tipo` LIKE '$categoria' AND `lista` LIKE '$lista' ORDER BY `id` DESC";
            }
        
        } else {
            $sql="SELECT * FROM `productosEYSL` WHERE `lista` LIKE '$lista' ORDER BY `id` DESC";
        }

    }

?>

<!-- CONTENIDO -->
<div class="container mt-5">
    <h1 class="text-center my-4"><?= $nombreLista ?></h1>

    <!-- BARRA BÚSQUEDA -->

    <div class="container w-75">
        <form method="POST" class="row d-flex my-5 shadow-sm border rounded-3">
            <!-- Categoría -->
            <div class="col-md-3 rounded-3 ps-0">
                <select name="tipo" class="shadow-none border-success form-select mx-0 form-select-lg" id="floatingSelect" aria-label="Floating label select example" required>
                    <option selected>Todos</option>
                    <option value="Otros">Otros</option>
                    <option value="Alimentación">Alimentación</option>
                    <option value="Bebida">Bebida</option>
                    <option value="Hogar">Hogar</option>
                    <option value="Limpieza">Limpieza</option>
                    <option value="Perfumería">Perfumería</option>
                    <option value="Higiene">Higiene</option>
                    <option value="Mascotas">Mascotas</option>
                    <option value="Parafarmacia">Parafarmacia</option>
                    <option value="Moda">Moda</option>
                    <option value="Juguetes">Juguetes</option>
                    <option value="Libros">Libros</option>
                    <option value="Papelería">Papelería</option>
                    <option value="Deportes">Deportes</option>
                    <option value="Ocio">Ocio</option>
                </select>
            </div>

            <!-- Texto -->
            <div class="col-md-8 form-group">
                <input class="form-control form-control-lg shadow-none" name="search" style="border:none ;" type="text" placeholder="Search..."/>
            </div>


            <!-- Buscar -->
            <div class="col-md-1 rounded-3 me-0">
                <button name="filtrarProductos" type="sumbit" class="btn btn-lg btn-success">Buscar</button>
            </div>
        </form>
    </div>

    <!-- FIN BARRA BÚSQUEDA -->

    <!-- AÑADIR PRODUCTO -->
    <div class="my-5">
        <?php if(isset($_SESSION['admin'])){ ?>
            <a href="guardar-producto.php?lista=<?= $lista?>" class="col btn btn-primary text-white">Añadir producto</a>
        <?php } ?>
        <a href="listas.php<?= (isset($_GET['filtro']) && ($_GET['filtro'] == 'mis-listas')) ? '?filtro=mis-listas' : '' ?><?= (isset($_GET['filtro']) && ($_GET['filtro'] == 'favoritos')) ? '?filtro=favoritos' : '' ?>" class="col btn btn-outline-secondary">Volver</a>
    </div>
    <!-- FIN AÑADIR PRODUCTO -->

    <?php

        $productos = mysqli_query($conn, $sql);

        while($producto = mysqli_fetch_array($productos)){?>

    <!-- ELEMENTO LISTA -->
    <div class="d-flex">
        <div class="flex-grow-1 rounded-3 shadow-sm border px-2 mb-3">
            <div class="accordion accordion-flush">
                <div class="accordion-item">
                    <div class="accordion-header" id="flush-heading<?= $producto['id'] ?>">
                        <div class="accordion-button collapsed" style="background-color:white;" type="button"
                            data-bs-toggle="collapse" data-bs-target="#flush-collapse<?= $producto['id'] ?>" aria-expanded="false"
                            aria-controls="flush-collapse<?= $producto['id'] ?>">
                            <h5 class="m-0"><span class="badge bg-warning me-4" style="width: 115px"><?= $producto['tipo'] ?></span><?= $producto['producto'] ?></h5>
                        </div>
                    </div>
                    <div id="flush-collapse<?= $producto['id'] ?>" class="accordion-collapse collapse" aria-labelledby="flush-heading<?= $producto['id'] ?>"
                        data-bs-parent="#accordionFlushExample">
                        <div class="accordion-body">
                            <p><?= $producto['descripcion'] ?></p>
                            <br>
                            <div>
                                <p class="d-inline-block me-5"><b>Precio: </b> <?= $producto['precio'] ?> €/u</p>|
                                <p class="d-inline-block mx-5"><b>Cantidad: </b> <?= $producto['cantidad'] ?> u</p>|
                                <p class="d-inline-block mx-5"><b>Total: </b> <?= (floatval($producto["precio"]) * intval($producto["cantidad"])) ?> €</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <?php if(isset($_SESSION['admin']) && $_SESSION['id_usuario'] == $usuarioLista){ ?>
            <div class="ms-2">
                <a href="./guardar-producto.php?lista=<?= $lista ?>&producto=<?= $producto['id'] ?>" type="button" class="shadow-sm mx-2 px-4 py-3 btn btn-outline-primary">
                    <i class="bi bi-pencil-square"></i>
                </a>
                <form method="POST" class="d-inline">
                    <input type="hidden" value="<?= $producto['id'] ?>" name="id_producto">
                    <input type="hidden" value="<?= $producto['lista'] ?>" name="id_lista">
                    <button type="submit" class="shadow-sm px-4 py-3 btn btn-outline-danger" name="eliminarProducto">
                        <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-trash3"
                            viewBox="0 0 16 16">
                            <path
                                d="M6.5 1h3a.5.5 0 0 1 .5.5v1H6v-1a.5.5 0 0 1 .5-.5ZM11 2.5v-1A1.5 1.5 0 0 0 9.5 0h-3A1.5 1.5 0 0 0 5 1.5v1H2.506a.58.58 0 0 0-.01 0H1.5a.5.5 0 0 0 0 1h.538l.853 10.66A2 2 0 0 0 4.885 16h6.23a2 2 0 0 0 1.994-1.84l.853-10.66h.538a.5.5 0 0 0 0-1h-.995a.59.59 0 0 0-.01 0H11Zm1.958 1-.846 10.58a1 1 0 0 1-.997.92h-6.23a1 1 0 0 1-.997-.92L3.042 3.5h9.916Zm-7.487 1a.5.5 0 0 1 .528.47l.5 8.5a.5.5 0 0 1-.998.06L5 5.03a.5.5 0 0 1 .47-.53Zm5.058 0a.5.5 0 0 1 .47.53l-.5 8.5a.5.5 0 1 1-.998-.06l.5-8.5a.5.5 0 0 1 .528-.47ZM8 4.5a.5.5 0 0 1 .5.5v8.5a.5.5 0 0 1-1 0V5a.5.5 0 0 1 .5-.5Z" />
                        </svg>
                    </button>
                </form>
            </div>    
        <?php } ?>
    </div>
    <!-- FIN ELEMENTO LISTA -->
    

    <?php }
    ?>

</div>
<!-- FIN CONTENIDO -->

<?php include("includes/footer.php") ?>
                                       