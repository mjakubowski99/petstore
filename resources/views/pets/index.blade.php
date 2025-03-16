{{-- resources/views/pet/index.blade.php --}}
    <!DOCTYPE html>
<html lang="pl">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Pets List</title>
    <!-- Dodanie CDN Bootstrap -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
<div class="container mt-5">
    <h1>Lista Zwierząt</h1>

    <!-- Tabela z informacjami o zwierzętach -->
    <table class="table table-striped table-bordered">
        <thead>
        <tr>
            <th>ID</th>
            <th>Name</th>
            <th>Status</th>
            <th>Category</th>
            <th>Tags</th>
            <th>Photos</th>
        </tr>
        </thead>
        <tbody>
        @foreach($pets as $pet)
            <tr>
                <!-- ID -->
                <td>{{ $pet->getId() }}</td>

                <!-- Name -->
                <td>{{ $pet->getName() }}</td>

                <!-- Status -->
                <td>{{ $pet->getStatus() }}</td> <!-- Assuming getStatus() returns an object with getName() -->

                <!-- Category -->
                <td>
                    @if($pet->getCategory())
                        {{ $pet->getCategory()->getName() }}
                    @else
                        No category assigned
                    @endif
                </td>

                <!-- Tags -->
                <td>
                    @foreach($pet->getTags() as $tag)
                        {{ $tag->getName() }} @if(!$loop->last), @endif
                    @endforeach
                </td>

                <!-- Photos -->
                <td>
                    @foreach($pet->getPhotoUrls() as $url)
                        <img src="{{ $url }}" alt="Pet photo" width="50" height="50" />
                    @endforeach
                </td>
            </tr>
        @endforeach
        </tbody>
    </table>
</div>

<!-- Dodanie skryptów Bootstrap -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
