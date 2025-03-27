<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class SaleStatusesSeeder extends Seeder
{
    public function run()
    {
        DB::table('sale_statuses')->insert([
            [
                'name' => 'Partially',
                'color' => 'yellow',
                'creation_by' => 1,  // Assuming a user with ID 1 exists
                'modified_by' => 1,  // Assuming a user with ID 1 exists
                'is_deleted' => false,
                'deleted_by' => null,
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ],
            [
                'name' => 'Paid',
                'color' => 'green',
                'creation_by' => 1,  // Assuming a user with ID 1 exists
                'modified_by' => 1,  // Assuming a user with ID 1 exists
                'is_deleted' => false,
                'deleted_by' => null,
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ],
            [
                'name' => 'Unpaid',
                'color' => 'red',
                'creation_by' => 1,  // Assuming a user with ID 1 exists
                'modified_by' => 1,  // Assuming a user with ID 1 exists
                'is_deleted' => false,
                'deleted_by' => null,
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ],
        ]);
    }
}
