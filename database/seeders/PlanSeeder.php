<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class PlanSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $freePlan = DB::table('plans')->where('is_free', 1)->first();
        if (!$freePlan) {
            DB::table('plans')->insert([
                'name' => 'Free',
                'description' => 'Free',
                'trial_days' => 0,
                'monthly_price' => 0,
                'yearly_price' => 0,
                'visibility' => 1,
                'is_free' => 1,
            ]);
        }
    }
}
