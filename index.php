<?php

echo "Cet index est normalement inaccessible, si le .htaccess fait correctement son travail.";

// Redirige vers le dossier public :

 header("location: /public");