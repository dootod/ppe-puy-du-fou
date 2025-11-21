<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Connexion - Puy du Fou</title>
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
            font-family: 'Cinzel', 'Times New Roman', serif;
        }

        @import url('../../public/img/bg.jpg');

        body {
            background: 
                linear-gradient(rgba(20, 12, 5, 0.7), rgba(44, 26, 8, 0.8)),
                url('../../public/img/bg.jpg');
            background-size: cover;
            background-position: center;
            background-attachment: fixed;
            color: #e8d8b6;
            line-height: 1.6;
            min-height: 100vh;
            display: flex;
            flex-direction: column;
            align-items: center;
            justify-content: center;
            padding: 20px;
        }

        .container {
            width: 100%;
            max-width: 450px;
            background: 
                linear-gradient(145deg, rgba(88, 52, 16, 0.9), rgba(44, 26, 8, 0.95));
            border-radius: 15px;
            box-shadow: 
                0 10px 30px rgba(0, 0, 0, 0.5),
                inset 0 1px 0 rgba(255, 215, 140, 0.2);
            padding: 40px 35px;
            margin: 20px 0;
            border: 1px solid #8b6b3d;
            position: relative;
            overflow: hidden;
        }

        .container::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            right: 0;
            height: 3px;
            background: linear-gradient(90deg, transparent, #d4af37, #ffd700, #d4af37, transparent);
        }

        .logo {
            text-align: center;
            margin-bottom: 10px;
        }

        .logo-text {
            font-family: 'MedievalSharp', cursive;
            font-size: 2.8rem;
            color: #d4af37;
            text-shadow: 2px 2px 4px rgba(0, 0, 0, 0.5);
            letter-spacing: 2px;
            margin-bottom: 5px;
        }

        .logo-subtitle {
            font-size: 1rem;
            color: #c9a96e;
            margin-bottom: 25px;
            letter-spacing: 1px;
        }

        h1 {
            text-align: center;
            color: #e8d8b6;
            margin-bottom: 30px;
            font-weight: 600;
            font-size: 1.8rem;
            text-transform: uppercase;
            letter-spacing: 1px;
            position: relative;
        }

        h1::after {
            content: '';
            display: block;
            width: 80px;
            height: 2px;
            background: linear-gradient(90deg, transparent, #d4af37, transparent);
            margin: 10px auto 0;
        }

        .form-group {
            margin-bottom: 25px;
            position: relative;
        }

        label {
            display: block;
            margin-bottom: 8px;
            font-weight: 500;
            color: #d4af37;
            font-size: 0.95rem;
        }

        input[type="email"],
        input[type="password"],
        input[type="text"],
        input[type="number"],
        select {
            width: 100%;
            padding: 14px 15px;
            background: rgba(20, 12, 5, 0.6);
            border: 1px solid #8b6b3d;
            border-radius: 8px;
            font-size: 16px;
            color: #e8d8b6;
            transition: all 0.3s;
            box-shadow: inset 0 2px 4px rgba(0, 0, 0, 0.3);
        }

        input::placeholder {
            color: #a89b7c;
        }

        input[type="email"]:focus,
        input[type="password"]:focus,
        input[type="text"]:focus,
        input[type="number"]:focus,
        select:focus {
            border-color: #d4af37;
            box-shadow: 
                0 0 0 2px rgba(212, 175, 55, 0.3),
                inset 0 2px 4px rgba(0, 0, 0, 0.3);
            outline: none;
        }

        button {
            width: 100%;
            padding: 16px;
            background: linear-gradient(to bottom, #d4af37, #b8941f);
            color: #2c1a08;
            border: none;
            border-radius: 8px;
            font-size: 1.1rem;
            font-weight: 700;
            cursor: pointer;
            transition: all 0.3s;
            margin-top: 15px;
            text-transform: uppercase;
            letter-spacing: 1px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.3);
            position: relative;
            overflow: hidden;
        }

        button:hover {
            background: linear-gradient(to bottom, #e0ba3d, #c9a028);
            transform: translateY(-2px);
            box-shadow: 0 6px 12px rgba(0, 0, 0, 0.4);
        }

        button:active {
            transform: translateY(1px);
            box-shadow: 0 2px 4px rgba(0, 0, 0, 0.3);
        }

        .alert {
            padding: 15px;
            border-radius: 8px;
            margin-bottom: 25px;
            text-align: center;
            border: 1px solid;
            font-weight: 500;
        }

        .alert-success {
            background-color: rgba(40, 80, 40, 0.6);
            color: #a8e6a8;
            border-color: #5a8c5a;
        }

        .alert-error {
            background-color: rgba(80, 30, 30, 0.6);
            color: #e8a8a8;
            border-color: #8c5a5a;
        }

        p {
            text-align: center;
            margin-top: 25px;
            color: #c9a96e;
        }

        a {
            color: #d4af37;
            text-decoration: none;
            font-weight: 600;
            transition: all 0.3s;
            border-bottom: 1px dotted #d4af37;
            padding-bottom: 1px;
        }

        a:hover {
            color: #ffd700;
            border-bottom: 1px solid #ffd700;
        }

        .decoration {
            position: absolute;
            font-size: 1.5rem;
            color: #8b6b3d;
            opacity: 0.3;
        }

        .decoration-top-left {
            top: 15px;
            left: 15px;
        }

        .decoration-top-right {
            top: 15px;
            right: 15px;
        }

        .decoration-bottom-left {
            bottom: 15px;
            left: 15px;
        }

        .decoration-bottom-right {
            bottom: 15px;
            right: 15px;
        }

        @media (max-width: 480px) {
            .container {
                padding: 30px 20px;
            }
            
            h1 {
                font-size: 1.6rem;
            }
            
            .logo-text {
                font-size: 2.2rem;
            }
        }
    </style>
</head>
<body>
    <div class="container">
        <div class="decoration decoration-top-left">⚔</div>
        <div class="decoration decoration-top-right">🛡</div>
        
        <div class="logo">
            <div class="logo-text">PUY DU FOU</div>
            <div class="logo-subtitle">L'Épopée Médiévale</div>
        </div>
        
        <h1>Connexion</h1>
        
        <?php if (isset($_SESSION['message'])): ?>
            <div class="alert alert-success"><?php echo $_SESSION['message']; unset($_SESSION['message']); ?></div>
        <?php endif; ?>
        
        <?php if (!empty($erreurs)): ?>
            <div class="alert alert-error">
                <?php foreach ($erreurs as $erreur): ?>
                    <p><?php echo $erreur; ?></p>
                <?php endforeach; ?>
            </div>
        <?php endif; ?>
        
        <form method="POST" action="index.php?action=traiterConnexion">
            <div class="form-group">
                <label for="email">Email:</label>
                <input type="email" id="email" name="email" value="<?php echo isset($_POST['email']) ? htmlspecialchars($_POST['email']) : ''; ?>" required>
            </div>
            
            <div class="form-group">
                <label for="mot_de_passe">Mot de passe:</label>
                <input type="password" id="mot_de_passe" name="mot_de_passe" required>
            </div>
            
            <button type="submit">Se connecter</button>
        </form>
        
        <p>Pas encore de compte ? <a href="index.php?action=afficherInscription">S'inscrire</a></p>
        
        <div class="decoration decoration-bottom-left">🏰</div>
        <div class="decoration decoration-bottom-right">🎪</div>
    </div>
</body>
</html>