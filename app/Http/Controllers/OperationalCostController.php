<?php

namespace App\Http\Controllers;

use App\Models\OperationalCost;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;

use Symfony\Component\HttpFoundation\StreamedResponse;

class OperationalCostController extends Controller
{
    public function index(Request $request)
    {
        $start_date = $request->query('start_date');
        $end_date = $request->query('end_date');

        $query = OperationalCost::query();

        if ($start_date) {
            $query->whereDate('created_at', '>=', $start_date);
        }
        if ($end_date) {
            $query->whereDate('created_at', '<=', $end_date);
        }

        $total = (clone $query)->sum('amount');

        $costs = $query->orderBy('created_at', 'desc')->paginate(20)->appends($request->only('start_date', 'end_date'));

        return view('admin.operational_costs', compact('costs', 'total', 'start_date', 'end_date'));
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'item' => 'required|string|max:255',
            'category' => 'nullable|string|max:255',
            'amount' => 'required|numeric|min:0',
            'date' => 'nullable|date',
            'notes' => 'nullable|string',
            'related_book_id' => 'nullable|integer|exists:books,id'
        ]);

        $data['created_by'] = Auth::id();
        $cost = OperationalCost::create($data);

        if (!empty($data['date'])) {
            try {
                $d = Carbon::createFromFormat('Y-m-d', $data['date'])->startOfDay();
                $cost->created_at = $d;
                $cost->save();
            } catch (\Exception $e) {
                // ignore invalid date parsing and keep default created_at
            }
        }

        return back()->with('success', 'Biaya operasional berhasil ditambahkan');
    }

    public function update(Request $request, OperationalCost $operationalCost)
    {
        $data = $request->validate([
            'item' => 'required|string|max:255',
            'category' => 'nullable|string|max:255',
            'amount' => 'required|numeric|min:0',
            'date' => 'nullable|date',
            'notes' => 'nullable|string',
        ]);

        $operationalCost->update($data);

        if (!empty($data['date'])) {
            try {
                $d = Carbon::createFromFormat('Y-m-d', $data['date'])->startOfDay();
                $operationalCost->created_at = $d;
                $operationalCost->save();
            } catch (\Exception $e) {
                // ignore invalid date parsing
            }
        }

        return back()->with('success', 'Biaya operasional berhasil diperbarui');
    }

    public function export(Request $request)
    {
        $start_date = $request->query('start_date');
        $end_date = $request->query('end_date');

        $query = OperationalCost::query();
        if ($start_date) $query->whereDate('created_at', '>=', $start_date);
        if ($end_date) $query->whereDate('created_at', '<=', $end_date);

        $costs = $query->orderBy('created_at', 'desc')->get();

        $filename = 'operational-costs_' . ($start_date ?? 'all') . '_to_' . ($end_date ?? 'all') . '.csv';

        $response = new StreamedResponse(function() use ($costs) {
            $handle = fopen('php://output', 'w');
            fputcsv($handle, ['Tanggal', 'Item', 'Kategori', 'Jumlah', 'Notes', 'Created By']);
            foreach ($costs as $c) {
                fputcsv($handle, [
                    $c->created_at->format('Y-m-d H:i:s'),
                    $c->item,
                    $c->category,
                    $c->amount,
                    $c->notes ?? '',
                    $c->created_by ?? ''
                ]);
            }
            fclose($handle);
        });

        $disposition = 'attachment; filename="' . $filename . '"';
        $response->headers->set('Content-Type', 'text/csv; charset=UTF-8');
        $response->headers->set('Content-Disposition', $disposition);

        return $response;
    }

    public function destroy(OperationalCost $operationalCost)
    {
        $operationalCost->delete();
        return back()->with('success', 'Biaya operasional berhasil dihapus');
    }
}
