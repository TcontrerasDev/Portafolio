<?php

class CategoriaProyectoAdminController
{
    private CategoriaProyectoModel $modelo;

    public function __construct(PDO $pdo)
    {
        $this->modelo = new CategoriaProyectoModel($pdo);
    }

    public function index(): void
    {
        $categorias = $this->modelo->obtenerTodos();
        $mensaje    = $_SESSION['mensaje'] ?? null;
        unset($_SESSION['mensaje']);
        require __DIR__ . '/../../views/admin/categorias-proyectos/index.php';
    }

    public function crear(): void
    {
        $categoria = null;
        $accion    = BASE_URL . '/tom-workspace/categorias-proyectos/guardar';
        require __DIR__ . '/../../views/admin/categorias-proyectos/formulario.php';
    }

    public function guardar(): void
    {
        Csrf::validar();
        $datos = $this->extraerDatos();
        $this->modelo->crear($datos);
        $_SESSION['mensaje'] = 'Categoría de proyecto creada';
        header('Location: ' . BASE_URL . '/tom-workspace/categorias-proyectos');
        exit;
    }

    public function editar(int $id): void
    {
        $categoria = $this->modelo->obtenerPorId($id);
        if (!$categoria) { http_response_code(404); exit('No encontrado'); }
        $accion = BASE_URL . '/tom-workspace/categorias-proyectos/actualizar/' . $id;
        require __DIR__ . '/../../views/admin/categorias-proyectos/formulario.php';
    }

    public function actualizar(int $id): void
    {
        Csrf::validar();
        if (!$this->modelo->obtenerPorId($id)) { http_response_code(404); exit('No encontrado'); }
        $this->modelo->actualizar($id, $this->extraerDatos());
        $_SESSION['mensaje'] = 'Categoría de proyecto actualizada';
        header('Location: ' . BASE_URL . '/tom-workspace/categorias-proyectos');
        exit;
    }

    public function eliminar(int $id): void
    {
        Csrf::validar();
        if ($this->modelo->estaEnUso($id)) {
            $_SESSION['mensaje'] = 'No se puede eliminar: la categoría está en uso por proyectos';
            header('Location: ' . BASE_URL . '/tom-workspace/categorias-proyectos');
            exit;
        }
        $this->modelo->eliminar($id);
        $_SESSION['mensaje'] = 'Categoría de proyecto eliminada';
        header('Location: ' . BASE_URL . '/tom-workspace/categorias-proyectos');
        exit;
    }

    private function extraerDatos(): array
    {
        return ['nombre' => trim($_POST['nombre'] ?? '')];
    }
}
