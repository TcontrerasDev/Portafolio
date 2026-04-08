<?php

class Project
{

    private PDO $conn;

    public function __construct(PDO $conn)
    {
        $this->conn = $conn;
    }

    public function getAllProject(?string $categoria = null): array
    {
        $sql = "SELECT p.nombre AS titulo,
                c.nombre AS categoria,
                p.link,
                p.codigo_imagen
                FROM portf_proyectos p
                JOIN portf_categorias_proyectos c ON p.categoria_id = c.id";

        $params = [];

        if ($categoria !== null) {
            $sql .= " WHERE c.nombre = :categoria";
            $params[':categoria'] = $categoria;
        }
        $sql .= " ORDER BY p.id ASC";

        try {
            $stmt = $this->conn->prepare($sql);
            $stmt->execute($params);

            return $stmt->fetchAll();
        } catch (PDOException $e) {

            error_log("Error en Project::getAllProject: " . $e->getMessage());

            throw new RuntimeException("Ocurrio un problema al obtener los proyectos");
        }
    }

    // ── Métodos CRUD para el panel admin ──────────────────────────────────

    public function obtenerTodos(): array
    {
        $sql = 'SELECT p.*, c.nombre AS nombre_categoria
                FROM portf_proyectos p
                LEFT JOIN portf_categorias_proyectos c ON p.categoria_id = c.id
                ORDER BY p.id DESC';
        return $this->conn->query($sql)->fetchAll(PDO::FETCH_ASSOC);
    }

    public function obtenerPorId(int $id): ?array
    {
        $stmt = $this->conn->prepare('SELECT * FROM portf_proyectos WHERE id = :id LIMIT 1');
        $stmt->execute([':id' => $id]);
        $fila = $stmt->fetch(PDO::FETCH_ASSOC);
        return $fila ?: null;
    }

    public function crear(array $datos): int
    {
        $stmt = $this->conn->prepare(
            'INSERT INTO portf_proyectos (nombre, link, codigo_imagen, categoria_id)
             VALUES (:nombre, :link, :codigo_imagen, :categoria_id)'
        );
        $stmt->execute([
            ':nombre'        => $datos['nombre'],
            ':link'          => $datos['link'],
            ':codigo_imagen' => $datos['codigo_imagen'],
            ':categoria_id'  => $datos['categoria_id'],
        ]);
        return (int) $this->conn->lastInsertId();
    }

    public function actualizar(int $id, array $datos): bool
    {
        $stmt = $this->conn->prepare(
            'UPDATE portf_proyectos
             SET nombre = :nombre, link = :link, codigo_imagen = :codigo_imagen, categoria_id = :categoria_id
             WHERE id = :id'
        );
        return $stmt->execute([
            ':nombre'        => $datos['nombre'],
            ':link'          => $datos['link'],
            ':codigo_imagen' => $datos['codigo_imagen'],
            ':categoria_id'  => $datos['categoria_id'],
            ':id'            => $id,
        ]);
    }

    public function eliminar(int $id): bool
    {
        $stmt = $this->conn->prepare('DELETE FROM portf_proyectos WHERE id = :id');
        return $stmt->execute([':id' => $id]);
    }
}
