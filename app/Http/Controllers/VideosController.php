<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Video;

class VideosController extends Controller
{
    /* obtener un video */
    public function getOne(Video $video){
        return $video;
    }
}
