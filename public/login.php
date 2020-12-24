<?php

declare(strict_types = 1);

use Symfony\Component\Yaml\Yaml;
use Twig\Environment;
use Twig\Extension\DebugExtension;
use Twig\Loader\FilesystemLoader;

// activation du système d'autoloading de Composer une seule fois
require __DIR__.'/../vendor/autoload.php';

session_start();

// instanciation du chargeur de template
$loader = new FilesystemLoader(__DIR__. '/../templates');

// instanciation du moteur de template
$twig = new Environment($loader, [
    // activation du mode debug
    'debug' => true,
    // activation du mode de variables strictes
    'strict_variables' => true,
    // activation du cache pour la production
    // 'cache' => __DIR__.'/../var/cache',
]);

// chargement de l'extension DebugExtension
$twig->addExtension(new DebugExtension());

// traitement des données
$config = Yaml::parseFile(__DIR__.'/../config/config.yaml');

// Traitement des données
$formData = [
    'login' => '',
    'password' => '',
];

$errors = [];

// données par défaut 
$default = TRUE;


if ($_POST) {
    foreach($formData as $key => $value) {
        if(isset($_POST[$key])) {
            $formData[$key] = $_POST[$key];
            // données en provenance de l'utilisateur
            $default = FALSE;
        }
    }

    $maxLength = 190;
    $minPwd = 8;
    $maxPwd = 32;

    if (empty($_POST['login'])) {
        // le champ du login est-il vide ?
        $errors['login'] = 'Veuillez entrer un login';
    } elseif (strlen($_POST['login']) > $maxLength) {
        // la longueur du login est-elle hors des limites ?
        $errors['login'] = "Merci de rédiger un login dont la longueur maximale ne dépasse pas ${maxLength} caractères";
    }

    if (empty($_POST['password'])) {
        $errors['password'] = 'Veuillez entrer un mot de passe';
    } elseif (strlen($_POST['password']) < $minPwd || strlen($_POST['password']) > $maxPwd) {
        $errors['password'] = "Le mot de passe doit contenir entre ${minPwd} et ${maxPwd} caractères";
    } elseif (preg_match('/[0-9]/', $_POST['password']) === 0) {
        $errors['password'] = 'Votre mot de passe doit contenir au moins un chiffre';
    } elseif (preg_match('/[^A-Za-z0-9]/', $_POST['password']) === 0) {
        $errors['password'] = 'Votre mot de passe doit contenir au moins un caractère spécial';
    } elseif (!password_verify($_POST['password'], $config['password'])) {
        $errors['password'] = 'Login ou mot de passe invalide';
    }

    dump($errors);  
    dump($formData);  

    if (!$errors) {
        $_SESSION['login'] = $config['smtp']['login'];
        $_SESSION['password'] = $config['smtp']['password'];
        // connecté avec succès, renvoi vers la page privée
        // echo '<p>Vous vous êtes connecté avec succès, vous allez donc être redirigé vers la page privée dans quelques instants..</p>';
        $url = 'private.php';
        header('Location: {$url}', true, 301);
        exit();
    }

    // renvoi en cas d'erreur désactivé pour le moment
    // if (!isset($_SESSION['login'])) {
    //     // l'utilisateur ne peut pas accéder à la page
    //     // renvoi vers home page
    //     echo '<p>Vous avez échoué à vous connecter, vous avez donc été redirigé vers la page publique</p>';
    //     $url = 'index.php';
    //     header('Location: {$url}', true, 301);
    //     exit();
    // }   
}

// Affichage du rendu du template
echo $twig->render('login.html.twig', [
    // transmission de données au template
    'errors' => $errors,
    'formData' => $formData,
    'default' => $default
]);

