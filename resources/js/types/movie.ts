export type Movie = {
    id: Number
    tmbd_id: Number
    media_type: String
    title: String
    original_title: String
    original_language: String
    backdrop_path: String
    backdrop_url: String
    poster_path: String
    poster_url: String
    genre_ids: Number[]
    genres?: MovieGenre[]
    release_date: String
    overview: String
    video: Boolean
    adult: Boolean
    popularity: Number
    vote_average: Number
    vote_count: Number
    created_at: String
    updated_at: String
}

export type MovieGenre = {
    id: String
    tmbd_id: String
    name: String
    movies_count?: Number
}
