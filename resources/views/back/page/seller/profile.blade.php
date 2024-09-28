@extends('back.layout.pages-layout')
@section('pageTitle', isset($pageTitle) ? $pageTitle : 'Page title here')
@section('content')

<div class="page-header">
    <div class="row">
        <div class="col-md-12 col-sm-12">
            <div class="title">
                <h4>Profile</h4>
            </div>
            <nav aria-label="breadcrumb" role="navigation">
                <ol class="breadcrumb">
                    <li class="breadcrumb-item">
                        <a href="{{ route('seller.home') }}">Home</a>
                    </li>
                    <li class="breadcrumb-item active" aria-current="page">
                        Profile
                    </li>
                </ol>
            </nav>
        </div>
    </div>
</div>

@livewire('seller.seller-profile')

@endsection

@push('scripts')
    <script>
        window.addEventListener('updateSellerInfo', function(event){
            $('#sellerProfileName').html(event.detail[0].sellerName);
            $('#sellerProfileEmail').html(event.detail[0].sellerEmail);
        });

        $('input[type="file"][name="sellerProfilePictureFile"][id="sellerProfilePictureFile"]').ijaboCropTool({
          preview : '#sellerProfilePicture',
          setRatio:1,
          allowedExtensions: ['jpg', 'jpeg','png'],
          buttonsText:['CROP','QUIT'],
          buttonsColor:['#30bf7d','#ee5155', -15],
          processUrl:'{{ route("seller.change-profile-picture") }}',
          withCSRF:['_token','{{ csrf_token() }}'],
          onSuccess:function(message, element, status){
            Livewire.emit('updateSellerHeaderInfo');
            alert(message);
          },
          onError:function(message, element, status){
            alert(message);
          }
       });
    </script>
@endpush
