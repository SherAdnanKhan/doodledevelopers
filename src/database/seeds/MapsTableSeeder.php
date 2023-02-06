<?php

use App\Models\Map;
use Illuminate\Database\Seeder;

class MapsTableSeeder extends Seeder
{

    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        if (!Map::exists()) {
            $mapJson1 = '{"data": {"ball_radius":0.2,"ball_color":"#00ffff","wall_color":"#ff0000","block_width":1,"block_height":1,"board_width":9,"board_height":29,"blocks":[{"id":91,"x":4.5,"y":26.5,"color_image":"yellow","total_hp":30,"points_per_hit":10,"points_per_destruction":25},{"id":92,"x":3.5,"y":25.5,"color_image":"yellow","total_hp":30,"points_per_hit":10,"points_per_destruction":25},{"id":93,"x":5.5,"y":25.5,"color_image":"yellow","total_hp":30,"points_per_hit":10,"points_per_destruction":25},{"id":94,"x":2.5,"y":24.5,"color_image":"yellow","total_hp":30,"points_per_hit":10,"points_per_destruction":25},{"id":95,"x":1.5,"y":23.5,"color_image":"yellow","total_hp":30,"points_per_hit":10,"points_per_destruction":25},{"id":96,"x":6.5,"y":24.5,"color_image":"yellow","total_hp":30,"points_per_hit":10,"points_per_destruction":25},{"id":97,"x":7.5,"y":23.5,"color_image":"yellow","total_hp":30,"points_per_hit":10,"points_per_destruction":25},{"id":102,"x":3.5,"y":14.5,"color_image":"yellow","total_hp":30,"points_per_hit":10,"points_per_destruction":25},{"id":103,"x":4.5,"y":13.5,"color_image":"yellow","total_hp":30,"points_per_hit":10,"points_per_destruction":25},{"id":104,"x":5.5,"y":14.5,"color_image":"yellow","total_hp":30,"points_per_hit":10,"points_per_destruction":25},{"id":105,"x":0.5,"y":10.5,"color_image":"yellow","total_hp":30,"points_per_hit":10,"points_per_destruction":25},{"id":106,"x":1.5,"y":9.5,"color_image":"yellow","total_hp":30,"points_per_hit":10,"points_per_destruction":25},{"id":107,"x":1.5,"y":8.5,"color_image":"yellow","total_hp":30,"points_per_hit":10,"points_per_destruction":25},{"id":108,"x":0.5,"y":7.5,"color_image":"yellow","total_hp":30,"points_per_hit":10,"points_per_destruction":25},{"id":111,"x":3.5,"y":4.5,"color_image":"yellow","total_hp":30,"points_per_hit":10,"points_per_destruction":25},{"id":112,"x":5.5,"y":4.5,"color_image":"yellow","total_hp":30,"points_per_hit":10,"points_per_destruction":25},{"id":113,"x":0.5,"y":2.5,"color_image":"yellow","total_hp":30,"points_per_hit":10,"points_per_destruction":25},{"id":114,"x":8.5,"y":2.5,"color_image":"yellow","total_hp":30,"points_per_hit":10,"points_per_destruction":25},{"id":115,"x":8.5,"y":7.5,"color_image":"yellow","total_hp":30,"points_per_hit":10,"points_per_destruction":25},{"id":116,"x":7.5,"y":8.5,"color_image":"yellow","total_hp":30,"points_per_hit":10,"points_per_destruction":25},{"id":117,"x":7.5,"y":9.5,"color_image":"yellow","total_hp":30,"points_per_hit":10,"points_per_destruction":25},{"id":118,"x":8.5,"y":10.5,"color_image":"yellow","total_hp":30,"points_per_hit":10,"points_per_destruction":25},{"id":119,"x":4.5,"y":4.5,"color_image":"red","total_hp":90,"points_per_hit":10,"points_per_destruction":25},{"id":120,"x":8.5,"y":8.5,"color_image":"red","total_hp":90,"points_per_hit":10,"points_per_destruction":25},{"id":121,"x":8.5,"y":9.5,"color_image":"red","total_hp":90,"points_per_hit":10,"points_per_destruction":25},{"id":122,"x":0.5,"y":9.5,"color_image":"red","total_hp":90,"points_per_hit":10,"points_per_destruction":25},{"id":123,"x":0.5,"y":8.5,"color_image":"red","total_hp":90,"points_per_hit":10,"points_per_destruction":25},{"id":124,"x":4.5,"y":14.5,"color_image":"red","total_hp":90,"points_per_hit":10,"points_per_destruction":25},{"id":125,"x":2.5,"y":23.5,"color_image":"red","total_hp":90,"points_per_hit":10,"points_per_destruction":25},{"id":126,"x":4.5,"y":25.5,"color_image":"red","total_hp":90,"points_per_hit":10,"points_per_destruction":25},{"id":127,"x":6.5,"y":23.5,"color_image":"red","total_hp":90,"points_per_hit":10,"points_per_destruction":25},{"id":130,"x":0.5,"y":20.5,"color_image":"green","total_hp":150,"points_per_hit":10,"points_per_destruction":25},{"id":131,"x":0.5,"y":18.5,"color_image":"green","total_hp":150,"points_per_hit":10,"points_per_destruction":25},{"id":132,"x":8.5,"y":20.5,"color_image":"green","total_hp":150,"points_per_hit":10,"points_per_destruction":25},{"id":133,"x":8.5,"y":18.5,"color_image":"green","total_hp":150,"points_per_hit":10,"points_per_destruction":25},{"id":134,"x":3.5,"y":19.5,"color_image":"blue","total_hp":240,"points_per_hit":10,"points_per_destruction":25},{"id":135,"x":5.5,"y":19.5,"color_image":"blue","total_hp":240,"points_per_hit":10,"points_per_destruction":25},{"id":136,"x":7.5,"y":19.5,"color_image":"red","total_hp":90,"points_per_hit":10,"points_per_destruction":25},{"id":137,"x":1.5,"y":19.5,"color_image":"red","total_hp":90,"points_per_hit":10,"points_per_destruction":25},{"id":138,"x":4.5,"y":15.5,"color_image":"blue","total_hp":240,"points_per_hit":10,"points_per_destruction":25},{"id":139,"x":4.5,"y":5.5,"color_image":"blue","total_hp":240,"points_per_hit":10,"points_per_destruction":25}],"last_generated_id":139}}';
            $mapJson2 = '{"data": {"ball_radius":0.2,"ball_color":"#00ffff","wall_color":"#ff0000","block_width":1,"block_height":1,"board_width":9,"board_height":29,"blocks":[{"id":91,"x":4.5,"y":26.5,"color_image":"yellow","total_hp":30,"points_per_hit":10,"points_per_destruction":25},{"id":92,"x":3.5,"y":25.5,"color_image":"yellow","total_hp":30,"points_per_hit":10,"points_per_destruction":25},{"id":93,"x":5.5,"y":25.5,"color_image":"yellow","total_hp":30,"points_per_hit":10,"points_per_destruction":25},{"id":94,"x":2.5,"y":24.5,"color_image":"yellow","total_hp":30,"points_per_hit":10,"points_per_destruction":25},{"id":95,"x":1.5,"y":23.5,"color_image":"yellow","total_hp":30,"points_per_hit":10,"points_per_destruction":25},{"id":96,"x":6.5,"y":24.5,"color_image":"yellow","total_hp":30,"points_per_hit":10,"points_per_destruction":25},{"id":97,"x":7.5,"y":23.5,"color_image":"yellow","total_hp":30,"points_per_hit":10,"points_per_destruction":25},{"id":102,"x":3.5,"y":14.5,"color_image":"yellow","total_hp":30,"points_per_hit":10,"points_per_destruction":25},{"id":103,"x":4.5,"y":13.5,"color_image":"yellow","total_hp":30,"points_per_hit":10,"points_per_destruction":25},{"id":104,"x":5.5,"y":14.5,"color_image":"yellow","total_hp":30,"points_per_hit":10,"points_per_destruction":25},{"id":105,"x":0.5,"y":10.5,"color_image":"yellow","total_hp":30,"points_per_hit":10,"points_per_destruction":25},{"id":106,"x":1.5,"y":9.5,"color_image":"yellow","total_hp":30,"points_per_hit":10,"points_per_destruction":25},{"id":107,"x":1.5,"y":8.5,"color_image":"yellow","total_hp":30,"points_per_hit":10,"points_per_destruction":25},{"id":108,"x":0.5,"y":7.5,"color_image":"yellow","total_hp":30,"points_per_hit":10,"points_per_destruction":25},{"id":111,"x":3.5,"y":4.5,"color_image":"yellow","total_hp":30,"points_per_hit":10,"points_per_destruction":25},{"id":112,"x":5.5,"y":4.5,"color_image":"yellow","total_hp":30,"points_per_hit":10,"points_per_destruction":25},{"id":113,"x":0.5,"y":2.5,"color_image":"yellow","total_hp":30,"points_per_hit":10,"points_per_destruction":25},{"id":114,"x":8.5,"y":2.5,"color_image":"yellow","total_hp":30,"points_per_hit":10,"points_per_destruction":25}],"last_generated_id":139}}';
            $mapJson3 = '{"data": {"ball_radius":0.2,"ball_color":"#00ffff","wall_color":"#ff0000","block_width":1,"block_height":1,"board_width":9,"board_height":29,"blocks":[{"id":91,"x":4.5,"y":26.5,"color_image":"yellow","total_hp":30,"points_per_hit":10,"points_per_destruction":25},{"id":102,"x":3.5,"y":14.5,"color_image":"yellow","total_hp":30,"points_per_hit":10,"points_per_destruction":25},{"id":103,"x":4.5,"y":13.5,"color_image":"yellow","total_hp":30,"points_per_hit":10,"points_per_destruction":25},{"id":116,"x":7.5,"y":8.5,"color_image":"yellow","total_hp":30,"points_per_hit":10,"points_per_destruction":25},{"id":117,"x":7.5,"y":9.5,"color_image":"yellow","total_hp":30,"points_per_hit":10,"points_per_destruction":25},{"id":118,"x":8.5,"y":10.5,"color_image":"yellow","total_hp":30,"points_per_hit":10,"points_per_destruction":25},{"id":119,"x":4.5,"y":4.5,"color_image":"red","total_hp":90,"points_per_hit":10,"points_per_destruction":25},{"id":120,"x":8.5,"y":8.5,"color_image":"red","total_hp":90,"points_per_hit":10,"points_per_destruction":25},{"id":121,"x":8.5,"y":9.5,"color_image":"red","total_hp":90,"points_per_hit":10,"points_per_destruction":25},{"id":122,"x":0.5,"y":9.5,"color_image":"red","total_hp":90,"points_per_hit":10,"points_per_destruction":25},{"id":123,"x":0.5,"y":8.5,"color_image":"red","total_hp":90,"points_per_hit":10,"points_per_destruction":25},{"id":124,"x":4.5,"y":14.5,"color_image":"red","total_hp":90,"points_per_hit":10,"points_per_destruction":25},{"id":125,"x":2.5,"y":23.5,"color_image":"red","total_hp":90,"points_per_hit":10,"points_per_destruction":25},{"id":126,"x":4.5,"y":25.5,"color_image":"red","total_hp":90,"points_per_hit":10,"points_per_destruction":25},{"id":127,"x":6.5,"y":23.5,"color_image":"red","total_hp":90,"points_per_hit":10,"points_per_destruction":25},{"id":130,"x":0.5,"y":20.5,"color_image":"green","total_hp":150,"points_per_hit":10,"points_per_destruction":25},{"id":131,"x":0.5,"y":18.5,"color_image":"green","total_hp":150,"points_per_hit":10,"points_per_destruction":25},{"id":132,"x":8.5,"y":20.5,"color_image":"green","total_hp":150,"points_per_hit":10,"points_per_destruction":25},{"id":133,"x":8.5,"y":18.5,"color_image":"green","total_hp":150,"points_per_hit":10,"points_per_destruction":25},{"id":134,"x":3.5,"y":19.5,"color_image":"blue","total_hp":240,"points_per_hit":10,"points_per_destruction":25},{"id":135,"x":5.5,"y":19.5,"color_image":"blue","total_hp":240,"points_per_hit":10,"points_per_destruction":25},{"id":136,"x":7.5,"y":19.5,"color_image":"red","total_hp":90,"points_per_hit":10,"points_per_destruction":25},{"id":137,"x":1.5,"y":19.5,"color_image":"red","total_hp":90,"points_per_hit":10,"points_per_destruction":25},{"id":138,"x":4.5,"y":15.5,"color_image":"blue","total_hp":240,"points_per_hit":10,"points_per_destruction":25},{"id":139,"x":4.5,"y":5.5,"color_image":"blue","total_hp":240,"points_per_hit":10,"points_per_destruction":25}],"last_generated_id":139}}';

            $maps[] = json_decode($mapJson1, true);
            $maps[] = json_decode($mapJson2, true);
            $maps[] = json_decode($mapJson3, true);

            foreach ($maps as $map) {
                Map::create($map);
            }
        }
    }
}