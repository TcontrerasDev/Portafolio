<?php

class HabilidadAdminController
{
    private TechnicalSkill $modelo;
    private CategoriaModel $modeloCategorias;

    public function __construct(PDO $pdo)
    {
        $this->modelo           = new TechnicalSkill($pdo);
        $this->modeloCategorias = new CategoriaModel($pdo);
    }

    public function index(): void
    {
        $habilidades = $this->modelo->obtenerTodos();
        $mensaje     = $_SESSION['mensaje'] ?? null;
        unset($_SESSION['mensaje']);
        require __DIR__ . '/../../views/admin/habilidades/index.php';
    }

    public function crear(): void
    {
        $habilidad  = null;
        $categorias = $this->modeloCategorias->obtenerTodos();
        $accion     = BASE . '/admin/habilidades/guardar';
        require __DIR__ . '/../../views/admin/habilidades/formulario.php';
    }

    public function guardar(): void
    {
        Csrf::validar();
        $datos = $this->extraerDatos();
        $this->modelo->crear($datos);
        $_SESSION['mensaje'] = 'Habilidad creada correctamente';
        header('Location: ' . BASE . '/admin/habilidades');
        exit;
    }

    public function editar(int $id): void
    {
        $habilidad = $this->modelo->obtenerPorId($id);
        if (!$habilidad) { http_response_code(404); exit('No encontrado'); }
        $categorias = $this->modeloCategorias->obtenerTodos();
        $accion     = BASE . '/admin/habilidades/actualizar/' . $id;
        require __DIR__ . '/../../views/admin/habilidades/formulario.php';
    }

    public function actualizar(int $id): void
    {
        Csrf::validar();
        $existente = $this->modelo->obtenerPorId($id);
        if (!$existente) { http_response_code(404); exit('No encontrado'); }
        $this->modelo->actualizar($id, $this->extraerDatos());
        $_SESSION['mensaje'] = 'Habilidad actualizada';
        header('Location: ' . BASE . '/admin/habilidades');
        exit;
    }

    public function eliminar(int $id): void
    {
        Csrf::validar();
        $this->modelo->eliminar($id);
        $_SESSION['mensaje'] = 'Habilidad eliminada';
        header('Location: ' . BASE . '/admin/habilidades');
        exit;
    }

    private function extraerDatos(): array
    {
        return [
            'nombre_habilidad' => trim($_POST['nombre_habilidad'] ?? ''),
            'categoria_id'     => (int) ($_POST['categoria_id'] ?? 0),
        ];
    }
}
