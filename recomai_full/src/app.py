from flask import Flask, request, jsonify, render_template
from flask_cors import CORS
import pandas as pd
import numpy as np
import requests
import pickle
import base64

app = Flask(__name__)
CORS(app)

movies_list = pickle.load(open("movies_list.pkl", 'rb'))
similarity = pickle.load(open("similarity_list.pkl", 'rb'))
movies_title_list = movies_list['title'].values

headers = {
    "accept": "application/json",
    "Authorization": "YOUR_API"
}

def get_movies_as_json():
    movies_json = movies_list[['id', 'title']].to_json(orient='records')
    return movies_json

def fetch_poster(movie_id):
    url = "https://api.themoviedb.org/3/movie/{}".format(movie_id)
    data = requests.get(url, headers=headers)
    data=data.json()
    path = data['poster_path']
    poster_path = "https://image.tmdb.org/t/p/w500"+ path
    return poster_path

def get_overview(movie_id):
    url = "https://api.themoviedb.org/3/movie/{}".format(movie_id)
    data = requests.get(url, headers=headers)
    data=data.json()
    overview = data['overview']
    return overview
    
def recommend(movies):
    index = movies_list[movies_list['id']==movies].index[0]
    distance = sorted(list(enumerate(similarity[index])), reverse=True, key= lambda vector:vector[1])
    recommend_movies=[]
    recommend_poster=[]
    recommend_overview=[]
    for i in distance[1:6]:
        movies_id = movies_list.iloc[i[0]].id
        recommend_movies.append(movies_list.iloc[i[0]].title)
        recommend_poster.append(fetch_poster(movies_id))
        recommend_overview.append(get_overview(movies_id))
        

    return recommend_movies, recommend_poster, recommend_overview

@app.route('/movies', methods=['GET'])
def get_movies():
    movies_json = get_movies_as_json()
    return jsonify({'movies': movies_json})

@app.route('/recommend/<int:recommend_id>', methods=['GET'])
def get_recommendation(recommend_id):
    movie_name, movie_poster, movie_overview = recommend(recommend_id)
    
    recommendation_data = {
        "movie_name": movie_name,
        "movie_poster": movie_poster,
        "movie_overview": movie_overview
    }
    
    return jsonify(recommendation_data)


CLIENT_ID = 'xxx'
CLIENT_SECRET = 'xxx'

def get_token():
    token_url = 'https://accounts.spotify.com/api/token'
    token_data = {
        'grant_type': 'client_credentials'
    }
    token_headers = {
        'Authorization': 'Basic ' + base64.b64encode(f"{CLIENT_ID}:{CLIENT_SECRET}".encode()).decode(),
        'Content-Type': 'application/x-www-form-urlencoded'
    }

    response = requests.post(token_url, data=token_data, headers=token_headers)
    if response.status_code == 200:
        return response.json().get('access_token')
    else:
        return None

@app.route('/api/search', methods=['GET'])
def search():
    query = request.args.get('q')
    token = get_token()
    if not token:
        return jsonify({'error': 'Unable to get access token'}), 500

    search_url = 'https://api.spotify.com/v1/search'
    headers = {
        'Authorization': f'Bearer {token}'
    }
    params = {
        'q': query,
        'type': 'track',
        'limit': 5
    }

    response = requests.get(search_url, headers=headers, params=params)
    if response.status_code == 200:
        tracks = response.json().get('tracks', {}).get('items', [])
        songs = [{'id': track['id'], 'name': track['name'], 'artist': track['artists'][0]['name']} for track in tracks]
        return jsonify({'songs': songs})
    else:
        return jsonify({'error': 'No tracks found'}), 500

@app.route('/api/recommendations', methods=['GET'])
def recommendations():
    track_id = request.args.get('trackId')
    token = get_token()
    if not token:
        return jsonify({'error': 'Unable to get access token'}), 500

    rec_url = 'https://api.spotify.com/v1/recommendations'
    headers = {
        'Authorization': f'Bearer {token}'
    }
    params = {
        'seed_tracks': track_id,
        'limit': 5
    }

    response = requests.get(rec_url, headers=headers, params=params)
    if response.status_code == 200:
        tracks = response.json().get('tracks', [])
        recommendations = [{'name': track['name'], 'artist': track['artists'][0]['name'], 'albumArt': track['album']['images'][0]['url']} for track in tracks]
        return jsonify({'recommendations': recommendations})
    else:
        return jsonify({'error': 'No recommendations found'}), 500


if __name__ == '__main__':
    app.run(debug=True)
