<div class="row px-3 pt-3">
    <div class="col-md-8">
        <div class="card">
            <div class="card-header">
                <div class="row">
                    <div class="col-8">
                        <h4 class="card-title">{{ __('Create Documentation') }}</h4>
                    </div>
                    <div class="col-4 text-right">
                        <a href="javascript:void(0)" wire:click="cancel()" class="btn btn-sm btn-primary">{{ __('Back') }}</a>
                    </div>
                </div>
            </div>
            <div class="card-body">
                <form wire:submit.prevent="store">
                    <div class="form-group">
                        <label for="module_key">{{__('Module Key')}}</label>
                        <input type="text" wire:model="module_key" class="form-control @error('module_key') is-invalid @enderror" wire:keyup="validateField('module_key')" placeholder="Enter name" value="{{ old('module_key') }}">
                        @error('module_key') <span class="text-danger">{{ $message }}</span>@enderror
                    </div>
                    <div class="form-group">
                        <label for="documentation">{{__('Documentation')}}</label>
                        <textarea class="form-control @error('documentation') is-invalid @enderror" wire:keyup="validateField('documentation')" wire:model="documentation" placeholder="Enter Body">{{ old('documentation') }}</textarea>
                        @error('documentation') <span class="text-danger">{{ $message }}</span>@enderror
                    </div>
                    <button type="submit" class="btn btn-primary">{{__('Create')}}</button>
                    <button wire:click.prevent="cancel()" class="btn btn-danger">{{__('Cancel')}}</button>
                </form>
            </div>
        </div>
    </div>
    <div class="col-md-4">
        <div class="card">
            <div class="card-body">
                <p class="card-header">
                    <b>{{__('Documentation')}}</b>
                </p>
                <div class="card-body">
                    <p><b>User Name:</b> This field is required. It is a text field with character limit of 6-255 characters </p>

                    <p><b>Email:</b> This field is required and unique. It is a email field with a maximum character limit of 255. The entered value must follow the standard email format (e.g., user@example.com).</p>

                    <p><b>Password:</b> This field is required. It is a password field. Password strength should meet the specified criteria (e.g., include uppercase and lowercase letters, numbers, and special characters). The entered password should be a minimum of 6 characters.</p>

                    <p><b>Confirm Password:</b> This field is required. It is a password field. It should match the entered password in the "Password" field.</p>

                    <p><b>Role:</b> This field is required. This is an option field. It represents the user's role.</p>
                </div>
            </div>
        </div>
    </div>
</div>