<?php
require_once('../BACK/services/LibrosService.php');

$categoria = isset($_GET['categoria']) ? (int)$_GET['categoria'] : '0';

$libros = new Libros();
// Suponiendo que getLibros acepta un parámetro de categoría
$result = $libros->getLibrosbyIdCategoria($categoria);

foreach ($result as $libro) :
    $imagen64 = base64_encode($libro["imagen"]);
?>
    <div class="col-lg-4 col-md-6 mb-4 d-flex justify-content-center">
        <div class="card bg-info-subtle" style="width: 300px;">
            <div class="card-body text-center px-4 py-5 px-md-5">
				<h5 class="fw-bold card-title mb-3"><?= htmlspecialchars($libro['titulo']); ?></h5>
                <a href="./producto.php?libro=<?= $libro["ID"] ?>"><img width="200" height="250" class="d-block mx-auto" src="data:image/jpeg;base64, <?= $imagen64 ?>" title="<?= $libro['titulo'] ?>"></a>
                <br>
                <button class="btn btn-info btn-sm" type="button" onclick="location.href='./producto.php?libro=<?= $libro['ID'] ?>'">Leer libro</button>
            </div>
        </div>
    </div>
<?php endforeach; ?>