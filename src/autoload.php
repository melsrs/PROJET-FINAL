<?php

spl_autoload_register('chargerClasse');

function chargerClasse($classe)
{
  $classe = str_replace('src', '', $classe);
  $classe = str_replace('\\', '/', $classe);
  $classe = $classe . '.php';
  try {
    if (file_exists(__DIR__ . $classe)) {
      require_once __DIR__ . $classe;
    } else {
      throw new Exception("La classe $classe est introuvable.");
    }
  } catch (Exception $e) {
    echo $e->getMessage();
  }
}
