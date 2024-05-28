<?php
require_once('../BACK/services/LibrosService.php');

$categoria = isset($_GET['categoria']) ? $_GET['categoria'] : 'categoria1';

$libros = new Libros();
// Suponiendo que getLibros acepta un parámetro de categoría
$result = $libros->getLibrosbyIdCategoria($categoria);

foreach ($result as $libro) :
    $imagen64 = base64_encode($libro["imagen"]);
?>
    <div class="col-lg-4 col-md-6 mb-4 d-flex justify-content-center">
        <div class="card bg-info-subtle" style="width: 300px;">
            <div class="card-body text-center px-4 py-5 px-md-5">
                <a href="./producto.php?libro=<?= $libro["ID"] ?>"><img class="img-fluid d-block mx-auto" src="data:image/jpeg;base64, <?= $imagen64 ?>"></a>
                <h5 class="fw-bold card-title mb-3"><?= htmlspecialchars($libro['titulo']); ?></h5>
                <p class="fw-bold text-info card-text mb-2"><?= htmlspecialchars($libro['descripcion']); ?></p>
                <p class="fw-bold text-info card-text mb-2"><?= htmlspecialchars('$' . $libro['precio']); ?></p>
                <button class="btn btn-info btn-sm" type="button" onclick="location.href='./producto.php?libro=<?= $libro['ID'] ?>'">Leer</button>
            </div>
        </div>
    </div>
<?php endforeach; ?>