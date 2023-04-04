<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;
use App\Models\Video;


class SePuedeObtenerUnVideoTest extends TestCase
{
    /**
     * A basic feature test example.
     */
    public function testSePuedeObtenerUnVideoTest()
    {
        //CREAR EL ESCENARIO

        //Crear un video en la base de datos
        factory(Video::class)->create([
            'id' => 1,
            'titulo' => 'Mi titulo',
            'descripcion' => 'Mi descripcion',
            'url_video' => 'https://www.youtube.com/hma0608'
            
        ]);

        //Llamar al API para pedir ese video
        $respuesta = $this->get('api/videos/1');

        //Comprobar que se nos devuelve el video
        $respuesta->assertJsonFragment([
            'id' => 1,
            'titulo' => 'Mi titulo',
            'descripcion' => 'Mi descripcion',
            'url_video' => 'https://www.youtube.com/hma0608'
            
        ]);
    }
}
