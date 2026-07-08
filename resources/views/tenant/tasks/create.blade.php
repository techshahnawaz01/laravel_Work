@extends('layouts.tenant')

@section('title', 'Create Task')

@section('content')
    @include('tenant.tasks.partials.form', [
        'action' => route('tenant.tasks.store', ['tenant' => $tenant->slug]),
        'method' => 'POST',
        'task' => null,
        'submitLabel' => 'Create Task',
    ])
@endsection
