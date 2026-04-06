<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\GiaoDich;
use App\Models\KhoanThu;
use App\Models\DanhMuc;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class DashboardController extends Controller
{
    public function index()
    {
        $userId = Auth::id();
        $now = Carbon::now();
        $startOfMonth = $now->copy()->startOfMonth();
        $endOfMonth = $now->copy()->endOfMonth();

        // 1. Overall Balance
        $totalIncome = KhoanThu::where('nguoi_dung_id', $userId)->sum('so_tien');
        $totalExpense = GiaoDich::where('nguoi_dung_id', $userId)->sum('so_tien');
        $availableBalance = $totalIncome - $totalExpense;

        // 2. Monthly Stats
        $monthlyIncome = KhoanThu::where('nguoi_dung_id', $userId)
            ->whereBetween('ngay_nhan', [$startOfMonth, $endOfMonth])
            ->sum('so_tien');
            
        $monthlyExpense = GiaoDich::where('nguoi_dung_id', $userId)
            ->whereBetween('ngay_giao_dich', [$startOfMonth, $endOfMonth])
            ->sum('so_tien');

        $savingsRate = $monthlyIncome > 0 
            ? max(0, round((($monthlyIncome - $monthlyExpense) / $monthlyIncome) * 100, 1))
            : 0;

        // 3. Category Distribution (Allocation)
        $categoryData = GiaoDich::where('nguoi_dung_id', $userId)
            ->whereBetween('ngay_giao_dich', [$startOfMonth, $endOfMonth])
            ->select('danh_muc_id', DB::raw('SUM(so_tien) as total'))
            ->groupBy('danh_muc_id')
            ->with('danhMuc')
            ->orderByDesc('total')
            ->get();

        // 4. Performance Matrix (Past 7 days)
        $days = [];
        $incomeTrends = [];
        $expenseTrends = [];

        for ($i = 6; $i >= 0; $i--) {
            $date = Carbon::today()->subDays($i);
            $days[] = $date->format('d/m');
            
            $incomeTrends[] = KhoanThu::where('nguoi_dung_id', $userId)
                ->whereDate('ngay_nhan', $date)
                ->sum('so_tien');
                
            $expenseTrends[] = GiaoDich::where('nguoi_dung_id', $userId)
                ->whereDate('ngay_giao_dich', $date)
                ->sum('so_tien');
        }

        // 5. Recent Activity
        $recentExpenses = GiaoDich::where('nguoi_dung_id', $userId)
            ->with('danhMuc')
            ->orderByDesc('ngay_giao_dich')
            ->limit(3)
            ->get()
            ->map(function($item) {
                $item->type = 'chi';
                $item->date = $item->ngay_giao_dich;
                return $item;
            });

        $recentIncomes = KhoanThu::where('nguoi_dung_id', $userId)
            ->with('danhMuc')
            ->orderByDesc('ngay_nhan')
            ->limit(3)
            ->get()
            ->map(function($item) {
                $item->type = 'thu';
                $item->date = $item->ngay_nhan;
                return $item;
            });

        $recentActivity = $recentExpenses->concat($recentIncomes)
            ->sortByDesc('date')
            ->values()
            ->take(5);

        return view('dashboard', compact(
            'availableBalance', 
            'monthlyIncome', 
            'monthlyExpense', 
            'savingsRate',
            'categoryData',
            'days',
            'incomeTrends',
            'expenseTrends',
            'recentActivity'
        ));
    }
}
