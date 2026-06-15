# MiamWeek

Application web de planification de repas hebdomadaires.

---

## Description

**MiamWeek** est une application qui aide les utilisateurs à organiser leurs repas sur une semaine, suivre leurs apports caloriques, gérer leurs allergies et préparer leur liste de courses.

Le cycle de fonctionnement est le suivant :

1. L'utilisateur s'inscrit et définit ses allergies et son objectif calorique quotidien
2. Il crée ou consulte des recettes
3. Il génère un plan de repas sur 7 jours
4. Chaque jour contient plusieurs repas (petit-déjeuner, déjeuner, dîner)
5. Les calories sont calculées automatiquement
6. Une liste de courses est générée depuis le plan
7. Les anciens plans restent disponibles dans l'historique

---

## Fonctionnalités

- Inscription et connexion
- Planification des repas sur 7 jours
- Création et consultation de recettes
- Recherche de recettes par ingrédients
- Calcul automatique des calories par repas, par jour
- Statistiques de consommation calorique
- Gestion des recettes favorites
- Génération automatique de la liste de courses depuis le plan de repas
- Gestion des allergies avec filtrage des recettes
- Suggestions de repas personnalisées
- Notifications de rappel envoyées
- Historique des plans de repas de la semaine dernière

---

## Stack technique

| Catégorie | Technologies |
|---|---|
| Frontend | HTML, CSS |
| Backend | PHP |
| Base de données | MySQL |
| Environnement | Linux |

---

## Structure de la base de données

Les entités principales sont les suivantes :

- `Utilisateur` — nom, email, mot de passe hashé, objectif calorique quotidien
- `PlanDeRepas` — période de 7 jours, statut (en cours / terminé / archivé)
- `Jour` — date, appartient à un plan de repas
- `Repas` — type (petit-déjeuner, déjeuner, dîner), appartient à un jour
- `Recette` — description, temps de préparation, temps de cuisson, calories totales
- `Ingredient` — unité par défaut, calories par unité
- `Allergie` — liée à des ingrédients via une table de jointure
- `ListeCourse` — générée depuis un plan de repas, contient des ingrédients avec quantités
- `Favori` — association entre un utilisateur et une recette
- `Notification` — rappels par utilisateur

La chaîne logique du modèle est :

```
Utilisateur → PlanDeRepas → Jour → Repas → Recette → Ingredient
```

---

## Installation

```bash
# Cloner le projet
git clone https://github.com/Emiliahrabeson/miamweek.git
cd miamweek

# Importer la base de données
mysql -u root -p < database.sql

# Configurer la connexion
cp config/config.example.php config/config.php
# Renseigner les identifiants MySQL dans config.php
```

Lancer ensuite le projet via Apache, Nginx ou `php -S localhost:8000 -t public`.

---

## Auteur

Rabeson Fanomezantsoa Fenitra Emiliah
