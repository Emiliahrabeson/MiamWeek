# MiamWeek

**MiamWeek** est une application web de planification de repas hebdomadaire permettant aux utilisateurs d'organiser leurs repas, consulter des recettes, suivre leur consommation calorique et générer automatiquement leur liste de courses.

L'objectif est de simplifier l'organisation alimentaire quotidienne en centralisant les **recettes**, les **plans de repas**, les **allergies**, les **calories**, les **statistiques** et les **listes de courses** dans une seule application.

---

## Fonctionnalités

### Gestion du compte

* Inscription et connexion
* Gestion du profil utilisateur
* Modification du mot de passe
* Confirmation du compte par e-mail

### Planification des repas

* Planification des repas sur une semaine
* Organisation des repas par jour
* Gestion du petit-déjeuner, déjeuner et dîner
* Suggestion automatique d'un plan de repas
* Consultation de l'historique des plans de repas

### Gestion des recettes

* Consultation des recettes
* Recherche par recette ou ingrédient
* Recherche par type de repas
* Affichage des ingrédients et de leurs quantités
* Affichage du temps de préparation et de cuisson
* Calcul des calories d'une recette
* Création de recettes personnelles
* Gestion des recettes favorites

### Gestion des allergies

* Définition des allergies de l'utilisateur
* Association des allergies aux ingrédients
* Filtrage automatique des recettes contenant des ingrédients auxquels l'utilisateur est allergique

### Liste de courses

* Génération automatique d'une liste de courses à partir du plan de repas
* Regroupement des ingrédients nécessaires
* Calcul des quantités nécessaires pour la semaine

### Suivi des calories

* Calcul des calories par repas
* Calcul des calories par jour
* Calcul des calories sur l'ensemble de la semaine
* Visualisation des statistiques de consommation calorique

### Notifications

* Notifications quotidiennes
* Rappel du plan de repas prévu pour la journée

---

## Architecture

MiamWeek est développé selon le modèle **MVC (Modèle - Vue - Contrôleur)**.

```text
┌───────────────────────┐
│         Vue           │
│      HTML / CSS       │
└───────────┬───────────┘
            │
            ▼
┌───────────────────────┐
│     Contrôleur        │
│         PHP           │
└───────────┬───────────┘
            │
            ▼
┌───────────────────────┐
│        Modèle         │
│   Logique métier /    │
│    accès aux données  │
└───────────┬───────────┘
            │
            ▼
┌───────────────────────┐
│        MySQL          │
│      Base de données  │
└───────────────────────┘
```

Cette architecture permet de séparer :

* la présentation ;
* la logique applicative ;
* l'accès aux données.

Elle facilite ainsi la maintenance et l'évolution de l'application.

---

## Modèle de données

La base de données repose notamment sur les entités suivantes :

* `Utilisateur`
* `Recette`
* `Ingrédient`
* `Repas`
* `Jour`
* `Plan_de_repas`
* `Allergie`
* `Notification`
* `Liste_de_courses`

Des tables d'association permettent également de gérer les relations plusieurs-à-plusieurs, notamment entre les recettes et les ingrédients ainsi qu'entre les allergies et les ingrédients.

---

## Technologies utilisées

| Technologie  | Utilisation                    |
| ------------ | ------------------------------ |
| PHP          | Logique métier et contrôleurs  |
| MySQL        | Base de données                |
| HTML5        | Structure des pages            |
| CSS3         | Mise en forme et interface     |
| Git / GitHub | Gestion de versions            |
| Linux        | Environnement de développement |

---

## Tableau de bord

L'application dispose d'un tableau de bord permettant notamment de visualiser la consommation calorique au cours de la semaine.

Les statistiques permettent d'avoir une vue synthétique des habitudes alimentaires de l'utilisateur.

---

## Installation

### 1. Cloner le projet

```bash
git clone https://github.com/Emiliahrabeson/MiamWeek.git
cd MiamWeek
```

### 2. Configurer la base de données

Créer une base de données MySQL puis importer le fichier SQL fourni dans le projet.

### 3. Configurer la connexion à la base de données

Modifier les paramètres de connexion MySQL dans le fichier de configuration du projet :

```text
Host     : localhost
Database : miamweek
Username : votre_utilisateur
Password : votre_mot_de_passe
```

### 4. Lancer l'application

Placer le projet dans le répertoire de votre serveur web PHP, puis accéder à l'application depuis votre navigateur.

---

## Objectifs du projet

Le projet a été réalisé dans le cadre de la **Licence 3 Informatique et Technologie** à l'Université d'Antananarivo.

Il avait notamment pour objectifs de mettre en pratique :

* l'analyse des besoins ;
* la définition de règles de gestion ;
* la modélisation d'une base de données ;
* la conception d'un MCD et d'un MLD ;
* l'architecture MVC ;
* le développement d'une application web complète ;
* la gestion d'une base de données MySQL ;
* l'utilisation de Git et GitHub.

---

## Perspectives d'amélioration

Plusieurs améliorations peuvent être envisagées :

* améliorer le système de recommandation des plans de repas ;
* mettre en place l'envoi réel des notifications par e-mail ou notification navigateur ;
* enrichir la recherche de recettes avec davantage de critères nutritionnels ;
* améliorer l'ergonomie de la planification ;
* développer une version mobile de l'application.

---

## Auteur

**Rabeson Fanomezantsoa Fenitra Emiliah**

Licence 3 – Informatique et Technologie
Université d'Antananarivo

---

## Projet académique

MiamWeek est un projet réalisé dans le cadre d'un projet universitaire de Licence 3.

**Dépôt GitHub :**
https://github.com/Emiliahrabeson/MiamWeek
