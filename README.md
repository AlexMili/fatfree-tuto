Introduction à FatFree Framework
=============

Bonjour, aujourd'hui je vais vous parler d'un jeune pouce dans le monde PHP : FatFree.
FatFree est un micro framework PHP qui fournit des outils avancés de développement tout en restant le plus léger et simple possible.
En effet, le framework est condensé en un unique fichier de 50Ko.
Encore peu connu, ce framework est un compromis entre les outils bien plus complets mais aussi beaucoup plus lourds tel que symphony,
zend ou cakePHP.

Avant de commencer je tiens à préciser que tout le code que je m'apprête à vous montrer se trouve sur [Github](http://github.com/AlexMili/fatfree-tuto.git). Dans la suite de ce tuto je prends pour acquis le faite que vous connaissiez MVC et la POO.
Sans plus tarder découvrons les fonctionnalités de ce framework.

Hello World
-------------

Tout d'abord récupérez le fichier core de fatfree : [https://github.com/bcosca/fatfree/blob/master/lib/base.php](https://github.com/bcosca/fatfree/blob/master/lib/base.php)

Commençons donc par ce qui nous intéresse, du code :

index.php
```
$f3=require('base.php');
$f3->route('GET /',
    function() {
        echo 'Hello World!';
    }
);
$f3->run();
```

.htaccess
```
# Enable rewrite engine and route requests to framework
RewriteEngine On

RewriteCond %{REQUEST_FILENAME} !-l
RewriteCond %{REQUEST_FILENAME} !-f
RewriteCond %{REQUEST_FILENAME} !-d
RewriteRule .* index.php [L,QSA]
```

Le .htaccess a pour seul rôle de tout rediriger sur l'index. Pensez à activer l'URL REWRITING.

Comme vous pouvez le voir fatfree permet de produire un code propre et comprehensible et cela même lorsqu'on ne connait pas le framework.

La première ligne permet de récupérer le framework que l'ont stock dans une variable nommée $f3.
Ensuite on définit la route par défaut '/' qui correspond à la racine du site. A cette route nous attribuons une fonction qui sera appellée à chaque fois que quelqu'un tente d'accéder à la racine du site.
La dernière ligne permet de démarrer la machine ;)

Si tout va bien vous aurez votre jolie 'Hello World !'.

Routing engine
-------------

Maintenant nous allons nous pencher plus en détails sur le routing engine. Son rôle est d'analyser l'url entrée par l'utilisateur pour ensuite appeller la fonction qui est liée à l'adresse demandée. Cela nous permet d'attacher une action pour chaque route voir une action pour plusieurs routes.

Reprenons notre ligne de tout à l'heure légèrement modifiée:

```
$f3->route('GET|POST /about/@prenom',
    function($f3) {
        echo 'Hello ' .$f3->get('PARAMS.prenom');
    }
);
```

Comme vous pouvez le voir afin de pouvoir utiliser les fonctionnalités de fatfree dans une fonction tièrce nous devons passer son instance en paramètre. Le framework s'occupe d'injecter automatiquement l'instance en tant que premier argument.
Ici je créer une route '/about/' qui prend un argument 'prenom' dans l'URL. Pour retrouver cet argument dans notre code il suffit d'utiliser la méthode $f3->get('PARAMS.prenom');. Attention ! Si vous tentez d'accéder à '/about/' (sans l'argument), fatfree vous retournera une belle erreur.

Notre nouvelle route est désormais accessible aussi bien en GET qu'en POST.

Le routing engine peut encore faire pleins de choses mais j'aimerais vous parler de deux fonctionnalités qui m'ont permis d'apprécier fatfree : les fichiers de config et l'autoload.

Fichier de configuration
-------------

L'exemple que je vous ai montré précédemment est jolie pour une petite démo mais lorsque vous avez un projet de plusieurs dizaines de routes, votre code risque de rapidement devenir n'importe quoi. C'est là qu'interviennent les fichiers de configuration.
Ne perdons pas de temps en explications et regardons cela tout de suite. Voici un fichier de configuration que j'ai l'habitude d'utiliser dans mes projets :

```
[globals]
#AUTOLOADS
AUTOLOAD=app/Controllers/;app/Helpers/;app/Models/

#PATHS
UI=app/Views/

#DATABASE
db_host=localhost
db_name=autolive
db_port=3306
db_user=root
db_pass=

#ENVIRONMENT
DEBUG=2

[routes]
################   GENERAL
GET|POST /=										MainController->login
GET /deconnecter=								MainController->logout
GET /accueil=									MainController->home
GET /gestion=									MainController->setting
```

Nous avons deux catégories, [global] et [routes]. La premières permet de définir les variables globales du projet et la seconde les routes.

Dans ce tas de variables, vous en avez 3 qui sont propres au framework :
AUTOLOAD : Nous allons en parler juste après
UI : Chemin relatif du répertoire des vues
DEBUG : Les valeurs possibles sont 0, 1, 2 et 3. 0 étant aucune sortie debug.

les variables db_ sont mes variables maison que j'utilise pour définir l'accès à ma BDD.
Vous l'aurez compris, la section [routes] permet de définir ses routes très rapidement. Ca peut paraître anodin mais niveau productivité ça vous fera gagner beaucoup de temps ;)

Voici comment charger ce fichier de configuration :

```
$f3->config('config.cfg');
```

Je vais maintenant aborder rapidement l'autoload.

Autoload
-------------

Pour les non-anglophones "autoload" signifie chargement automatique. Cette fonctionnalité va chercher dans les répertoires que vous aurez ajoutés dans la variable de tout à l'heure AUTOLOAD. Cela aura pour effet de rendre directement accessible vos fonctions qui se trouvent dans d'autres répertoires. Vous pouvez donc utiliser votre architecture de dossier/fichier comme vous en avez l'habitude.

C'est sur ces fonctionnalités essentiels que je m'arrête aujourd'hui. Le but de cet article était de vous faire découvrir le framework FatFree. J'èspère vous avoir donné envie de découvrir plus profondément ce framework.

Pour aller plus loin
-------------

Pour ceux qui aimeraient aller plus loin je vous recommande le Github du projet qui est extrèmement bien documenté :
[https://github.com/bcosca/fatfree](https://github.com/bcosca/fatfree)
Et leur site :
[http://fatfreeframework.com/home](http://fatfreeframework.com/home)

J'èspère pouvoir continuer à vous faire découvrir d'autres fonctionnalités une autre fois.

A la prochaine.
