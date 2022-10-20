<?php 
    include("includes/header.php");

    $accion = "";

    // Crear producto -> id lista
    // Editar producto -> id producto

    if(isset($_GET['lista'])){
        $lista = $_GET['lista'];
        $accion = "Crear";
    } else if(isset($_GET['producto'])){
        $id_producto = $_GET['producto'];
        $accion = "Editar";

        $sql = "SELECT * FROM `productosEYSL` WHERE id = $id_producto"; 

        $resultado = mysqli_query($conn, $sql);

        if(mysqli_num_rows($resultado) == 1){
            $producto = mysqli_fetch_array($resultado);
        }
    }

?>

<!-- CONTENIDO -->

<div class="container my-5 py-5">
    <div class="p-5 align-items-center rounded-3 border shadow-lg">
        <div class="text-end">
            <a href="./productos.php?lista=<?= ($accion == 'Crear') ? $lista : $producto['lista'] ?>" class="btn btn-close" aria-label="Close"></a>
        </div>
        <h1 class="text-center pb-4"><?= ($accion == 'Crear') ? 'Añade' : 'Edita' ?> un producto</h1>
        <form method="POST">
            <fieldset class="form px-5 pb-3">
                <div class="row">
                    <div class="col">
                        <div class="form-floating mb-3">
                            <input type="text" class="shadow-none form-control" name="producto" placeholder="Producto" <?php if($accion == 'Editar'){ ?> value="<?= $producto['producto'] ?>" <?php } ?> required />
                            <label for="producto">Producto
                                <span class="required-indicator">*</span>
                            </label>
                        </div>
                    </div>
                    <div class="col">
                        <div class="form-floating">
                            <select name="tipo" class="shadow-none form-select" id="floatingSelect" aria-label="Floating label select example" required>
                                <option value="Otros" <?= ($accion == 'Crear' || ($accion == 'Editar' && $producto['tipo'] == "Otros")) ? 'selected' : '' ?>>Otros</option>
                                <option value="Alimentación" <?= ($accion == 'Editar' && $producto['tipo'] == "Alimentación") ? 'selected' : '' ?>>Alimentación</option>
                                <option value="Bebida" <?= ($accion == 'Editar' && $producto['tipo'] == "Bebida") ? 'selected' : '' ?>>Bebida</option>
                                <option value="Hogar" <?= ($accion == 'Editar' && $producto['tipo'] == "Hogar") ? 'selected' : '' ?>>Hogar</option>
                                <option value="Limpieza" <?= ($accion == 'Editar' && $producto['tipo'] == "Limpieza") ? 'selected' : '' ?>>Limpieza</option>
                                <option value="Perfumería" <?= ($accion == 'Editar' && $producto['tipo'] == "Perfumería") ? 'selected' : '' ?>>Perfumería</option>
                                <option value="Higiene" <?= ($accion == 'Editar' && $producto['tipo'] == "Higiene") ? 'selected' : '' ?>>Higiene</option>
                                <option value="Mascotas" <?= ($accion == 'Editar' && $producto['tipo'] == "Mascotas") ? 'selected' : '' ?>>Mascotas</option>
                                <option value="Parafarmacia" <?= ($accion == 'Editar' && $producto['tipo'] == "Parafarmacia") ? 'selected' : '' ?>>Parafarmacia</option>
                                <option value="Moda" <?= ($accion == 'Editar' && $producto['tipo'] == "Moda") ? 'selected' : '' ?>>Moda</option>
                                <option value="Juguetes" <?= ($accion == 'Editar' && $producto['tipo'] == "Juguetes") ? 'selected' : '' ?>>Juguetes</option>
                                <option value="Libros" <?= ($accion == 'Editar' && $producto['tipo'] == "Libros") ? 'selected' : '' ?>>Libros</option>
                                <option value="Papelería" <?= ($accion == 'Editar' && $producto['tipo'] == "Papelería") ? 'selected' : '' ?>>Papelería</option>
                                <option value="Deportes" <?= ($accion == 'Editar' && $producto['tipo'] == "Deportes") ? 'selected' : '' ?>>Deportes</option>
                                <option value="Ocio" <?= ($accion == 'Editar' && $producto['tipo'] == "Ocio") ? 'selected' : '' ?>>Ocio</option>
                            </select>
                            <label for="floatingSelect">Tipo de producto</label>
                        </div>
                    </div>
                    <div class="col">
                        <div class="input-group mb-3">
                            <div class="form-floating">
                                <input type="number" step=".01" class="shadow-none form-control" name="precio" placeholder="Precio" min="0" <?php if($accion == 'Editar'){ ?> value="<?= $producto['precio'] ?>" <?php } ?> required/>
                                <label for="precio">Precio
                                    <span class="required-indicator">*</span>
                                </label>
                            </div>
                            <span class="input-group-text" id="basic-addon1">€</span>
                        </div>
                    </div>
                    <div class="col">
                        <div class="form-floating mb-3">
                            <input type="number" class="shadow-none form-control" name="cantidad" placeholder="Cantidad" min="0" max="9999" <?php if($accion == 'Editar'){ ?> value="<?= $producto['cantidad'] ?>" <?php } ?> required/>
                            <label for="cantidad">Cantidad
                                <span class="required-indicator">*</span>
                            </label>
                        </div>
                    </div>
                </div>

                <div class="form-floating mb-3">
                    <textArea id="autoresizing" style="height: 100px" maxlength="2000" type="text" class="shadow-none form-control"
                        id="descripcion" name="descripcion" placeholder="descripcion"><?= ($accion == 'Editar') ? $producto['descripcion'] : '' ?></textArea>
                    <label for="descripcion">Descripción</label>
                </div>

                <?php if($accion == 'Editar'){ ?>
                    <input type="hidden" value="<?= $id_producto ?>" name="id_producto">
                <?php } ?>

                <input type="hidden" value="<?= ($accion == 'Editar') ? $producto['lista'] : $lista ?>" name="id_lista">

                <button type="submit" name="<?= ($accion == 'Editar') ? 'editarProducto' : 'crearProducto' ?>" class="w-100 btn btn-lg btn-primary"><?= ($accion == 'Crear') ? 'Añadir' : 'Editar' ?></button>

            </fieldset>
        </form>
    </div>
</div>

<!-- FIN CONTENIDO -->

<?php include("includes/footer.php") ?>