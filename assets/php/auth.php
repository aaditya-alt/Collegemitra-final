<?php

require_once 'config.php';

class Auth extends Database{


//predicting the college
public function get_prediction($rank, $category){
    $sql = "SELECT * FROM tablename WHERE closingRank>=:rank AND category=:category";
    $stmt = $this->conn->prepare($sql);
    $stmt->execute(['rank'=>$rank, 'category'=>$category]);

    $result = $stmt->fetchAll(PDO::FETCH_ASSOC);
    return $result;
}






}

?>