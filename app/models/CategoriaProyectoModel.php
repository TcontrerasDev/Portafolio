<?php

class CategoriaProyectoModel
{
    private PDO $pdo;

    public function __construct(PDO $pdo)
    {
        $this->pdo = $pdo;
    }

    public function obtenerTodos(): array
    {
        return $this->pdo->query(
            'SELECT * FROM portf_categorias_proyectos ORDER BY id ASC'
        )->fetchAll(PDO::FETCH_ASSOC);
    }

    public function obtenerPorId(int $id): ?array
    {
        $stmt = $this->pdo->prepare('SELECT * FROM portf_categorias_proyectos WHERE id = :id LIMIT 1');
        $stmt->execute([':id' => $id]);
        $fila = $stmt->fetch(PDO::FETCH_ASSOC);
        return $fila ?: null;
    }

    public function crear(array $datos): int
    {
        $stmt = $this->pdo->prepare('INSERT INTO portf_categorias_proyectos (nombre) VALUES (:nombre)');
        $stmt->execute([':nombre' => $datos['nombre']]);
        return (int) $this->pdo->lastInsertId();
    }

    public function actualizar(int $id, array $datos): bool
    {
        $stmt = $this->pdo->prepare('UPDATE portf_categorias_proyectos SET nombre = :nombre WHERE id = :id');
        return $stmt->execute([':nombre' => $datos['nombre'], ':id' => $id]);
    }

    public function eliminar(int $id): bool
    {
        $stmt = $this->pdo->prepare('DELETE FROM portf_categorias_proyectos WHERE id = :id');
        return $stmt->execute([':id' => $id]);
    }

    public function estaEnUso(int $id): bool
    {
        $stmt = $this->pdo->prepare('SELECT COUNT(*) FROM portf_proyectos WHERE categoria_id = :id');
        $stmt->execute([':id' => $id]);
        return ((int) $stmt->fetchColumn()) > 0;
    }
}
