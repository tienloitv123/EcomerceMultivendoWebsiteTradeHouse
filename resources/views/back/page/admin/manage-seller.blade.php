@extends('back.layout.pages-layout')
@section('pageTitle', isset($pageTitle) ? $pageTitle : 'Seller List')
 @section('content')
    <div class="container mt-4">
        <h2 class="mb-4">Manage Sellers</h2>
        <table class="table table-bordered table-striped">
            <thead class="table-dark">
                <tr>
                    <th>ID</th>
                    <th>Name</th>
                    <th>Email</th>
                    <th>Shop Name</th>
                    <th>Created At</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($sellers as $seller)
                    <tr>
                        <td>{{ $seller->id }}</td>
                        <td>{{ $seller->name }}</td>
                        <td>{{ $seller->email }}</td>
                        <td>{{ $seller->shop->shop_name ?? 'N/A' }}</td>
                        <td>{{ $seller->created_at->format('d-m-Y H:i') }}</td>
                    </tr>
                @endforeach
            </tbody>
        </table>

        <!-- Pagination Links -->
        @if (method_exists($sellers, 'links'))
            <div class="mt-4">
                {{ $sellers->links() }}
            </div>
        @endif
    </div>
@endsection
