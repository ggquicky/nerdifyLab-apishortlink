<?php

namespace App\Http\Controllers;


use App\Models\LinkCounter;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class ClickReportController extends Controller
{
 public function monthlyReport(){

     $data = LinkCounter::whereRelation('link', 'user_id', Auth::id())
         ->select(DB::raw("DATE_FORMAT(created_at, '%b') as Months"),
             DB::raw("count(link_id) as clicks"))
         ->groupBy(DB::raw("Months"))
         ->orderByRaw("Months asc")
         ->get();

    return $data;
 }


}
