<?php


use App\Models\Category;
use App\User;
use Faker\Factory as Faker;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class PostSeeder extends Seeder
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
                'user_id' => User::pluck('id')[$faker->numberBetween(1,User::count()-1)],
                'category_id' => Category::pluck('id')[$faker->numberBetween(1,Category::count()-1)],
                'name' => $faker->name(),
                'description' => $faker->paragraph(),
                
            ]);
        }
    }
}
