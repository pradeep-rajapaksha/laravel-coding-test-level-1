@extends('layout.app')

@section('content')
    <div class="container-fluid px-4">
        <h1 class="mt-4">Events</h1>
        <ol class="breadcrumb mb-4">
            <li class="breadcrumb-item">Dashboard</li>
            <li class="breadcrumb-item">Events</li>
            <li class="breadcrumb-item active">Edit</li>
        </ol>

        <div class="card mb-4">
            <div class="card-body">
                <form action="{{ route('events.update', $event->id) }}" method="post">
                    @csrf
                    @method('PATCH')
                    @include('events.form')
                </form>
            </div>
        </div>
    </div>
@stop