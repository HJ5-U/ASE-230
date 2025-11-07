<?php

namespace Database\Seeders;

use App\Models\Student;
use Illuminate\Database\Seeder;

/**
 * Student Database Seeder
 * 
 * Teaching Points:
 * 1. Seeders provide sample data for testing and development
 * 2. Demonstrate Model::create() with multiple records
 * 3. Show realistic student data for university system
 * 
 * Usage:
 * php artisan db:seed --class=StudentSeeder
 * OR
 * php artisan db:seed (if registered in DatabaseSeeder)
 */
class StudentSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Sample students data
        $students = [
            [
                'name' => 'John Doe',
                'course' => 'CIT 230',
                'major' => 'Computer Science',
                'year' => 2
            ],
            [
                'name' => 'Jane Smith',
                'course' => 'MATH 150',
                'major' => 'Mathematics',
                'year' => 3
            ],
            [
                'name' => 'Bob Johnson',
                'course' => 'PHYS 101',
                'major' => 'Physics',
                'year' => 1
            ],
            [
                'name' => 'Alice Brown',
                'course' => 'CHEM 210',
                'major' => 'Chemistry',
                'year' => 4
            ],
            [
                'name' => 'Charlie Wilson',
                'course' => 'ASU 101',
                'major' => 'Computer Science',
                'year' => 2
            ],
            [
                'name' => 'Diana Davis',
                'course' => 'BIO 120',
                'major' => 'Biology',
                'year' => 3
            ],
            [
                'name' => 'Eva Martinez',
                'course' => 'ENGR 200',
                'major' => 'Engineering',
                'year' => 1
            ],
            [
                'name' => 'Frank Garcia',
                'course' => 'MATH 250',
                'major' => 'Mathematics',
                'year' => 4
            ]
        ];

        // Create students in database
        foreach ($students as $studentData) {
            Student::create($studentData);
        }

        // Alternative method: Using Model::insert() for bulk insertion
        // Student::insert($students); // Note: This won't trigger model events or fill timestamps
        
        echo "✅ Created " . count($students) . " sample students\n";
    }
}
