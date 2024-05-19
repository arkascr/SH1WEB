<?php
// controllers/ApiController.php

require_once __DIR__ . '/../services/EventsService.php';
require_once __DIR__ . '/../config/database.php'; // Incluye el archivo de configuración de la base de datos

class ApiController {
    private EventsService $eventsService;
    private PDO $dbEvents; // Variable para almacenar la conexión a la base de datos
	

   public function __construct() {
        $this->dbEvents = Database::connectDB(); // Obtiene la conexión a la base de datos
        $this->eventsService = new EventsService($this->dbEvents);
    }
	
	public function getAllEvents() {
        $users = $this->eventsService->getAllEvents();

        // Devolver la respuesta como JSON
        header('Content-Type: application/json');
		header('Access-Control-Allow-Origin: *');
        echo json_encode($users);
    }
	
	public function getAllResultados() {
        $users = $this->eventsService->getAllResultados();

        // Devolver la respuesta como JSON
        header('Content-Type: application/json');
		header('Access-Control-Allow-Origin: *');
        echo json_encode($users);
    }
	public function getEventById(string $id) {
		
        $users = $this->eventsService->getEventById($id);
		

        // Devolver la respuesta como JSON
        header('Content-Type: application/json');
		header('Access-Control-Allow-Origin: *');
        echo json_encode(array("result"=> $result));
    }

    // Otros métodos para manejar las operaciones CRUD
}
