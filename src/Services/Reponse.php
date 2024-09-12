<?php
namespace src\Services;

trait Reponse {

  /**
   * La méthode render permet d'afficher une vue. Elle peut prendre en second paramètre des données à afficher dans la vue.
   *
   * @param string $view  Le nom de la vue à rendre
   * @param array $data   Les données à afficher dans la vue, sous format tableau associatif. Les valeurs attendues sont : en clef, le nom de la variable que vous voudrez utiliser dans votre vue (ex: film), et en valeur, la valeur ! Deux clefs sont attendues, section et action, qui seront par défaut vides si vous ne les fournissez pas. La section permet de savoir quelle partie le tableau de bord doit afficher, l'action permet de savoir quelle est l'action du CRUD en cours de demande.
   * @return void
   */
  public function render(string $view, array $data = ['section' => '', 'action' => ''], $StatusCode = 200): void {
    if (!empty($data)) {
      foreach ($data as $key => $value) {
        ${$key} = $value;
      }
    }
    if (!isset($section)) {
      $section = '';
    }
    if (!isset($action)) {
      $action = '';
    }
    header('Content-Type: text/html');
    http_response_code($StatusCode);
    include_once __DIR__ . '/../Views/'. $view . ".php";
  }

  /**
   * Méthode permettant de répondre du JSON
   *
   * @param null|array $data    Les données. Elles seront encodées ici-même
   * @param integer $StatusCode Le code à renvoyer. Par défaut, 200
   * @return void
   */
  public function JsonResponse(null|array $data = null, $StatusCode = 200): void {
    header('Content-Type: application/json');
    http_response_code($StatusCode);
    if ($data) {
      echo json_encode($data);
    }

  }

}