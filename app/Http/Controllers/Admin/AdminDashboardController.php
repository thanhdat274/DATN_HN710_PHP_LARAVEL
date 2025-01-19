<?php

namespace App\Http\Controllers\Admin;

use App\Events\NewMessageNotification;
use App\Http\Controllers\Controller;
use App\Models\Chat;
use App\Models\ChatDetail;
use App\Models\Order;
use App\Models\Product;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Request;

class AdminDashboardController extends Controller
{
    public function index()
    {
        $today = Carbon::today();

        $totalRevenue = Order::where('status', 4)
            ->whereDate('updated_at', $today)
            ->sum('total_amount');

        $ordersCount = Order::where('status', 4)
            ->whereDate('created_at', $today)
            ->count();

        $productCount = Product::count();

        $usersCount = User::where('role', '0')->count();

        $dailyRevenueLast7Days = Order::where('status', 4)
            ->whereBetween('updated_at', [now()->subDays(7), now()])
            ->selectRaw('DATE(updated_at) as date, SUM(total_amount) as total')
            ->groupBy('date')
            ->orderBy('date', 'asc')
            ->get();

        // Chuyển dữ liệu sang mảng
        $dates = [];
        $revenues = [];
        foreach ($dailyRevenueLast7Days as $data) {
            $dates[] = Carbon::parse($data->date)->format('d/m/Y');
            $revenues[] = $data->total;
        }

        return view('admin.layout.yeld', compact('usersCount', 'productCount', 'ordersCount', 'totalRevenue', 'dates', 'revenues'));
    }

}
