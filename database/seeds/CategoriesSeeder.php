<?php

use App\Category;
use Illuminate\Database\Seeder;

class CategoriesSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        //

        Category::create([
            'name'=>'High Tech',
            'slug'=>'high-tech'
        ]);
        Category::create([
            'name'=>'Livres',
            'slug'=>'livers'
        ]);
        Category::create([
            'name'=>'Meubles',
            'slug'=>'meubmes'
        ]);
        Category::create([
            'name'=>'Jeux',
            'slug'=>'jeux'
        ]);
        Category::create([
            'name'=>'Nourriture',
            'slug'=>'nourriture'
        ]);

    }
}
