@extends('pets.layout')

@section('content')
    <div class="container mt-5">
        <div class="card mb-4">
            <div class="card-header">Dodaj nowe zwierzę</div>
            <div class="card-body">
                @if ($errors->any())
                    <div style="color: red;">
                        <ul>
                            @foreach ($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif

                <form action="{{ route('pets.store') }}" method="POST" enctype="multipart/form-data">
                    @csrf

                    <div class="mb-3">
                        <label for="name" class="form-label">Nazwa</label>
                        <input type="text" class="form-control" id="name" name="name" required>
                    </div>

                    <div class="mb-3">
                        <label for="status" class="form-label">Status</label>
                        <select class="form-control" id="status" name="status" required>
                            @foreach($statuses as $status)
                                <option value="{{$status}}">{{$status}}</option>
                            @endforeach
                        </select>
                    </div>

                    <div class="mb-3">
                        <label for="category" class="form-label">Kategoria</label>
                        <input type="text" class="form-control" id="category_name" name="category_name">
                    </div>

                    <div class="mb-3">
                        <label for="tags" class="form-label">Tagi (oddzielone przecinkami)</label>
                        <input type="text" class="form-control" id="tags" name="tags">
                    </div>

                    <div class="mb-3">
                        <label for="photos" class="form-label">Urle zdjęć (oddzielone przecinkami)</label>
                        <input type="text" class="form-control" id="photos" name="photos">
                    </div>

                    <button type="submit" class="btn btn-primary">Dodaj zwierzę</button>
                </form>
            </div>
        </div>
    </div>
@endsection
