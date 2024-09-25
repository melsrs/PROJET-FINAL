<?php

namespace src\Repositories;

use PDO;
use src\Models\Database;
use src\Models\Utilisateur;

class UtilisateurRepository
{
  private $DB;

  public function __construct()
  {
    $database = new Database;
    $this->DB = $database->getDB();

    require_once __DIR__ . '/../../config.php';
  }


  public function createUtilisateur(Utilisateur $utilisateur)
  {
    $sql = "INSERT INTO " . "utilisateur (prenom, nom, mail, mdp, id_role) 
    VALUES (:prenom, :nom, :mail, :mdp, 2);";

    $statement = $this->DB->prepare($sql);

    $statement->execute([
      ':prenom'               => $utilisateur->getPrenom(),
      ':nom'                  => $utilisateur->getNom(),
      ':mail'                 => $utilisateur->getMail(),
      ':mdp'                  => $utilisateur->getMdp()
    ]);

    $idUtilisateur = $this->DB->lastInsertId();
    $utilisateur->setIdUtilisateur($idUtilisateur);

    return $utilisateur;
  }

  public function isMailExistant($mail)
  {
    $sql = "SELECT COUNT(*) as nombre FROM ". "utilisateur WHERE mail = :mail;";
    $statement = $this->DB->prepare($sql);
    $statement->execute([':mail' => $mail]);
    return (int) $statement->fetch()['nombre'] > 0;
    
  }

  // public function getUtilisateurByMail($mail)
  // {
  //     $sql = "SELECT * FROM utilisateur WHERE mail = :mail;";
  //     $statement = $this->DB->prepare($sql);
  //     $statement->execute([':mail' => $mail]);
  //     return $statement->fetch(PDO::FETCH_ASSOC);
  // }

  public function getUtilisateurByMail($mail)
  {
      $sql = "SELECT * FROM utilisateur WHERE mail = :mail;";
      $statement = $this->DB->prepare($sql);
      $statement->execute([':mail' => $mail]);
      $statement->setFetchMode(PDO::FETCH_CLASS, Utilisateur::class);
      return $statement->fetch();
  }

  // public function getRoleType($Id_Role)
  // {
  //   $sql = "SELECT type FROM role WHERE Id_Role = :id_role;";
  //   $statement = $this->DB->prepare($sql);
  //   $statement->execute([':id_role' => $Id_Role]);
  //   return $statement->fetch(PDO::FETCH_ASSOC)['type'];
  // }


  public function getRoleType($Id_Role)
  {
    $sql = "SELECT type FROM role WHERE Id_Role = :id_role;";
    $statement = $this->DB->prepare($sql);
    $statement->execute([':id_role' => $Id_Role]);
    $statement->setFetchMode(PDO::FETCH_CLASS, Utilisateur::class);
    return $statement->fetch();
  }
  
}