<?php

class Utility
{

    public static function replaceUpload(array $file, string $uploadDir, ?string $oldFile = null)
    {
        $newFile = self::handleUpload($file, $uploadDir);

        if (!$newFile) {
            return false;
        }

        // Delete old file
        if (!empty($oldFile)) {
            
            $oldFileName = basename($oldFile);
            $oldFilePath = BASE_PATH . DIRECTORY_SEPARATOR . ltrim($uploadDir, '/\\') . DIRECTORY_SEPARATOR . $oldFileName;

            if (file_exists($oldFilePath) && is_file($oldFilePath)) {
                unlink($oldFilePath);
            }
        }

        return $newFile;
    }

    public static function handleUpload($file = null, string $targetDir): ?string
    {
        if (!$file || $file['error'] !== UPLOAD_ERR_OK) {
            return null;
        }

        $extension = strtolower(pathinfo($file['name'], PATHINFO_EXTENSION));
        $allowedExtensions = ['jpg', 'jpeg', 'png', 'webp'];

        if (!in_array($extension, $allowedExtensions)) {
            return null;
        }

        $filename = uniqid('', true) . '.' . $extension;

        $targetDir = ltrim($targetDir, '/\\');
        $targetPath = BASE_PATH . DIRECTORY_SEPARATOR . $targetDir . DIRECTORY_SEPARATOR . $filename;

        // check and if not exist create it 
        $dir = dirname($targetPath);
        if (!is_dir($dir)) {
            mkdir($dir, 0777, true);
        }

        if (move_uploaded_file($file['tmp_name'], $targetPath)) {
            return $filename;
        }

        return null;
    }
}
