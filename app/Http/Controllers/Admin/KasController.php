<?php

namespace App\Http\Controllers\Admin;

// use App\Models\Hotel;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Kas;
use Illuminate\Support\Facades\Validator;
use Carbon\Carbon;
use PDF;

class KasController extends Controller
{
    public function index(Request $request)
    {

        if ($request->ajax()) {

            $filter = $request->input('filter');
            if ($filter != null) {
                $query = Kas::query();


                if ($filter === 'in') {
                    $query->where('in_out', 'in');
                } elseif ($filter === 'out') {
                    $query->where('in_out', 'out');
                }

                $kas = $query->get();
            } else {
                $kas = Kas::all();
            }
            return view('pages.admin.kas.list', compact('kas'));
        }

        return view('pages.admin.kas.main');
    }

public function pdf(Request $request)
{
    if (!$request->start_date || !$request->end_date) {
        return redirect()->back()->with('error', 'Tanggal tidak boleh kosong');
    }

    $startDate = Carbon::parse($request->start_date)
    ->locale('id')
    ->startOfDay();

$endDate = Carbon::parse($request->end_date)
    ->locale('id')
    ->endOfDay();

    $kas = Kas::whereBetween('inout_date', [$startDate, $endDate])
        ->orderBy('inout_date', 'DESC')
        ->get();
    if ($kas->isEmpty()) {
        return redirect()->back()
            ->with('error', 'Tidak ada data pada rentang tanggal tersebut.');
    }

    $pdf = PDF::loadView(
        'pages.admin.kas.pdf',
        compact('kas', 'startDate', 'endDate')
    );

    $fileName = 'kas_' .
        $startDate->translatedFormat('d_F_Y') .
        '_to_' .
        $endDate->translatedFormat('d_F_Y') .
        '.pdf';

    return $pdf->download($fileName);
}

    public function store(Request $request)
    {
        $validators = Validator::make($request->all(), [
            'id' => 'required|numeric',
            'inout_date' => 'required|date',
            'in_out' => 'required|in:in,out',
            'amount' => 'required|numeric',
            'transaction_type' => 'required|string|max:255',

        ]);

        if ($validators->fails()) {
            return response()->json([
                'status' => 'error',
                'message' => $validators->errors()->first(),
            ]);
        }

        Kas::create([
            'id' => $request->id,
            'in_out' => $request->in_out,
            'inout_date' => $request->inout_date,
            'amount' => $request->amount,
            'transaction_type' => $request->transaction_type,
        ]);

        return response()->json([
            'status' => 'success',
            'message' => 'Data berhasil ditambahkan',
            'redirect' => route('admin.pengeluaran.index')
        ]);
    }

    public function destroy(Kas $kas)
    {
        $kas->delete();

        return response()->json([
            'alert' => 'success',
            'message' => 'Pesanan berhasil dihapus',
        ]);
    }
}
