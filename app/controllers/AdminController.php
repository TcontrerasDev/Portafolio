<?php

class AdminController
{
    private PDO $pdo;

    public function __construct(PDO $pdo)
    {
        $this->pdo = $pdo;
    }

    public function dashboard(): void
    {
        // Conteos para el dashboard
        $totalProyectos   = (int) $this->pdo->query('SELECT COUNT(*) FROM portf_proyectos')->fetchColumn();
        $totalHabilidades = (int) $this->pdo->query('SELECT COUNT(*) FROM portf_habilidades')->fetchColumn();
        $totalExperiencia = (int) $this->pdo->query('SELECT COUNT(*) FROM portf_experiencia')->fetchColumn();
        $totalCategorias  = (int) $this->pdo->query('SELECT COUNT(*) FROM portf_categorias')->fetchColumn();

        require __DIR__ . '/../../views/admin/dashboard.php';
    }
}
