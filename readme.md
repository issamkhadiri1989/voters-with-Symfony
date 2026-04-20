# Les Voters

Le but de ce petit projet est de se familiariser avec les Voters en Symfony.

Dans cet exemple, vous allez développer un petit CMS.

Les pages de votre site peuvent être :

* Publiques

* Privées

Un utilisateur peut consulter les pages publiées. Pour les pages non publiques (archivées ou en brouillon), seul leur
auteur est autorisé à les visualiser.

## Contenu du projet :

- `src/Controller/BlogController.php` : Le contrôleur responsable des opérations VIEW / EDIT / ADD d’un blog.

- `src/Controller/SecurityController.php` : Affiche la page de connexion.

- `src/Entity/Blog.php` : L’entité principale Blog.

- `src/Entity/User.php` : L’entité User.

- `src/Enum/Status.php` : Énumération représentant les statuts du blog.

- `src/Handler/Blog/BlogHandler.php` : Gère la manipulation des blogs.

- `src/Security/Voter/BlogVoter.php` : Le voter qui contrôle les opérations sur les blogs. Si la page est publiée,
  aucune connexion n’est nécessaire. Sinon, l’utilisateur doit être connecté.


