<?php
require_once 'IRepository.php';
require_once '../config/db.php';

abstract class Repository implements IRepository {
    protected $db;
    protected $tableName;

    public function __construct($table) {
        $this->db = ConnexionDB::getInstance();
        $this->tableName = $table;
    }

    public function findAll() {
        $query = "SELECT * FROM {$this->tableName}";
        $response = ($this->db->query($query))->fetchAll();
        return $response;
    }

    public function findById($id) {
        $query = "SELECT * FROM {$this->tableName} WHERE id = :id";
        $response = $this->db->prepare($query);
        $response->execute(['id' => $id]);
        $response = $response->fetch(PDO::FETCH_ASSOC);
        return $response;
    }

    public function create($params) {
        $keys = array_keys($params);
        $keys_str = implode(',', $keys);

        $param_elements = array_fill(0, count($keys), '?');
        $param_elements_str = implode(',', $param_elements);

        $query = "INSERT INTO {$this->tableName} ({$keys_str}) VALUES ({$param_elements_str})";
        $reponse = $this->db->prepare($query);
        return $reponse->execute(array_values($params));
    }

    public function delete($id) {
        $query = "DELETE FROM {$this->tableName} WHERE id = ?";
        $response = $this->db->prepare($query);
        return $response->execute([$id]);
    }

    public function update($params) {
        $id = $params['id'];
        unset($params['id']);

        $set_clause = implode(' = ?, ', array_keys($params)) . ' = ?';
        $query = "UPDATE {$this->tableName} SET {$set_clause} WHERE id = ?";
        $response = $this->db->prepare($query);
        return $response->execute(array_merge(array_values($params), [$id]));
    }
}
