@extends('front.layout.pages-layout')
@section('pageTitle', 'Edit Profile')
@section('content')

<div class="page-header">
    <div class="row">
        <div class="col-md-12">
            <h4>Edit Profile</h4>
            <nav aria-label="breadcrumb" role="navigation">
                <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a href="{{ route('client.home') }}">Home</a></li>
                    <li class="breadcrumb-item active" aria-current="page">Profile</li>
                </ol>
            </nav>
        </div>
    </div>
</div>

@livewire('client.client-profile')

@endsection

@push('scripts')
<script>
    document.getElementById('clientProfilePictureFile').addEventListener('change', function() {
        const fileInput = this;
        if (fileInput.files && fileInput.files[0]) {
            const reader = new FileReader();
            reader.onload = function(e) {
                document.getElementById('clientProfilePicture').src = e.target.result;
            }
            reader.readAsDataURL(fileInput.files[0]);
        }
    });

    $('#clientProfilePictureFile').ijaboCropTool({
        preview: '#clientProfilePicture',
        setRatio: 1,
        allowedExtensions: ['jpg', 'jpeg', 'png'],
        processUrl: '{{ route("client.change-profile-picture") }}',
        withCSRF: ['_token', '{{ csrf_token() }}'],
        onSuccess: function(message, element, status) {
            Livewire.emit('updateClientHeaderInfo');
            alert(message);
        },
        onError: function(message, element, status) {
            alert(message);
        }
    });
</script>
@endpush
