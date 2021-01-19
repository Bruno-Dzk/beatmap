<!DOCTYPE html>
<html>
    <head>
        <meta charset="utf-8">
        <meta name="author" content="Bruno Dzikowski">
        <meta name="viewport" content="width=device-width,initial-scale=1">
        <link rel="stylesheet" href="public/style/reset.css" type="text/css">
        <link rel="stylesheet" href="public/style/sign.css" type="text/css">
        <title>Beatmap</title>
    </head>
    <body>
        <div class="main">
            <h1 class="logo">Beatmap</h1>
            <form action="login" method="POST" id="login_form">
                <div class="labeled-input">
                    <label>Email</label>
                    <input type="text" name="email" id="email" autocomplete="false"autocomplete="chrome-off" required>
                </div>
                <div class="labeled-input">
                    <label>Password</label>
                    <input type="password" name="password" id="password" autocomplete="false">
                </div>
                <input type="submit" name="sign_in" id="sign_in" value="Sign in">
                <a id="register_link" href="register">Sign up</a>
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
    </body>
</html>