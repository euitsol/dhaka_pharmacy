<div class="card " wire:poll.5s="refresh">
    <div class="card-header">
        <div class="row">
            <div class="col-8">
                <h4 class="card-title">{{__('Test List')}}</h4>
            </div>
            <div class="col-4 text-right">
                <a href="javascript:void(0)" wire:loading.attr="disabled" wire:click="create()" class="btn btn-sm btn-primary">{{ __('Add Test') }}</a>
            </div>
        </div>
        <div class="row g-4 align-items-center">
            <div class="col-sm">
                <div class="col-xl-3">
                    <div class="col-sm">
                        <div class="d-flex">
                            <div class="search-box">
                                <input type="text" wire:model.live="search" class="form-control" autocomplete="off" placeholder="Search Users...">
                                <i class="ri-search-line search-icon"></i>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-lg-auto">
                <div class="d-flex flex-wrap align-items-start gap-2">
                    <div class="">
                        <select class="form-select bg-light" wire:model.live="size" name="size">
                            <option value="5">5</option>
                            <option selected value="10">10</option>
                            <option value="25">25</option>
                            <option value="50">50</option>
                            <option value="100">100</option>
                        </select>
                    </div>
                    <button type="button" class="btn btn-secondary" wire:click="exportPdf"><i class="ri-save-3-line align-bottom me-1"></i> Export PDF</button>
                    {{-- <button type="button" class="btn btn-secondary" onclick="window.print()"><i class="ri-printer-line align-bottom me-1"></i> Print</button> --}}
                    <button type="button" class="btn btn-secondary" wire:click="export('excel')"><i class="ri-save-3-line align-bottom me-1"></i> Export Excel</button>
                    <button type="button" class="btn btn-secondary" wire:click="export('csv')"><i class="ri-save-3-line align-bottom me-1"></i> Export CSV</button>
                </div>
            </div>
        </div>
    </div>
    <div class="card-body">
        @include('alerts.success',['key'=>'message'])
        <table class="table table-striped datatable">
            <thead>
                <tr>
                    <th>{{__('SL')}}</th>
                    <th>{{__('Name')}}</th>
                    <th>{{__('Roll')}}</th>
                    <th>{{ __('Creation date') }}</th>
                    <th>{{ __('Created by') }}</th>
                    <th>{{__('Action')}}</th>
                </tr>
            </thead>
            <tbody>
                
                @forelse($datas as $data)
                <tr>
                    <td>{{ $loop->iteration }}</td>
                    <td>{{ $data->name }}</td>
                    <td>{{ $data->roll }}</td>
                    <td>{{ timeFormate($data->created_at) }}</td> 
                    <td>{{ $data->created_user->name ?? 'System' }}</td>
                    <td>


                        <div class="dropdown">
                            <a class="btn btn-sm btn-icon-only text-light" href="javascript:void(0)" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                <i class="fas fa-ellipsis-v"></i>
                            </a>
                            <div class="dropdown-menu dropdown-menu-right dropdown-menu-arrow">
                                    <a class="dropdown-item" data-bs-toggle="modal" wire:loading.attr="disabled" data-bs-target="#updateStudentModal" wire:click="show({{ $data->id }})" href="javascript:void(0)">{{ __('View Details') }}</a>
                                    <a class="dropdown-item" wire:loading.attr="disabled" wire:click="edit({{ $data->id }})" href="javascript:void(0)">{{ __('Update') }}</a>
                                    <a class="dropdown-item" wire:loading.attr="disabled" wire:click="delete({{ $data->id }})" href="javascript:void(0)">{{ __('Delete') }}</a>
                            </div>
                        </div>
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="9">
                        <div class="text-center">
                            <lord-icon src="https://cdn.lordicon.com/msoeawqm.json" trigger="loop" colors="primary:#121331,secondary:#08a88a" style="width:75px;height:75px"></lord-icon>
                            <h5 class="mt-2">Sorry! No users found for matching "{{ $search }}".</h5>
                            <p class="text-muted mb-0">We've searched more than {{ $total_data }}+ users We did not find any users for you search.</p>
                        </div>
                    </td>
                </tr>
                @endforelse

            </tbody>
        </table>
    </div>
    <div class="card-footer">
        <div class="float-start">
            <div class="dataTables_info">Showing 1 to {{ count($datas) }} of {{ $total_data }} entries</div>
        </div>
        <div class="float-end">
            {{ $datas->links('vendor.livewire.bootstrap')}}
        </div>
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
                            <th class="text-nowrap">{{__('Name')}}</th>
                            <th>:</th>
                            <td>{{ $name }}</td>
                        </tr>
                        <tr>
                            <th class="text-nowrap">{{__('Roll')}}</th>
                            <th>:</th>
                            <td>{{$roll}}</td>
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



{{-- @include('admin.partials.datatable', ['columns_to_show' => [0, 1, 2, 3, 4, 5]]) --}}
