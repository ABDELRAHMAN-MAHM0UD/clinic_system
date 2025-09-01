<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class DoctorSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('doctors')->insert([
            [
                'name' => 'Dr. Ahmed Mohammed',
                'specialization' => 'Cardiologist',
                'email' => 'ahmed.mohammed@gmail.com',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'name' => 'Dr. Mariam Mohammed',
                'specialization' => 'Dermatologist',
                'email' => 'mariam.mohammed@gmail.com',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'name' => 'Dr. Sara Ali',
                'specialization' => 'Neurologist',
                'email' => 'sara.ali@gmail.com',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'name' => 'Dr. Sara Hassan',
                'specialization' => 'Pediatrician',
                'email' => 'sara.hassan@gmail.com',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'name' => 'Dr. Leyla Ahmed',
                'specialization' => 'Pediatrician',
                'email' => 'leyla.ahmed@gmail.com',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'name' => 'Dr. Omar Khalid',
                'specialization' => 'Orthopedic Surgeon',
                'email' => 'omar.khalid@gmail.com',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'name' => 'Dr. Fatima ',
                'specialization' => 'Gynecologist',
                'email' => 'fatima.f@gmail.com',
                'created_at' => now(),
                'updated_at' => now(),
            ],
        
        ]);
        
        $this->command->info('Doctors seed data inserted successfully!');
        
    }
}
