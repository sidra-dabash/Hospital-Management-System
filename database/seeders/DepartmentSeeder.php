<?php

namespace Database\Seeders;

use App\Models\Department;
use Illuminate\Database\Seeder;

class DepartmentSeeder extends Seeder
{
    public function run(): void
    {
        $departments = [
            [
                'name' => 'قلب',
                'description' => 'قسم أمراض القلب والأوعية الدموية',
            ],
            [
                'name' => 'أطفال',
                'description' => 'قسم طب الأطفال وحديثي الولادة',
            ],
            [
                'name' => 'إسعاف',
                'description' => 'قسم الطوارئ والإسعافات الأولية',
            ],
            [
                'name' => 'جراحة',
                'description' => 'قسم الجراحة العامة',
            ],
            [
                'name' => 'عظام',
                'description' => 'قسم العظام والمفاصل',
            ],
            [
                'name' => 'باطنة',
                'description' => 'قسم الباطنة والأمراض المزمنة',
            ],
            [
                'name' => 'أسنان',
                'description' => 'قسم طب الأسنان والفكين',
            ],
            [
                'name' => 'نساء وتوليد',
                'description' => 'قسم النساء والتوليد',
            ],
        ];

        foreach ($departments as $department) {
            Department::firstOrCreate(
                ['name' => $department['name']],
                ['description' => $department['description']]
            );
        }
    }
}
