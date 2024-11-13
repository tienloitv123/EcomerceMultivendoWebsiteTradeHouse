<div>
    @if (session()->has('message'))
        <div class="alert alert-success">{{ session('message') }}</div>
    @endif

    <div class="profile-tab">
        <ul class="nav nav-tabs">
            <li class="nav-item">
                <a wire:click.prevent="$set('tab', 'personal_details')" class="nav-link {{ $tab == 'personal_details' ? 'active' : '' }}">Personal Details</a>
            </li>
        </ul>
        <div class="tab-content">
            <div class="tab-pane fade {{ $tab == 'personal_details' ? 'show active' : '' }}">
                <form wire:submit.prevent="updateClientDetails">
                    <div class="form-group">
                        <label>Name</label>
                        <input type="text" class="form-control" wire:model="name">
                        @error('name') <span class="text-danger">{{ $message }}</span> @enderror
                    </div>
                    <div class="form-group">
                        <label>Address</label>
                        <input type="text" class="form-control" wire:model="address">
                        @error('address') <span class="text-danger">{{ $message }}</span> @enderror
                    </div>
                    <div class="form-group">
                        <label>Phone</label>
                        <input type="text" class="form-control" wire:model="phone">
                        @error('phone') <span class="text-danger">{{ $message }}</span> @enderror
                    </div>
                    <div class="form-group">
                        <label>Email</label>
                        <input type="email" class="form-control" wire:model="email">
                        @error('email') <span class="text-danger">{{ $message }}</span> @enderror
                    </div>
                    <button type="submit" class="btn btn-primary">Save Changes</button>
                </form>
            </div>
        </div>
    </div>
</div>
