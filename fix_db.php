<?php
use Illuminate\Support\Facades\DB;
DB::statement("ALTER TABLE lead_communications MODIFY COLUMN type VARCHAR(100) DEFAULT 'system'");
echo "Success\n";
