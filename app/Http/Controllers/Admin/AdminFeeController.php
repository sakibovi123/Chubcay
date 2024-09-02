<?php

namespace App\Http\Controllers\Admin;

use App\Exports\PendingPaymentExport;
use App\Http\Controllers\Controller;
use App\Models\FeeCheckout;
use App\Models\Record;
use Barryvdh\DomPDF\Facade\Pdf;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Maatwebsite\Excel\Facades\Excel;


class AdminFeeController extends Controller
{

    public function index()
    {
        $fees = FeeCheckout::all();
        $records = Record::orderBy('created_at', 'desc')->get();

        return view('admin.payment.index', [
            'fees' => $fees,
            'records' => $records
        ]);
    }

    public function getFeesByStatus( Request $request )
    {
        $status = $request->input('status');

        $fees = FeeCheckout::where('status', $status)->get();

        return view('admin.payment.index', [
            'fees' => $fees
        ]);
    }

    public function downloadFees()
    {
        // Fetch the data you want to include in the PDF
        $pendingPayments = FeeCheckout::where('payment_status', 'due')->get();

        // Pass the data to the view
        // $pdf = PDF::loadView('pdf.pending_payments', compact('pendingPayments'));
        $pdf = Pdf::loadView('pdf.pending', [
            'pendingPayments' => $pendingPayments
        ]);
        // Download the PDF
        $dateTime = Carbon::now();
        return $pdf->download($dateTime.'.pdf');
    }

    public function details($feeId)
    {
        return view('admin.payment.details', [
            'fee' => FeeCheckout::where('id', $feeId)->first()
        ]);
    }

    public function update(Request $request, $feeId)
    {
        $feeId = FeeCheckout::where('id', $feeId)
            ->first();

        $request->validate([
            'status' => 'string',
            'payment_status' => 'string'
        ]);

        $request->all();

        $feeId->payment_status = $request->payment_status;

        $feeId->save();

        return redirect()->back()->with('message', 'Updated successfully');

    }


    // download all records
    public function downloadAllRecords()
    {
        $records = Record::all();
        $pdf = Pdf::loadView('pdf.records', [
            'records' => $records
        ]);

        return $pdf->download();
    }
}
