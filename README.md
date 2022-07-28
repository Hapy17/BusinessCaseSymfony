# BusinessCaseSymfony - Mode d'emploi
Le but de ce projet est de créer un site web pour un e-commerce sous Symfony pour valider une un titre de développeur web.
***
# Sommaire
- [Pré-requis](#prerequis)
- [Création de la BDD](#creabdd)
- [Mis en place des fixtures](#fixtures)
- [Comment voir la doc de l'API](#docapi)
## Pré-requis
Vous avez besoin d'un IDE, VS Code ou PHPStorm feront l'affaire.

## Installation à partir de GitHub et mis en route<a name="prerequis"></a>
- Ouvrez un terminal à l'endroit où vous souhaitez installer le projet et exécutez la commande suivante:
    ```
    git clone https://github.com/Hapy17/BusinessCaseSymfony.git
    ```  
    *Cette commande permet d'installer le projet distant en local sur votre machine*  
    ***
- Dans le dossier BusinessCaseSymfony, exécutez la commande suivante:
    ```
    symfony composer install
    ```
    *Cette commande permet d'installer les dépendances liste dans le composer.json*
    ***
- Dans le même terminal, exécutez la commande suivante:
    ```
    symfony serve
    ```
    *Cette commande permet de lancer le serveur symfony*
    ***
## Création de la base de données<a name="creabdd"></a>
- Dans un nouveaux terminal, exécutez la commande suivante:
    ```
    symfony console doctrine:database:create
    ```
    *Cette commande permet de créer la base de données*
    ***
- Dans le terminal, exécutez la commande suivante:
    ```
    symfony console make:migration
    ```
    *Cette commande permet de comparer le projet Symfony et la BDD et créer des requêtes en fonction*
    ***
- Dans le terminal, exécutez la commande suivante:
    ```
    symfony console doctrine:migrations:migrate
    ```
    *Cette commande permet de faire une migration du projet Symfony sur la BDD*
    ***
## Mis en place des fixtures<a name="fixtures"></a>
- Dans le terminal, exécutez la commande suivante:
    ```
    symfony console hautelook:fixtures:load --purge-with-truncate
    ```
    *Cette commande permet d'exécuter les fixtures*
    ***
## Comment voir la doc de l'API<a name="docapi"></a>
- Ouvrez un nouveau navigateur et entrez l'adresse suivante:
    ```
    http://localhost:8000/api/docs
    ```
    ***

