@extends('back.layout.pages-layout')
@section('pageTitle', 'Seller Dashboard')
@section('content')
<div class="container mt-4">

    <!-- Overview -->
    <div class="row">
        <div class="col-md-3">
            <div class="card border-left-primary shadow h-100 py-2">
                <div class="card-body">
                    <h5>Earnings Today</h5>
                    <p class="text-primary">${{ number_format($dailyRevenue, 2) }}</p>
                </div>
            </div>
        </div>
        <div class="col-md-3">
            <div class="card border-left-success shadow h-100 py-2">
                <div class="card-body">
                    <h5>Earnings This Month</h5>
                    <p class="text-success">${{ number_format($monthlyRevenue, 2) }}</p>
                </div>
            </div>
        </div>
        <div class="col-md-3">
            <div class="card border-left-info shadow h-100 py-2">
                <div class="card-body">
                    <h5>Earnings This Year</h5>
                    <p class="text-info">${{ number_format($yearlyRevenue, 2) }}</p>
                </div>
            </div>
        </div>
        <div class="col-md-3">
            <div class="card border-left-warning shadow h-100 py-2">
                <div class="card-body">
                    <h5>Products Sold</h5>
                    <p class="text-warning">{{ $totalProductsSold }}</p>
                </div>
            </div>
        </div>
    </div>

    <!-- Charts -->
    <div class="row mt-4">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">Revenue Over Time</div>
                <div class="card-body">
                    <canvas id="revenueChart"></canvas>
                </div>
            </div>
        </div>
        <div class="col-md-4">
            <div class="card">
                <div class="card-header">Order Analysis</div>
                <div class="card-body">
                    <canvas id="orderPieChart"></canvas>
                </div>
            </div>
        </div>
    </div>

    <!-- Top Selling Products -->
    <div class="row mt-4">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header">Top Selling Products</div>
                <div class="card-body">
                    <table class="table">
                        <thead>
                            <tr>
                                <th>#</th>
                                <th>Product Name</th>
                                <th>Units Sold</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($topProducts as $index => $product)
                                <tr>
                                    <td>{{ $index + 1 }}</td>
                                    <td>{{ $product->product->name }}</td>
                                    <td>{{ $product->total_sold }}</td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
    // Revenue Chart
    const revenueChart = new Chart(document.getElementById('revenueChart'), {
        type: 'line',
        data: {
            labels: @json($revenueData->pluck('date')),
            datasets: [{
                label: 'Revenue ($)',
                data: @json($revenueData->pluck('revenue')),
                borderColor: 'rgba(75, 192, 192, 1)',
                backgroundColor: 'rgba(75, 192, 192, 0.2)',
                fill: true
            }]
        }
    });

    // Pie Chart
    const orderPieChart = new Chart(document.getElementById('orderPieChart'), {
        type: 'pie',
        data: {
            labels: ['Completed', 'Processing', 'Cancelled'],
            datasets: [{
                data: @json(array_values($orderStats)),
                backgroundColor: ['#28a745', '#ffc107', '#dc3545']
            }]
        }
    });
</script>
@endsection
