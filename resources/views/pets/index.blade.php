@extends('pets.layout')

@section('content')
    @if ($errors->any())
        <div style="color: red; padding: 10px; background-color: #f8d7da; border: 1px solid #f5c6cb; border-radius: 5px;">
            <ul>
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    @if(isset($error_message))
        <div style="color: red; padding: 10px; background-color: #f8d7da; border: 1px solid #f5c6cb; border-radius: 5px;">
            {{ $error_message }}
        </div>
    @endif

    <div class="container mb-3 text-end">
        <a href="{{route('pets.create')}}" class="btn btn-primary">Dodaj Zwierzę</a>
    </div>

    <div class="container mb-3">
        Pets by status:
        @foreach($statuses as $status)
            <a href="{{route('pets.index') . '?status=' . $status}}" class="btn {{$status === $current_status ? 'btn-danger' : 'btn-primary'}}">{{$status}}</a>
        @endforeach
    </div>

    <div class="w-75 mx-auto">
        <table class="table table-striped table-bordered">
            <thead>
            <tr>
                <th>ID</th>
                <th>Name</th>
                <th>Status</th>
                <th>Category</th>
                <th>Tags</th>
                <th>Photos</th>
                <th>Actions</th>
            </tr>
            </thead>
            <tbody>
            @foreach($pets as $pet)
                <tr>
                    <td>{{ $pet->getId() }}</td>

                    <td>{{ $pet->getName() }}</td>

                    <td>{{ $pet->getStatus() }}</td>

                    <td>
                        @if($pet->getCategory())
                            {{ $pet->getCategory()->getName() }}
                        @else
                            No category assigned
                        @endif
                    </td>

                    <td>
                        @foreach($pet->getTags() as $tag)
                            {{ $tag->getName() }} @if(!$loop->last), @endif
                        @endforeach
                    </td>

                    <td>
                        @foreach($pet->getPhotoUrls() as $url)
                            <img src="{{ $url }}" alt="Pet photo" width="50" height="50" />
                        @endforeach
                    </td>

                    <td>
                        <a href="{{ route('pets.edit', $pet->getId()) }}" class="btn btn-warning btn-sm">Edit</a>
                        <form action="{{ route('pets.destroy', $pet->getId()) }}" method="POST" style="display:inline;">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn btn-danger btn-sm" onclick="return confirm('Are you sure you want to delete this pet?');">Delete</button>
                        </form>
                    </td>
                </tr>
            @endforeach
            </tbody>
        </table>
    </div>
@endsection
