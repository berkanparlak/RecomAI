function getRecommendation() {
    var select = document.getElementById("movies");
    var selectedMovie = select.options[select.selectedIndex].value;

    var xhr = new XMLHttpRequest();
    xhr.open("GET", "http://127.0.0.1:5000/recommend/" + selectedMovie);
    xhr.onreadystatechange = function () {
        if (xhr.readyState === 4 && xhr.status === 200) {
            var response = JSON.parse(xhr.responseText);
            displayRecommendation(response);
        }
    };
    xhr.send();
}

function displayRecommendation(recommendation) {

    var recommends = document.getElementById("recommends");
    recommends.style.display = 'block';

    var space = document.getElementById("space");
    space.style.display = 'none';

    var title1 = document.getElementById("title1");
    var title2 = document.getElementById("title2");
    var title3 = document.getElementById("title3");
    var title4 = document.getElementById("title4");

    var text1 = document.getElementById("text1");
    var text2 = document.getElementById("text2");
    var text3 = document.getElementById("text3");
    var text4 = document.getElementById("text4");

    var img1 = document.getElementById("img1");
    var img2 = document.getElementById("img2");
    var img3 = document.getElementById("img3");
    var img4 = document.getElementById("img4");

    title1.innerText = recommendation.movie_name[0];
    text1.innerText = recommendation.movie_overview[0];
    img1.src = recommendation.movie_poster[0];

    title2.innerText = recommendation.movie_name[1];
    text2.innerText = recommendation.movie_overview[1];
    img2.src = recommendation.movie_poster[1];

    title3.innerText = recommendation.movie_name[2];
    text3.innerText = recommendation.movie_overview[2];
    img3.src = recommendation.movie_poster[2];

    title4.innerText = recommendation.movie_name[3];
    text4.innerText = recommendation.movie_overview[3];
    img4.src = recommendation.movie_poster[3];
}

// Populate select options with movies
var moviesSelect = document.getElementById("movies");
fetch("http://127.0.0.1:5000/movies")
    .then(response => response.json())
    .then(data => {
        var movies = JSON.parse(data.movies);
        movies.forEach(movie => {
            var option = document.createElement("option");
            option.text = movie.title;
            option.value = movie.id;
            moviesSelect.add(option);
        });
    });