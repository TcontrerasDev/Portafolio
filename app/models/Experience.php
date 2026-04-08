<?php

class Experience
{

    private PDO $conn;

    public function __construct(PDO $conn)
    {
        $this->conn = $conn;
    }

    public function getAllexperience(): array
    {

        $sql = "SELECT * FROM portf_experiencia ORDER BY id DESC";

        try {
            $stmt = $this->conn->prepare($sql);
            $stmt->execute();

            return $stmt->fetchAll();
        } catch (PDOException $e) {

            error_log("Error en Experience::gerAllexperience: " . $e->getMessage());

            throw new RuntimeException("Ocurrio un problema al obtener la experienca laboral");
        }
    }

    // ── Métodos CRUD para el panel admin ──────────────────────────────────

    public function obtenerTodos(): array
    {
        return $this->conn->query(
            'SELECT * FROM portf_experiencia ORDER BY id DESC'
        )->fetchAll(PDO::FETCH_ASSOC);
    }

    public function obtenerPorId(int $id): ?array
    {
        $stmt = $this->conn->prepare('SELECT * FROM portf_experiencia WHERE id = :id LIMIT 1');
        $stmt->execute([':id' => $id]);
        $fila = $stmt->fetch(PDO::FETCH_ASSOC);
        return $fila ?: null;
    }

    public function crear(array $datos): int
    {
        $stmt = $this->conn->prepare(
            'INSERT INTO portf_experiencia (cargo, empresa, periodo, descripcion)
             VALUES (:cargo, :empresa, :periodo, :descripcion)'
        );
        $stmt->execute([
            ':cargo'       => $datos['cargo'],
            ':empresa'     => $datos['empresa'],
            ':periodo'     => $datos['periodo'],
            ':descripcion' => $datos['descripcion'],
        ]);
        return (int) $this->conn->lastInsertId();
    }

    public function actualizar(int $id, array $datos): bool
    {
        $stmt = $this->conn->prepare(
            'UPDATE portf_experiencia
             SET cargo = :cargo, empresa = :empresa, periodo = :periodo, descripcion = :descripcion
             WHERE id = :id'
        );
        return $stmt->execute([
            ':cargo'       => $datos['cargo'],
            ':empresa'     => $datos['empresa'],
            ':periodo'     => $datos['periodo'],
            ':descripcion' => $datos['descripcion'],
            ':id'          => $id,
        ]);
    }

    public function eliminar(int $id): bool
    {
        $stmt = $this->conn->prepare('DELETE FROM portf_experiencia WHERE id = :id');
        return $stmt->execute([':id' => $id]);
    }
}
