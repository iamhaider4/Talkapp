<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use PDO;
use PDOException;

class CreateDatabase extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'db:create';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Create a new MySQL database based on config';

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
        try {
            $database = config('database.connections.mysql.database');
            $host = config('database.connections.mysql.host');
            $port = config('database.connections.mysql.port');
            $username = config('database.connections.mysql.username');
            $password = config('database.connections.mysql.password');

            $pdo = new PDO("mysql:host=$host;port=$port", $username, $password);
            $pdo->exec("CREATE DATABASE IF NOT EXISTS `$database`;") 
                or die(print_r($pdo->errorInfo(), true));

            $this->info("Successfully created database: $database");
        } catch (PDOException $e) {
            $this->error($e->getMessage());
        }
    }
}
