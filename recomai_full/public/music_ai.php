<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>MusicAI by RecomAI</title>
        <link rel="stylesheet" href="music_ai.css">
    </head>
    <body>
        <?php include 'navbar.php' ?>
        <div class="container">
            <div class="title">MusicAI</div>
            <input type="text" id="searchInput" placeholder="Şarkı veya sanatçı ara...">
            <ul id="suggestions"></ul>
        </div>
        <div class="recommendations-container hidden" id="recommendationsContainer"> 
            <div class="title">Önerilen Şarkılar</div>
            <ul id="recommendations"></ul>
        </div>

        <div id="space" style="display: block;">
                <p>&nbsp</p><p>&nbsp</p><p>&nbsp</p><p>&nbsp</p><p>&nbsp</p>
                <p>&nbsp</p><p>&nbsp</p><p>&nbsp</p>
        </div>

        <?php include 'footer.php' ?>
        <script src="music_ai.js"></script>
    </body>
</html>
