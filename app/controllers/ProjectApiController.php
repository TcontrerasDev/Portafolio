<?php

class ProjectApiController
{

    private PDO $db;

    public function __construct(PDO $db)
    {
        $this->db = $db;
    }

    public function index(?string $categoria = null)
    {
        // 1. Establecemos la cabecera para que sea JSON puro
        header('Content-Type: application/json; charset=utf-8');

        try {
            $projectModel = new Project($this->db);
            $project = $projectModel->getAllProject($categoria);

            echo json_encode($project, JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES);
        } catch (Exception $e) {
            error_log("ProjectApiController error: " . $e->getMessage());
            http_response_code(500);
            echo json_encode([
                "error"   => true,
                "message" => "Error interno del servidor",
            ]);
        }
    }
}
