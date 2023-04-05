<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;
use App\Models\Video;
use Carbon\Carbon;

class SePuedeObtenerUnListadoDeVideosTest extends TestCase
{
    use RefreshDatabase;

   public function testSepuedeObtenerListado(){
       //Crear dos videos
       Video::factory()->count(2)->create();

       //Llamamos a la API para listar videos
        $this->getJson('/api/videos')
        ->assertOk()
        ->assertJsonCount(2);//Si devuelve dos videos
        

   }
   public function testSiVideosDevuelvenIdThumbnail(){
       /* //Crear dos videos 
       //Lo que hacia en este escaenario:
       //testElPayloadContieneLosVideosEnSistema
       $vid = Video::factory()->count(2)->create();

       //Llamamos a la API para listar videos
        $this->getJson('/api/videos')
        ->assertJson($vid->toArray());//Validar si los videos creados est'an en la lista
 */

    //Refactorizar, para solo devolver el id y el thumnails
    $unId = '123456';
    $unThumbnail = "https://unaimagen.com";
    Video::factory()->create([
        'id'=> $unId,
        'thumbnail'=> $unThumbnail
    ]);
    $this->getJson('/api/videos')
        ->assertJson([
            ['id'=> $unId,
            'thumbnail'=> $unThumbnail
            ],
        ]); 
   }

   public function testLosVideosOrdenadosNuevoAViejo(){
       //Crear video de fecha hace un mes
       $videoHaceUnMes = Video::factory()->create([
           'created_at' => Carbon::now()->subDays(30)
       ]);
       //Crear video de fecha hoy
       $videoHoy = Video::factory()->create([
           'created_at' => Carbon::now()
       ]);
       //Crear video de fecha ayer
       $videoAyer = Video::factory()->create([
           'created_at' => Carbon::yesterday()
       ]);

       /*-
       //Manera 1 de hacerlo
       $response = $this->getJson('/api/videos');
        
       [$videoPrimero, $videoSegundo, $videoTercero] = $response->Json();
       
       //Hoy
       $this->assertEquals($videoHoy['id'], $videoPrimero['id']);
       //Ayer
       $this->assertEquals($videoAyer['id'], $videoSegundo['id']);
       //Hace un mes
       $this->assertEquals($videoHaceUnMes['id'], $videoTercero['id']); */ 
       //Refactorizaci'on del c'odigo del test
       $this->getJson('/api/videos')
       ->assertJsonPath('0.id', $videoHoy->id)//Path es la direcci'on el elemento en el arreglo.nombreColumna
       ->assertJsonPath('1.id', $videoAyer->id)
       ->assertJsonPath('2.id', $videoHaceUnMes->id);

   }
}
