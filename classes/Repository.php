<?php
include_once "db.php";
abstract class Repository implements IRespository{
    protected $db;
    protected $tableName;
    
    public function __construct($table){
        $db = ConnexionDB::getConnection();
        $this->tableName = $table;
    }

    public function findAll(){
        $query= "SELECT * FROM $this->tableName";
        $response = (this->db->query($query))->fetchAll(PDO::FETCH_OBJ);
        return $response;
    }

    public function findById($id){
        $query = "SELECT * FROM {$this->tableName} WHERE id=:id";
        $response = this->db->prepare($query);
        $response = ($response->execute(['id' => $id]))->fetchAll(PDO::FETCH_ASSOC);
        return $response;
    }

    public function create($params){
        $keys = array_keys($params);
        $keys_str = implode(',', $keys);

        $param_elements = array_fill(0, count($keys), '?');
        $param_elements_str = implode(',', $param_elements);

        $query = "INSERT INTO {this->tableName}({$keys_str}) VALUES ({$param_elements_str})";
        $reponse = this->db->prepare($query);
        $reponse->execute(array_values($params));
        return $reponse->fetchAll(PDO::FETCH_OBJ);
    }

    public function delete($id){
        $query = "DELETE {this->tableName} WHERE id = ?";
        $response = $this->db->prepare($query);
        $response->execute($id);
    }

}