<?php

namespace src\Repositories;

use PDO;
use src\Models\Role;
use src\Models\Database;

class RoleRepository
{
    private $DB;

    public function __construct()
    {
        $database = new Database;
        $this->DB = $database->getDB();

        require_once __DIR__ . '/../../config.php';
    }

    public function getRoleById()
    {
        $sql = "SELECT Id_Role, type FROM role;";
        return  $this->DB->query($sql)->fetchAll(PDO::FETCH_CLASS, Role::class);
    }

    
}