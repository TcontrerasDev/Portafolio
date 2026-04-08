<?php

class SubidaImagen
{
    /**
     * Procesa una imagen subida por formulario.
     *
     * @param string $campo   Nombre del input file (ej: 'imagen')
     * @param string $carpeta Subcarpeta dentro de public/assets/img/ (ej: 'proyectos')
     * @return string|null    Nombre del archivo guardado, o null si no se subió nada
     */
    public static function procesar(string $campo, string $carpeta): ?string
    {
        if (empty($_FILES[$campo]) || $_FILES[$campo]['error'] === UPLOAD_ERR_NO_FILE) {
            return null;
        }

        $archivo = $_FILES[$campo];

        if ($archivo['error'] !== UPLOAD_ERR_OK) {
            throw new RuntimeException('Error al subir la imagen (código ' . $archivo['error'] . ')');
        }

        // Validar tamaño (5 MB máx)
        if ($archivo['size'] > 5 * 1024 * 1024) {
            throw new RuntimeException('La imagen excede 5 MB');
        }

        // Detectar tipo MIME real por magic bytes (sin depender de extensiones PHP)
        $mime = self::detectarMime($archivo['tmp_name']);
        $extensionesPermitidas = [
            'image/webp' => 'webp',
            'image/png'  => 'png',
            'image/jpeg' => 'jpg',
            'image/avif' => 'avif',
            'image/gif'  => 'gif',
        ];
        if (!isset($extensionesPermitidas[$mime])) {
            throw new RuntimeException('Tipo de imagen no permitido');
        }

        // Conservar extensión original si coincide con el MIME
        $extensionOriginal = strtolower(pathinfo($archivo['name'], PATHINFO_EXTENSION));
        $extensionMime     = $extensionesPermitidas[$mime];
        $extension         = ($extensionOriginal === $extensionMime
                              || ($extensionOriginal === 'jpeg' && $extensionMime === 'jpg'))
            ? $extensionOriginal
            : $extensionMime;

        // Sanitizar nombre base
        $nombreBase = pathinfo($archivo['name'], PATHINFO_FILENAME);
        $nombreBase = preg_replace('/[^a-zA-Z0-9_-]/', '-', $nombreBase);
        $nombreBase = trim($nombreBase, '-') ?: 'imagen';
        $nombreBase = strtolower($nombreBase);

        // Evitar colisiones
        $directorio = __DIR__ . '/../../public/assets/img/' . $carpeta;
        if (!is_dir($directorio)) {
            mkdir($directorio, 0775, true);
        }

        $nombreFinal = $nombreBase . '.' . $extension;
        if (file_exists($directorio . '/' . $nombreFinal)) {
            $nombreFinal = $nombreBase . '-' . substr(bin2hex(random_bytes(4)), 0, 6) . '.' . $extension;
        }

        if (!move_uploaded_file($archivo['tmp_name'], $directorio . '/' . $nombreFinal)) {
            throw new RuntimeException('No se pudo mover la imagen subida');
        }

        return $nombreFinal;
    }

    public static function eliminar(string $nombreArchivo, string $carpeta): void
    {
        if (empty($nombreArchivo)) return;
        $ruta = __DIR__ . '/../../public/assets/img/' . $carpeta . '/' . basename($nombreArchivo);
        if (is_file($ruta)) {
            if (!unlink($ruta)) {
                error_log("SubidaImagen: no se pudo eliminar {$ruta}");
            }
        }
    }

    /**
     * Detecta el tipo MIME leyendo los magic bytes del archivo.
     * No requiere extensiones PHP adicionales (fileinfo, mime_magic).
     */
    private static function detectarMime(string $ruta): string
    {
        $handle = fopen($ruta, 'rb');
        if (!$handle) {
            throw new RuntimeException('No se pudo leer el archivo subido');
        }
        $bytes = fread($handle, 12);
        fclose($handle);

        // PNG: \x89PNG\r\n\x1a\n
        if (substr($bytes, 0, 8) === "\x89PNG\r\n\x1a\n") {
            return 'image/png';
        }
        // JPEG: \xFF\xD8\xFF
        if (substr($bytes, 0, 3) === "\xFF\xD8\xFF") {
            return 'image/jpeg';
        }
        // GIF: GIF87a o GIF89a
        if (substr($bytes, 0, 6) === 'GIF87a' || substr($bytes, 0, 6) === 'GIF89a') {
            return 'image/gif';
        }
        // WebP: RIFF????WEBP
        if (substr($bytes, 0, 4) === 'RIFF' && substr($bytes, 8, 4) === 'WEBP') {
            return 'image/webp';
        }
        // AVIF/HEIF: ftyp a los 4 bytes
        if (substr($bytes, 4, 4) === 'ftyp') {
            return 'image/avif';
        }

        return 'application/octet-stream';
    }
}
