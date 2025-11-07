<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Accès Mobile - Puy du Fou</title>
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            font-family: 'Georgia', 'Times New Roman', serif;
            background: linear-gradient(135deg, #8B4513 0%, #D2691E 50%, #F4A460 100%);
            background-image: url('data:image/svg+xml,<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 100 100" opacity="0.1"><path d="M20,20 Q50,10 80,20 T80,80 Q50,90 20,80 T20,20Z" fill="none" stroke="%23000" stroke-width="2"/></svg>');
            background-size: 200px 200px;
            min-height: 100vh;
            display: flex;
            justify-content: center;
            align-items: center;
            padding: 20px;
            color: #2C1810;
        }

        .message-container {
            background: rgba(255, 248, 225, 0.95);
            padding: 40px 30px;
            border-radius: 20px;
            border: 3px solid #8B4513;
            box-shadow: 
                0 10px 30px rgba(139, 69, 19, 0.3),
                inset 0 0 20px rgba(255, 215, 0, 0.2);
            max-width: 500px;
            width: 100%;
            text-align: center;
            position: relative;
            overflow: hidden;
        }

        .message-container::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            right: 0;
            height: 8px;
            background: linear-gradient(90deg, #8B4513, #D2691E, #8B4513);
            border-radius: 20px 20px 0 0;
        }

        .message-container::after {
            content: '';
            position: absolute;
            bottom: 0;
            left: 0;
            right: 0;
            height: 4px;
            background: linear-gradient(90deg, #8B4513, #FFD700, #8B4513);
        }

        .icon {
            font-size: 4em;
            margin-bottom: 20px;
            color: #8B4513;
            text-shadow: 2px 2px 4px rgba(0, 0, 0, 0.2);
            animation: pulse 2s infinite;
        }

        @keyframes pulse {
            0% { transform: scale(1); }
            50% { transform: scale(1.1); }
            100% { transform: scale(1); }
        }

        h1 {
            font-size: 2.2em;
            margin-bottom: 20px;
            color: #8B4513;
            text-shadow: 1px 1px 2px rgba(0, 0, 0, 0.1);
            font-weight: bold;
            letter-spacing: 1px;
        }

        p {
            font-size: 1.1em;
            line-height: 1.6;
            margin-bottom: 15px;
            color: #5D4037;
        }

        .puydufou-brand {
            margin-top: 25px;
            padding-top: 20px;
            border-top: 2px dashed #8B4513;
        }

        .puydufou-brand p {
            font-style: italic;
            color: #8B4513;
            font-weight: bold;
            font-size: 1em;
            margin: 0;
        }

        .decoration {
            position: absolute;
            font-size: 1.5em;
            opacity: 0.3;
        }

        .decoration.top-left {
            top: 10px;
            left: 15px;
        }

        .decoration.top-right {
            top: 10px;
            right: 15px;
        }

        .decoration.bottom-left {
            bottom: 10px;
            left: 15px;
        }

        .decoration.bottom-right {
            bottom: 10px;
            right: 15px;
        }

        @media (max-width: 480px) {
            .message-container {
                padding: 30px 20px;
                margin: 10px;
            }
            
            h1 {
                font-size: 1.8em;
            }
            
            p {
                font-size: 1em;
            }
            
            .icon {
                font-size: 3.5em;
            }
        }
    </style>
</head>
<body>
    <div class="message-container">
        <div class="decoration top-left">⚔️</div>
        <div class="decoration top-right">🏰</div>
        
        <div class="icon">📱</div>
        <h1>Accès Mobile Requis</h1>
        <p>L'application Puy du Fou est spécialement conçue pour les appareils mobiles.</p>
        <p>Veuillez accéder à cette page depuis votre smartphone ou tablette pour profiter pleinement de l'expérience.</p>
        <p>Merci de votre compréentation.</p>
        
        <div class="decoration bottom-left">🛡️</div>
        <div class="decoration bottom-right">🎪</div>
        
        <div class="puydufou-brand">
            <p>Puy du Fou - L'émotion à la française</p>
        </div>
    </div>
</body>
</html>