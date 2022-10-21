<div class="container">
		<footer class="d-flex flex-wrap justify-content-between align-items-center py-3 my-4 border-top">
            <p class="col-md-4 mb-0 text-muted">© 2022 EYSL</p>


			<a href="../index.php"
				class="col-md-4 d-flex align-items-center justify-content-center mb-3 mb-md-0 me-md-auto link-dark text-decoration-none">
				<img src="./assets/img/logo.png" alt="Logo" />
			</a>

			<ul class="nav col-md-4 justify-content-end">
				<li class="nav-item"><a href="../index.php" class="nav-link px-2 text-muted">Inicio</a></li>
				<li class="nav-item"><a href="../mis-listas.php" class="nav-link px-2 text-muted">Ver listas</a></li>
				<li class="nav-item"><a href="../guardar-lista.php" class="nav-link px-2 text-muted">Añadir lista</a></li>
                <?php if(isset($_SESSION['id_usuario'])){ ?>
                    <li class="nav-item"><form method="POST"><button class="btn btn-link nav-link px-2 text-muted" name="cerrarSesion">Cerrar sesión</button></form></li>
                <?php } else { ?>
                    <li class="nav-item"><a href="./login.php" class="nav-link px-2 text-muted">Login</a></li>
                    <li class="nav-item"><a href="./registro.php" class="nav-link px-2 text-muted">Registro</a></li>
                <?php } ?>
			</ul>

		</footer>
	</div>


	<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.1/dist/js/bootstrap.bundle.min.js"
		integrity="sha384-u1OknCvxWvY5kfmNBILK2hRnQC3Pr17a+RTT6rIHI7NnikvbZlHgTPOOmMi466C8" crossorigin="anonymous">
	</script>
</body>
</html>