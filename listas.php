<?php include("includes/header.php");


if(isset($_SESSION['admin']) && (isset($_GET['filtro']) && $_GET['filtro'] == "mis-listas")){
    
    // MIS LISTAS
    $id_usuario = $_SESSION['id_usuario'];

    if(isset($_POST['filtrarListas']) && $_POST['search'] != null){
        $busqueda = $_POST['search'];
        $sql="SELECT * FROM `listasEYSL` WHERE (`descripcion` LIKE '%$busqueda%' OR `nombre` LIKE '%$busqueda%') AND `usuario` like '$id_usuario' ORDER BY `id` DESC";
    } else {
        $sql="SELECT * FROM `listasEYSL` WHERE `usuario` like '$id_usuario' ORDER BY `id` DESC";
    }

} else if(isset($_SESSION['id_usuario']) && !isset($_SESSION['admin']) && (isset($_GET['filtro']) && $_GET['filtro'] == "favoritos")){
    // FAVORITOS
    $id_usuario = $_SESSION['id_usuario'];

    if(isset($_POST['filtrarListas']) && $_POST['search'] != null){
        $sql = "SELECT * FROM `listasEYSL` WHERE id IN (SELECT `lista` FROM `favoritosEYSL` WHERE usuario LIKE '$id_usuario') AND (`descripcion` LIKE '%$busqueda%' OR `nombre` LIKE '%$busqueda%') ORDER BY `id` DESC";
    } else {
        $sql = "SELECT * FROM `listasEYSL` WHERE id IN (SELECT `lista` FROM `favoritosEYSL` WHERE usuario LIKE '$id_usuario') ORDER BY `id` DESC";
    }
    
} else {

    // VER TODAS
    if(isset($_POST['filtrarListas']) && $_POST['search'] != null){
        $busqueda = $_POST['search'];
        $sql = "SELECT * FROM `listasEYSL` WHERE (`descripcion` LIKE '%$busqueda%' OR `nombre` LIKE '%$busqueda%') ORDER BY `id` DESC";
    } else {
        $sql="SELECT * FROM `listasEYSL` ORDER BY `id` DESC";
    }
}

?>

<!-- CONTENIDO -->
<div class="container mt-5">
    <?php if(isset($_SESSION['admin']) && (isset($_GET['filtro']) && $_GET['filtro'] == "mis-listas")){ ?>
        <h1 class="text-center my-4">Mis listas</h1>
    <?php } else if(isset($_SESSION['id_usuario']) && !isset($_SESSION['admin']) && (isset($_GET['filtro']) && $_GET['filtro'] == "favoritos")) { ?>
        <h1 class="text-center my-4">Favoritos</h1>    
    <?php } else { ?>
        <h1 class="text-center my-4">Listas creadas <br> por profesionales</h1>     
    <?php }?>

    <!-- BARRA BÚSQUEDA -->

    <div class="container w-75">
        <form method="POST" class="row d-flex my-5 shadow-sm border rounded-3">

            <!-- Texto -->
            <div class="col-md-11">
                <input class="form-control form-control-lg shadow-none" name="search" style="border:none ;" type="text" placeholder="Search..."/>
            </div>

            <!-- Buscar -->
            <div class="col-md-1 rounded-3 me-0">
                <button name="filtrarListas" type="sumbit" class="btn btn-lg btn-success">Buscar</button>
            </div>
        </form>
    </div>

    <!-- FIN BARRA BÚSQUEDA -->

    <!-- AÑADIR LISTA -->
    <?php if(isset($_SESSION['admin'])){ ?>
        <div class="my-5">
            <a href="crear-lista.php" class="col btn btn-primary text-white">Crear lista</a>
        </div>
    <!-- FIN AÑADIR LISTA -->

    <?php
        }
        
        $listas = mysqli_query($conn, $sql);

        while($lista = mysqli_fetch_array($listas)){

            $favorito = false;

            if(isset($_SESSION['id_usuario']) && !isset($_SESSION['admin'])){
                $id_usuario = $_SESSION['id_usuario'];
                $id_lista = $lista['id'];
                $sql = "SELECT * FROM `favoritosEYSL` WHERE usuario like '$id_usuario' AND `lista` like '$id_lista'";

                $resultado = mysqli_fetch_array(mysqli_query($conn, $sql));

                if($resultado){
                    $favorito = true;
                }
            }
    ?>

    <!-- ELEMENTO LISTA -->
    <div class="d-flex">
        <div class="flex-grow-1 rounded-3 shadow-sm border px-2 mb-3">
            <div class="accordion accordion-flush">
                <div class="accordion-item">
                    <div class="accordion-header" id="flush-heading<?= $lista['id'] ?>">
                        <div class="accordion-button collapsed" style="background-color:white;" type="button"
                            data-bs-toggle="collapse" data-bs-target="#flush-collapse<?= $lista['id'] ?>" aria-expanded="false"
                            aria-controls="flush-collapse<?= $lista['id'] ?>">
                            <h5 class="m-0"><?= $lista['nombre'] ?></h5>
                        </div>
                    </div>
                    <div id="flush-collapse<?= $lista['id'] ?>" class="accordion-collapse collapse" aria-labelledby="flush-heading<?= $lista['id'] ?>"
                        data-bs-parent="#accordionFlushExample">
                        <div class="accordion-body">
                            <p><?= $lista['descripcion'] ?></p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="ms-2">

            <a href="./productos.php?lista=<?= $lista['id'] ?>" type="button" class="shadow-sm mx-2 px-4 py-3 btn btn-warning text-white">
                <b><i class="bi bi-eye-fill"></i></b>
            </a>

            <?php if(isset($_SESSION['id_usuario']) && !isset($_SESSION['admin'])){ ?>
                <form method="POST" class="d-inline">
                    <?php if($favorito) { ?>
                        <input type="hidden" value="<?= $lista['id'] ?>" name="id_lista">
                        <button class="shadow-sm me-2 px-4 py-3 btn btn-danger" name="eliminarFavorito">
                            <i class="bi bi-heart "></i>
                        </button>
                    <?php } else { ?>
                        <input type="hidden" value="<?= $lista['id'] ?>" name="id_lista">
                        <button class="shadow-sm me-2 px-4 py-3 btn btn-outline-danger" name="nuevoFavorito">
                            <i class="bi bi-heart "></i>
                        </button>
                    <?php } ?> 
                </form>
            <?php } if(isset($_SESSION['admin']) && (isset($_GET['filtro']) && $_GET['filtro'] == "mis-listas")){ ?>
                <a href="./guardar-lista.php?lista=<?= $lista['id'] ?>" class="shadow-sm me-2 px-4 py-3 btn btn-outline-primary" name="editarLista">
                    <i class="bi bi-pencil-square"></i>
                </a>
                <form method="POST" class="d-inline">
                    <input type="hidden" value="<?= $lista['id'] ?>" name="id_lista">
                    <button type="submit" class="shadow-sm px-4 py-3 btn btn-outline-danger" name="eliminarLista">
                        <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-trash3"
                            viewBox="0 0 16 16">
                            <path
                                d="M6.5 1h3a.5.5 0 0 1 .5.5v1H6v-1a.5.5 0 0 1 .5-.5ZM11 2.5v-1A1.5 1.5 0 0 0 9.5 0h-3A1.5 1.5 0 0 0 5 1.5v1H2.506a.58.58 0 0 0-.01 0H1.5a.5.5 0 0 0 0 1h.538l.853 10.66A2 2 0 0 0 4.885 16h6.23a2 2 0 0 0 1.994-1.84l.853-10.66h.538a.5.5 0 0 0 0-1h-.995a.59.59 0 0 0-.01 0H11Zm1.958 1-.846 10.58a1 1 0 0 1-.997.92h-6.23a1 1 0 0 1-.997-.92L3.042 3.5h9.916Zm-7.487 1a.5.5 0 0 1 .528.47l.5 8.5a.5.5 0 0 1-.998.06L5 5.03a.5.5 0 0 1 .47-.53Zm5.058 0a.5.5 0 0 1 .47.53l-.5 8.5a.5.5 0 1 1-.998-.06l.5-8.5a.5.5 0 0 1 .528-.47ZM8 4.5a.5.5 0 0 1 .5.5v8.5a.5.5 0 0 1-1 0V5a.5.5 0 0 1 .5-.5Z" />
                        </svg>
                    </button>
                </form>
            <?php }?>

            
        </div>
    </div>
    <!-- FIN ELEMENTO LISTA -->
    
    <?php } ?>

</div>
<!-- FIN CONTENIDO -->

<?php include("includes/footer.php") ?>