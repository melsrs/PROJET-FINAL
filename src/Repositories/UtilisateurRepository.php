<?php

namespace src\Repositories;

use PDO;
use src\Models\Database;

class UtilisateurRepository
{
  private $DB;

  public function __construct()
  {
    $database = new Database;
    $this->DB = $database->getDB();

    require_once __DIR__ . '/../../config.php';
  }

  public function createUtilisateur($prenom, $nom, $mail, $motDePasseHash)
  {
    $sql = "INSERT INTO " . "utilisateur (prenom, nom, mail, mdp, id_role) 
    VALUES (:prenom, :nom, :mail, :motDePasseHash, 2);";

    $statement = $this->DB->prepare($sql);

    $success = $statement->execute([
      ':prenom'               => $prenom,
      ':nom'                  => $nom,
      ':mail'                 => $mail,
      ':motDePasseHash'       => $motDePasseHash
    ]);

    return $success;
  }

  public function isMailExistant($mail)
  {
    $sql = "SELECT COUNT(*) as nombre FROM ". "utilisateur WHERE mail = :mail;";
    $statement = $this->DB->prepare($sql);
    $statement->execute([':mail' => $mail]);
    return (int) $statement->fetch()['nombre'] > 0;
    
  }

  public function getUtilisateurByMail($mail)
  {
      $sql = "SELECT * FROM utilisateur WHERE mail = :mail;";
      $statement = $this->DB->prepare($sql);
      $statement->execute([':mail' => $mail]);
      return $statement->fetch(PDO::FETCH_ASSOC);
  }

  public function getRoleType($Id_Role)
  {
    $sql = "SELECT type FROM role WHERE Id_Role = :id_role;";
    $statement = $this->DB->prepare($sql);
    $statement->execute([':id_role' => $Id_Role]);
    return $statement->fetch(PDO::FETCH_ASSOC)['type'];
  }
  
}