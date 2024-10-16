<?php

namespace src\Services;

trait Hydratation
{

  /**
   * Constructeur : appelle la fonction d'hydratation de l'objet.
   * A besoin d'un tableau de données dont les clés sont les noms des propriétés, en camelCase, Snake_Case, PascalCase.
   *
   * @param array $data tableau de données, facultatif.
   */
  public function __construct(array $data = array())
  {
    $this->hydrate($data);
  }

  /**
   * Méthode permettant d'hydrater les propriétés de l'objet si elles existent. 
   *
   * @param array $data
   * @return void
   */
  private function hydrate(array $data): void
  {
    foreach ($data as $key => $value) {
      $parts = explode('_', $key);
      $setter = 'set';
      foreach ($parts as $part) {
        $setter .= ucfirst(strtolower($part));
      }
      if (method_exists($this, $setter)) {
        $this->$setter($value);
      }
    }
  }

  /**
   * Méthode magique __set appelée généralement lors de l'instanciation en sortie de BDD. permet d'hydrater chaque propriété une à une.
   *
   * @param [type] $name
   * @param [type] $value
   */
  public function __set($name, $value)
  {
    $this->hydrate([$name => $value]);
  }


  /**
   * Méthode de réhydratation de l'objet lors de sa déserialisation.
   *
   * @param   array  $data  l'objet
   *
   * @return  void
   */
  // public function __unserialize(array $data): void
  // {
  //   $this->hydrate($data);
  // }

  /**
   * Méthode qui retourne l'objet sous format tableau. Récupère toutes les propriétés.
   * * Contrairement à la méthode __serialize() au-dessus, elle ne s'occupe pas des getters.
   * ! Attention au format des données récupérées : dates, prix, ...
   *
   * @return array
   */
  public function toArray(): array
  {
    return get_object_vars($this);
  }
}
