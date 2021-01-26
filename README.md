UE 235 - Projet de base pour mini-projet
==================================

## Gestion de l'environnement ##

Si votre projet tourne sur un environnement `LAMP` *"classique"*, assurez-vous que les éléments suivants sont correctement installés, disponibles et configurés sur votre container Docker :
  * votre VirtualHost Apache pointe bien sur le répertoire `public` de votre application 
  * module *"rewrite"* activé sous Apache : `a2enmod rewrite && service apache2 reload` 
  * que le module "sqlite3" correspondant à votre version de PHP est bien installé. Par exemple pour une version PHP 7.4 : `apt update && apt install php7.4-sqlite3`


## Lancement du projet ##

Pour les instructions suivantes, nous partirons du principe que votre port de connexion au projet est `1234`.

Une fois votre environnement Docker lancé, executez `composer update` à la racine du projet, afin d'installer et/ou mettre à jour les dépendances définies dans le fichier `composer.json` et nécessaire au projet. 

Si nécessaire, créez un fichier `.env.local` afin d'y renseigner vos paramètres locaux. Notons que ce fichier ne sera pas synchronisé avec votre dépôt GIT.

N'oubliez pas d'initialiser la base de données et son contenu. Pour ce faire, executer les commandes suivantes : 
  * `php bin/console make:migration` : prépare la migration des données
  * `php bin/console doctrine:migrations:migrate` : rend effectifs les modifications en base de données
  * `php bin/console doctrine:fixtures:load` : injecte les *"fixtures"*, c'est à dire les données par défaut, en base de données

Puis enfin, accédez au projet Symfony par l'intermédiaire de votre navigateur, en saisissant l'URL [http://localhost:1234](http://localhost:1234). 


## Présentation du projet ##

Le projet proposé pose les bases d'une gestion de blog. Ce projet simpliste gère : 
  * des articles 
  * des catégories

Pour chacun de ces éléments, une gestion [CRUD](https://fr.wikipedia.org/wiki/CRUD) est déjà disponible, avec des interfaces déjà mise en place : listing / édition / ajout / suppression de données.

Les **`Articles`** sont définis par les caractéristiques suivantes :
  * `id` : identifiant unique de l'article
  * `titre` : titre de l'article
  * `content` : contenu de l'article
  * `category` : catégorie de l'article -> liaison avec les données **`Category`**
  
Les **`Category`** sont définies par les caractéristiques suivantes : 
  * `id` : identifiant unique de la catégorie
  * `name` : nom de la catégorie


## URL du projet ##

  * [Page d'accueil](http://localhost:1234) -> redirection vers [http://localhost:1234](http://localhost:1234/article)
  * [Page de listing d'articles](http://localhost:1234/article)
  * Page de détails d'un article dont l'identifiant unique est **1** : [http://localhost:1234/article/1/](http://localhost:1234/article/1/)
  * Page d'édition d'un article dont l'identifiant unique est **1** : [http://localhost:1234/article/1/edit/](http://localhost:1234/article/1/edit/)
  * [Page d'ajout d'un article](http://localhost:1234/article/new/)
  * [Page de listing des catégories](http://localhost:1234/category)
  * Page de détails d'une catégorie dont l'identifiant unique est **1** : [http://localhost:1234/category/1/](http://localhost:1234/category/1/)
  * Page d'édition d'une catégorie dont l'identifiant unique est **1** : [http://localhost:1234/category/1/edit/](http://localhost:1234/category/1/edit/)
  * [Page d'ajout d'une categorie](http://localhost:1234/category/new/)

