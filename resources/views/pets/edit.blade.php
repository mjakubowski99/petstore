@php
    use App\Contracts\PetStore\IPet;use App\Contracts\PetStore\ITag;
    /** @var IPet $pet */
@endphp
@extends('pets.layout')

@section('content')
    <div class="container mt-5">
        <div class="card mb-4">
            <div class="card-header">Edytuj</div>
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

                <form action="{{ route('pets.update', ['petId' => $pet->getId()]) }}" method="POST">
                    @csrf
                    @method('PUT')

                    <div class="mb-3">
                        <label for="name" class="form-label">Nazwa</label>
                        <input type="text" class="form-control" id="name" name="name" required
                               value="{{$pet->getName()}}">
                    </div>

                    <div class="mb-3">
                        <label for="status" class="form-label">Status</label>
                        <select class="form-control" id="status" name="status" required>
                            @foreach($statuses as $status)
                                <option
                                    {{$pet->getStatus()->value === $status ? 'selected' : ''}} value="{{$status}}">{{$status}}</option>
                            @endforeach
                        </select>
                    </div>

                    <div class="mb-3">
                        <label for="category" class="form-label">Kategoria</label>
                        <input type="text" class="form-control" id="category_name" name="category_name"
                               value="{{$pet->getCategory() ? $pet->getCategory()->getName() : null}}">
                    </div>

                    <div class="mb-3">
                        <label for="tags" class="form-label">Tagi (oddzielone przecinkami)</label>
                        <input type="text" class="form-control" id="tags" name="tags"
                               value="{{implode(',', array_map(fn(ITag $tag) => $tag->getName(), $pet->getTags()))}}"
                        >
                    </div>

                    <div class="mb-3">
                        <label for="photos" class="form-label">Urle zdjęć (oddzielone przecinkami)</label>
                        <input type="text" class="form-control" id="photos" name="photos" value="{{implode(',', $pet->getPhotoUrls())}}">
                    </div>

                    <button type="submit" class="btn btn-primary">Edytuj</button>
                </form>
            </div>
        </div>
    </div>
@endsection
