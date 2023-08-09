<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;
use App\Models\Role;



class RoleSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */

   
    public function run()
    {
         
    $roles= [
        [
            'role_name' => 'SuperAdmin',
            'slug'=>Str::slug('SuperAdmin'),
         ],
        [
            'role_name' => 'Admin',
            'slug'=>Str::slug('Admin '),
        ],
      
        [
            'role_name' => 'Developer',
            'slug'=>Str::slug('Developer'),

        ],
        [
            'role_name' => 'Trainer',
            'slug'=>Str::slug('Trainer'),

        ],
        [
            'role_name' => 'Gymer',
            'slug'=>Str::slug('Gymer'),

        ],
      
    ];

    foreach ($roles as $key => $role) {
        Role::create($role);
    }

    }
}
