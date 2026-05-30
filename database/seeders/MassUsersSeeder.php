<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

class MassUsersSeeder extends Seeder
{
    private const TOTAL  = 10_000;
    private const CHUNK  = 500;

    public function run(): void
    {
        $this->command->info('Generando ' . number_format(self::TOTAL) . ' usuarios...');

        // Hash pre-calculado una sola vez para todos los usuarios
        $password  = Hash::make('password');
        $now       = now()->toDateTimeString();
        $faker     = \Faker\Factory::create('es_ES');

        $bar = $this->command->getOutput()->createProgressBar(self::TOTAL / self::CHUNK);
        $bar->start();

        $inserted = 0;

        while ($inserted < self::TOTAL) {
            $batch = [];
            $limit = min(self::CHUNK, self::TOTAL - $inserted);

            for ($i = 0; $i < $limit; $i++) {
                $batch[] = [
                    'name'              => $faker->name(),
                    'email'             => $faker->unique()->safeEmail(),
                    'email_verified_at' => $now,
                    'password'          => $password,
                    'role'              => 'usuario',
                    'status'            => 'activo',
                    'remember_token'    => Str::random(10),
                    'created_at'        => $now,
                    'updated_at'        => $now,
                ];
            }

            DB::table('users')->insert($batch);
            $inserted += $limit;
            $bar->advance();
        }

        $bar->finish();
        $this->command->newLine();
        $this->command->info('✓ ' . number_format($inserted) . ' usuarios creados. Contraseña: password');
    }
}
