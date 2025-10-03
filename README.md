/ppe-puy-du-fou
│
├── /app
│   ├── /Controllers        # Contrôleurs : gèrent les requêtes et appellent les modèles
│   │   └── UserController.php
│   │
│   ├── /Models             # Modèles : logique métier et gestion des données
│   │   └── User.php
│   │
│   ├── /Views              # Vues : affichage des données à l’utilisateur
│   │   └── /user
│   │       └── profile.php
│   │
│   └── /Core               # Classes de base (Controller, Router)
│       ├── Controller.php
│       └── Router.php
│
├── /config                 # Configuration du site et base de données
│   └── database.php
│
├── /public                 # Fichiers accessibles publiquement (front controller, CSS, JS)
│   ├── index.php
│   └── /css
│       └── style.css
└── .htaccess               # Réécriture d’URL pour URLs propres
