@extends('layout.app')

@section('content')
    <div class="container-fluid px-4">
        <h1 class="mt-4">Events</h1>
        <ol class="breadcrumb mb-4">
            <li class="breadcrumb-item">Dashboard</li>
            <li class="breadcrumb-item active">Events</li>
        </ol>
        <div class="mb-2" style="text-align: right;">
            <a href="{{ route('events.create') }}" class="btn btn-primary btn-sm" >Add new event</i></a>
        </div>

        <div class="card mb-4">
            <div class="card-body">
                <table id="datatablesSimple">
                    <thead>
                        <tr>
                            <th class="text-center">#</th>
                            <th>Name</th>
                            <th>Slug</th>
                            <th>Start At</th>
                            <th>End At</th>
                            <th></th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($events as $key => $event)
                            <tr>
                                <td class="text-center">{{ $key +1 }}</td>
                                <td><a href="{{ route('events.show', $event->id) }}">{{ $event->name }}</a></td>
                                <td>{{ $event->slug }}</td>
                                <td>{{ $event->startAt }}</td>
                                <td>{{ $event->endAt }}</td>
                                <td class="col-sm-1 align-middle">
                                    <form action="{{ route('events.destroy', $event->id) }}" method="post" class="d-inline">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn btn-danger btn-sm"><i class="fas fa-trash"></i></button>
                                    </form>

                                    <a href="{{ route('events.edit', $event->id) }}" class="btn btn-secondary btn-sm" ><i class="fas fa-pencil-square"></i></a>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
@stop