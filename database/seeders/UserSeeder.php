<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;
use App\Models\User;
use App\Models\Gender;
use App\Models\Bloodtype;
use App\Models\Shift;


class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */

    public function run()
    {
        $users = [
            [
                'name'=>'SuperAdmin User',
                'email'=>'superadmin@gmail.com',
                'role'=> 1,
                'pass_name'=>'password',
                'password' => Hash::make('password'),
                'slug'=> rand(1,9999),
            ],
            [
                'name'=>'Admin User',
                'email'=>'admin@gmail.com',
                'role'=>2,
                'pass_name'=>'password',
                'password' => Hash::make('password'),
                'slug'=> rand(1,9999),
            ],

                   
        ];

        foreach ($users as $key => $user) {
            User::create($user);
        }

       $genders = [
            [
                'name' => 'Male',
                'slug' => 'male',
            ],
            [
                'name' => 'Female',
                'slug' => 'female',
            ],
        ];
        
        foreach ($genders as $key => $gender) {
            Gender::create($gender);
        }

        $blood_types = [
         [
            'name' => 'A+',
            'slug' => 'a+',
        ],
        [
        'name' => 'B+',
        'slug' => 'b+',
        ],
        [
        'name' => 'A-',
        'slug' => 'a-',
        ],
        [
        'name' => 'B-',
        'slug' => 'b-',
        ],
        [
        'name' => 'O+',
        'slug' => 'o+',
        ],
        [
        'name' => 'O-',
        'slug' => 'o-',
        ],
        [
        'name' => 'AB+',
        'slug' => 'ab+',
        ],
        [
        'name' => 'AB-',
        'slug' => 'ab-',
        ],
        [
        'name' => 'No',
        'slug' => 'no',
        ],
    ];
    foreach ($blood_types as $key => $blood_type) {
        Bloodtype::create($blood_type);
    }
   
    $shifts = 
    [
        [
            'shift_name'=>'morning',
            'starttime'=> '06:00',
            'endtime'=> '07:00',
            'slug'=>rand(1,99999999),
        ],
        [
            'shift_name'=>'evening',
            'starttime'=> '',
            'endtime'=> '',
            'slug'=>rand(1,99999999),
        ],
        [
            'shift_name'=>'night',
            'starttime'=> '',
            'endtime'=> '',
            'slug'=>rand(1,99999999),
        ],
    ];
    foreach($shifts as $key => $shift){
        Shift::create($shift);
    }
    }
}
