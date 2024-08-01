<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Queue\Events\Looping;
use Illuminate\Support\Facades\Http;

class MovieController extends Controller
{
    public function index() 
    {
        $baseURL        = env('MOVIE_DB_BASE_URL');
        $imageBaseURL   = env('MOVIE_DB_IMAGE_BASE_URL');
        $apiKey         = env('MOVIE_DB_API_KEY');
        $max_image      = 3;
        $max_image_item = 10;

        // Mengambil/Hit API untuk banner
        $bannerResponse = Http::get("{$baseURL}/trending/movie/week", [
            'api_key' => $apiKey
        ]);

        // Persiapan variable
        $bannerArray = [];

        // check API response
        if ($bannerResponse->successful()) {
            $resultArray = $bannerResponse->object()->results;
            if(isset($resultArray)){
                // Looping data image
                foreach($resultArray as $item) {
                    array_push($bannerArray, $item);
                    if(count($bannerArray) == $max_image) {
                        break;
                    }
                }
            }
        }
        // Hit API for top 10 movie
        $loopMovieResponse = Http::get("{$baseURL}/movie/top_rated", [
            'api_key' => $apiKey,
        ]);

         // Persiapan variable top 10 movie
         $loopMovieArray = [];

         // check API response
         if ($loopMovieResponse->successful()) {
             $resultArray = $loopMovieResponse->object()->results;
             if (isset($resultArray)){
                 // Looping data image
                 foreach($resultArray as $item) {
                     array_push($loopMovieArray, $item);
                     if (count($loopMovieArray) == $max_image_item) {
                         break;
                     }
                 }
             }
         }


        return view('home', [
            'baseURL'       => $baseURL,
            'imageBaseURL'  => $imageBaseURL,
            'apiKey'        => $apiKey,
            'banner'        => $bannerArray,
            'loopMovies'    => $loopMovieArray
        ]);
    }
}
