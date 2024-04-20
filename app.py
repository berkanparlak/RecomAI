import streamlit as st
import pickle
import requests

movies_list = pickle.load(open("movies_list.pkl", 'rb'))
similarity = pickle.load(open("similarity_list.pkl", 'rb'))
movies_title_list = movies_list['title'].values

headers = {
    "accept": "application/json",
    "Authorization": "Bearer eyJhbGciOiJIUzI1NiJ9.eyJhdWQiOiI2ODE0OTI0MTg5ZmY5Y2Y1MjA5N2ZlYzQxYTkxMGI4YiIsInN1YiI6IjY2MWJmYjFlOWEzYzQ5MDE2Mjk0MTA1YyIsInNjb3BlcyI6WyJhcGlfcmVhZCJdLCJ2ZXJzaW9uIjoxfQ.Si7zMclLURAiin0ulKcWnpk1I1pF-yKF_tF6qiHUXNo"
}

st.header("Movie Recommender System")
selected_value = st.selectbox("Select movie from dropdown", movies_title_list)

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
    index = movies_list[movies_list['title']==movies].index[0]
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

if st.button("Show Reccommend"):
    movie_name, movie_poster, movie_overview = recommend(selected_value)
    
    colm1,colm2 = st.columns([1,3])
    with colm1:
       st.image(movie_poster[0])
    with colm2:
        st.header(movie_name[0])
        st.write(movie_overview[0])
        
    colm1,colm2 = st.columns([1,3])
    with colm1:
        st.image(movie_poster[1])
    with colm2:
        st.header(movie_name[1])
        st.write(movie_overview[1])

    colm1,colm2 = st.columns([1,3])
    with colm1:
        st.image(movie_poster[2])
    with colm2:
        st.header(movie_name[2])
        st.write(movie_overview[2])

    colm1,colm2 = st.columns([1,3])
    with colm1:
        st.image(movie_poster[3])
    with colm2:
        st.header(movie_name[3])
        st.write(movie_overview[3])
            
    colm1,colm2 = st.columns([1,3])
    with colm1:
        st.image(movie_poster[4])
    with colm2:
        st.header(movie_name[4])
        st.write(movie_overview[4])