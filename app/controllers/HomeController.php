<?php

class HomeController
{
    // Propiedad privada para guardar la conexión
    private PDO $db;

    // El constructor recibe la conexión (Inyección de Dependencias)
    public function __construct(PDO $db) {
        $this->db = $db;
    }

    public function index()
    {
        // Inicializamos variables para la vista
        $habilidades = [];
        $experience = [];
        $error = null;

        try {
            // Usamos la conexión que ya tenemos guardada en $this->db
            $technicalSkillModel = new TechnicalSkill($this->db);
            $habilidades = $technicalSkillModel->getAllGroupedByCategory();

            $experienceModel = new Experience($this->db);
            $experience = $experienceModel->getAllexperience();  

        } catch (RuntimeException $e) {
            // Capturamos el error para pasarlo a la vista
            $error = $e->getMessage();
        }

        require_once __DIR__ . '/../../views/layout/header.php';
        require_once __DIR__ . '/../../views/pages/home.php';
        require_once __DIR__ . '/../../views/layout/footer.php';

    }
}
