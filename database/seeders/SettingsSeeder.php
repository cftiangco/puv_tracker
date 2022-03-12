<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use App\Models\Role;
use App\Models\Admin;
use App\Models\CardStatus;
use App\Models\DriverStatus;
use App\Models\RoleStatus;
use App\Models\PassengerStatus;
use App\Models\ScheduleStatus;
use App\Models\UserStatus;
use App\Models\TripPassengerStatus;

class SettingsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
      Role::insert([
        ['description' => 'Admin'],
        ['description' => 'User'],
      ]);

      Admin::create([
        'last_name' => 'admin',
        'first_name' => 'admin',
        'middle_name' => 'admin',
        'role_id' => 1,
        'status_id' => 1,
        'username' => 'admin',
        'password' => Hash::make('admin')
      ]);

      CardStatus::insert([
        ['description' => 'Active'],
        ['description' => 'Inactive'],
      ]);

      DriverStatus::insert([
        ['description' => 'Active'],
        ['description' => 'Inactive'],
      ]);

      PassengerStatus::insert([
        ['description' => 'Active'],
        ['description' => 'Inactive'],
      ]);

      ScheduleStatus::insert([
        ['description' => 'Active'],
        ['description' => 'Inactive'],
      ]);

      UserStatus::insert([
        ['description' => 'Active'],
        ['description' => 'Inactive'],
      ]);

      TripPassengerStatus::insert([
        ['description' => 'Active'],
        ['description' => 'Completed'],
        ['description' => 'Cancelled'],
      ]);

    }
}
