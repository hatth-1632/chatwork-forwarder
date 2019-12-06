@extends('layouts.app')
<link rel="stylesheet" href="{{ mix('/css/style.css') }}">
@section('content')
<ul class="breadcrumb breadcrumb-top">
    <li>Home</li>
    <li><a href="">Bots</a></li>
</ul>
<!-- END Datatables Header -->

<!-- Datatables Content -->

<div class="block full">
    <div class="block-title">
        <h2><strong>List bots</strong></h2>
        <a href="{{ route('bots.create') }}" class="btn-pull-right btn btn-md btn-primary"><i class="fa fa-plus-circle"></i> Create</a>
    </div>
    @include('common.flash-message')

    <div class="table-responsive">
        @include('bots.modal')
        <table id="bot-datatable" class="table table-vcenter table-condensed table-bordered" data-toggle="dataTable" data-form="deleteForm">
            <thead>
                <tr>
                    <th>Name</th>
                    <th>CW ID</th>
                    <th class="text-center">Actions</th>
                </tr>
            </thead>
            <tbody>
                @foreach($bots as $bot)
                    <tr>
                        <td class="pl-20">{{ $bot->name }}</td>
                        <td class="pl-20">{{ $bot->cw_id }}</td>
                        <td class="text-center">
                            <a class="btn btn-sm btn-default" href="{{ route('bots.edit', $bot->id) }}"><i class="fa fa-pencil"></i> Edit</a>

                            {{ Form::open([
                                'method' => 'DELETE',
                                'route' => ['bots.destroy', 'bot' => $bot],
                                'style' => 'display:inline',
                                'class' => 'form-delete'
                            ]) }}
                            {{ Form::button('<i class="fa fa-trash-o"></i> Delete' , [
                                'type' => 'DELETE',
                                'class' => 'btn btn-sm btn-danger delete-btn',
                                'title' => 'Delete'
                            ]) }}
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</div>
<!-- END Datatables Content -->
@endsection
@section('js')
    <script src="{{ asset('/js/bot.js') }}"></script>
@endsection
