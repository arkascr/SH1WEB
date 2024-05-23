<?php
require_once __DIR__ . '/../config/database.php';

class Libros {
    private PDO $dbLibros; 

    public function __construct() {
        $this->dbLibros = Database::connectDB(); // Obtiene la conexión a la base de datos
    }

    public function getLibrosSearch(string $libro){
    // Prepara la consulta SQL con marcadores de posición
    $stmt = $this->dbLibros->prepare("SELECT * FROM `t_libros` WHERE titulo LIKE ? OR descripcion like ?");

    // Asigna el valor directamente al marcador de posición
    $stmt->bindValue(1, "%". $libro. "%", PDO::PARAM_STR);
	$stmt->bindValue(2, "%". $libro. "%", PDO::PARAM_STR);
		
	try {

		// Ejecuta la consulta
		$stmt->execute();
	} catch (PDOException $e) {
		die("Error al ejecutar la consulta: " . $e->getMessage());
	}
    // Verifica si la consulta fue exitosa
    if ($stmt === false) {
        // Maneja el error aquí
        die("Error en la consulta: ");
    }

    // Obtén los resultados como un array asociativo
    $result = $stmt->fetchAll(PDO::FETCH_ASSOC);

    // Cierra la conexión a la base de datos
    Database::close($this->dbLibros);

    // Devuelve los resultados
    return $result;
}


}

