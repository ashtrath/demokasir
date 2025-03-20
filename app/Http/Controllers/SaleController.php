<?php

namespace App\Http\Controllers;

use App\Exports\SalesExport;
use App\Http\Requests\StoreSaleRequest;
use App\Models\Sale;
use Barryvdh\DomPDF\Facade\Pdf as PDF;
use Carbon\Carbon;
use Inertia\Inertia;
use Maatwebsite\Excel\Facades\Excel;

class SaleController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return Inertia::render("sales/index", [
            "sales" => Sale::sort()->paginate(10)
        ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreSaleRequest $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(Sale $sale)
    {
        return Inertia::render("sales/show", [
            "sale" => $sale->load("detailSale")
        ]);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Sale $sale)
    {
        if ($sale->delete()) {
            return back()->with("success", "Success delete record");
        }
        return back()->with("error", "Error delete record, try again");
    }

    public function pdf()
    {
        request()->validate([
            "startDate" => "required|date",
            "endDate" => "required|date",
        ]);

        $sale = Sale::whereBetween("created_at", [request("startDate"), request("endDate")])->orderBy("created_at",
            "ASC")->get(["total", "created_at"]);

        $pdf = PDF::loadView('pdf', [
            "sales" => $sale,
            "total" => $sale->sum("total"),
            "dates" => [
                Carbon::createFromDate(request("startDate"))->locale("id-ID")->getTranslatedMonthName(),
                Carbon::createFromDate(request("endDate"))->locale("id-ID")->getTranslatedMonthName(),
                Carbon::createFromDate(request("endDate"))->year
            ]
        ])->setPaper("A4");

        $startDate = Carbon::parse(request('startDate'))->locale('id-ID');
        $endDate = Carbon::parse(request('endDate'))->locale('id-ID');
        $filename = "Sales report ".$startDate->getTranslatedMonthName();
        if ($startDate->getTranslatedMonthName() !== $endDate->getTranslatedMonthName()) {
            $filename .= " - ".$endDate->getTranslatedMonthName();
        }
        $filename .= $endDate->year;
        return $pdf->stream($filename.'.pdf');
    }

    public function excel()
    {
        request()->validate([
            "startDate" => "required|date",
            "endDate" => "required|date",
        ]);

        $startDate = Carbon::parse(request('startDate'))->locale('id-ID');
        $endDate = Carbon::parse(request('endDate'))->locale('id-ID');
        $filename = "Sales report ".$startDate->getTranslatedMonthName();
        if ($startDate->getTranslatedMonthName() !== $endDate->getTranslatedMonthName()) {
            $filename .= " - ".$endDate->getTranslatedMonthName();
        }
        $filename .= $endDate->year;

        return Excel::download(new SalesExport(request("startDate"), request("endDate")), $filename.".xlsx");
    }

    public function printReceipt(Sale $sale)
    {
        $user = auth()->user();
        $sale->load(['detailSale.item']);

        // Render the view to HTML
        $html = view('receipt', [
            "sale" => $sale,
            'store_name' => $user->store_name,
            'store_address' => $user->store_address,
            'store_phone' => $user->store_phone,
            'cashier_name' => $user->name,
        ])->render();

        // First pass to calculate height
        $pdf1 = app('dompdf.wrapper');
        $pdf1->loadHtml($html);
        $pdf1->setPaper([0, 0, 226.77, 3000], 'portrait');
        $pdf1->setOptions([
            'isRemoteEnabled' => true,
            'defaultFont' => 'sans-serif',
            'isHtml5ParserEnabled' => true
        ]);

        $GLOBALS['bodyHeight'] = 0;

        // Modified callback - frame is passed directly
        $pdf1->getDomPDF()->set_callbacks([
            'myCallbacks' => [
                'event' => 'end_frame',
                'f' => function ($frame) {
                    $node = $frame->get_node();

                    // Add null check for node
                    if ($node && strtolower($node->nodeName) === "body") {
                        $padding_box = $frame->get_padding_box();
                        $GLOBALS['bodyHeight'] += $padding_box['h'];
                    }
                }
            ]
        ]);

        $pdf1->render();

        // Calculate final height with margin
        $docHeight = $GLOBALS['bodyHeight'] + 15;

        // Second pass with correct height
        $pdf2 = app('dompdf.wrapper');
        $pdf2->loadHtml($html);
        $pdf2->setPaper([0, 0, 226.77, $docHeight], 'portrait');
        $pdf2->setOptions([
            'isRemoteEnabled' => true,
            'defaultFont' => 'sans-serif',
            'isHtml5ParserEnabled' => true
        ]);

        return $pdf2->stream('receipt.pdf');
    }
}
