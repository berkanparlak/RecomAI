<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>MovieAI</title>
    <link rel="stylesheet" href="movie_ai.css">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>
</head>
<body>

    <?php include 'navbar.php' ?>

    <div class="container">

        <div style="display: block;">
            <p>&nbsp</p><p>&nbsp</p>
        </div>

        <h1 class="MovieAI">MovieAI by RecomAI</h1>
        <form id="movieForm">
            <select id="movies" name="movies">
            </select>
            <button type="button" onclick="getRecommendation()">Recommend</button>
        </form>

        <div id="space" style="display: block;">
            <p>&nbsp</p><p>&nbsp</p><p>&nbsp</p><p>&nbsp</p><p>&nbsp</p>
            <p>&nbsp</p><p>&nbsp</p><p>&nbsp</p><p>&nbsp</p>
        </div>

        <div id="recommends"  style="display: none;">
            <div id="cardGroup" class="d-flex flex-wrap justify-content-around mt-4">
                <div class="card bg-dark text-white" id="card1" style="width: 18rem;">
                    <img class="card-img-top" id="img1" src="" alt="Card image cap">
                    <div class="card-body">
                        <h4 class="card-title" id="title1"></h4>
                        <p class="card-text text-white" id="text1"></p>
                    </div>
                </div>
                <div class="card bg-dark text-white" id="card2" style="width: 18rem;">
                    <img class="card-img-top" id="img2" src="" alt="Card image cap">
                    <div class="card-body">
                        <h4 class="card-title" id="title2"></h4>
                        <p class="card-text text-white" id="text2"></p>
                    </div>
                </div>
                <div class="card bg-dark text-white" id="card3" style="width: 18rem;">
                    <img class="card-img-top" id="img3" src="" alt="Card image cap">
                    <div class="card-body">
                        <h4 class="card-title" id="title3"></h4>
                        <p class="card-text text-white" id="text3"></p>
                    </div>
                </div>
                <div class="card bg-dark text-white" id="card4" style="width: 18rem;">
                    <img class="card-img-top" id="img4" src="" alt="Card image cap">
                    <div class="card-body">
                        <h4 class="card-title" id="title4"></h4>
                        <p class="card-text text-white" id="text4"></p>
                    </div>
                </div>
            </div>
        </div>

    </div>

    <?php include 'footer.php' ?>

    <script src="movie_ai.js"></script>
</body>
</html>