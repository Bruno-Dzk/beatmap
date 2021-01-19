<!DOCTYPE html>
<html>
    <head>
        <meta charset="utf-8">
        <meta name="author" content="Bruno Dzikowski">
        <meta name="viewport" content="width=device-width,initial-scale=1">
        <link rel="stylesheet" href="public/style/reset.css" type="text/css">
        <link rel="stylesheet" href="public/style/common.css" type="text/css">
        <link rel="stylesheet" href="public/style/sign.css" type="text/css">
        <title>Beatmap</title>
    </head>
    <body>
        <div class="main">
            <h1 class="logo">Beatmap</h1>
            <form action="register" method="POST">
                <div class="labeled-input">
                    <label>Username</label>
                    <input type="text" name="username" id="username" autocomplete="false"autocomplete="chrome-off">
                </div>
                <div class="labeled-input">
                    <label>Password</label>
                    <input type="password" name="password" id="password" autocomplete="false"autocomplete="chrome-off">
                </div>
                <div class="labeled-input">
                    <label>Repeat password</label>
                    <input type="password" name="repeatedPassword" id="repeated_password" autocomplete="false" autocomplete="chrome-off">
                </div>
                <input type="submit" name="sign_up" id="sign_up" value="Sign up">
            </form>
            <div id="message">
                <?php
                if(isset($messages)){
                    foreach($messages as $message){
                        echo "<p>${message}</p>";
                    }
                }
                ?>
            </div>
        </div>     
        <div class="gradient-overlay"></div>
        <script src="public/script/validation.js" type="text/javascript"></script>
    </body>
</html>