<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

class EnsureOrderColumns extends Command
{
    protected $signature = 'app:ensure-order-columns';
    protected $description = 'Ensure all FK-dependent columns exist (idempotent, no FK constraints)';

    public function handle(): void
    {
        $this->ensureColumns('orders', [
            'coupon_id'      => 'ALTER TABLE orders ADD COLUMN coupon_id BIGINT UNSIGNED NULL',
            'coupon_code'    => 'ALTER TABLE orders ADD COLUMN coupon_code VARCHAR(255) NULL',
            'subtotal'       => 'ALTER TABLE orders ADD COLUMN subtotal DECIMAL(10,2) NOT NULL DEFAULT 0',
            'discount_total' => 'ALTER TABLE orders ADD COLUMN discount_total DECIMAL(10,2) NOT NULL DEFAULT 0',
            'repartidor_id'  => 'ALTER TABLE orders ADD COLUMN repartidor_id BIGINT UNSIGNED NULL',
            'admin_notes'    => 'ALTER TABLE orders ADD COLUMN admin_notes TEXT NULL',
            'delivery_status'=> "ALTER TABLE orders ADD COLUMN delivery_status VARCHAR(255) NOT NULL DEFAULT 'sin_asignar'",
        ]);

        $this->ensureColumns('users', [
            'commerce_id' => 'ALTER TABLE users ADD COLUMN commerce_id BIGINT UNSIGNED NULL',
        ]);
    }

    private function ensureColumns(string $table, array $columns): void
    {
        foreach ($columns as $col => $sql) {
            try {
                if (! Schema::hasColumn($table, $col)) {
                    DB::statement($sql);
                    $this->info("Added {$table}.{$col}");
                } else {
                    $this->line("OK     {$table}.{$col}");
                }
            } catch (\Throwable $e) {
                $this->error("FAIL   {$table}.{$col}: " . $e->getMessage());
            }
        }
    }
}
