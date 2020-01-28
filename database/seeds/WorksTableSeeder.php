<?php

use Carbon\Carbon;
use Illuminate\Database\Seeder;

class WorksTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        for($i=0;$i<10;$i++){
            $type_id = rand(1,2);
            if($type_id === 1){
                DB::table('works')->insert([
                    'title' => 'work_single'.rand(0,10),
                    'type_id' => 1,
                    'single_price_min' => 10000,
                    'single_price_max' => 20000,
                    'user_id' => rand(1,10),
                    'detail' => 'detaildetaildetaildetaildetaildetaildetail',
                    'created_at' => Carbon::now(),
                    'updated_at' => Carbon::now()
                ]);
            }else if($type_id === 2){
                DB::table('works')->insert([
                    'title' => 'work_revsh'.rand(0,10),
                    'type_id' => $type_id,
                    'revenue_share_price' => 50000,
                    'user_id' => rand(1,10),
                    'detail' => 'detaildetaildetaildetaildetaildetaildetail',
                    'created_at' => Carbon::now(),
                    'updated_at' => Carbon::now()
                ]);
            }
            
        }
    }
}
