# 📦 Stocks Management – Carrosserie & Pare-brise Management System

![PHP](https://img.shields.io/badge/PHP-8.2-blue)
![MySQL](https://img.shields.io/badge/MySQL-8-orange)
![Docker](https://img.shields.io/badge/Docker-Containerized-blue)
![Jenkins](https://img.shields.io/badge/CI/CD-Jenkins-red)

---

## 📌 Description

**Stocks Management** est une application web développée en **PHP / MySQL** permettant la gestion des produits de carrosserie et pare-brise.

Ce projet a été conçu dans une logique **DevOps**, incluant :

- 🐳 Conteneurisation avec Docker  
- 🧩 Orchestration avec Docker Compose  
- 🔄 Préparation à l’intégration continue avec Jenkins  

L’objectif est de fournir une application simple, modulaire et déployable rapidement dans n’importe quel environnement.

---

## 🎯 Fonctionnalités

- 🔐 Authentification utilisateur (ADMIN / VISITEUR)
- 📦 Gestion des marchandises
- 📥 Gestion des entrées de stock
- 📤 Gestion des sorties de stock
- 📊 Calcul automatique des totaux
- 🗄️ Base de données relationnelle structurée

---

## 🛠️ Stack Technique

| Technologie | Version |
|-------------|----------|
| PHP | 8.2 |
| MySQL | 8 |
| Apache | 2.4 |
| Docker | Latest |
| Docker Compose | Latest |
| Jenkins | CI/CD |

---

## 🏗️ Architecture

```
Client (Browser)
        |
        v
Apache + PHP (Docker Container)
        |
        v
MySQL (Docker Container)
```

### Services Docker

- **app** → PHP 8.2 + Apache
- **db** → MySQL 8
- **phpmyadmin** (optionnel)

---

## 🗃️ Base de données

Nom de la base : `stock_management`

### Tables principales :

- `marchandise`
- `entrees`
- `sorties`
- `utilisateur`

### Relations :

- `entrees.reference` → `marchandise.reference`
- `sorties.reference` → `marchandise.reference`

---

## 👤 Comptes par défaut

| Login  | Mot de passe |
|--------|-------------|
| admin  | 123 |
| user1  | 123 |
| user2  | 123 |

⚠ Les mots de passe sont actuellement stockés en MD5.  
🔒 À améliorer avec `password_hash()` pour un usage production.

---

# 🚀 Installation & Lancement

## 1️⃣ Cloner le projet

```bash
git clone https://github.com/<your-username>/stocks-management.git
cd stocks-management
```

## 2️⃣ Lancer Docker

```bash
docker compose up --build
```

## 3️⃣ Accéder à l’application

```
http://localhost:8080
```

---

# 🔧 Variables importantes

Dans `docker-compose.yml` :

- MYSQL_DATABASE=stock_management
- MYSQL_ROOT_PASSWORD=root
- MYSQL_USER=root
- MYSQL_PASSWORD=root

---

# 🐳 Dockerfile

L’application utilise :

- Image officielle `php:8.2-apache`
- Extensions activées :
  - mysqli
  - pdo
  - pdo_mysql

---

# 🔄 CI/CD – Jenkins Pipeline (Prévu)

Un pipeline Jenkins sera mis en place pour :

- Clone automatique du repository
- Build de l’image Docker
- Lancement des containers
- Déploiement automatique

---

## 🧪 Exemple de Jenkinsfile

```groovy
pipeline {
    agent any

    stages {

        stage('Clone Repository') {
            steps {
                git 'https://github.com/<your-username>/stocks-management.git'
            }
        }

        stage('Build Docker Image') {
            steps {
                sh 'docker build -t stocks-management-app .'
            }
        }

        stage('Deploy Containers') {
            steps {
                sh 'docker compose down || true'
                sh 'docker compose up -d --build'
            }
        }

        stage('Success') {
            steps {
                echo 'Application deployed successfully!'
            }
        }
    }
}
```

---

# 📈 Roadmap DevOps

- [x] Application PHP fonctionnelle
- [x] Base de données MySQL
- [x] Dockerisation complète
- [x] Docker Compose
- [ ] Jenkins CI/CD
- [ ] Tests automatisés
- [ ] Déploiement Cloud (AWS / Azure)
- [ ] Monitoring & Logging

---

# 🔐 Améliorations Futures

- Migration MD5 → `password_hash()`
- Sécurisation contre injection SQL
- Gestion des rôles avancée
- Mise en place HTTPS
- Tests unitaires

---

# 🎓 Objectif du Projet

Projet académique orienté :

- Développement Web PHP
- Gestion de base de données
- Docker & Conteneurisation
- Introduction à l’intégration continue (CI/CD)
- Approche DevOps moderne

---

# 👨‍💻 Auteur

Projet de gestion de stock spécialisé en carrosserie et pare-brise.

---

# 📌 Licence

Projet académique – utilisation libre à des fins éducatives.
