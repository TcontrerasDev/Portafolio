<?php

class ExperienciaAdminController
{
    private Experience $modelo;

    public function __construct(PDO $pdo)
    {
        $this->modelo = new Experience($pdo);
    }

    public function index(): void
    {
        $experiencias = $this->modelo->obtenerTodos();
        $mensaje      = $_SESSION['mensaje'] ?? null;
        unset($_SESSION['mensaje']);
        require __DIR__ . '/../../views/admin/experiencia/index.php';
    }

    public function crear(): void
    {
        $experiencia = null;
        $accion      = BASE_URL . '/admin/experiencia/guardar';
        require __DIR__ . '/../../views/admin/experiencia/formulario.php';
    }

    public function guardar(): void
    {
        Csrf::validar();
        $this->modelo->crear($this->extraerDatos());
        $_SESSION['mensaje'] = 'Experiencia creada correctamente';
        header('Location: ' . BASE_URL . '/admin/experiencia');
        exit;
    }

    public function editar(int $id): void
    {
        $experiencia = $this->modelo->obtenerPorId($id);
        if (!$experiencia) { http_response_code(404); exit('No encontrado'); }
        $accion = BASE_URL . '/admin/experiencia/actualizar/' . $id;
        require __DIR__ . '/../../views/admin/experiencia/formulario.php';
    }

    public function actualizar(int $id): void
    {
        Csrf::validar();
        if (!$this->modelo->obtenerPorId($id)) { http_response_code(404); exit('No encontrado'); }
        $this->modelo->actualizar($id, $this->extraerDatos());
        $_SESSION['mensaje'] = 'Experiencia actualizada';
        header('Location: ' . BASE_URL . '/admin/experiencia');
        exit;
    }

    public function eliminar(int $id): void
    {
        Csrf::validar();
        $this->modelo->eliminar($id);
        $_SESSION['mensaje'] = 'Experiencia eliminada';
        header('Location: ' . BASE_URL . '/admin/experiencia');
        exit;
    }

    private function extraerDatos(): array
    {
        return [
            'cargo'       => trim($_POST['cargo'] ?? ''),
            'empresa'     => trim($_POST['empresa'] ?? ''),
            'periodo'     => trim($_POST['periodo'] ?? ''),
            'descripcion' => trim($_POST['descripcion'] ?? ''),
        ];
    }
}
