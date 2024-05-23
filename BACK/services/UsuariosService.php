<?php
require_once __DIR__ . '/../config/database.php';

class Usuario {
    private PDO $dbEvents; 

    public function __construct() {
        $this->dbEvents = Database::connectDB(); // Obtiene la conexión a la base de datos
    }

    public function registrarUsuario($nombre, $correo, $contrasena) {
        
        // Verificar si el correo ya está registrado
        $stmt = $this->dbEvents->prepare("SELECT id FROM usuarios WHERE correo = :correo");
        $stmt->bindParam(':correo', $correo);
        $stmt->execute();
        
        if ($stmt->rowCount() > 0) {
            return false; // Correo electrónico ya existe
        }

        // Hash de la contraseña
        $hashedPassword = password_hash($contrasena, PASSWORD_DEFAULT);

        // Insertar usuario en la base de datos
        $stmt = $this->dbEvents->prepare("INSERT INTO usuarios (nombre, correo, contrasena) VALUES (:nombre, :correo, :contrasena)");
        $stmt->bindParam(':nombre', $nombre);
        $stmt->bindParam(':correo', $correo);
        $stmt->bindParam(':contrasena', $hashedPassword);
        $result = $stmt->execute();

        return $result;
    }

    public function login($correo, $contrasena) {
        // Obtener la contraseña almacenada para el correo dado
        $stmt = $this->dbEvents->prepare("SELECT contrasena FROM usuarios WHERE correo = :correo");
        $stmt->bindParam(':correo', $correo);
        $stmt->execute();

        if ($stmt->rowCount() !== 1) {
            return false; // Usuario no encontrado
        }

        $hashedPassword = $stmt->fetchColumn();

        // Verificar la contraseña
        if (password_verify($contrasena, $hashedPassword)) {
            return true; // Contraseña correcta
        } else {
            return false; // Contraseña incorrecta
        }
    }
}

/* este es para calar a ver si funciona we 
$user = new Usuario();
$resultadoRegistro = $usuario->registrarUsuario("Ejemplo Usuario", "ejemplo@example.com", "contraseña");
if ($resultadoRegistro) {
    echo "Registro exitoso!";
} else {
    echo "El correo electrónico ya está registrado.";
} */
