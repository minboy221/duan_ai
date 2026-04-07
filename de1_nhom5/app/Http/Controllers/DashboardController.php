<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\GiaoDich;
use App\Models\KhoanThu;
use App\Models\DanhMuc;
use App\Models\MucTieuTietKiem;
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

        // Check if guest
        if (!$userId) {
            return view('dashboard', [
                'availableBalance' => 0,
                'monthlyIncome' => 0,
                'monthlyExpense' => 0,
                'savingsRate' => 0,
                'categoryData' => collect([]),
                'days' => array_map(fn($i) => Carbon::today()->subDays(6-$i)->format('d/m'), range(0, 6)),
                'incomeTrends' => array_fill(0, 7, 0),
                'expenseTrends' => array_fill(0, 7, 0),
                'recentActivity' => collect([]),
                'monthDaysLabels' => array_map(fn($i) => "Ngày $i", range(1, 31)),
                'thisMonthValues' => array_fill(0, 31, 0),
                'lastMonthValues' => array_fill(0, 31, 0),
            ]);
        }

        // 1. Overall Balance
        $totalIncome = KhoanThu::where('nguoi_dung_id', $userId)->sum('so_tien');
        $totalExpense = GiaoDich::where('nguoi_dung_id', $userId)->sum('so_tien');
        $totalSavings = MucTieuTietKiem::where('nguoi_dung_id', $userId)->sum('so_tien_hien_tai');
        
        $availableBalance = $totalIncome - $totalExpense - $totalSavings;

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

        // 6. Expense Comparison (This Month vs Last Month)
        $monthDaysLabels = array_map(fn($i) => "Ngày $i", range(1, 31));
        $thisMonthExpenses = array_fill(0, 31, 0);
        $lastMonthExpenses = array_fill(0, 31, 0);

        $thisMonthData = GiaoDich::where('nguoi_dung_id', $userId)
            ->whereBetween('ngay_giao_dich', [$startOfMonth, $endOfMonth])
            ->get();
        foreach($thisMonthData as $g) {
            $dayIndex = (int)date('d', strtotime($g->ngay_giao_dich)) - 1;
            $thisMonthExpenses[$dayIndex] += $g->so_tien;
        }

        $lastMonthStart = $now->copy()->subMonth()->startOfMonth();
        $lastMonthEnd = $now->copy()->subMonth()->endOfMonth();
        $lastMonthData = GiaoDich::where('nguoi_dung_id', $userId)
            ->whereBetween('ngay_giao_dich', [$lastMonthStart, $lastMonthEnd])
            ->get();
        foreach($lastMonthData as $g) {
            $dayIndex = (int)date('d', strtotime($g->ngay_giao_dich)) - 1;
            $lastMonthExpenses[$dayIndex] += $g->so_tien;
        }

        $thisMonthValues = $thisMonthExpenses;
        $lastMonthValues = $lastMonthExpenses;

        return view('dashboard', compact(
            'availableBalance', 
            'totalSavings',
            'monthlyIncome', 
            'monthlyExpense', 
            'savingsRate',
            'categoryData',
            'days',
            'incomeTrends',
            'expenseTrends',
            'recentActivity',
            'monthDaysLabels',
            'thisMonthValues',
            'lastMonthValues'
        ));
    }
}
