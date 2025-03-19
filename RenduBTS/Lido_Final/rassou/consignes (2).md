# 🏖️ Contexte

Le lido (restaurant de plage) Serena à besoin de vous. Le systeme ancestral de prise de commande (papier stylo ✏️) engendre de plus en plus d'**erreurs** et ralenti le service.

La direction souhaite donc se moderniser pour éviter ces erreurs, et aimerait se dotter de nouveaux outils de pilotage pour gérer le restaurant avec plus de précision notamment au niveau des stocks.

Pour cela elle fait appel à vous afin que vous leur proposiez une solution un peu plus dans l'air du temps ! La direction souhaite voir ses serveurs prendre les commandes via une **tablette**, afin d'**automatiser l'envoi** en cuisine et éviter les incompréhensions. Ces tablettes permettront également aux serveur d'enregistrer le payement (_fictif_) des clients.

La direction souhaite tout de même rester flexible, la carte change régulièrement et un nouvel outil ne doit pas être un obstacle au coeur de metier du restaurant. A ce titre elle vous demande de leur proposer une **interface administrateur** qui leur permettra de **modifier elle même** les _plats, menus, boissons_... proposés à la carte.

De plus elle souhaiterais avoir accès à un **tableau de bord** affichant des graphiques de plusieurs données (plats les plus commandés, jours de la semaine les plus fréquentés ...) afin de mieux comprendre les besoins de leurs clients et mieux piloter leur restaurant.

---

# ⚙️ Réalisation

Vous devrez réaliser une application web pour les tablettes du restaurant. Cette application permettra au serveur de saisir les commandes et de calculer l'addition de chaque table.

Tant qu'une table n'a pas payé, il est possible qu'elle commande de nouveaux produits (desserts, boissons, ou même menu pourquoi pas), il faut donc que les serveurs puissent ajouter des produits à une commande passée précédement.

## 👨‍💼 Application commande/payement

### 🍝 La commande

Le serveur séléctionne la table qui passe commande.

Le client peut commander :

- Une pizza 🍕
- Des pates 🍝
- Un plat 🍲
- Un dessert 🍨
- Une boisson 🍺
- Un menu (peut contenir) 📄
  - Un plat / pizza / pates
  - Un dessert _optionnel_
  - Une boisson _optionnel_

### 💸 Le payement

Le serveur séléctionne la table qui veut payer et clique sur **_PAYER_**. L'application affiche le montant total et le detail du prix de chaque produit

Les commandes et payement devront être enregistrés dans une BDD.

## 👔 Interface admin

Les utilisateur admins (connexion user/mdp) auront la possibilité d'accéder à une interface administrateur comptant 2 paneaux :

### 💾 Gestion des plats, menus ...

Interface simple permettant d'ajouter des plats, boissons, desserts et menus à la carte.

⚠️ **Attention** les menus doivent être précis, on doit savoir ce qu'il est possible de mettre dans un menu. Par exemple : un menu _Pizza+Boisson_ ne peut pas contenir des pates. A vous de gérer ça.

### 📈 Tableau de bord

Affiche des graphiques pour piloter le restaurant

- Plats les plus commandés (pie chart)
- Jours de la semaine le plus fréquenté (bar chart)
- Addition moyenne par personne
- ...

## 👨‍🍳 Application cuisine

Cette application à destination des cuisiniers doit afficher les commandes en cours. Quand les plats sont prêts, le cuisinier n'a qu'a cliquer sur un bouton pour prévenir les serveurs, les plats envoyés ne sont plus visible sur l'application cuisine.
Une notification s'affiche alors sur la tablette des serveurs qui pourront la supprimer après avoir servi les plats.

# 🛠️ Contraintes techniques

Vous êtes libre d'utiliser les technologies, langages, framework... **Que vous voulez**. Il vous faudra simplement un frontend, un backend et une BDD, à vous de bien les choisir.

Votre tech-lead vous à seulement demander une chose : Créer 3 applications distinctes :

- Backend & interface admin
- Application commande/payement pour les serveurs
- Application cuisine

L'objectif est de rendre le code plus modulaire et réutilisable dans d'autres futurs projets. (pour vous c'est l'occasion d'apprendre à créer une API utilisable depuis une application exterieur)

Interagir avec votre serveur depuis des applications externes va causer de problèmes d'autorisation (le serveur n'autorise pas n'importe qui à lui envoyer des données). Il faudra donc prévoir du temps pour les **CORS** (**C**ross **O**rigin **R**esources **S**haring), cela être plus ou moins difficile selon les langages que vous aurez choisi. N'hésitez pas à me demander de l'aide sur ce point c'est toujours un peu complexe.

# 📂 Rendu projet

- Le **planning du projet**, comportant la répartition des taches et une estimation de temps pour chaque tache (utilisez un outil type [Trello](https://trello.com/))
- Le **code terminé**, sans bug et à jour
- Un fichier `readme.md` contenant
  - Les prérequis pour lancer les applications.
  - Les outils utilisés et pourquoi avoir choisi ceux là
  - Les problèmes rencontrés
  - L'explication des fonctionnalités et leur place dans le code
- Un repo **git propre**

# ☝ Conseils

Jusqu'au rendu je joue le role de votre _tech-lead_, **n'hésitez pas à me soliciter**, ne restez surtout pas bloqué pendant plusieurs heures. N'oubliez pas que pour le rendu je change de role, je deviens **le client**, donc les documents du rendu doivent **s'addresser à un client** (pas à un expert de l'informatique)

Avancez **pas à pas**, ne commencez pas 3 choses en même temps.

Faites des logs et **débuggez**

Prenez le temps de lire les erreurs et essayer de les comprendre avant de les copier-coller bêtement sur internet

Travailler en équipe **prend du temps** ! Prévoyez ce temps, mettre en commun le travail de 3 personnes ça ne se fait pas avec un simple copier coller. Pour vous simplifier la vie mettez le code en commun **régulièrement**, pas au moment d'envoyer le code.

**Communiquez** ! Il faut que vous sachiez qui travaille sur quoi, pour ne pas faire le travail en double ET pour que vos codes se complètent intelligement.
