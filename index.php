<?php
require_once __DIR__ . '/includes/session.php';
if (isset($_SESSION['user_id'])) {
    header('Location: dashboard.php');
    exit;
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login - Todo App</title>
    <link rel="stylesheet" href="assets/css/style.css">
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;600&display=swap" rel="stylesheet">
    <style>
        /* Panda Design Override */
        body {
            background-color: #f4c531 !important;
            font-family: "Poppins", sans-serif !important;
        }

        .container {
            height: 31.25em;
            width: 31.25em;
            position: absolute;
            transform: translate(-50%, -50%);
            top: 50%;
            left: 50%;
        }

        .auth-form {
            width: 23.75em !important;
            height: 18.75em !important;
            background-color: #ffffff !important;
            position: absolute !important;
            transform: translate(-50%, -50%) !important;
            top: calc(50% + 3.1em) !important;
            left: 50% !important;
            padding: 0 3.1em !important;
            display: flex !important;
            flex-direction: column !important;
            justify-content: center !important;
            border-radius: 0.5em !important;
            box-shadow: 0 10px 30px rgba(0,0,0,0.2) !important;
        }

        .auth-form h2 {
            text-align: center !important;
            margin-bottom: 1.5em !important;
            color: #2e0d30 !important;
            font-size: 1.5em !important;
            font-weight: 600 !important;
        }

        .form-group {
            margin-bottom: 0.9em !important;
        }

        .auth-form input {
            width: 100% !important;
            font-size: 0.95em !important;
            font-weight: 400 !important;
            color: #3f3554 !important;
            padding: 0.3em !important;
            border: none !important;
            border-bottom: 0.12em solid #3f3554 !important;
            outline: none !important;
            background: transparent !important;
        }

        .auth-form input:focus {
            border-color: #f4c531 !important;
        }

        .auth-form button {
            font-size: 0.95em !important;
            padding: 0.8em 0 !important;
            border-radius: 2em !important;
            border: none !important;
            cursor: pointer !important;
            outline: none !important;
            background-color: #f4c531 !important;
            color: #2e0d30 !important;
            text-transform: uppercase !important;
            font-weight: 600 !important;
            letter-spacing: 0.15em !important;
            margin-top: 0.8em !important;
            transition: 0.3s !important;
            width: 100% !important;
        }

        .auth-form button:hover {
            transform: translateY(-2px) !important;
            box-shadow: 0 5px 15px rgba(244, 197, 49, 0.4) !important;
        }

        .auth-form p {
            margin-top: 1em !important;
            text-align: center !important;
            color: #666 !important;
            font-size: 0.9em !important;
        }

        .auth-form a {
            color: #f4c531 !important;
            text-decoration: none !important;
            font-weight: 600 !important;
        }

        /* Panda Elements - Fixed Alignment */
        .panda-face {
            height: 7.5em;
            width: 8.4em;
            background-color: #ffffff;
            border: 0.18em solid #2e0d30;
            border-radius: 7.5em 7.5em 5.62em 5.62em;
            position: absolute;
            top: 2em;
            left: 50%;
            transform: translateX(-50%);
        }

        .ear-l, .ear-r {
            background-color: #3f3554;
            height: 2.5em;
            width: 2.81em;
            border: 0.18em solid #2e0d30;
            border-radius: 2.5em 2.5em 0 0;
            top: 1.75em;
            position: absolute;
        }

        .ear-l {
            transform: rotate(-38deg);
            left: calc(53.5% - 6.15em);
        }

        .ear-r {
            transform: rotate(38deg);
            left: calc(46.5% + 3.35em);
        }

        .blush-l, .blush-r {
            background-color: #ff8bb1;
            height: 1em;
            width: 1.37em;
            border-radius: 50%;
            position: absolute;
            top: 4em;
        }

        .blush-l {
            transform: rotate(25deg);
            left: 1em;
        }

        .blush-r {
            transform: rotate(-25deg);
            right: 1em;
        }

        .eye-l, .eye-r {
            background-color: #3f3554;
            height: 2.18em;
            width: 2em;
            border-radius: 2em;
            position: absolute;
            top: 2.18em;
        }

        .eye-l {
            left: 1.37em;
            transform: rotate(-20deg);
        }

        .eye-r {
            right: 1.37em;
            transform: rotate(20deg);
        }

        .eyeball-l, .eyeball-r {
            height: 0.6em;
            width: 0.6em;
            background-color: #ffffff;
            border-radius: 50%;
            position: absolute;
            left: 0.6em;
            top: 0.6em;
            transition: 1s all;
        }

        .eyeball-l {
            transform: rotate(20deg);
        }

        .eyeball-r {
            transform: rotate(-20deg);
        }

        .nose {
            height: 1em;
            width: 1em;
            background-color: #3f3554;
            position: absolute;
            top: 4.37em;
            left: 50%;
            transform: translateX(-50%) rotate(45deg);
            border-radius: 1.2em 0 0 0.25em;
        }

        .nose:before {
            content: "";
            position: absolute;
            background-color: #3f3554;
            height: 0.6em;
            width: 0.1em;
            transform: rotate(-45deg);
            top: 0.75em;
            left: 1em;
        }

        .mouth, .mouth:before {
            height: 0.75em;
            width: 0.93em;
            background-color: transparent;
            position: absolute;
            border-radius: 50%;
            box-shadow: 0 0.18em #3f3554;
        }

        .mouth {
            top: 5.65em;
            left: 45%;
            transform: translateX(-50%);
        }

        .mouth:before {
            content: "";
            position: absolute;
            left: 0.87em;
        }

        .hand-l, .hand-r {
            background-color: #3f3554;
            height: 2.81em;
            width: 2.5em;
            border: 0.18em solid #2e0d30;
            border-radius: 0.6em 0.6em 2.18em 2.18em;
            transition: 1s all;
            position: absolute;
            top: 8.4em;
        }

        .hand-l {
            left: calc(50% - 8em);
        }

        .hand-r {
            left: calc(50% + 5.5em);
        }

        .paw-l, .paw-r {
            background-color: #3f3554;
            height: 3.12em;
            width: 3.12em;
            border: 0.18em solid #2e0d30;
            border-radius: 2.5em 2.5em 1.2em 1.2em;
            position: absolute;
            top: 26.56em;
        }

        .paw-l {
            left: calc(50% - 5.56em);
        }

        .paw-r {
            left: calc(50% + 2.44em);
        }

        .paw-l:before, .paw-r:before {
            position: absolute;
            content: "";
            background-color: #ffffff;
            height: 1.37em;
            width: 1.75em;
            top: 1.12em;
            left: 0.55em;
            border-radius: 1.56em 1.56em 0.6em 0.6em;
        }

        .paw-l:after, .paw-r:after {
            position: absolute;
            content: "";
            background-color: #ffffff;
            height: 0.5em;
            width: 0.5em;
            border-radius: 50%;
            top: 0.31em;
            left: 1.12em;
            box-shadow: 0.87em 0.37em #ffffff, -0.87em 0.37em #ffffff;
        }

        @media screen and (max-width: 500px) {
            .container {
                font-size: 14px;
            }
        }
    </style>
</head>
<body>
    <div class="container">
        <form id="loginForm" class="auth-form">
            <h2>Login</h2>
            <div class="form-group">
                <input type="text" name="username" placeholder="Username" required>
            </div>
            <div class="form-group">
                <input type="password" name="password" placeholder="Password" required>
            </div>
            <button type="submit">Login</button>
            <p>No account? <a href="register.php">Register here</a></p>
        </form>
        
        <!-- Panda Elements -->
        <div class="ear-l"></div>
        <div class="ear-r"></div>
        <div class="panda-face">
            <div class="blush-l"></div>
            <div class="blush-r"></div>
            <div class="eye-l">
                <div class="eyeball-l"></div>
            </div>
            <div class="eye-r">
                <div class="eyeball-r"></div>
            </div>
            <div class="nose"></div>
            <div class="mouth"></div>
        </div>
        <div class="hand-l"></div>
        <div class="hand-r"></div>
        <div class="paw-l"></div>
        <div class="paw-r"></div>
    </div>
    
    <script src="assets/js/script.js"></script>
    <script>
        // Panda animation - added after your original script loads
        document.addEventListener('DOMContentLoaded', function() {
            let usernameRef = document.querySelector('input[name="username"]');
            let passwordRef = document.querySelector('input[name="password"]');
            let eyeL = document.querySelector(".eyeball-l");
            let eyeR = document.querySelector(".eyeball-r");
            let handL = document.querySelector(".hand-l");
            let handR = document.querySelector(".hand-r");

            if (!usernameRef || !passwordRef || !eyeL || !eyeR || !handL || !handR) return;

            let normalEyeStyle = () => {
                eyeL.style.cssText = `
                    left:0.6em;
                    top: 0.6em;
                `;
                eyeR.style.cssText = `
                    right:0.6em;
                    top:0.6em;
                `;
            };

            let normalHandStyle = () => {
                handL.style.cssText = `
                    height: 2.81em;
                    top:8.4em;
                    left: calc(50% - 8em);
                    transform: rotate(0deg);
                `;
                handR.style.cssText = `
                    height: 2.81em;
                    top: 8.4em;
                    left: calc(50% + 5.5em);
                    transform: rotate(0deg)
                `;
            };

            // When clicked on username input
            usernameRef.addEventListener("focus", () => {
                eyeL.style.cssText = `
                    left: 0.75em;
                    top: 1.12em;  
                `;
                eyeR.style.cssText = `
                    right: 0.75em;
                    top: 1.12em;
                `;
                normalHandStyle();
            });

            // When clicked on password input
            passwordRef.addEventListener("focus", () => {
                handL.style.cssText = `
                    height: 6.56em;
                    top: 3.87em;
                    left: calc(43% - 1.25em);
                    transform: rotate(-155deg);    
                `;
                handR.style.cssText = `
                    height: 6.56em;
                    top: 3.87em;
                    left: calc(57% - 1.25em);
                    transform: rotate(155deg);
                `;
                normalEyeStyle();
            });

            // When clicked outside username and password input
            document.addEventListener("click", (e) => {
                let clickedElem = e.target;
                if (clickedElem != usernameRef && clickedElem != passwordRef) {
                    normalEyeStyle();
                    normalHandStyle();
                }
            });
        });
    </script>
</body>
</html>