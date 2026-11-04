<?php

namespace Database\Seeders;

use App\Models\Employee;
use Illuminate\Database\Seeder;

class EmployeeSeeder extends Seeder
{
    /**
     * Seed the 10-person crew. Salaries are in USD.
     * Idempotent: matching on name, re-running updates instead of duplicating.
     */
    public function run(): void
    {
        $employees = [
            ['name' => 'James Carter',    'phone' => '+1 (415) 555-0182', 'role' => 'Plumber',          'nationality' => 'American',  'join_date' => '2021-03-15', 'salary' => 4800, 'status' => 'active'],
            ['name' => 'Miguel Santos',   'phone' => '+1 (415) 555-0147', 'role' => 'Welder',           'nationality' => 'Filipino',  'join_date' => '2020-07-01', 'salary' => 5200, 'status' => 'active'],
            ['name' => 'David Miller',    'phone' => '+1 (628) 555-0119', 'role' => 'Electrician',      'nationality' => 'American',  'join_date' => '2019-11-20', 'salary' => 5500, 'status' => 'active'],
            ['name' => 'Rajesh Kumar',    'phone' => '+1 (510) 555-0136', 'role' => 'AC Technician',    'nationality' => 'Indian',    'join_date' => '2022-01-10', 'salary' => 4300, 'status' => 'active'],
            ['name' => 'Carlos Ramirez',  'phone' => '+1 (510) 555-0173', 'role' => 'Painter',          'nationality' => 'Mexican',   'join_date' => '2021-09-05', 'salary' => 3900, 'status' => 'active'],
            ['name' => 'Ahmed Hassan',    'phone' => '+1 (408) 555-0125', 'role' => 'Carpenter',        'nationality' => 'Egyptian',  'join_date' => '2020-02-18', 'salary' => 4600, 'status' => 'active'],
            ['name' => 'Luis Torres',     'phone' => '+1 (408) 555-0168', 'role' => 'Tile Specialist',  'nationality' => 'Colombian', 'join_date' => '2022-06-27', 'salary' => 4200, 'status' => 'active'],
            ['name' => 'Kevin O\'Brien',  'phone' => '+1 (650) 555-0141', 'role' => 'Team Lead',        'nationality' => 'American',  'join_date' => '2018-04-02', 'salary' => 6500, 'status' => 'active'],
            ['name' => 'Samuel Bennett',  'phone' => '+1 (650) 555-0194', 'role' => 'Cleaning Expert',  'nationality' => 'American',  'join_date' => '2023-08-14', 'salary' => 3500, 'status' => 'active'],
            ['name' => 'Nigel Adams',     'phone' => '+1 (707) 555-0158', 'role' => 'Plumber',          'nationality' => 'British',   'join_date' => '2024-02-09', 'salary' => 4400, 'status' => 'inactive'],
        ];

        foreach ($employees as $employee) {
            Employee::updateOrCreate(['name' => $employee['name']], $employee);
        }
    }
}
