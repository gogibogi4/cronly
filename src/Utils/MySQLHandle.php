<?php


namespace Cronly\Utils;

use Symfony\Component\Yaml\Yaml;

class MySQLHandle
{
    /**
     * @var null
     */
    private static $pdoHandle = null;

    /**
     * MySQLHandle constructor.
     * @param string $host
     * @param string $databaseName
     * @param string $user
     * @param string $password
     */
    public function __construct(string $host, string $databaseName, string $user, string $password)
    {
        self::$pdoHandle = new \PDO(sprintf('mysql:dbname=%s;host=%s', $databaseName, $host), $user, $password);
    }

    /**
     * @return \PDO
     */
    public static function getInstance(): \PDO
    {
        if (!isset(self::$pdoHandle)) {
            $config = Yaml::parse(file_get_contents(sprintf('%smysql.yml', BASE_CONFIG_DIR)));

            self::$pdoHandle = (new MySQLHandle(
                $config['host'],
                $config['database'],
                $config['username'],
                $config['password']
            ))->getInstance();
        }

        return self::$pdoHandle;
    }
}