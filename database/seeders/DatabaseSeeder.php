<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use Faker\Factory as Faker;

use App\Models\User;
use App\Models\House;
use App\Models\Resident;
use App\Models\OccupancyHistory;
use App\Models\MonthlyFee;
use App\Models\Expense;
use App\Models\Setting;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        $faker = Faker::create();

        // Buat user admin
        User::create([
            'name' => 'Ketua RT',
            'email' => 'admin@rt.com',
            'password' => Hash::make('password'),
            'email_verified_at' => now(),
        ]);

        // Tambah 15 rumah dihuni dan 5 kosong
        House::factory(15)->create(['occupancy_status' => 'occupied']);
        House::factory(5)->create(['occupancy_status' => 'vacant']);

        // Buat 15 penghuni tetap
        $residents = Resident::factory(15)->create(['resident_status' => 'permanent']);

        // Ambil semua rumah yang dihuni
        $houses = House::where('occupancy_status', 'occupied')->get();

        // Hubungkan rumah dengan penghuni (occupancy history)
        foreach ($houses as $i => $house) {
            if (isset($residents[$i])) {
                $resident = $residents[$i];

                OccupancyHistory::create([
                    'house_id' => $house->id,
                    'resident_id' => $resident->id,
                    'occupancy_type' => 'permanent',
                ]);
            }
        }

        // Tambah data iuran bulanan untuk setiap rumah yang dihuni
        $month = now()->month;
        $year = now()->year;

        foreach ($houses as $i => $house) {
            if (isset($residents[$i])) {
                $resident = $residents[$i];

                for ($m = 1; $m <= $month; $m++) {
                    MonthlyFee::create([
                        'house_id' => $house->id,
                        'resident_id' => $resident->id,
                        'month' => $m,
                        'year' => $year,
                        'security_fee' => 100000,
                        'cleaning_fee' => 15000,
                        'security_status' => $faker->randomElement(['paid', 'unpaid']),
                        'cleaning_status' => $faker->randomElement(['paid', 'unpaid']),
                        'payment_date' => $faker->optional()->date(),
                        'payment_method' => $faker->optional()->randomElement(['cash', 'transfer']),
                        'notes' => $faker->optional()->sentence(),
                    ]);
                }
            }
        }

        // Hitung total pemasukan dari MonthlyFee (15 rumah × 115rb per bulan × n bulan)
        $totalPemasukan = 15 * 115000 * $month;

        // Target pengeluaran maksimal 70% dari pemasukan agar tidak defisit
        $maxTotalPengeluaran = $totalPemasukan * 0.7;
        $currentTotalExpense = 0;

        // Tambah pengeluaran RT dengan kontrol agar tidak melebihi pemasukan
        $categories = [
            'security_salary',
            'security_post_electricity',
            'road_maintenance',
            'drainage_maintenance',
            'other'
        ];

        while ($currentTotalExpense < $maxTotalPengeluaran) {
            $sisa = $maxTotalPengeluaran - $currentTotalExpense;
            $amount = min($faker->randomFloat(2, 50000, 500000), $sisa);

            Expense::create([
                'category' => $faker->randomElement($categories),
                'amount' => $amount,
                'date' => now()->subDays(rand(1, 300)),
                'description' => $faker->sentence(),
            ]);

            $currentTotalExpense += $amount;
        }

        // Tambah data setting default
        Setting::create([
            'default_security_fee' => 100000,
            'default_cleaning_fee' => 15000,
            'current_year' => now()->year,
            'rt_name' => 'RT 01',
            'neighborhood_name' => 'Green Garden Elite',
        ]);
    }
}