Visitez notre site via cette url : www.entmmichamps.fr

COMMENT INSTALLER LE SITE SUR UN AUTRE SERVEUR?

A) Installation d’un site en local 🏠:


Installation du serveur local  XAMPP

 - Installer XAMPP en incluant au moins les modules Apache et MySQL.
 - Une fois XAMPP ouvert, activez les serveurs Apache et MySQL.
- Accédez au répertoire htdocs dans le dossier XAMPP à la racine de votre disque. "C:\xampp"
 - Déposez dans le répertoire htdocs le dossier "ent_test", contenant le code du site et la base de données "ent_test.sql".


Installation de la base de données locale :

 - Ouvrez votre navigateur et accédez à "localhost/phpMyAdmin".
 - Créez une nouvelle base de données.
 - Sélectionnez la nouvelle base de données, allez dans "Importer" et importez le fichier `ent_test.sql` du dossier ent_test.


Configuration de la connexion :

Modifiez les informations de connexion dans le fichier ‘connexion.php’ en fonction des paramètres de votre base de données. Lorsque vous travaillez en local sur Windows avec XAMPP, il est courant de laisser le champ du mot de passe vide pour l'utilisateur par défaut ('root'). En revanche, sous Mac, l'utilisateur par défaut ‘root’ a pour mot de passe également ‘root’.

 Accédez au site en local :
 
 - Ouvrez votre navigateur et entrez l'URL correspondante sur XAMPP : 
Allez à l'adresse http://localhost/ent/index.php  dans votre navigateur pour arriver sur le site.




B) INSTALLATION EN LIGNE 🚀: 

Hébergement web : 

-Vous devez choisir un service d'hébergement web auprès d'un fournisseur.
Transfert de fichiers : 
-Utilisez un client FTP comme FileZilla pour transférer le dossier ent sur le serveur. -Vous devrez généralement les placer dans le répertoire public_html ou www de -votre compte d'hébergement.
Base de données en ligne : 
-Vous devrez créer une base de données MySQL sur votre serveur d'hébergement. -Utilisez l'outil de gestion de base de données de votre hébergeur ou phpMyAdmin -pour importer la base de données ‘ent_test.sql’ comprise dans le dossier ent.
Configuration de la connexion :
-Assurez-vous que les informations de connexion dans le fichier connexion.php correspondent aux paramètres de votre base de données en ligne, vous devrez créer un utilisateur et lui associer un mot de passe, veillez bien à changer ceux présent dans ce fichier.



Accéder au site : 

Une fois les fichiers transférés et la base de données configurée, accédez au site en utilisant le nom de domaine associé à votre hébergement.
Exemple : http://www.domaine.com/ent/index.php


Points Importants
-Sécurité : utilisez des mots de passe robustes pour la base de données. Consultez la documentation de XAMPP pour des conseils sur la sécurisation de votre environnement de développement.
-Version de XAMPP : utilisez la dernière version stable
-Dépendances : Vérifiez et installez toutes les dépendances requises mentionnées dans le fichier README pour assurer le bon fonctionnement du site.
-Tests et Débogage : Avant de déployer le site, assurez-vous de l




