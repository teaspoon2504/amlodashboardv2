<?php

namespace Database\Seeders;

use App\Models\BranchOffice;
use App\Models\Officer;
use App\Models\RegionalOffice;
use App\Models\Task;
use App\Models\TaskCategory;
use App\Models\TeamLead;
use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        $ro1 = RegionalOffice::create(['code' => 'RO-JKT', 'name' => 'Regional Office Jakarta']);
        $ro2 = RegionalOffice::create(['code' => 'RO-SBY', 'name' => 'Regional Office Surabaya']);

        $bo1 = BranchOffice::create(['code' => 'BO-JKT-01', 'name' => 'Cabang Jakarta Pusat', 'regional_office_id' => $ro1->id]);
        $bo2 = BranchOffice::create(['code' => 'BO-JKT-02', 'name' => 'Cabang Jakarta Selatan', 'regional_office_id' => $ro1->id]);
        $bo3 = BranchOffice::create(['code' => 'BO-SBY-01', 'name' => 'Cabang Surabaya Utara', 'regional_office_id' => $ro2->id]);
        $bo4 = BranchOffice::create(['code' => 'BO-SBY-02', 'name' => 'Cabang Surabaya Selatan', 'regional_office_id' => $ro2->id]);

        $tl1 = TeamLead::create(['name' => 'Budi Santoso', 'regional_office_id' => $ro1->id]);
        $tl2 = TeamLead::create(['name' => 'Siti Rahayu', 'regional_office_id' => $ro2->id]);

        $o1 = Officer::create(['name' => 'Ahmad Rizki', 'branch_office_id' => $bo1->id]);
        $o2 = Officer::create(['name' => 'Dewi Lestari', 'branch_office_id' => $bo1->id]);
        $o3 = Officer::create(['name' => 'Fajar Nugroho', 'branch_office_id' => $bo2->id]);
        $o4 = Officer::create(['name' => 'Rina Wulandari', 'branch_office_id' => $bo3->id]);
        $o5 = Officer::create(['name' => 'Wahyu Pratama', 'branch_office_id' => $bo4->id]);

        $categories = [
            'Tindak Lanjut Alert STR',
            'STR Proaktif',
            'Pengkinian Bad Data',
            'Tindak Lanjut PEP',
            'E Learning Reminder',
            'Adhoc EDD',
            'Adhoc RFI Remittance',
            'Adhoc Pendampingan AML',
        ];
        foreach ($categories as $cat) {
            TaskCategory::create(['name' => $cat]);
        }
        $allCats = TaskCategory::all();
        $now = now();

        User::create(['name' => 'Super Admin', 'email' => 'superadmin@amlo.com', 'password' => Hash::make('password'), 'role' => 'ho']);
        User::create(['name' => $tl1->name, 'email' => 'lead@amlo.com', 'password' => Hash::make('password'), 'role' => 'lead', 'team_lead_id' => $tl1->id, 'regional_office_id' => $ro1->id]);
        User::create(['name' => $tl2->name, 'email' => 'lead2@amlo.com', 'password' => Hash::make('password'), 'role' => 'lead', 'team_lead_id' => $tl2->id, 'regional_office_id' => $ro2->id]);
        User::create(['name' => $o1->name, 'email' => 'amlo@amlo.com', 'password' => Hash::make('password'), 'role' => 'officer', 'officer_id' => $o1->id, 'team_lead_id' => $tl1->id, 'regional_office_id' => $ro1->id]);
        User::create(['name' => $o2->name, 'email' => 'amlo2@amlo.com', 'password' => Hash::make('password'), 'role' => 'officer', 'officer_id' => $o2->id, 'team_lead_id' => $tl1->id, 'regional_office_id' => $ro1->id]);
        User::create(['name' => $o3->name, 'email' => 'amlo3@amlo.com', 'password' => Hash::make('password'), 'role' => 'officer', 'officer_id' => $o3->id, 'team_lead_id' => $tl1->id, 'regional_office_id' => $ro1->id]);
        User::create(['name' => $o4->name, 'email' => 'amlo4@amlo.com', 'password' => Hash::make('password'), 'role' => 'officer', 'officer_id' => $o4->id, 'team_lead_id' => $tl2->id, 'regional_office_id' => $ro2->id]);
        User::create(['name' => $o5->name, 'email' => 'amlo5@amlo.com', 'password' => Hash::make('password'), 'role' => 'officer', 'officer_id' => $o5->id, 'team_lead_id' => $tl2->id, 'regional_office_id' => $ro2->id]);

        $officers = [
            ['o' => $o1, 'bo' => $bo1, 'tl' => $tl1, 'ro' => $ro1],
            ['o' => $o2, 'bo' => $bo1, 'tl' => $tl1, 'ro' => $ro1],
            ['o' => $o3, 'bo' => $bo2, 'tl' => $tl1, 'ro' => $ro1],
            ['o' => $o4, 'bo' => $bo3, 'tl' => $tl2, 'ro' => $ro2],
            ['o' => $o5, 'bo' => $bo4, 'tl' => $tl2, 'ro' => $ro2],
        ];

        foreach ($officers as $officerData) {
            foreach ($allCats as $cat) {
                $progress = fake()->randomElement(['done', 'in_progress', 'not_started']);
                $target = fake()->numberBetween(5, 20);
                $done = $progress === 'done' ? $target : ($progress === 'in_progress' ? fake()->numberBetween(1, $target - 1) : 0);
                Task::create([
                    'regional_office_id' => $officerData['ro']->id,
                    'task_category_id' => $cat->id,
                    'team_lead_id' => $officerData['tl']->id,
                    'officer_id' => $officerData['o']->id,
                    'branch_office_id' => $officerData['bo']->id,
                    'description' => "Task {$cat->name} untuk {$officerData['o']->name}",
                    'progress' => $progress,
                    'target' => $target,
                    'amount_done' => $done,
                    'due_date' => $now->copy()->addDays(fake()->numberBetween(3, 14))->toDateString(),
                ]);
            }
        }
    }
}