@php use App\Enums\PayloadHistoryStatus; @endphp
@extends('layouts.app')
@section('content')
@include('common.flash-message')
<link rel="stylesheet" href="{{ mix('/css/style.css') }}">
<ul class="breadcrumb breadcrumb-top">
    <li>Payload histories</li>
    <li><a href="{{ route('admin.history.index') }}">Lists</a></li>
</ul>
<!-- END Datatables Header -->

<!-- Datatables Content -->
<div class="block">
    <div class="form-group row">
        {{ Form::open(['method' => 'GET','route' => 'admin.history.index']) }}
            <div class="col-xs-4">
                <select name="search[webhook]" class="select-select2" style="width: 100%;" data-placeholder="Choose a webhook">
                    <option></option>
                    @foreach($webhooks as $key => $value)
                        <option value="{{ $value }}" {{ (request('search')['webhook'] ?? '') == $value ? 'selected' : '' }}>
                            {{ $key }}
                        </option>
                    @endforeach
                </select>
            </div>
            <div class="col-xs-4">
                <select name="search[status]" class="select-select2" style="width: 100%;" data-placeholder="Choose a status">
                    <option></option>
                    @foreach($payloadHistoryStatuses as $key => $value)
                        <option value="{{ $key }}" {{ (request('search')['status'] ?? '') == $key ? 'selected' : '' }}>
                            {{ ucfirst(strtolower($key)) }}
                        </option>
                    @endforeach
                </select>
            </div>
            <button class="btn btn-md btn-search"><i class="fa fa-search"></i> search</button>
        {{ Form::close() }}
    </div>
</div>
<script>

</script>
<div class="block full">
    <div class="block-title">
        <h2><strong>List payload histories</strong></h2>
    </div>
    <div class="table-responsive">
        <table class="table table-vcenter table-striped">
            <thead>
                <tr>
                    <th>No.</th>
                    <th>Webhook</th>
                    <th>User</th>
                    <th >Status</th>
                    <th>Log</th>
                    <th class="text-center">Sent at</th>
                    <th class="text-center">Actions</th>
                </tr>
            </thead>
            <tbody>
                @if(Request::get('search') && $payloadHistories->count() == 0)
                <p class="tbl-no-data "><i class="fa fa-info-circle"></i> No matching records found</p>
                @elseif($payloadHistories->count() == 0)
                <p class="tbl-no-data "><i class="fa fa-info-circle"></i> No data</p>
                @else
                    @foreach($payloadHistories as $payloadHistory)
                    <tr class="item-{{ $payloadHistory->id }} user-item">
                        <td>{{ Helper::indexNumber(app('request')->input('page'), config('paginate.perPage'), $loop->iteration) }}</td>
                        <td>
                            {{ $payloadHistory->webhook->name }}
                        </td>
                        <td>
                            {{ $payloadHistory->webhook->user->name }}
                        </td>
                        <td>
                            @if($payloadHistory->status === PayloadHistoryStatus::SUCCESS)
                                <div class="label label-success">Success</div>
                            @else
                                <div class="label label-danger">Failed</div>
                            @endif
                        </td>
                        <td><a href="page_ready_user_profile.html">{{ $payloadHistory->log }}</a></td>
                        <td class="text-center">{{ $payloadHistory->created_at }}</td>
                        <td class="text-center">
                            <a class="btn btn-sm btn-default" href="{{ route('admin.history.show', ['history' => $payloadHistory->id]) }}">
                                <i class="fa fa-pencil"></i>Detail
                            </a>
                        </td>
                    </tr>
                    @endforeach
                @endif
            </tbody>
        </table>
        <div class="pagination-wrapper text-center"> {{ $payloadHistories->appends(['search' => Request::get('search')])->render() }} </div>
    </div>
</div>
<!-- END Datatables Content -->

@endsection
