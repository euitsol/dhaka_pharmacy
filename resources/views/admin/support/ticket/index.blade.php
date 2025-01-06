@extends('admin.layouts.master', ['pageSlug' => 'ticket'])
@section('title', 'Support Ticket List')
@section('content')
    <div class="row">
        <div class="col-md-12">
            <div class="card ">
                <div class="card-header">
                    <div class="row">
                        <div class="col-8">
                            <h4 class="card-title">{{ __('Ticket List') }}</h4>
                        </div>
                        <div class="col-4 text-right">
                            {{-- @include('admin.partials.button', [
                                'routeName' => 'am.role.role_create',
                                'className' => 'btn-primary',
                                'label' => 'Add Role',
                            ]) --}}
                        </div>
                    </div>
                </div>
                <div class="card-body">

                    <table class="table table-striped datatable">
                        <thead class=" text-primary">
                            <tr>
                                <th>{{ __('SL') }}</th>
                                <th>{{ __('Subject') }}</th>
                                <th>{{ __('Status') }}</th>
                                <th>{{ __('Created By') }}</th>
                                <th>{{ __('Opened By') }}</th>
                                <th>{{ __('Created At') }}</th>
                                <th>{{ __('Updated At') }}</th>
                                <th class="text-center">{{ __('Action') }}</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($tickets as $ticket)
                                <tr>
                                    <td> {{ $loop->iteration }} </td>
                                    <td>{{ $ticket->subject }}</td>
                                    <td><span
                                            class="{{ $ticket->getStatusBadgeClass() }}">{{ $ticket->getStatus() }}</span>
                                    </td>
                                    <td>{{ $ticket->ticketable->name }}</td>
                                    <td>{{ optional($ticket->assignedAdmin)->name }}</td>
                                    <td>{{ timeFormate($ticket->created_at) }}</td>
                                    <td>{{ timeFormate($ticket->updated_at) }}</td>
                                    <td>
                                        {{-- @include('admin.partials.action_buttons', [
                                            'menuItems' => [
                                                [
                                                    'routeName' => 'javascript:void(0)',
                                                    'params' => [$role->id],
                                                    'label' => 'View Details',
                                                    'className' => 'view',
                                                    'data-id' => $role->id,
                                                ],
                                                [
                                                    'routeName' => 'am.role.role_edit',
                                                    'params' => [$role->id],
                                                    'label' => 'Update',
                                                ],
                                                [
                                                    'routeName' => 'am.role.role_delete',
                                                    'params' => [$role->id],
                                                    'label' => 'Delete',
                                                    'delete' => true,
                                                ],
                                            ],
                                        ]) --}}
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
        </div>
    </div>
@endsection
@include('admin.partials.datatable', ['columns_to_show' => [0, 1, 2, 3, 4, 5]])
