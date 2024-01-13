<div class="card ">
    <div class="card-header">
        <div class="row">
            <div class="col-8">
                <h4 class="card-title">{{__('Documentation List')}}</h4>
            </div>
            <div class="col-4 text-right">
                <a href="javascript:void(0)" wire:click="create()" class="btn btn-sm btn-primary">{{ __('Add Documentation') }}</a>
            </div>
        </div>
    </div>
    <div class="card-body">
        @include('alerts.success',['key'=>'message'])
        <table class="table table-striped datatable">
            <thead>
                <tr>
                    <th>{{__('SL')}}</th>
                    <th>{{__('Module Key')}}</th>
                    <th>{{__('Documentation')}}</th>
                    <th>{{ __('Creation date') }}</th>
                    <th>{{ __('Created by') }}</th>
                    <th>{{__('Action')}}</th>
                </tr>
            </thead>
            <tbody>
                @foreach($datas as $data)
                <tr>
                    <td>{{ $loop->iteration }}</td>
                    <td>{{ $data->module_key }}</td>
                    <td>{{ $data->documentation }}</td>
                    <td>{{ timeFormate($data->created_at) }}</td> 
                    <td>{{ $data->created_user->name ?? 'System' }}</td>
                    <td>


                        <div class="dropdown">
                            <a class="btn btn-sm btn-icon-only text-light" href="javascript:void(0)" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                <i class="fas fa-ellipsis-v"></i>
                            </a>
                            <div class="dropdown-menu dropdown-menu-right dropdown-menu-arrow">
                                    <a class="dropdown-item" data-bs-toggle="modal" data-bs-target="#updateStudentModal" wire:click="show({{ $data->id }})" href="javascript:void(0)">{{ __('View Details') }}</a>
                                    <a class="dropdown-item" wire:click="edit({{ $data->id }})" href="javascript:void(0)">{{ __('Update') }}</a>
                                    <a class="dropdown-item" wire:click="delete({{ $data->id }})" href="javascript:void(0)">{{ __('Delete') }}</a>
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

{{-- Bootstrap Modal --}}
<div wire:ignore.self class="modal fade" id="updateStudentModal" role="dialog" tabindex="-1" aria-labelledby="updateStudentModalLabel"
    aria-hidden="true">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="updateStudentModalLabel">{{__('Edit Documentaion')}}</h5>
                <button type="button" class="close" data-bs-dismiss="modal" wire:click="closeModal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
                <div class="modal-body">
                    <table class="table table-striped">
                        <tr>
                            <th class="text-nowrap">{{__('Module Key')}}</th>
                            <th>:</th>
                            <td>{{ $module_key }}</td>
                        </tr>
                        <tr>
                            <th class="text-nowrap">{{__('Documentation')}}</th>
                            <th>:</th>
                            <td>{{$documentation}}</td>
                        </tr>
                        <tr>
                            <th class="text-nowrap">{{__('Created By')}}</th>
                            <th>:</th>
                            <td>{{$created_user}}</td>
                        </tr>
                        <tr>
                            <th class="text-nowrap">{{__('Creation Date')}}</th>
                            <th>:</th>
                            <td>{{timeFormate($creation_date)}}</td>
                        </tr>
                        <tr>
                            <th class="text-nowrap">{{__('Updated By')}}</th>
                            <th>:</th>
                            <td>{{$updated_user ?? 'N/A'}}</td>
                        </tr>
                        <tr>
                            <th class="text-nowrap">{{__('Updated Date')}}</th>
                            <th>:</th>
                            <td>{{$creation_date ? timeFormate($creation_date) : 'N/A'}}</td>
                        </tr>
                    </table>
                </div>
                <div class="modal-footer">
                </div>
        </div>
    </div>
</div>