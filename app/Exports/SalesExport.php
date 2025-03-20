<?php

namespace App\Exports;

use App\Models\Sale;
use Carbon\Carbon;
use Illuminate\Contracts\View\View;
use Maatwebsite\Excel\Concerns\FromView;
use Maatwebsite\Excel\Concerns\WithCustomStartCell;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithStrictNullComparison;

class SalesExport implements FromView, WithStrictNullComparison
{
    /**
    * @return \Illuminate\Support\Collection
    */

    private string $startDate;
    private string $endDate;

    public function __construct(string $startDate, string $endDate)
    {
        $this->startDate = $startDate;
        $this->endDate = $endDate;
    }

    public function view() : View
    {
        $sale = Sale::whereBetween("created_at", [$this->startDate, $this->endDate])->orderBy("created_at", "ASC")->get(["total", "created_at"]);
        
        return view("excel", [
            "sales" => $sale,
            "total" => $sale->sum("total"),
            "dates" => [Carbon::createFromDate($this->startDate)->locale("id-ID")->getTranslatedMonthName(), Carbon::createFromDate($this->endDate)->locale("id-ID")->getTranslatedMonthName(), Carbon::createFromDate($this->endDate)->year]
        ]);
    }
}
