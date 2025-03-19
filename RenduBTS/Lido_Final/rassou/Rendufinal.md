# 📌 Lido Serena - Système de Gestion des Commandes et des Stocks

## 📖 Introduction
Le restaurant de plage **Lido Serena** souhaite moderniser son système de prise de commande afin d'éviter les erreurs et améliorer l'efficacité du service. Cette application permet aux serveurs de prendre les commandes directement via une **tablette**, d'envoyer les commandes en cuisine et de gérer les paiements des clients. 

Une interface administrateur permet de **modifier les plats, menus et boissons** proposés à la carte, tandis qu'un **tableau de bord** aide la direction à suivre les tendances et optimiser la gestion du restaurant.

---

## 🎯 Fonctionnalités

### 1️⃣ Application de commande & paiement (Serveurs)
- Sélection d'une table
- Ajout de produits à une commande (plats, boissons, menus)
- Consultation des commandes en cours
- Gestion des paiements (simulation)

### 2️⃣ Interface administrateur
- Gestion des plats, boissons et menus 
- Ajout / modification / suppression de produits
- Définition des menus avec contraintes (ex: un menu "Pizza + Boisson" ne peut contenir que des pizzas)
- Consultation d'un **tableau de bord** avec des graphiques interactifs :
  - Plats les plus commandés (Pie Chart)
  - Jours les plus fréquentés (Bar Chart)
  - Addition moyenne par personne

### 3️⃣ Application cuisine
- Affichage des commandes en cours
- Notification aux serveurs lorsque les plats sont prêts
- Possibilité de marquer les commandes comme terminées

---

## 🛠️ Technologies Utilisées
| Composant              | Technologie |
|------------------------|-------------|
| **Backend**           | PHP (API REST) |
| **Base de données**  | MySQL       |
| **Frontend Admin**    | React.js    |
| **Application Serveurs** | React Native / Vue.js |
| **Application Cuisine** | Vue.js     |

---

## 📂 Architecture du Projet
```
backend/
├── api/
│   ├── controllers/
│   ├── models/
│   ├── routes/
│   ├── index.php
│   ├── database.php
├── config/
├── tests/

frontend-admin/
├── src/
│   ├── components/
│   ├── pages/
│   ├── services/
│   ├── App.js
│   ├── index.js

application-serveur/
├── src/
│   ├── screens/
│   ├── components/
│   ├── api/
│   ├── App.js

application-cuisine/
├── src/
│   ├── screens/
│   ├── components/
│   ├── api/
│   ├── App.js
```

---

## 🚀 Installation & Configuration

### 📌 Prérequis
- PHP 8+
- MySQL 5.7+
- Node.js 16+
- Composer

### 🏗️ Installation
```bash
# Cloner le projet
git clone https://github.com/votre-repo.git
cd votre-repo

# Installer les dépendances backend
cd backend
composer install

# Configurer l'environnement
cp .env.example .env
nano .env  # Modifier les variables (DB_NAME, DB_USER, DB_PASS...)

# Lancer le serveur backend
php -S localhost:8000 -t public
```

```bash
# Installer et lancer l'interface admin
cd ../frontend-admin
npm install
npm run dev
```

```bash
# Installer et lancer l'application Serveur
cd ../application-serveur
npm install
npm start
```

```bash
# Installer et lancer l'application Cuisine
cd ../application-cuisine
npm install
npm start
```

---

## 🛠️ API Endpoints (Exemples)

### 📌 Gestion des commandes
| Méthode | Endpoint                | Description |
|----------|-------------------------|-------------|
| `GET`    | `/tables`                | Liste des tables disponibles |
| `POST`   | `/commandes`             | Créer une nouvelle commande |
| `GET`    | `/commandes/{id}`        | Récupérer une commande |
| `POST`   | `/commandes/{id}/ajout`  | Ajouter un produit à une commande |
| `POST`   | `/commandes/{id}/payer`  | Marquer la commande comme payée |

### 📌 Gestion des menus
| Méthode | Endpoint                 | Description |
|----------|--------------------------|-------------|
| `GET`    | `/menus`                 | Liste des menus |
| `POST`   | `/menus`                 | Créer un nouveau menu |
| `PUT`    | `/menus/{id}`            | Modifier un menu |
| `DELETE` | `/menus/{id}`            | Supprimer un menu |

---

## 🗂️ Planification & Suivi
La gestion du projet a été réalisée via **Trello**.
- **Backlog** : Tâches en attente
- **En cours** : Ce qui est en train d'être développé
- **Terminé** : Fonctionnalités validées

Lien vers le Trello : [Trello du projet](https://trello.com/)

---

## 📜 Conclusion
Ce projet répond à un besoin réel de digitalisation dans la restauration en proposant un système moderne et efficace. Il offre une meilleure gestion des commandes, des stocks et de l'analyse de performance.

Des évolutions futures pourraient inclure :
- Un module de réservation de tables
- Un système de gestion des clients fidèles
- Une interface mobile pour les clients

📩 **Contact :** [votre@email.com](mailto:votre@email.com)
