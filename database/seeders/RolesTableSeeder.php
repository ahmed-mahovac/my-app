<?php

namespace Database\Seeders;

use App\Models\Role;
use Illuminate\Database\Seeder;

class RolesTableSeeder extends Seeder {
    public function run(){
        Role::create(['name' => 'admin']);
        Role::create(['name' => 'user']);
    }
}