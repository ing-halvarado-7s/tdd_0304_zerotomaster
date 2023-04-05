<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Video;

class VideosController extends Controller
{
    /* obtener un video */
    public function show(Video $video){
        return $video;
    }

    /* obtener un listado de videos */
    public function index(){
        return Video::orderBy('created_at','desc')->get()
        ->map(function(Video $video){
            return[
                'id' => $video->id,
                'thumbnail' => $video->thumbnail,
            ];
        });
    }
}
