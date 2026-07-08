@extends('layouts.tenant')

@section('title', 'Edit Task')

@section('content')
    @include('tenant.tasks.partials.form', [
        'action' => route('tenant.tasks.update', ['tenant' => $tenant->slug, 'task' => $task]),
        'method' => 'PUT',
        'task' => $task,
        'submitLabel' => 'Save Changes',
    ])
@endsection
