<?php
// Run with: php scripts/sync_attendance_status.php
require __DIR__ . '/../vendor/autoload.php';
$app = require_once __DIR__ . '/../bootstrap/app.php';
$app->make(Illuminate\Contracts\Console\Kernel::class)->bootstrap();

use App\Models\Attendance;

echo "Syncing attendance.status values to canonical keys\n\n";

$mapping = [
    // legacy -> canonical
    'hadir' => 'ontime',
    'terlambat' => 'late',
    // already canonical keep mapping for clarity
    'ontime' => 'ontime',
    'late' => 'late',
    'absent' => 'absent',
    'izin' => 'izin',
    'alfa' => 'alfa',
];

// report current counts
echo "Current counts:\n";
foreach ($mapping as $old => $new) {
    $cnt = Attendance::where('status', $old)->count();
    printf("  %-12s => %-8s : %d\n", $old, $new, $cnt);
}

// Also show any other values present
$others = Attendance::select('status', \DB::raw('count(*) as c'))
    ->groupBy('status')
    ->get()
    ->pluck('c','status')
    ->toArray();

echo "\nAll status values in DB:\n";
foreach ($others as $k => $c) {
    printf("  %-16s : %d\n", $k, $c);
}

// Confirm with user
echo "\nProceed to normalize legacy keys (hadir->ontime, terlambat->late)? (y/N): ";
$ans = trim(fgets(STDIN));
if (strtolower($ans) !== 'y') {
    echo "Aborted. No changes made.\n";
    exit(0);
}

// Do updates
$totalChanged = 0;
foreach ($mapping as $old => $new) {
    if ($old === $new) continue;
    $cnt = Attendance::where('status', $old)->count();
    if ($cnt > 0) {
        Attendance::where('status', $old)->update(['status' => $new]);
        $totalChanged += $cnt;
        printf("Updated %d records: %s -> %s\n", $cnt, $old, $new);
    }
}

echo "\nDone. Total records updated: {$totalChanged}\n";

// Optionally print new counts
echo "\nNew counts:\n";
foreach ($mapping as $old => $new) {
    $cnt = Attendance::where('status', $new)->count();
    printf("  %-12s : %d\n", $new, $cnt);
}

echo "\nYou can review DB or run backups before/after as needed.\n";
