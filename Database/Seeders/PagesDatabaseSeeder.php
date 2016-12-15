<?php

namespace Cms\Modules\Pages\Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Database\Eloquent\Model;

class PagesDatabaseSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run()
    {
        Model::unguard();

        //$this->call(__NAMESPACE__.'\');
    }
}
