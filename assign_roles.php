<?php
require __DIR__.'/vendor/autoload.php';
$app = require_once __DIR__.'/bootstrap/app.php';
$kernel = $app->make(Illuminate\Contracts\Console\Kernel::class);
$kernel->bootstrap();

use Spatie\Permission\Models\Role;
use App\Models\User;

try {
    Role::firstOrCreate(['name' => 'super_admin', 'guard_name' => 'web']);
    Role::firstOrCreate(['name' => 'panel_user', 'guard_name' => 'web']);
    Role::firstOrCreate(['name' => 'tecnico', 'guard_name' => 'web']);

    $u = User::where('email', 'admin@mantenciones.local')->first();
    if($u) {
        $u->assignRole('super_admin');
        echo "Assigned super_admin to {$u->email}\n";
    }
} catch (\Exception $e) {
    echo "Error: " . $e->getMessage() . "\n";
}
