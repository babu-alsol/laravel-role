<?php

namespace Database\Seeders;

use App\User;
use App\Models\Category;
use Faker\Factory as Faker;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class demo extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        
        $faker = Faker::create();

        foreach(range (1, 100) as $value){
            DB::table('posts')->insert([
                'user_id' => 1,
                'category_id' => Category::pluck('id')[$faker->numberBetween(1,Category::count()-1)],
                'title' => $faker->name(),
                'description' => $faker->paragraph(),
                
            ]);
        }
    
    }
}
