<?php

class ProyectoAdminController
{
    private Project $modelo;
    private CategoriaProyectoModel $modeloCategorias;

    public function __construct(PDO $pdo)
    {
        $this->modelo           = new Project($pdo);
        $this->modeloCategorias = new CategoriaProyectoModel($pdo);
    }

    public function index(): void
    {
        $proyectos = $this->modelo->obtenerTodos();
        $mensaje   = $_SESSION['mensaje'] ?? null;
        unset($_SESSION['mensaje']);
        require __DIR__ . '/../../views/admin/proyectos/index.php';
    }

    public function crear(): void
    {
        $proyecto   = null;
        $categorias = $this->modeloCategorias->obtenerTodos();
        $accion     = BASE_URL . '/admin/proyectos/guardar';
        require __DIR__ . '/../../views/admin/proyectos/formulario.php';
    }

    public function guardar(): void
    {
        Csrf::validar();
        $datos = $this->extraerDatos();
        $datos['codigo_imagen'] = SubidaImagen::procesar('imagen', '') ?? '';
        $this->modelo->crear($datos);
        $_SESSION['mensaje'] = 'Proyecto creado correctamente';
        header('Location: ' . BASE_URL . '/admin/proyectos');
        exit;
    }

    public function editar(int $id): void
    {
        $proyecto = $this->modelo->obtenerPorId($id);
        if (!$proyecto) { http_response_code(404); exit('No encontrado'); }
        $categorias = $this->modeloCategorias->obtenerTodos();
        $accion     = BASE_URL . '/admin/proyectos/actualizar/' . $id;
        require __DIR__ . '/../../views/admin/proyectos/formulario.php';
    }

    public function actualizar(int $id): void
    {
        Csrf::validar();
        $existente = $this->modelo->obtenerPorId($id);
        if (!$existente) { http_response_code(404); exit('No encontrado'); }

        $datos = $this->extraerDatos();
        $nuevaImagen            = SubidaImagen::procesar('imagen', '');
        $datos['codigo_imagen'] = $nuevaImagen ?? $existente['codigo_imagen'];

        $this->modelo->actualizar($id, $datos);
        $_SESSION['mensaje'] = 'Proyecto actualizado';
        header('Location: ' . BASE_URL . '/admin/proyectos');
        exit;
    }

    public function eliminar(int $id): void
    {
        Csrf::validar();
        $existente = $this->modelo->obtenerPorId($id);
        if ($existente && !empty($existente['codigo_imagen'])) {
            SubidaImagen::eliminar($existente['codigo_imagen'], '');
        }
        $this->modelo->eliminar($id);
        $_SESSION['mensaje'] = 'Proyecto eliminado';
        header('Location: ' . BASE_URL . '/admin/proyectos');
        exit;
    }

    private function extraerDatos(): array
    {
        return [
            'nombre'       => trim($_POST['nombre'] ?? ''),
            'link'         => trim($_POST['link'] ?? ''),
            'categoria_id' => (int) ($_POST['categoria_id'] ?? 0),
        ];
    }
}
