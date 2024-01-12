<div class="card ">
    <div class="card-header">
        <div class="row">
            <div class="col-8">
                <h4 class="card-title">{{__('Admin List')}}</h4>
            </div>
            <div class="col-4 text-right">
                <a href="javascript:void(0)" wire:click="create()" class="btn btn-sm btn-primary">{{ __('Add Posts') }}</a>
            </div>
        </div>
    </div>
    <div class="card-body">
        @if (session()->has('message'))
            <div class="alert alert-success">
                {{ session('message') }}
            </div>
        @endif
        <table class="table table-striped datatable">
            <thead>
                <tr>
                    <th>{{__('SL')}}</th>
                    <th>{{__('Title')}}</th>
                    <th>{{__('Body')}}</th>
                    <th>{{__('Action')}}</th>
                </tr>
            </thead>
            <tbody>
                @foreach($posts as $post)
                <tr>
                    <td>{{ $loop->iteration }}</td>
                    <td>{{ $post->title }}</td>
                    <td>{{ $post->body }}</td>
                    <td>


                        <div class="dropdown">
                            <a class="btn btn-sm btn-icon-only text-light" href="javascript:void(0)" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                <i class="fas fa-ellipsis-v"></i>
                            </a>
                            <div class="dropdown-menu dropdown-menu-right dropdown-menu-arrow">
                                
                                    <a class="dropdown-item" wire:click="edit({{ $post->id }})" href="javascript:void(0)">{{ __('Update') }}</a>
                                    <a class="dropdown-item" wire:click="delete({{ $post->id }})" href="javascript:void(0)">{{ __('Delete') }}</a>
                            </div>
                        </div>
                    </td>
                </tr>
                @endforeach

            </tbody>
        </table>
    </div>
    <div class="card-footer py-4">
        <nav class="d-flex justify-content-end" aria-label="...">
        </nav>
    </div>
</div>