<?php
// Run with: php scripts/recalc_attendance_status_from_checkin.php
require __DIR__ . '/../vendor/autoload.php';
$app = require_once __DIR__ . '/../bootstrap/app.php';
$app->make(Illuminate\Contracts\Console\Kernel::class)->bootstrap();

use App\Models\Attendance;
use Carbon\Carbon;

echo "Recalculating attendance.status from check_in (07:30 cutoff)\n\n";

$query = Attendance::whereNotNull('check_in');
$total = $query->count();
if ($total === 0) {
    echo "No attendance records with check_in found.\n";
    exit(0);
}

echo "Total records with check_in: {$total}\n";

$mismatches = [];
$items = $query->cursor();
foreach ($items as $att) {
    $computed = $att->calculateStatus(); // returns 'ontime'|'late'|'absent'
    $dbStatus = $att->status;
    if ($dbStatus !== $computed) {
        $mismatches[] = [
            'id' => $att->id,
            'date' => $att->date,
            'check_in' => $att->check_in,
            'db' => $dbStatus,
            'computed' => $computed,
        ];
    }
}

$cnt = count($mismatches);
if ($cnt === 0) {
    echo "All records already match computed status. Nothing to do.\n";
    exit(0);
}

echo "Found {$cnt} records where DB status differs from computed status. Sample:\n";
$sample = array_slice($mismatches, 0, 10);
foreach ($sample as $m) {
    printf("  id=%d date=%s check_in=%s db=%s computed=%s\n", $m['id'], $m['date'], $m['check_in'], $m['db'] ?? '(null)', $m['computed']);
}

echo "\nProceed to update these {$cnt} records to computed status? (y/N): ";
$ans = trim(fgets(STDIN));
if (strtolower($ans) !== 'y') {
    echo "Aborted. No changes made.\n";
    exit(0);
}

$changed = 0;
\DB::transaction(function() use(&$changed, $mismatches) {
    foreach ($mismatches as $m) {
        $att = Attendance::find($m['id']);
        if (!$att) continue;
        $computed = $att->calculateStatus();
        if ($att->status !== $computed) {
            $att->status = $computed;
            $att->save();
            $changed++;
        }
    }
});

echo "\nDone. Updated {$changed} records.\n";
