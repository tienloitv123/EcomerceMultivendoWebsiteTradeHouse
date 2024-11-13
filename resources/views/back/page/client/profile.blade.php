@extends('front.layout.pages-layout')
@section('pageTitle', 'Edit Profile')
@section('content')

<style type="text/css">
    body {
        margin-top: 20px;
        background: #f8f8f8;
    }
</style>
<link href="https://maxcdn.bootstrapcdn.com/font-awesome/4.3.0/css/font-awesome.min.css" rel="stylesheet">

<div class="container">
    <div class="row flex-lg-nowrap">
        <div class="col">
            <div class="row">
                <div class="col mb-3">
                    <div class="card">
                        <div class="card-body">
                            <div class="e-profile">
                                <div class="d-flex justify-content-center">
                                    <div class="col-xl-4 col-lg-4 col-md-4 col-sm-12 mb-30">
                                        <div class="pd-20 card-box height-100-p text-center">
                                            <div class="profile-photo position-relative">
                                                <!-- Kích hoạt chọn file khi click vào icon pencil -->
                                                <a href="javascript:;" onclick="event.preventDefault();document.getElementById('clientProfilePictureFile').click();" class="edit-avatar">
                                                    <i class="fa fa-pencil"></i>
                                                </a>
                                                <!-- Ảnh hồ sơ của client -->
                                                <img src="{{ asset('images/users/clients/' . $client->picture) }}" alt="Profile Picture" class="avatar-photo rounded-circle mx-auto" id="clientProfilePicture" style="width: 140px; height: 140px;">
                                                <!-- Input file ẩn để chọn ảnh mới -->
                                                <input type="file" name="clientProfilePictureFile" id="clientProfilePictureFile" class="d-none" style="opacity: 0;">
                                            </div>
                                            <!-- Tên và email của client -->
                                            <h5 class="text-center h5 mb-0 mt-3" id="clientProfileName">{{ $client->name }}</h5>
                                            <p class="text-center text-muted font-14" id="clientProfileEmail">
                                                {{ $client->email }}
                                            </p>
                                        </div>
                                    </div>
                                </div>

                                <ul class="nav nav-tabs">
                                    <li class="nav-item"><a href="#" class="active nav-link">Settings</a></li>
                                </ul>
                                <div class="tab-content pt-3">
                                    <div class="tab-pane active">
                                        <form action="{{ route('client.update-profile') }}" method="POST" novalidate>
                                            @csrf
                                            <div class="row">
                                                <div class="col">
                                                    <div class="row">
                                                        <div class="col">
                                                            <div class="form-group">
                                                                <label>Full Name</label>
                                                                <input class="form-control" type="text" name="name" value="{{ old('name', $client->name) }}">
                                                                @error('name') <span class="text-danger">{{ $message }}</span> @enderror
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="row">
                                                        <div class="col">
                                                            <div class="form-group">
                                                                <label>Email</label>
                                                                <input class="form-control" type="text" name="email" value="{{ old('email', $client->email) }}">
                                                                @error('email') <span class="text-danger">{{ $message }}</span> @enderror
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="row">
                                                        <div class="col">
                                                            <div class="form-group">
                                                                <label>Phone</label>
                                                                <input class="form-control" type="text" name="phone" value="{{ old('phone', $client->phone) }}">
                                                                @error('phone') <span class="text-danger">{{ $message }}</span> @enderror
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="row">
                                                        <div class="col mb-3">
                                                            <div class="form-group">
                                                                <label>Address</label>
                                                                <textarea class="form-control" name="address" rows="1">{{ old('address', $client->address) }}</textarea>
                                                                @error('address') <span class="text-danger">{{ $message }}</span> @enderror
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="row">
                                                <div class="col d-flex justify-content-end">
                                                    <button class="btn btn-primary" type="submit">Save Changes</button>
                                                </div>
                                            </div>
                                        </form>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="">
                        <div class="card mb-3">
                            <div class="card-body">
                                <div class="px-xl-6">
                                    <form action="{{ route('client.logout') }}" method="POST">
                                        @csrf
                                        <button class="btn btn-danger" type="submit">
                                            <i class="fa fa-sign-out"></i>
                                            <span>Logout</span>
                                        </button>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<script src="https://code.jquery.com/jquery-1.10.2.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@4.1.1/dist/js/bootstrap.bundle.min.js"></script>
<script src="/extra-assets/ijaboCropTool/ijaboCropTool.min.js"></script>

<script>

    $('input[type="file"][name="clientProfilePictureFile"][id="clientProfilePictureFile"]').ijaboCropTool({
    preview: '#clientProfilePicture',
    setRatio: 1,
    allowedExtensions: ['jpg', 'jpeg', 'png'],
    buttonsText: ['CROP', 'QUIT'],
    buttonsColor: ['#30bf7d', '#ee5155', -15],
    processUrl: '{{ route("client.change-profile-picture") }}',
    withCSRF: ['_token', '{{ csrf_token() }}'],
    onSuccess: function(message, element, status) {
        alert(message);
    },
    onError: function(message, element, status) {
        alert(message);
    }
});

</script>

@endsection
