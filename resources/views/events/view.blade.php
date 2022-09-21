@extends('layout.app')

@section('content')
    <div class="container-fluid px-4">
        <h1 class="mt-4">Events</h1>
        <ol class="breadcrumb mb-4">
            <li class="breadcrumb-item">Dashboard</li>
            <li class="breadcrumb-item">Events</li>
            <li class="breadcrumb-item active">View Event</li>
        </ol>

        <div class="card mb-4">
            <div class="card-body">
                <table class="table">
                    <tbody>
                        <tr>
                            <th>Name</th>
                            <td>: {{ $event->name }}</td>
                        </tr>
                        <tr>
                            <th>Slug</th>
                            <td>: {{ $event->slug }}</td>
                        </tr>
                        <tr>
                            <th>Start At</th>
                            <td>: {{ $event->startAt }}</td>
                        </tr>
                        <tr>
                            <th>End At</th>
                            <td>: {{ $event->endAt }}</td>
                        </tr>
                    </tbody>
                </table>
                <div>
                    <a href="{{ route('events.index') }}" class="btn btn-secondary btn-sm">View all</a>

                    <a href="{{ route('events.edit', $event->id) }}" class="btn btn-primary btn-sm">Edit</a>

                    <form action="{{ route('events.destroy', $event->id) }}" method="post" class="d-inline">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="btn btn-danger btn-sm">Delete</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
@stop