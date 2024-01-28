Documentation de l'architecture du backend
==========================================

# Organisation en couche

L'application backend est divisé en trois couches distinctes :

## La couche action

C'est les différents points d'entrées du backend (les endpoints). Chaque fichier correspond à un appel de l'API. Ces appels d'API sont documentés dans le fichiers `./documentation/api.md`.
Cette couche est seulement responsable de décoder la requête (lire le contenus des variables `$_POST`, `$_GET`, etc.) et la transmettre au service approprié. Il ne doit donc y avoir que très peu de code.

## La couche service

Cette couche est la plus importante de l'application. C'est ici que se trouve toutes les règles métiers. Un service peut contenir plusieurs cas d'usage (par exemple, le service utilisateur (`UserService`) permet à la fois de se connecter, de se déconnecter et de s'inscrire). Cette couche doit être focus sur la valeur ajouté de l'application. Tout ce qui ne concerne pas ces règles métiers doit être délégués à une autre couche (la couche repository par exemple).
Tous les services étendront de la classe `BaseService`. Cette classe met notamment à disposition une méthode `fatalError()` qui permet d'unifier la gestion des erreurs. Elle prend en paramètre un message d'erreur, et arrète l'exécution de la requête en retournant le message d'erreur.

## La couche repository

La couche repository permet de centraliser toutes les interractions avec la base de données. C'est la seule couche qui peut faire des requêtes sql. Elle est reponsable de faire les requêtes de façon sécurisé (requếtes préparées), et de "mapper" les résultats avec les classes de notre modèle.
Tous les repositories étendront de la classe `BaseRepository`. Cette classe met à disposition une méthode `getDb()` qui permet de récupérer une instance de `PDO`.

# Représentations des données : les models

Les représentations de tous les objets métiers sont définis dans le répertoire `./model`. Ce sont des classes avec des propriétés privés et des getter. Chaque classe possède un contructeur permettant de les instancier en définissants toutes les propriétés d'un coup.
Il n'y a pas de setter. Lorsqu'on souhaitera modifier un objet, on en instanciera un nouveau.
Ces objets pourront être utilisé lors des échanges entre les services et les repositories : Lorsqu'un service doit récupérer une liste de questions, le repositories retournera un tableau d'instance du modèle Question. Ou alors, lorsqu'un service voudra enregistrer une question, il pourra passer dirrectement en paramètre au repository une instance du modèle Question avec toutes les données à enregistrer.

# La base de données

Les scripts d'installations de la base de données se trouvent dans le répertoire `./db`. Ce sont des fichiers sql à éxecuter dans l'ordre alphabétique pour installer la base de données.

# Idées d'améliorations

  * Ajouter une table dans la base de données avec un champ db_version. Dans le script d'installation de la base de données, incrémenter à chaque fois ce champs version, et renseigner ce nouveau numéro de version dans `./config/DbConfig.php`. Comme ça, dans la méthode `getDb()` du `BaseRepository` on peut vérifier que la base de données est à jour avec le code, sinon afficher un message d'erreur.
