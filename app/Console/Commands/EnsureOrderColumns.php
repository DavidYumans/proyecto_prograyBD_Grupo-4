<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

class EnsureOrderColumns extends Command
{
    protected $signature = 'app:ensure-order-columns';
    protected $description = 'Ensure repartidor_id and admin_notes exist on orders table';

    public function handle(): void
    {
        $columns = [
            'repartidor_id' => 'ALTER TABLE orders ADD COLUMN repartidor_id BIGINT UNSIGNED NULL',
            'admin_notes'   => 'ALTER TABLE orders ADD COLUMN admin_notes TEXT NULL',
            'delivery_status' => "ALTER TABLE orders ADD COLUMN delivery_status VARCHAR(255) NOT NULL DEFAULT 'sin_asignar'",
        ];

        foreach ($columns as $col => $sql) {
            if (! Schema::hasColumn('orders', $col)) {
                DB::statement($sql);
                $this->info("Added column: {$col}");
            } else {
                $this->info("Column already exists: {$col}");
            }
        }
    }
}
