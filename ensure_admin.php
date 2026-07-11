<?php
require __DIR__.'/vendor/autoload.php';
$app = require_once __DIR__.'/bootstrap/app.php';
$kernel = $app->make(Illuminate\Contracts\Console\Kernel::class);
$kernel->bootstrap();

use App\Models\User;

try {
    $u = User::where('email', 'admin@mantenciones.local')->first();
    if($u) {
        $u->password = bcrypt('password123');
        $u->save();
        echo "Password updated successfully.\n";
    }
} catch (\Exception $e) {
    echo "Error: " . $e->getMessage() . "\n";
}
