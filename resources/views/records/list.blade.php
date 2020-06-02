
@extends('layouts.app')

@section('content')
    <div class="row">
        <div class="col-lg-12 margin-tb">
            <div class="pull-left">
                <h2>Пластинки:</h2>
            </div>
            <div class="pull-right">
                <a class="btn btn-success" href="{{ route('records.create') }}">Добавить пластинку</a>
            </div>
        </div>
    </div>

    @if ($message = Session::get('success'))
        <div class="alert alert-success">
            <p>{{ $message }}</p>
        </div>
    @endif

    <table class="table table-bordered">
        <tr>
            <th>Image</th>
            <th>Name</th>
            <th>Details</th>
            <th width="280px">Action</th>
        </tr>
        @foreach ($records as $record)
            <tr>
                <td><img src="{{ asset($record->image ?? ('img/vinil.png'))  }}" alt="" style="max-width: 100px; display: flex; margin: auto"></td>
                <td>{{ $record->title }}</td>
                <td>{{ $record->description }}</td>
                <td>
                    <form action="{{ route('records.destroy', $record->id) }}" method="POST">

                        <a class="btn btn-info" href="{{ route('records.show', $record->id) }}">Show</a>

                        <a class="btn btn-primary" href="{{ route('records.edit', $record->id) }}">Edit</a>

                        @csrf
                        @method('DELETE')

                        <button type="submit" class="btn btn-danger">Delete</button>
                    </form>
                </td>
            </tr>
        @endforeach
    </table>

    {!! $records->links() !!}
@endsection
