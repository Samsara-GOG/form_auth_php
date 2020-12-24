# Exercice de formulaire d'authentification en php

Références :

- https://github.com/jibundeyare/php-basic-p7/blob/master/session1.php
- https://github.com/jibundeyare/php-basic-p7/blob/master/session2.php

- https://www.php.net/manual/en/function.password-hash.php
- https://www.php.net/manual/en/function.password-verify.php

- https://github.com/jibundeyare/cours/blob/master/php-language-basic.md
- https://github.com/jibundeyare/cours/blob/master/twig.md
- https://github.com/jibundeyare/cours/blob/master/var-dumper.md
- https://symfony.com/doc/current/components/yaml.html

- https://github.com/jibundeyare/php-intermediate-p7/blob/master/form-validation.php
- https://github.com/jibundeyare/php-intermediate-p7/blob/master/templates/form-validation.html.twig

- https://github.com/jibundeyare/php-intermediate-p7/blob/master/public/config.php
- https://github.com/jibundeyare/php-intermediate-p7/blob/master/config/config.yaml.dist

- https://github.com/jibundeyare/php-intermediate-p7/blob/master/public/password-verify.php
- https://github.com/jibundeyare/php-intermediate-p7/blob/master/templates/password-verify.html.twig

- https://github.com/jibundeyare/php-intermediate-p7/blob/master/public/private.php
- https://github.com/jibundeyare/php-intermediate-p7/blob/master/templates/private.html.twig

Contraintes techniques :

- composer
- symfony/var-dumper
- symfony/yaml
- twig/twig
- bootstrap : installation avec npm ou avec un cdn

Formulaire :

- identifiant : input type text, max 190 caractères inclus
- password : input type password, min 8 max 32 caractères inclus, caractères alphanumériques et spéciaux dont minimum 1 chiffre, 1 caractère spécial
- validation : respect de la structure du code html et des classes css pour la validation côté serveur
- message d'erreur : affichage d'un message d'erreur générique pour ne pas révéler si c'est l'identifiant ou le mot de passe qui est faux
- ré-affichage des données utilisateur après envoi des données (pour que l'utilisateur puisse corriger les données si besoin)

Livraison :

- envoyez-moi votre lien github
- il me faut au moins les fichiers suivants
  - /composer.json, composer.lock
  - /public/login.php
  - /templates/login.html.twig
- attention : ne pas commiter le dossier /vendor

Expressions régulières :

- pour vérifier qu'il y a au moins un caractère latin (sans accent) : preg_match('/[^A-Za-z]/', $password)
- pour vérifier qu'il y a au moins un chiffre : preg_match('/[0-9]/', $password)
- pour vérifier qu'il y a au moins un caractère spécial : preg_match('/[^A-Za-z0-9]/', $password)

Les caractères latins avec accent sont comptés comme des caractères spéciaux.
Le mot de passe de l'utilisateur est ici stocké dans $password, mais dans votre code de validation de formulaire, le mot de passe devrait plutôt se trouver dans $_POST['password'].
