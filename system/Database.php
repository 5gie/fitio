<?php

namespace app\system;

use PDO;

class Database
{
    public PDO $pdo;
    
    public function __construct(array $config)
    {
        
        $dsn = $config['dsn'] ?? '';
        $user = $config['user'] ?? '';
        $password = $config['password'] ?? '';
        $this->pdo = new PDO($dsn, $user, $password);
        $this->pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        
    }

    public function applyMigrations()
    {

        $this->createMigrationsTable();
        $applied = $this->getAppliedMigrations();

        $files = scandir(App::$ROOT_DIR.'/migrations');
        $toApply = array_diff($files, $applied);

        $newMigrations = [];
        foreach($toApply as $migration) {

            if($migration == '.' || $migration == '..') continue;

            require_once App::$ROOT_DIR.'/migrations/'.$migration;
            $className = pathinfo($migration, PATHINFO_FILENAME);
            $instance = new $className;
            $this->log('Applying migration');
            $instance->up();
            $this->log('Migration applied');
            $newMigrations[] = $migration;
        }

        if(!empty($newMigrations)){
            $this->saveMigrations($newMigrations);
        } else {
            $this->log('All migrations are applied');
        }

    }

    public function createMigrationsTable()
    {

        $this->pdo->exec('CREATE TABLE IF NOT EXISTS migrations(
            id INT AUTO_INCREMENT PRIMARY KEY,
            migration VARCHAR(255),
            created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
        ) ENGINE=InnoDB DEFAULT CHARSET=utf8');

    }

    public function getAppliedMigrations()
    {
        $stmt = $this->pdo->prepare('SELECT migration FROM migrations');
        $stmt->execute();

        return $stmt->fetchAll(PDO::FETCH_COLUMN);
    }

    public function saveMigrations(array $migrations)
    {
        $migrations = implode(',',array_map(fn($m) => "('$m')", $migrations));
        $stmt = $this->pdo->prepare('INSERT INTO migrations (migration) VALUES '.$migrations.'');

        $stmt->execute();
    }

    public function prepare($sql)
    {
        return $this->pdo->prepare($sql);
    }

    protected function log($message)
    {
        echo '['.date('Y-m-d H:i:s').'] - '.$message . PHP_EOL;
    }

}