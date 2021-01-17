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
            <form action="login" method="POST">
                <div class="labeled-input">
                    <label>Username</label>
                    <input type="text" name="username" id="username" autocomplete="false">
                </div>
                <div class="labeled-input">
                    <label>Password</label>
                    <input type="password" name="password" id="password" autocomplete="false">
                </div>
                <input type="submit" name="sign_in" id="sign_in" value="Sign in">
                <button>Sign up</button>
            </form>
        </div>     
        <div class="gradient-overlay"></div>
    </body>
</html>