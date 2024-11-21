@extends('back.layout.pages-layout')
@section('pageTitle', 'Admin Dashboard')
@section('content')
<div class="container-fluid">

    <!-- Tổng quan -->
    <div class="row">
        <div class="col-xl-3 col-md-6 mb-4">
            <div class="card border-left-primary shadow h-100 py-2">
                <div class="card-body">
                    <div class="text-xs font-weight-bold text-primary text-uppercase mb-1">
                        Total Orders</div>
                    <div class="h5 mb-0 font-weight-bold text-gray-800">{{ $totalOrders }}</div>
                </div>
            </div>
        </div>

        <div class="col-xl-3 col-md-6 mb-4">
            <div class="card border-left-success shadow h-100 py-2">
                <div class="card-body">
                    <div class="text-xs font-weight-bold text-success text-uppercase mb-1">
                        Total Revenue</div>
                    <div class="h5 mb-0 font-weight-bold text-gray-800">${{ number_format($totalRevenue, 2) }}</div>
                </div>
            </div>
        </div>

            <div class="col-xl-3 col-md-6 mb-4">
                <div class="card border-left-info shadow h-100 py-2">
                    <div class="card-body">
                        <div class="text-xs font-weight-bold text-info text-uppercase mb-1">
                            Total Products</div>
                        <div class="h5 mb-0 font-weight-bold text-gray-800">{{ $activeProducts }}</div>
                    </div>
                </div>
            </div>

        <div class="col-xl-3 col-md-6 mb-4">
            <div class="card border-left-warning shadow h-100 py-2">
                <div class="card-body">
                    <div class="text-xs font-weight-bold text-warning text-uppercase mb-1">
                        Total Users</div>
                    <div class="h5 mb-0 font-weight-bold text-gray-800">{{ $totalUsers }}</div>
                </div>
            </div>
        </div>
    </div>

    <!-- Biểu đồ Doanh Thu -->
    <div class="row mt-4">
        <div class="col-xl-8 col-lg-7">
            <div class="card shadow">
                <div class="card-header">
                    <h6 class="font-weight-bold text-primary">Revenue Analysis</h6>
                </div>
                <div class="card-body">
                    <canvas id="revenueLineChart"></canvas>
                </div>
            </div>
        </div>
        <div class="col-xl-4 col-lg-5">
            <div class="card shadow">
                <div class="card-header">
                    <h6 class="font-weight-bold text-primary">Revenue by Category</h6>
                </div>
                <div class="card-body">
                    <canvas id="revenueBarChart"></canvas>
                </div>
            </div>
        </div>
    </div>

    <!-- Phân tích đơn hàng -->
    <div class="row mt-4">
        <div class="col-lg-12">
            <div class="card shadow">
                <div class="card-header">
                    <h6 class="font-weight-bold text-primary">Order Analysis</h6>
                </div>
                <div class="card-body">
                    <canvas id="orderPieChart"></canvas>
                </div>
            </div>
        </div>
    </div>

    <!-- Thống kê người dùng -->
    <div class="row mt-4">
        <div class="col-xl-8 col-lg-7">
            <div class="card shadow">
                <div class="card-header">
                    <h6 class="font-weight-bold text-primary">User Growth</h6>
                </div>
                <div class="card-body">
                    <canvas id="userGrowthLineChart"></canvas>
                </div>
            </div>
        </div>
        <div class="col-xl-4 col-lg-5">
            <div class="card shadow">
                <div class="card-header">
                    <h6 class="font-weight-bold text-primary">User Distribution</h6>
                </div>
                <div class="card-body">
                    <canvas id="userPieChart"></canvas>
                </div>
            </div>
        </div>
    </div>

    <!-- Logs và thông báo -->
    <div class="row mt-4">
        <div class="col-lg-6">
            <div class="card shadow">
                <div class="card-header">
                    <h6 class="font-weight-bold text-primary">Recent Orders</h6>
                </div>
                <div class="card-body">
                    <ul>
                        @foreach ($recentOrders as $order)
                            <li>Order #{{ $order->id }} - ${{ number_format($order->total_amount, 2) }}</li>
                        @endforeach
                    </ul>
                </div>
            </div>
        </div>
        <div class="col-lg-6">
            <div class="card shadow">
                <div class="card-header">
                    <h6 class="font-weight-bold text-primary">Recent Users</h6>
                </div>
                <div class="card-body">
                    <ul>
                        @foreach ($recentUsers as $user)
                            <li>{{ $user->name }} ({{ $user instanceof App\Models\Client ? 'Client' : 'Seller' }})</li>
                        @endforeach
                    </ul>
                </div>
            </div>
        </div>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
    // Revenue Line Chart
    const revenueLineChart = new Chart(document.getElementById('revenueLineChart'), {
        type: 'line',
        data: {
            labels: @json($revenueByDate->pluck('date')),
            datasets: [{
                label: 'Revenue',
                data: @json($revenueByDate->pluck('revenue')),
                borderColor: '#4e73df',
                backgroundColor: 'rgba(78, 115, 223, 0.2)',
            }]
        }
    });

    // Revenue by Category Bar Chart
    const revenueBarChart = new Chart(document.getElementById('revenueBarChart'), {
        type: 'bar',
        data: {
            labels: @json($revenueByCategory->pluck('name')),
            datasets: [{
                label: 'Revenue',
                data: @json($revenueByCategory->pluck('revenue')),
                backgroundColor: '#36b9cc',
            }]
        }
    });

    // Order Pie Chart
    const orderPieChart = new Chart(document.getElementById('orderPieChart'), {
        type: 'pie',
        data: {
            labels: ['Completed', 'Processing', 'Canceled'],
            datasets: [{
                data: [{{ $orderStats['completed'] }}, {{ $orderStats['processing'] }}, {{ $orderStats['canceled'] }}],
                backgroundColor: ['#4e73df', '#1cc88a', '#e74a3b'],
            }]
        }
    });

    // User Growth Line Chart
    const userGrowthLineChart = new Chart(document.getElementById('userGrowthLineChart'), {
        type: 'line',
        data: {
            labels: @json($userGrowth->pluck('date')),
            datasets: [{
                label: 'New Clients',
                data: @json($userGrowth->pluck('total_clients')),
                borderColor: '#4e73df',
                backgroundColor: 'rgba(78, 115, 223, 0.2)',
            }, {
                label: 'New Sellers',
                data: @json($sellerGrowth->pluck('total_sellers')),
                borderColor: '#1cc88a',
                backgroundColor: 'rgba(28, 200, 138, 0.2)',
            }]
        }
    });

    // User Distribution Pie Chart
    const userPieChart = new Chart(document.getElementById('userPieChart'), {
        type: 'pie',
        data: {
            labels: ['Clients', 'Sellers'],
            datasets: [{
                data: [{{ $totalClients }}, {{ $totalSellers }}],
                backgroundColor: ['#4e73df', '#1cc88a'],
            }]
        }
    });
</script>
@endsection
