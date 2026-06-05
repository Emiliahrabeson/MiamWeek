<?php
require_once 'Database.php';

class Model {
    protected $pdo;

    public function __construct() {
        $this->pdo = Database::getConnection();
    }
}
