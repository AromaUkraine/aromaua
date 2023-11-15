<?php

namespace App\Services;

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

}