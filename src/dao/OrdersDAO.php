<?php

require_once( __DIR__ . '/DAO.php');

class OrderDAO extends DAO {

  public function selectAllProductsWIthId($ids) {
    $sql = "SELECT * FROM `products` WHERE 1";

    $bindValues = array();

    if (!empty($ids)) {
      $idsParams = "";
      foreach($ids as $index => $value){
          $idsParams .= ":product_id_".$index.",";
          $bindValues[":product_id_".$index] = $value;
      }
      $idsParams = rtrim($idsParams,",");
      $sql .= " AND `id` IN ($idsParams)";
    }

    $stmt = $this->pdo->prepare($sql);
    $stmt->execute($bindValues);
    return $stmt->fetchAll(PDO::FETCH_ASSOC);
  }

  public function selectUserByEmailAndPassword($email, $password){
    $sql = "SELECT * FROM `users` WHERE `email` = :email AND `password` = :password";
    $stmt = $this->pdo->prepare($sql);
    $stmt->bindValue(':email',$email);
    $stmt->bindValue(':password',$password);
    $stmt->execute();
    return $stmt->fetch(PDO::FETCH_ASSOC);
  }

  public function insertOrder($data){
    $sql = "INSERT INTO `orders` (`user`, `ordered`) VALUES (:user, :ordered)";
    $stmt = $this->pdo->prepare($sql);
    $stmt->bindValue(':user', json_encode($data['info']));
    $stmt->bindValue(':ordered', json_encode($data['orders']));
    $stmt->execute();
  }
}
