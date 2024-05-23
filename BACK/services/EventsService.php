<?php
// services/UserService.php

require_once __DIR__ . '/../config/database.php';
require_once __DIR__ . '/../models/Events.php';

// FETCH_ASSOC ( Regresa la tabla con nombre de columnas)
// FETCH_NUM ( Regresa la tabla con el indice de las tablas) ** Mejor opcion para mi

class EventsService {
    private PDO $dbEvents;

    public function __construct() {
        $this->dbEvents = Database::connectDB();
    }

    public function getAllEvents(): array {
        $stmt = $this->dbEvents->query("SELECT * FROM eventos_tag_ ORDER BY fecha_ ASC");
        $events = [];

        while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
            $event = new Event();
            foreach ($row as $key => $value) {
                if (property_exists($event, $key)) {
					
					if(rtrim($key, '_') == "id"){
						$key = "uuid";
						 $event->{$key} = $value;
					}else{
						 $event->{rtrim($key, '_')} = $value;
					}
                   
                }
            }
            $events[] = $event;
        }

        Database::close($this->dbEvents);
        return $events;
    }
	
	public function getAllResultados(): array {
        $stmt = $this->dbEvents->query("SELECT * FROM resultados_AGUILASRUN5K");
		 
		 Database::close($this->dbEvents);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
	
	public function getEventById(string $id): array {
		$stmt = $this->dbEvents->query("SELECT * FROM eventos_tag_ WHERE id_ = '". $id."' ");

		// Verificar si la consulta fue exitosa
		if ($stmt === false) {
			// Manejar el error
			die("Error en la consulta: ");
		}

		$result = $stmt->fetchAll(PDO::FETCH_ASSOC);

		Database::close($this->dbEvents);

		return $result;
	}

}
