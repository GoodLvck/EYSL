<?php 
    include("includes/header.php");

    if(isset($_GET['lista'])){
        $lista = $_GET['lista'];
        $sql = "SELECT * FROM `listasEYSL` WHERE id = $lista"; 

        $resultado = mysqli_query($conn, $sql);

        if(mysqli_num_rows($resultado) == 1){
            $fila = mysqli_fetch_array($resultado);
        }
    
    }

?>

<!-- CONTENIDO -->

<div class="container my-5 py-5">
    <div class="p-5 align-items-center rounded-3 border shadow-lg">
        <div class="text-end">
            <a href="./index.php" class="btn btn-close" aria-label="Close"></a>
        </div>
        <h1 class="text-center pb-4">
            <?= isset($_GET['lista']) ? 'Editar' : 'Crear' ?> una lista
        </h1>
        <form method="POST">
            <fieldset class="form px-5 pb-3">
                <div class="row">
                    <div class="col">
                        <div class="form-floating mb-3">
                            <input type="text" class="shadow-none form-control" name="nombre" placeholder="Nombre" <?php if(isset($_GET['lista'])){ ?> value="<?= $fila['nombre'] ?>" <?php } ?> required />
                            <label for="nombre">Nombre
                                <span class="required-indicator">*</span>
                            </label>
                        </div>
                    </div>
                </div>

                <div class="form-floating mb-3">
                    <textArea id="autoresizing" style="height: 100px" maxlength="2000" type="text" class="shadow-none form-control"
                        id="descripcion" name="descripcion" placeholder="descripcion"><?= isset($_GET['lista']) ? $fila['nombre'] : '' ?></textArea>
                    <label for="descripcion">Descripción</label>
                </div>

                <?php if(isset($_GET['lista'])){ ?>
                    <input type="hidden" value="<?= $_GET['lista'] ?>" name="id_lista">
                <?php } ?>

                <button type="submit" name="<?= isset($_GET['lista']) ? 'editarLista' : 'crearLista' ?>" class="w-100 btn btn-lg btn-primary"><?= isset($_GET['lista']) ? 'Editar' : 'Crear' ?></button>
            </fieldset>
        </form>
    </div>
</div>

<!-- FIN CONTENIDO -->

<?php include("includes/footer.php") ?>