<?php

namespace Config;

use CodeIgniter\Database\Config;

/**
 * Database Configuration
 */
class Database extends Config
{
    public string $filesPath = APPPATH . 'Database' . DIRECTORY_SEPARATOR;
    public string $defaultGroup = 'default';

    // public array $default = [
    //     'DSN'      => '',
    //     'hostname' => 'localhost',
    //     'username' => 'root',
    //     'password' => '',
    //     'database' => '',
    //     'DBDriver' => 'MySQLi',
    //     'DBPrefix' => '',
    //     'pConnect' => false,
    //     'DBDebug'  => (ENVIRONMENT !== 'development'),
    //     'cacheOn'  => false,
    //     'cacheDir' => '',
    //     'charset'  => 'utf8',
    //     'DBCollat' => 'utf8_general_ci',
    //     'swapPre'  => '',
    //     'encrypt'  => false,
    //     'compress' => false,
    //     'strictOn' => false,
    //     'failover' => [],
    //     'port'     => 3306,
    // ];

   public $default = [
        'DSN'      => '',
        'hostname' => '103.200.23.98', // zygame.click
        'username' => 'zygamezi',
        'password' => '+Q@J!T^cISmm58oc',
        'database' => 'zygamezi_panel',
        'DBDriver' => 'MySQLi',
        'DBPrefix' => '',
        'pConnect' => false,
        'DBDebug'  => (ENVIRONMENT !== 'production'),   // bật debug khi dev, tắt khi live
        'cacheOn'  => false,
        'cacheDir' => '',
        'charset'  => 'utf8mb4',                        // hỗ trợ emoji + đa ngôn ngữ
        'DBCollat' => 'utf8mb4_unicode_ci',
        'swapPre'  => '',
        'encrypt'  => true,                             // Bật nếu kết nối remote có SSL
        'compress' => false,
        'strictOn' => true,                             // Bật chế độ SQL Strict Mode để tránh query mập mờ (giúp bảo mật hơn).
        'failover' => [],
        'port'     => 3306,
    ];

    public array $tests = [
        'DSN'         => '',
        'hostname'    => '127.0.0.1',
        'username'    => '',
        'password'    => '',
        'database'    => ':memory:',
        'DBDriver'    => 'SQLite3',
        'DBPrefix'    => 'db_',  // Needed to ensure we're working correctly with prefixes live. DO NOT REMOVE FOR CI DEVS
        'pConnect'    => false,
        'DBDebug'     => true,
        'charset'     => 'utf8',
        'DBCollat'    => 'utf8_general_ci',
        'swapPre'     => '',
        'encrypt'     => false,
        'compress'    => false,
        'strictOn'    => false,
        'failover'    => [],
        'port'        => 3306,
        'foreignKeys' => true,
        'busyTimeout' => 1000,
    ];

    public function __construct()
    {
        parent::__construct();
        
        //$this->default['hostname'] = $_SERVER['HTTP_HOST'] ?? $this->default['hostname'];
        
        if (ENVIRONMENT === 'testing') {
            $this->defaultGroup = 'tests';
        }
    }
}
