<?php

namespace App\Models;

use App\Utils\Database;

use PDO;

class CardModel extends CoreModel {

    /**
     * Id of the card
     */
    protected $id;    
    
    /**
     * User id of the card owner
     * Not Null
     */
    private $user_id;
    
    /**
     * Name of the user card
     * Not Null
     */
    private $name;

    /**
     * Email of the user card
     * Nullable
     */
    private $email;

    /**
     * Company of the user card
     * Nullable
     */
    private $company;

    /**
     * Telephone of the user card
     * Nullable
     */
    private $telephone;

    const TABLE_NAME = 'cards';

    public function update()
    {
        $sql = '
            UPDATE ' . self::TABLE_NAME .
                ' 
            SET 
                `name` = :name
                ,`company` = :company
                ,`email` = :email
                ,`user_id` = :user_id
                ,`telephone` =:telephone
            WHERE id = :id
        ';

        $pdo = Database::getPDO();

        $pdoStatement = $pdo->prepare($sql);
        $pdoStatement->bindParam(':name', $this->name, PDO::PARAM_STR);
        $pdoStatement->bindParam(':company', $this->company, PDO::PARAM_STR);
        $pdoStatement->bindParam(':email', $this->email, PDO::PARAM_STR);
        $pdoStatement->bindParam(':user_id', $this->user_id, PDO::PARAM_INT);
        $pdoStatement->bindParam(':id', $this->id, PDO::PARAM_INT);
        $pdoStatement->bindParam(':telephone', $this->telephone, PDO::PARAM_STR);

        $pdoStatement->execute();

        $insertedRow = $pdoStatement->rowCount();

        if ($insertedRow < 1) {
            return false;
        }

        return true;
    }

    public function insert() {
        $sql = '
          INSERT INTO ' . self::TABLE_NAME . ' (
            `name`
            ,`company`
            ,`email`
            , `user_id`
            ,`telephone`
            )
          VALUES (
            :name
            ,:company
            ,:email
            ,:user_id
            ,:telephone
            )
        ';
    
        $pdo = Database::getPDO();
    
        $pdoStatement = $pdo->prepare($sql);
        $pdoStatement->bindParam(':name', $this->name, PDO::PARAM_STR);
        $pdoStatement->bindParam(':company', $this->company, PDO::PARAM_STR);
        $pdoStatement->bindParam(':email', $this->email, PDO::PARAM_STR);
        $pdoStatement->bindParam(':user_id', $this->user_id, PDO::PARAM_INT);
        $pdoStatement->bindParam(':telephone', $this->telephone, PDO::PARAM_STR);
    
        $pdoStatement->execute();
    
        $insertedRow = $pdoStatement->rowCount();
    
        if($insertedRow < 1 ){
          return false;
        }
    
        $this->id = $pdo->lastInsertId();
        return true;
    }

    public static function find($id){
        $sql = 'SELECT
                `cards`.`id`,
                `cards`.`name`,
                `cards`.`company`,
                `cards`.`user_id`,
                `cards`.`email`,
                `cards`.`telephone`
                FROM ' . static::TABLE_NAME .
                ' WHERE `cards`.`id` = :id
                ';

        $pdo = Database::getPDO();
        $pdoStatement = $pdo->prepare($sql);
        $pdoStatement->bindValue(':id', $id, PDO::PARAM_INT);
        $pdoStatement->execute();

        $result = $pdoStatement->fetchObject(static::class);
        return $result;  
    }

    public static function findAllByUser($user_id){
        $sql = 'SELECT 
                `cards`.`id`,
                `cards`.`name`,
                `cards`.`company`,
                `cards`.`user_id`,
                `cards`.`email`,
                `cards`.`telephone`
                FROM ' . static::TABLE_NAME .
                ' WHERE `cards`.`user_id` = :user_id
                ORDER BY name ASC';

        $pdo = Database::getPDO();
        $pdoStatement = $pdo->prepare($sql);
        $pdoStatement->bindValue(':user_id', $user_id, PDO::PARAM_INT);
        $pdoStatement->execute();
        $result = $pdoStatement->fetchAll(PDO::FETCH_CLASS, static::class);
        return $result;   
    }

    /**
     * Get id of the card
     */ 
    public function getId()
    {
        return $this->id;
    }

    /**
     * Set id of the card
     *
     * @return  self
     */ 
    public function setId($id)
    {
        $this->id = $id;

        return $this;
    }

    /**
     * Get user id of the card owner
     */ 
    public function getUser_id()
    {
        return $this->user_id;
    }

    /**
     * Set user id of the card owner
     *
     * @return  self
     */ 
    public function setUser_id($user_id)
    {
        $this->user_id = $user_id;

        return $this;
    }

    /**
     * Get name of the user card
     */ 
    public function getName()
    {
        return $this->name;
    }

    /**
     * Set name of the user card
     *
     * @return  self
     */ 
    public function setName($name)
    {
        $this->name = $name;

        return $this;
    }

    /**
     * Get company of the user card
     */ 
    public function getCompany()
    {
        return $this->company;
    }

    /**
     * Set company of the user card
     *
     * @return  self
     */ 
    public function setCompany($company)
    {
        $this->company = $company;

        return $this;
    }

    /**
     * Get telephone of the user card
     */ 
    public function getTelephone()
    {
        return $this->telephone;
    }

    /**
     * Set telephone of the user card
     *
     * @return  self
     */ 
    public function setTelephone($telephone)
    {
        $this->telephone = $telephone;

        return $this;
    }

    /**
     * Get email of the user card
     */ 
    public function getEmail()
    {
        return $this->email;
    }

    /**
     * Set email of the user card
     *
     * @return  self
     */ 
    public function setEmail($email)
    {
        $this->email = $email;

        return $this;
    }
}