<!DOCTYPE html>
<html>
    <head>
        <meta charset="utf-8">
        <meta name="author" content="Bruno Dzikowski">
        <meta name="viewport" content="width=device-width,initial-scale=1">
        <title>Beatmap</title>
        <!-- styles -->
        <link rel="stylesheet" href="public/style/reset.css">
        <link rel="stylesheet" href="public/libs/ol.css" type="text/css">
        <link href="https://fonts.googleapis.com/icon?family=Material+Icons"rel="stylesheet">
        <link rel="stylesheet" href="public/style/index.css">
    </head>
    <body>
        <header class="header">
            <a class="logout" href="logout"><span class="material-icons">exit_to_app</span> Logout</a>
            <h1 class="logo">Beatmap</h1>
        </header>
        <div class="main">
            <div class="map" id="map"></div>
            <div class="pin-viewer">
                <div class="lonlat-header">Could not find coordinates</div>
                <div class="pin-data">
                    <img class="track-image">
                    <div class="pin-desc">
                        <h1 class="track-name"></h1>
                        <p class="track-artists"></p>
                        <p class="pin-author">pin by <span class="app-user-name"></span></p>
                        <div class="pin-likes">
                            <span class="material-icons">favorite_border</span>
                            <span class="pin-no-likes"></span>
                        </div>
                        <div class="pin-dislikes">
                            <span class="material-icons">sentiment_very_dissatisfied</span>
                            <span class="pin-no-dislikes"></span>
                        </div>
                    </div>
                </div>
                <div class="button-box">
                    <div class="button pin-like"><span class="material-icons">favorite_border</span></div>
                    <div class="button pin-dislike"><span class="material-icons">sentiment_very_dissatisfied</span></div>
                    <div class="button pin-open"><a class="spotify-link" target="_blank">Open in spotify</a></div>
                    <div class="button pin-save">Save</div>
                </div>
            </div>
            <div class="pin-creator">
                <div class="lonlat-header">Could not find coordinates</div>
                <div class="box-header">
                    <h1 class="box-title">
                        Create a new pin
                    </h1>
                    <p class="box-desc">
                        Choose a song from Spotify to be available for other users as a pin on the map:
                    </p>
                </div><div class="searchbox">
                    <input type="search" id="track-search" name="track-search" spellcheck="false" autocomplete="off">
                </div>
                <div class="track-list" id="test-scroller"></div>
                <div class="button-box">
                    <div class="button pin-create">Create</div>
                    <div class="button cancel-create">Cancel</div>
                </div>
            </div>
        </div>
        <script src="https://cdn.jsdelivr.net/gh/openlayers/openlayers.github.io@master/en/v6.5.0/build/ol.js"></script>
        <script src="public/script/pin.js" type="text/javascript"></script>
        <script src="public/script/map.js" type="text/javascript"></script>
        <script src="public/script/track.js" type="text/javascript"></script>
        <script src="public/script/refresh.js" type="text/javascript"></script>
    </body>
</html>