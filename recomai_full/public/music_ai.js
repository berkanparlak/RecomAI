function debounce(func, wait) {
    let timeout;
    return function(...args) {
        const context = this;
        clearTimeout(timeout);
        timeout = setTimeout(() => func.apply(context, args), wait);
    };
}

document.getElementById('searchInput').addEventListener('input', debounce(function() {
    const query = this.value;
    if (query.length > 2) {
        fetchSuggestions(query);
    }
}, 300));

function fetchSuggestions(query) {
    fetch(`http://127.0.0.1:5000/api/search?q=${query}`)
        .then(response => response.json())
        .then(data => {
            const suggestions = data.songs;
            const suggestionsList = document.getElementById('suggestions');
            suggestionsList.innerHTML = '';
            suggestions.forEach(song => {
                const li = document.createElement('li');
                li.textContent = `${song.name} - ${song.artist}`;
                li.dataset.trackId = song.id;
                li.addEventListener('click', () => fetchRecommendations(song.id));
                suggestionsList.appendChild(li);
            });
        });
}

function fetchRecommendations(trackId) {
    fetch(`http://127.0.0.1:5000/api/recommendations?trackId=${trackId}`)
        .then(response => response.json())
        .then(data => {
            const recommendations = data.recommendations;
            const recommendationsList = document.getElementById('recommendations');
            recommendationsList.innerHTML = '';
            recommendations.forEach(track => {
                const li = document.createElement('li');
                const img = document.createElement('img');
                img.src = track.albumArt;
                const text = document.createTextNode(`${track.name} - ${track.artist}`);
                li.appendChild(img);
                li.appendChild(text);
                recommendationsList.appendChild(li);
            });

            document.getElementById('recommendationsContainer').classList.remove('hidden');
            var space = document.getElementById('space');
            space.style.display = "none";
        });
}