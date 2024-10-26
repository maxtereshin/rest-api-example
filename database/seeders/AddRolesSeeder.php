<?php

namespace Database\Seeders;

use App\Models\Role;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class AddRolesSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
       $roles = [
           'admin',
           'user',
       ];
       foreach ($roles as $role) {
           Role::create([
               'name' => $role
           ]);
       }
    }
}
