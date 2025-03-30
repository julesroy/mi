<?php
// Script temporaire pour installer les dépendances - À SUPPRIMER APRÈS USAGE !
$validPassword = 'MonMotDePasseSecret123'; // Changez ce mot de passe

if (($_GET['password'] ?? '') !== $validPassword) {
    die('Accès refusé : mot de passe incorrect.');
}

echo "<pre>";
echo "Lancement de composer install...\n\n";
flush();

// On remonte d'un niveau et on exécute composer
$output = shell_exec('cd .. && composer install --no-dev --optimize-autoloader 2>&1');

echo htmlspecialchars($output);
echo "\n\n✅ Installation terminée. PENSEZ À SUPPRIMER CE SCRIPT !";
echo "</pre>";