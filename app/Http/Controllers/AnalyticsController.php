<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Office;
use App\Models\User;
use App\Models\Prdoc;
use Inertia\Inertia;
use Inertia\Response;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\DB;

class AnalyticsController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $prTrends = Prdoc::select(
            DB::raw('MONTH(created_at) as month'),
            DB::raw('COUNT(*) as count')
        )
            ->groupBy('month')
            ->orderBy('month')
            ->get();

        $data = array_fill(1, 12, 0); // index 1-12 for Jan to Dec

        foreach ($prTrends as $trend) {
            $data[$trend->month] = $trend->count;
        }


        $prdocs = Prdoc::notFailed()
            ->orderBy('created_at')
            ->get()
            ->map(fn($prdoc) => [
                'x' => $prdoc->office->abbr,
                'y' => [$prdoc->created_at, $prdoc->event_need],
            ]);


        return Inertia::render('Analytics', [
            'prTrends' => Inertia::defer(fn() => [
                'data' => array_values($data), // [count for Jan, Feb, ..., Dec]
                'categ' => ['Jan', 'Feb', 'Mar', 'Apr', 'May', 'Jun', 'Jul', 'Aug', 'Sep', 'Oct', 'Nov', 'Dec']
            ]),
            'prdocs' => Inertia::defer(fn() => $prdocs),
        ]);
    }

}
