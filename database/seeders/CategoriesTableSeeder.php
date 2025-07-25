<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class CategoriesTableSeeder extends Seeder
{

    /**
     * Auto generated seed file
     *
     * @return void
     */
    public function run()
    {
        

        \DB::table('categories')->delete();
        
        \DB::table('categories')->insert(array (
            0 => 
            array (
                'id' => 1,
                'creator_id' => 1,
                'slug' => 'iphone',
                'title' => 'iPhone',
                'created_at' => '2025-07-25 12:46:23',
                'updated_at' => '2025-07-25 12:46:23',
            ),
            1 => 
            array (
                'id' => 2,
                'creator_id' => 1,
                'slug' => 'macbook-air',
                'title' => 'MacBook Air',
                'created_at' => '2025-07-25 13:00:54',
                'updated_at' => '2025-07-25 13:00:54',
            ),
            2 => 
            array (
                'id' => 3,
                'creator_id' => 1,
                'slug' => 'macbook-pro',
                'title' => 'MacBook Pro',
                'created_at' => '2025-07-25 13:08:55',
                'updated_at' => '2025-07-25 13:08:55',
            ),
            3 => 
            array (
                'id' => 4,
                'creator_id' => 1,
                'slug' => 'imac',
                'title' => 'iMac',
                'created_at' => '2025-07-25 13:16:13',
                'updated_at' => '2025-07-25 13:16:13',
            ),
            4 => 
            array (
                'id' => 5,
                'creator_id' => 1,
                'slug' => 'mac-mini',
                'title' => 'Mac mini',
                'created_at' => '2025-07-25 13:18:36',
                'updated_at' => '2025-07-25 13:18:36',
            ),
            5 => 
            array (
                'id' => 6,
                'creator_id' => 1,
                'slug' => 'watch',
                'title' => 'Watch',
                'created_at' => '2025-07-25 13:26:23',
                'updated_at' => '2025-07-25 13:26:23',
            ),
        ));
        
        
    }
}