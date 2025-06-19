# Bucket List (TP Fil Rouge ENI)

Bienvenue sur le dépôt du projet **Bucket List** !

## Présentation

Ce projet est une application web permettant de créer, gérer et partager des listes de souhaits (bucket lists). Il a été développé dans le cadre d'un travail pratique de longue durée à l'École Nationale d'Informatique (ENI).

## Fonctionnalités principales

- Création et gestion de souhaits
- Ajout de commentaires
- Authentification et gestion des utilisateurs
- Interface moderne et responsive

## Technologies utilisées

- PHP (Symfony)
- JavaScript
- HTML/CSS (Twig)
- Doctrine ORM

## Installation

1. Cloner le dépôt :

   ```bash
   git clone <url-du-dépôt>
   ```

2. Installer les dépendances PHP :

   ```bash
   composer install
   ```

3. Configurer la base de données dans `.env`

4. Exécuter les migrations :

   ```bash
   php bin/console doctrine:migrations:migrate
   ```

5. Lancer le serveur de développement :

   ```bash
   symfony serve
   ```

## Auteur

Antoine Guillo

---

 TP fil rouge réalisé dans le cadre du module de formation sur Symfony à l'ENI.
