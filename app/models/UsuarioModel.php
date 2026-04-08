<?php

class UsuarioModel
{
    private PDO $pdo;

    public function __construct(PDO $pdo)
    {
        $this->pdo = $pdo;
    }

    public function obtenerPorNombre(string $nombre): ?array
    {
        $stmt = $this->pdo->prepare(
            'SELECT * FROM portf_usuarios WHERE nombre_usuario = :nombre LIMIT 1'
        );
        $stmt->execute([':nombre' => $nombre]);
        $fila = $stmt->fetch(PDO::FETCH_ASSOC);
        return $fila ?: null;
    }
}
