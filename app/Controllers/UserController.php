<?php
namespace App\Controllers;

use App\Models\UserModel;
use App\Utils\User;
use App\Controllers\MainController;
use App\Models\CardModel;

class UserController extends CoreController {
  public function displaySignInForm() {
    $user = User::getConnectedUser();
    if (!empty($user)) {
      $this->forbidden();
    } else {
      $this->show('user/signin');
    }
  }

  public function displaySignUpForm() {
    $user = User::getConnectedUser();
    if (!empty($user)) {
      $this->forbidden();
    } else {
     $this->show('user/signup');
    }
  }

  public function logout() {
    User::disconnect();
    header('Location: /card-manager/public');
  }

  public function signIn() {

    $errorList = [];
    if(!empty($_POST)){
      $email = (isset($_POST['email'])) ? $_POST['email'] : '';
      $passwordLogin = (isset($_POST['password'])) ? $_POST['password'] : '';

      if(empty($errorList)){
        $userModel = UserModel::find($email);
          if(!empty($userModel)){
            $passwordInBdd = $userModel->getPassword();
            if(password_verify($passwordLogin ,$passwordInBdd)){
              User::connect($userModel);
              static::sendJson([
                'code' => 1,
                'redirect' => '/card-manager/public/',
                'succesMessage' => 'Connexion réussie'
              ]);

            } else {
                $errorList[]= "L'identifiant ou le mot de passe est incorrect";
                static::sendJson([
                  'code' => 2,
                  'errorList' => $errorList
                  ]);
            }
        } else {
            $errorList[]= "L'identifiant ou le mot de passe est incorrect";
            static::sendJson([
              'code' => 2,
              'errorList' => $errorList
              ]);
        }
      }
    } 
  }

  public function signUp() {
    $errorList = [];
    if(!empty($_POST)){
      if(isset($_POST['email'])) {
        $email = filter_input(INPUT_POST, 'email', FILTER_VALIDATE_EMAIL);
        if (!$email) {
          $errorList['email'] = 'Veuillez saisir un email valide';
        }
      } else {
        $errorList['email'] = 'Veuillez indiquer votre email';
      }

      if(isset($_POST['prenom']) && !empty($_POST['prenom'])) {
        $firstName = filter_input(INPUT_POST, 'prenom', FILTER_SANITIZE_STRING);
      } else {
        $errorList['prenom'] = 'Veuillez indiquer votre prénom';
      }
      if(isset($_POST['nom']) && !empty($_POST['nom'])) {
        $lastName = filter_input(INPUT_POST, 'nom', FILTER_SANITIZE_STRING);
      } else {
        $errorList['nom'] = 'Veuillez indiquer votre nom';
      }

      if(isset($_POST['password']) && !empty($_POST['password']) && isset($_POST['confirmedPassword']) && !empty($_POST['confirmedPassword'])) {
        $password = filter_input(INPUT_POST, 'password', FILTER_SANITIZE_STRING);
        $confirmedPassword = filter_input(INPUT_POST, 'confirmedPassword', FILTER_SANITIZE_STRING);
        if ($password !== $confirmedPassword) {
          $errorList['password'] = 'Les mots de passe ne sont pas identiques';
          $password = false;
          $confirmedPassword = false;
        }
      } else {
        if (!isset($_POST['password']) || empty($_POST['password'])) {
          $errorList['password'] = 'Veuillez choisir un mot de passe';
        }
        if (!isset($_POST['confirmedPassword']) || empty($_POST['confirmedPassword'])) {
          $errorList['confirmedPassword'] = 'Veuillez confirmer votre mot de passe';
        }
      }

      if(isset($_POST['CGUCheck'])) {
        $CGU = filter_input(INPUT_POST, 'CGUCheck', FILTER_SANITIZE_STRING);
        if ($CGU === "on") {
          $CGUAccepted = true;
        } else {
          $CGUAccepted = false;
          $errorList['CGUCheck'] = 'Veuillez ne pas pirater mon formulaire';
        }
      } else {
        $CGUAccepted = false;
        $errorList['CGUCheck'] = 'Vous devez accepter les conditions générales d\'utilisation pour vous inscrire';
      }
    }

    if(empty($errorList)) {
      $searchExistingAccount = UserModel::find($email);

      if($searchExistingAccount) {
        $errorList['emailInBDD'] = 'Un compte avec cet email existe déjà';
        static::sendJson([
          'code' => 2,
          'errorList' => $errorList
        ]);
      
      } else {
        $newAccount = new UserModel();
        $newAccount->setFirst_name($firstName);
        $newAccount->setLast_name($lastName);
        $newAccount->setEmail($email);
        $newAccount->setPassword(password_hash($password, PASSWORD_DEFAULT));

        $newAccount->insert();

        User::connect($newAccount);
        static::sendJson([
          'code' => 1,
          'redirect' => '/card-manager/public/',
          'succesMessage' => 'Inscription réussie'
        ]);
      }
    } else {
      static::sendJson([
        'code' => 2,
        'errorList' => $errorList
        ]);
    }
  }

  public function userAccount() {
    $user = User::getConnectedUser();
    if (empty($user)) {
      $this->forbidden();
    } else {
      $userId = $user->getId();
      $cards = CardModel::findAllByUser($userId);
      $newCard = new CardModel;
      $newCard->setUser_id($userId);

      if($user->getCard_id()) {
        $userCard = CardModel::find($user->getCard_id());
      } else {
        $userCard = new CardModel();
      }

      $this->show('user/profile', ['cards' => $cards, 'new_card' => $newCard, 'user_card' => $userCard]);
    }
  }

  public function createCard() {
    $user = User::getConnectedUser();
    if (empty($user)) {
      $this->forbidden();
    } else {
      $userId = $user->getId();
      $newCard = new CardModel;
      $newCard->setUser_id($userId);
      $errorList = [];
      if(!empty($_POST)){
        if(isset($_POST['email']) && !empty($_POST['email'])) {
          $email = filter_input(INPUT_POST, 'email', FILTER_VALIDATE_EMAIL);
          $newCard->setEmail($email);
          if (!$email) {
            $errorList['email'] = 'Veuillez saisir un email valide';
          }
        }
        if(isset($_POST['name']) && !empty($_POST['name'])) {
          $name = filter_input(INPUT_POST, 'name', FILTER_SANITIZE_STRING);
          $newCard->setName($name);
        } else {
          $errorList['name'] = 'Veuillez indiquer un nom';
        }
        if(isset($_POST['telephone']) && !empty($_POST['telephone'])) {
          $telephone = filter_input(INPUT_POST, 'telephone', FILTER_SANITIZE_STRING);
          $newCard->setTelephone($telephone);
          if (!$telephone) {
            $errorList['telephone'] = 'Veuillez saisir un numéro de téléphone';
          }
        }
        if(isset($_POST['company']) && !empty($_POST['company'])) {
          $company = filter_input(INPUT_POST, 'company', FILTER_SANITIZE_STRING);
          $newCard->setCompany($company);
          if (!$company) {
            $errorList['company'] = 'Veuillez saisir un nom d\'entreprise valide';
          }
        }
        if(empty($errorList)) {
          $newCard->insert();
        }
      }
    }
    $route = $this->router->generate('account_page');
    header('Location: ' . $route);
  }

  /**
   * Create / Update user own contact card
   */
  public function createUserCard() {
    $user = User::getConnectedUser();
    if (empty($user)) {
      $this->forbidden();
    } else {
      if ($user->getCard_id()) {
        $userCard = CardModel::find($user->getCard_id());
      } else {
        $userCard = new CardModel();
      }

      $errorList = [];

      if(!empty($_POST)){
        if(isset($_POST['email']) && !empty($_POST['email'])) {
          $email = filter_input(INPUT_POST, 'email', FILTER_VALIDATE_EMAIL);
          $userCard->setEmail($email);
          if (!$email) {
            $errorList['email'] = 'Veuillez saisir un email valide';
          }
        }
        if(isset($_POST['name']) && !empty($_POST['name'])) {
          $name = filter_input(INPUT_POST, 'name', FILTER_SANITIZE_STRING);
          $userCard->setName($name);
        } else {
          $errorList['name'] = 'Veuillez indiquer un nom';
        }
        if(isset($_POST['telephone']) && !empty($_POST['telephone'])) {
          $telephone = filter_input(INPUT_POST, 'telephone', FILTER_SANITIZE_STRING);
          $userCard->setTelephone($telephone);
          if (!$telephone) {
            $errorList['telephone'] = 'Veuillez saisir un numéro de téléphone';
          }
        }
        if(isset($_POST['company']) && !empty($_POST['company'])) {
          $company = filter_input(INPUT_POST, 'company', FILTER_SANITIZE_STRING);
          $userCard->setCompany($company);
          if (!$company) {
            $errorList['company'] = 'Veuillez saisir un nom d\'entreprise valide';
          }
        }
        if(empty($errorList)) {
          if ($user->getCard_id()) {
            $userCard->update();
          } else {
            $userCard->insert();
            $user->setCard_id($userCard->getId());
            $user->update();
          }
        }
      }
    }

    $route = $this->router->generate('account_page');
    header('Location: ' . $route);
  }


  public function displayProfile($params) {
    if (empty($params['id'])) {
      $this->forbidden();
    } else {
      $id = $params['id'];
      $user = UserModel::findById($id);
      if(!empty($user)) {
        $this->show('user/public-profile', ['user' => $user]);
      } else {
        $this->forbidden();
      }
    }
  }
}