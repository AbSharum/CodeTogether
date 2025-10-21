<?php
    declare(strict_types=1);
    
    class Database {
        private static ?mysqli $connection = null;
    
        public static function getConnection(): mysqli {
            if (self::$connection === null) {
                $host = getenv('MYSQL_HOST') ?: 'mariadb';
                $db   = getenv('MYSQL_DATABASE');
                $user = getenv('MYSQL_USER');
                $pass = getenv('MYSQL_PASSWORD');
            
                
                self::$connection = new mysqli($host, $user, $pass, $db);
            
                if (self::$connection->connect_error) {
                    throw new Exception('Connection failed: ' . self::$connection->connect_error);
                }
            }
            return self::$connection;
        }
    
        public static function close(): void {
            if (self::$connection !== null) {
                self::$connection->close();
                self::$connection = null;
            }
        }
    }
?>
