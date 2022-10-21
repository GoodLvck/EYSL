<?php 
    include("includes/header.php");

    if(!isset($_SESSION['admin'])){
        header("Location: listas.php");
    }

    if(isset($_GET['lista'])){
        $id_lista = $_GET['lista'];
        $sql = "SELECT * FROM `listasEYSL` WHERE id = $id_lista"; 

        $resultado = mysqli_query($conn, $sql);

        if(mysqli_num_rows($resultado) == 1){
            $lista = mysqli_fetch_array($resultado);
        }

        if($lista['usuario'] != $_SESSION['id_usuario']){
            header("Location: listas.php");
        }
    
    }

?>

<!-- CONTENIDO -->

<div class="container my-5 py-5">
    <div class="p-5 align-items-center rounded-3 border shadow-lg">
        <div class="text-end">
            <a href="./listas.php<?= (isset($_GET['filtro']) && $_GET['filtro'] == 'mis-listas') ? '?filtro=mis-listas' : '' ?>" class="btn btn-close" aria-label="Close"></a>
        </div>
        <h1 class="text-center pb-4">
            <?= isset($_GET['lista']) ? 'Editar' : 'Crear' ?> una lista
        </h1>
        <form method="POST">
            <fieldset class="form px-5 pb-3">
                <div class="row">
                    <div class="col">
                        <div class="form-floating mb-3">
                            <input type="text" class="shadow-none form-control" name="nombre" placeholder="Nombre" <?php if(isset($_GET['lista'])){ ?> value="<?= $lista['nombre'] ?>" <?php } ?> required />
                            <label for="nombre">Nombre
                                <span class="required-indicator">*</span>
                            </label>
                        </div>
                    </div>
                </div>

                <div class="form-floating mb-3">
                    <textArea id="autoresizing" style="height: 100px" maxlength="2000" type="text" class="shadow-none form-control"
                        id="descripcion" name="descripcion" placeholder="descripcion"><?= isset($_GET['lista']) ? $lista['nombre'] : '' ?></textArea>
                    <label for="descripcion">Descripción</label>
                </div>

                <?php if(isset($_GET['lista'])){ ?>
                    <input type="hidden" value="<?= $_GET['lista'] ?>" name="id_lista">
                <?php } else if(isset($_GET['filtro']) && $_GET['filtro'] == 'mis-listas'){ ?>
                    <input type="hidden" value="mis-listas" name="mis-listas">
                <?php } ?>

                <button type="submit" name="<?= isset($_GET['lista']) ? 'editarLista' : 'crearLista' ?>" class="w-100 btn btn-lg btn-primary"><?= isset($_GET['lista']) ? 'Editar' : 'Crear' ?></button>
            </fieldset>
        </form>
    </div>
</div>

<!-- FIN CONTENIDO -->

<?php include("includes/footer.php") ?>