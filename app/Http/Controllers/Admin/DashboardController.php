<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\QrCode;
use App\Models\Order;
use App\Models\QrScan;
use App\Models\QrRegistration;
use App\Models\User;
use App\Models\Category;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class DashboardController extends Controller
{
    /**
     * Display admin dashboard
     */
    public function index(Request $request)
    {
        $stats = [
            'total_qrs' => QrCode::count(),
            'available_qrs' => QrCode::where('status', 'available')->count(),
            'assigned_qrs' => QrCode::where('status', 'assigned')->count(),
            'registered_qrs' => QrCode::where('status', 'registered')->count(),
            'total_users' => QrRegistration::where('is_active', true)->count(),
            'total_revenue' => Order::where('payment_status', 'completed')->sum('total_amount'),
            'today_revenue' => Order::where('payment_status', 'completed')
                ->whereDate('updated_at', today())
                ->sum('total_amount'),
            'total_scans' => QrScan::count(),
            'today_scans' => QrScan::whereDate('created_at', today())->count(),
        ];

        // Recent Data
        $recentPayments = Order::with(['user'])->latest()->take(10)->get();
        $recentRegistrations = QrCode::with(['category', 'registration'])
            ->where('status', 'registered')
            ->latest('registered_at')
            ->take(10)->get();

        // Chart Data (Default select daily)
        $period = $request->get('period', 'daily');
        $chartData = $this->getRevenueChartData($period);

        return view('admin.dashboard', compact(
            'stats',
            'recentPayments',
            'recentRegistrations',
            'chartData',
            'period'
        ));
    }

    private function getRevenueChartData($period)
    {
        $query = Order::where('payment_status', 'completed');

        switch ($period) {
            case 'daily':
                // Last 15 days data
                return $query->where('updated_at', '>=', now()->subDays(15))
                    ->select(DB::raw('DATE(updated_at) as date'), DB::raw('SUM(total_amount) as revenue'))
                    ->groupBy('date')->orderBy('date')
                    ->get()->map(fn($item) => [
                        'label' => Carbon::parse($item->date)->format('d M'),
                        'revenue' => (float)$item->revenue
                    ]);

            case 'weekly':
                // Last 8 weeks data
                return $query->where('updated_at', '>=', now()->subWeeks(8))
                    ->select(DB::raw('YEARWEEK(updated_at, 1) as week'), DB::raw('MIN(updated_at) as date'), DB::raw('SUM(total_amount) as revenue'))
                    ->groupBy('week')->orderBy('date')
                    ->get()->map(fn($item) => [
                        'label' => 'Week ' . Carbon::parse($item->date)->format('W'),
                        'revenue' => (float)$item->revenue
                    ]);

            case 'yearly':
                // Last 5 years
                return $query->where('updated_at', '>=', now()->subYears(5))
                    ->select(DB::raw('YEAR(updated_at) as year'), DB::raw('SUM(total_amount) as revenue'))
                    ->groupBy('year')->orderBy('year')
                    ->get()->map(fn($item) => [
                        'label' => (string)$item->year,
                        'revenue' => (float)$item->revenue
                    ]);

            case 'monthly':
            default:
                // Last 12 months
                return $query->where('updated_at', '>=', now()->subMonths(12))
                    ->select(DB::raw('DATE_FORMAT(updated_at, "%Y-%m") as month'), DB::raw('SUM(total_amount) as revenue'))
                    ->groupBy('month')->orderBy('month')
                    ->get()->map(fn($item) => [
                        'label' => Carbon::parse($item->month . '-01')->format('M Y'),
                        'revenue' => (float)$item->revenue
                    ]);
        }
    }

    /**
     * Display analytics page
     */
    public function analytics(Request $request)
    {
        $dateFrom = $request->get('date_from', now()->subDays(30)->format('Y-m-d'));
        $dateTo = $request->get('date_to', now()->format('Y-m-d'));

        // 1. Scan analytics (Simple Counts)
        $scanStats = [
            'total_scans' => QrScan::whereBetween('created_at', [$dateFrom, $dateTo])->count(),
            'call_actions' => QrScan::whereBetween('created_at', [$dateFrom, $dateTo])
                ->where('action_taken', 'call')->count(),
            'whatsapp_actions' => QrScan::whereBetween('created_at', [$dateFrom, $dateTo])
                ->where('action_taken', 'whatsapp')->count(),
            'emergency_actions' => QrScan::whereBetween('created_at', [$dateFrom, $dateTo])
                ->where('action_taken', 'emergency')->count(),
        ];

        // 2. Daily scans (Fixed Group By)
        $dailyScans = QrScan::select(
            DB::raw('DATE(created_at) as date'),
            DB::raw('COUNT(*) as count')
        )
            ->whereBetween('created_at', [$dateFrom, $dateTo])
            ->groupBy(DB::raw('DATE(created_at)'))
            ->orderBy('date')
            ->get();

        // 3. Top scanned QR codes (FIXED: Using withCount)
        $topScannedQrs = QrCode::with(['category', 'registration'])
            ->withCount(['scans' => function ($query) use ($dateFrom, $dateTo) {
                $query->whereBetween('created_at', [$dateFrom, $dateTo]);
            }])
            ->having('scans_count', '>', 0)
            ->orderByDesc('scans_count')
            ->take(10)
            ->get();

        // 4. Payment analytics (from orders table)
        $paymentStats = [
            'total_payments' => Order::whereBetween('created_at', [$dateFrom, $dateTo])->count(),
            'successful_payments' => Order::where('payment_status', 'completed')
                ->whereBetween('updated_at', [$dateFrom, $dateTo])->count(),
            'failed_payments' => Order::where('payment_status', 'failed')
                ->whereBetween('created_at', [$dateFrom, $dateTo])->count(),
            'total_revenue' => Order::where('payment_status', 'completed')
                ->whereBetween('updated_at', [$dateFrom, $dateTo])
                ->sum('total_amount'),
        ];

        // 5. Payment methods distribution (using razorpay_order_id)
        $paymentMethods = Order::select('razorpay_order_id', DB::raw('COUNT(*) as count'))
            ->where('payment_status', 'completed')
            ->whereNotNull('razorpay_order_id')
            ->whereBetween('updated_at', [$dateFrom, $dateTo])
            ->groupBy('razorpay_order_id')
            ->get();

        return view('admin.analytics', compact(
            'scanStats',
            'dailyScans',
            'topScannedQrs',
            'paymentStats',
            'paymentMethods',
            'dateFrom',
            'dateTo'
        ));
    }
}
