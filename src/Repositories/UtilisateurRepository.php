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


  public function newUtilisateur(Utilisateur $utilisateur)
  {
    $sql = "INSERT INTO utilisateur (prenom, nom, mail, mdp, id_role) 
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

  public function getUtilisateurByMail($mail)
  {
      $sql = "SELECT * FROM utilisateur WHERE mail = :mail;";
      $statement = $this->DB->prepare($sql);
      $statement->execute([':mail' => $mail]);
      $statement->setFetchMode(PDO::FETCH_CLASS, Utilisateur::class);
      $user = $statement->fetch();
      return $user;
  }

  public function getUtilisateurById($Id_Utilisateur)
  {
      $sql = "SELECT * FROM utilisateur WHERE Id_Utilisateur = :Id_Utilisateur;";
      $statement = $this->DB->prepare($sql);
      $statement->execute([':Id_Utilisateur' => $Id_Utilisateur]);
      $statement->setFetchMode(PDO::FETCH_CLASS, Utilisateur::class);
      $user = $statement->fetch();
      return $user;
  }

  public function getRoleType($Id_Role)
  {
    $sql = "SELECT type FROM role WHERE Id_Role = :id_role;";
    $statement = $this->DB->prepare($sql);
    $statement->execute([':id_role' => $Id_Role]);
    return $statement->fetch();
  }

  public function getAllUtilisateur()
  {
      $sql = "SELECT * FROM utilisateur;";
      return  $this->DB->query($sql)->fetchAll(PDO::FETCH_CLASS, Utilisateur::class);
  }

  public function updateUtilisateur(Utilisateur $utilisateur)
  {
      $sql = "UPDATE utilisateur 
              SET prenom = :prenom, 
                  nom = :nom, 
                  mail = :mail, 
                  mdp = :mdp, 
                  Id_Role = :Id_Role 
              WHERE Id_Utilisateur = :Id_Utilisateur;";

      $statement = $this->DB->prepare($sql);

      $success = $statement->execute([
          ':Id_Utilisateur'       => $utilisateur->getIdUtilisateur(),
          ':prenom'               => $utilisateur->getPrenom(),
          ':nom'                  => $utilisateur->getNom(),
          ':mail'                 => $utilisateur->getMail(),
          ':mdp'                  => $utilisateur->getMdp(),
          ':Id_Role'              => $utilisateur->getIdRole(),
      ]);

      return $success;
  }

  public function deleteUtilisateur($Id_Utilisateur): bool
  {
    $sql = "DELETE FROM commenter WHERE Id_Utilisateur = :Id_Utilisateur;
            DELETE FROM article WHERE Id_Utilisateur = :Id_Utilisateur;
            DELETE FROM likes WHERE Id_Utilisateur = :Id_Utilisateur;
            DELETE FROM utilisateur WHERE Id_Utilisateur = :Id_Utilisateur";

    $statement = $this->DB->prepare($sql);

    return $statement->execute([':Id_Utilisateur' => $Id_Utilisateur]);
  }

  
}