<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreStatisticRequest;
use App\Models\CompanyStatistic;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class CompanyStatisticController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $statistics = CompanyStatistic::orderByDesc('id')->paginate(10);
        return view('admin.statistics.index', compact('statistics'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('admin.statistics.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreStatisticRequest $request)
    {
        DB::transaction(function() use($request){
            $validated = $request->validated();

            if($request->hasFile('icon')){
                $iconPath = $request->file('icon')->store('icons','public');
                $validated['icon'] = $iconPath;      
            }
            $newDataRecord = CompanyStatistic::create($validated);
        });

        return redirect()->route('admin.statistics.index')->with('success','Data Statistic Berhasil Dibuat');
    }

    /**
     * Display the specified resource.
     */
    public function show(CompanyStatistic $companyStatistic)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(CompanyStatistic $companyStatistic)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, CompanyStatistic $companyStatistic)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(CompanyStatistic $statistic)
    {
        DB::transaction(function() use ($statistic){
            $statistic->delete();
        });
        return redirect()->route('admin.statistics.index')->with('success','Data Statistic Berhasil Dihapus');
    }
}
