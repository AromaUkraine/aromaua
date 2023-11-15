<?php

namespace Modules\Backup\Services;


use Illuminate\Filesystem\FilesystemAdapter;

class BackupService
{

    private $connection;

    private function getEngine($engine=null): string
    {
        $engine = $engine ?? config('database.default');
        $this->connection = config('database.connections')[$engine];

        return $engine;
    }

    private function getUsername(): string
    {
        return $this->connection['username'];
    }

    private function getPassword(): string
    {
        return $this->connection['password'];
    }

    private function getHostname(): string
    {
        return $this->connection['host'];
    }

    private function getPort(): string
    {
        return $this->connection['port'];
    }

    private function getDatabase(): string
    {
        return $this->connection['database'];
    }


    public function restore($filepath, $engine=null)
    {
        $command = sprintf(
            '%s --user=%s --password=%s --host=%s --port=%s %s < %s',
            $this->getEngine($engine),
            escapeshellarg($this->getUsername()),
            escapeshellarg($this->getPassword()),
            escapeshellarg($this->getHostname()),
            escapeshellarg($this->getPort()),
            escapeshellarg($this->getDatabase()),
            escapeshellarg($filepath)
        );

        exec($command);
        
        return true;
    }

    

    
    public function getBackups(FilesystemAdapter $disk, $dirname, $reverse = true)
    {
        $files = $disk->files('/' . $dirname . '/');
        $backups = [];

        foreach ($files as $k => $f) {
            if (substr($f, -4) == '.zip' && $disk->exists($f)) {
                $backups[] = [
                    'file_path' => $f,
                    'file_name' => $this->humanFileName($f, $dirname),
                    'file_size' => $disk->size($f),
                    'human_file_size' =>  $this->humanFileSize($disk->size($f)),
                    'last_modified' => $disk->lastModified($f),
                ];
            }
        }

        if($reverse)
            return array_reverse($backups);
        else
            return $backups;
    }


    private function humanFileName($file, $dirname)
    {
        $file_name = str_replace(config('laravel-backup.backup.name') . $dirname . '/', '', $file);
        return str_replace('.zip', '', $file_name);
    }


    private function humanFileSize($size, $unit = "")
    {
        if ((!$unit && $size >= 1 << 30) || $unit == "GB")
            return number_format($size / (1 << 30), 2) . "GB";
        if ((!$unit && $size >= 1 << 20) || $unit == "MB")
            return number_format($size / (1 << 20), 2) . "MB";
        if ((!$unit && $size >= 1 << 10) || $unit == "KB")
            return number_format($size / (1 << 10), 2) . "KB";
        return number_format($size) . " bytes";
    }
}
