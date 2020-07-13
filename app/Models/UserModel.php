<?php

namespace App\Models;

use App\Utils\Database;

use PDO;

class UserModel extends CoreModel {

  /**
   * Card ID of the user
   * Nullable
   */
  private $card_id;

  /**
   * First name of User
   */
  private $first_name;

  /**
   * Last name of user
   */
  private $last_name;

  /**
   * Email of user
   */
  private $email;

  /**
   * Password of user
   */
  private $password;

  const TABLE_NAME = 'users';

  public static function find($email){
    $sql = 'SELECT *
            FROM ' . static::TABLE_NAME .
          ' WHERE email = :email';

    $pdo = Database::getPDO();
    $pdoStatement = $pdo->prepare($sql);
    $pdoStatement->bindValue(':email', $email, PDO::PARAM_STR);
    $pdoStatement->execute();

    $result = $pdoStatement->fetchObject(static::class);
    return $result;  
  }

  public static function findById($id){
    $sql = 'SELECT *
            FROM ' . static::TABLE_NAME .
          ' WHERE id = :id';

    $pdo = Database::getPDO();
    $pdoStatement = $pdo->prepare($sql);
    $pdoStatement->bindValue(':id', $id, PDO::PARAM_INT);
    $pdoStatement->execute();

    $result = $pdoStatement->fetchObject(static::class);
    return
     $result;  
  }
  
  public function insert() {
    $sql = '
      INSERT INTO ' . self::TABLE_NAME . ' (
        `first_name`
        ,`last_name`
        ,`email`
        ,`password`
        )
      VALUES (
        :firstName
        ,:lastName
        ,:email
        ,:password
        )
    ';

    $pdo = Database::getPDO();

    $pdoStatement = $pdo->prepare($sql);
    $pdoStatement->bindParam(':firstName', $this->first_name, PDO::PARAM_STR);
    $pdoStatement->bindParam(':lastName', $this->last_name, PDO::PARAM_STR);
    $pdoStatement->bindParam(':email', $this->email, PDO::PARAM_STR);
    $pdoStatement->bindParam(':password', $this->password, PDO::PARAM_STR);

    $pdoStatement->execute();

    $insertedRow = $pdoStatement->rowCount();

    if($insertedRow < 1 ){
      return false;
    }

    $this->id = $pdo->lastInsertId();
    return true;
  }

  public function update()
  {
    $sql = '
      UPDATE ' . self::TABLE_NAME .
    ' 
      SET 
        `first_name` = :firstName
        ,`last_name` = :lastName
        ,`email` = :email
        ,`card_id` = :card_id
      WHERE id = :id
    ';

    $pdo = Database::getPDO();

    $pdoStatement = $pdo->prepare($sql);
    $pdoStatement->bindParam(':firstName', $this->first_name, PDO::PARAM_STR);
    $pdoStatement->bindParam(':lastName', $this->last_name, PDO::PARAM_STR);
    $pdoStatement->bindParam(':email', $this->email, PDO::PARAM_STR);
    $pdoStatement->bindParam(':card_id', $this->card_id, PDO::PARAM_INT);
    $pdoStatement->bindParam(':id', $this->id, PDO::PARAM_INT);

    $pdoStatement->execute();

    $insertedRow = $pdoStatement->rowCount();

    if ($insertedRow < 1) {
      return false;
    }

    $this->id = $pdo->lastInsertId();
    return true;
  }


  /**
   * Get the value of first_name
   */ 
  public function getFirst_name()
  {
    return $this->first_name;
  }

  /**
   * Set the value of first_name
   *
   * @return  self
   */ 
  public function setFirst_name($first_name)
  {
    $this->first_name = $first_name;

    return $this;
  }

  /**
   * Get the value of last_name
   */ 
  public function getLast_name()
  {
    return $this->last_name;
  }

  /**
   * Set the value of last_name
   *
   * @return  self
   */ 
  public function setLast_name($last_name)
  {
    $this->last_name = $last_name;

    return $this;
  }

  /**
   * Get the value of email
   */ 
  public function getEmail()
  {
    return $this->email;
  }

  /**
   * Set the value of email
   *
   * @return  self
   */ 
  public function setEmail($email)
  {
    $this->email = $email;

    return $this;
  }

  /**
   * Get the value of password
   */ 
  public function getPassword()
  {
    return $this->password;
  }

  /**
   * Set the value of password
   *
   * @return  self
   */ 
  public function setPassword($password)
  {
    $this->password = $password;

    return $this;
  }


  /**
   * Get the value of card_id
   */ 
  public function getCard_id()
  {
    return $this->card_id;
  }

  /**
   * Set the value of card_id
   *
   * @return  self
   */ 
  public function setCard_id($card_id)
  {
    $this->card_id = $card_id;

    return $this;
  }
}