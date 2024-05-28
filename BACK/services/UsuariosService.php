<?php
require_once __DIR__ . '/../config/database.php';

class Usuario {
    private PDO $dbEvents; 

    public function __construct() {
        $this->dbEvents = Database::connectDB(); // Obtiene la conexión a la base de datos
    }

    public function registrarUsuario($nombre, $correo, $contrasena) {
        
        // Verificar si el correo ya está registrado
        $stmt = $this->dbEvents->prepare("SELECT id FROM usuarios WHERE email = :correo");
        $stmt->bindParam(':correo', $correo);
        $stmt->execute();
        
        if ($stmt->rowCount() > 0) {
            return false; // Correo electrónico ya existe
        }

        // Hash de la contraseña
        $hashedPassword = password_hash($contrasena, PASSWORD_DEFAULT);

        // Insertar usuario en la base de datos
        $stmt = $this->dbEvents->prepare("INSERT INTO usuarios (nombre, email, pass) VALUES (:nombre, :correo, :contrasena)");
        $stmt->bindParam(':nombre', $nombre);
        $stmt->bindParam(':correo', $correo);
        $stmt->bindParam(':contrasena', $hashedPassword);
        $result = $stmt->execute();

        return $result;
    }

	public function login($correo, $contrasena) {
		// Obtener la contraseña almacenada para el correo dado
		$stmt = $this->dbEvents->prepare("SELECT id, email, pass FROM usuarios WHERE email = :correo");
		$stmt->bindParam(':correo', $correo);
		$stmt->execute();

		if ($stmt->rowCount() !== 1) {
			return false; // Usuario no encontrado
		}

		$usuario = $stmt->fetch(PDO::FETCH_ASSOC);

		// Verificar la contraseña
		if (password_verify($contrasena, $usuario['pass'])) {
			// Contraseña correcta, devolver el correo electrónico del usuario
			return $usuario['email'];
		} else {
			return false; // Contraseña incorrecta
		}
	}
 
   public function buscarUsuario($correo) {
        $stmt = $this->dbEvents->prepare("SELECT id FROM usuarios WHERE email = :correo");
        $stmt->bindParam(':correo', $correo);
        $stmt->execute();

        if ($stmt->rowCount() > 0) {
            return true; // Usuario encontrado
        } else {
            return false; // Usuario no encontrado
        }
    }
	
	public function guardaToken($token, $email) {
        $stmt = $this->dbEvents->prepare("UPDATE usuarios SET token = :token  WHERE email = :correo");
        $stmt->bindParam(':token', $token);
        $stmt->bindParam(':correo', $email);
        $result = $stmt->execute();

        return $result;
    }
	
	public function buscarToken($token) {
        $stmt = $this->dbEvents->prepare("SELECT * FROM usuarios WHERE token = :token");
        $stmt->bindParam(':token', $token);
        $stmt->execute();

        if ($stmt->rowCount() > 0) {
            return true; // Usuario encontrado
        } else {
            return false; // Usuario no encontrado
        }
    }
	
	public function actualizarPass($password, $token) {
		
		$hashedPassword = password_hash($password, PASSWORD_DEFAULT);
        $stmt = $this->dbEvents->prepare("UPDATE usuarios SET pass = :password, token = ''  WHERE token = :token");
		$stmt->bindParam(':password', $hashedPassword);
        $stmt->bindParam(':token', $token);
        $result = $stmt->execute();
		
        return $result;
    }
}
