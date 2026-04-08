<?php

class TechnicalSkill
{

    // Propiedad privada y estrictamente tipada
    private PDO $conn;

    public function __construct(PDO $conn)
    {
        $this->conn = $conn;
    }

    /**
     * Obtiene todas las habilidades técnicas agrupadas por su categoría.
     * * @return array Arreglo asociativo ['Categoria' => ['Habilidad1', 'Habilidad2']]
     * @throws RuntimeException Si la consulta a la base de datos falla
     */
    public function getAllGroupedByCategory(): array
    {

        $sql = "SELECT c.nombre AS categoria, h.nombre_habilidad 
                FROM portf_habilidades h 
                JOIN portf_categorias c ON h.categoria_id = c.id 
                ORDER BY c.id, h.id";

        try {
            // 1. Sentencia Preparada (Incluso si no hay variables externas, es una excelente costumbre)
            $stmt = $this->conn->prepare($sql);
            $stmt->execute();

            // 2. Extracción de datos (PDO ya sabe que debe devolver FETCH_ASSOC por tu clase Database)
            $data = $stmt->fetchAll();

            // 3. Agrupación optimizada
            $grouped = [];
            foreach ($data as $row) {
                $categoria = $row['categoria'];
                $grouped[$categoria][] = $row['nombre_habilidad'];
            }

            return $grouped;
        } catch (PDOException $e) {
            // 4. Manejo de Errores Silencioso
            // Registramos el error real con detalles (query, tabla) en el log del servidor
            error_log("Error en TechnicalSkill::getAllGroupedByCategory: " . $e->getMessage());

            // Lanzamos una excepción genérica para que el Controlador decida qué mostrar en pantalla
            throw new RuntimeException("Ocurrió un problema al obtener las habilidades técnicas.");
        }
    }

    // ── Métodos CRUD para el panel admin ──────────────────────────────────

    public function obtenerTodos(): array
    {
        $sql = 'SELECT h.*, c.nombre AS nombre_categoria
                FROM portf_habilidades h
                LEFT JOIN portf_categorias c ON h.categoria_id = c.id
                ORDER BY c.id ASC, h.id ASC';
        return $this->conn->query($sql)->fetchAll(PDO::FETCH_ASSOC);
    }

    public function obtenerPorId(int $id): ?array
    {
        $stmt = $this->conn->prepare('SELECT * FROM portf_habilidades WHERE id = :id LIMIT 1');
        $stmt->execute([':id' => $id]);
        $fila = $stmt->fetch(PDO::FETCH_ASSOC);
        return $fila ?: null;
    }

    public function crear(array $datos): int
    {
        $stmt = $this->conn->prepare(
            'INSERT INTO portf_habilidades (nombre_habilidad, categoria_id)
             VALUES (:nombre_habilidad, :categoria_id)'
        );
        $stmt->execute([
            ':nombre_habilidad' => $datos['nombre_habilidad'],
            ':categoria_id'     => $datos['categoria_id'],
        ]);
        return (int) $this->conn->lastInsertId();
    }

    public function actualizar(int $id, array $datos): bool
    {
        $stmt = $this->conn->prepare(
            'UPDATE portf_habilidades
             SET nombre_habilidad = :nombre_habilidad, categoria_id = :categoria_id
             WHERE id = :id'
        );
        return $stmt->execute([
            ':nombre_habilidad' => $datos['nombre_habilidad'],
            ':categoria_id'     => $datos['categoria_id'],
            ':id'               => $id,
        ]);
    }

    public function eliminar(int $id): bool
    {
        $stmt = $this->conn->prepare('DELETE FROM portf_habilidades WHERE id = :id');
        return $stmt->execute([':id' => $id]);
    }
}
