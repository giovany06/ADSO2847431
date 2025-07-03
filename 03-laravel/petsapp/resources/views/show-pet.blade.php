<!DOCTYPE html>
<html lang="en" data-theme="dark">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Show Pet</title>
    <link href="https://cdn.jsdelivr.net/npm/daisyui@5" rel="stylesheet" type="text/css" />
</head>
<body>
    <h1 class="text-4xl mx-auto my-10 border-b w-[fit-content]">Show Pet</h1>

    <div class="card card-side bg-base-100 border w-2/3 mx-auto">
        <figure>
          <img
            src="{{ asset('images/'.$pet->image) }}"
            alt="{{ $pet->name }}" />
        </figure>
        <div class="card-body">
          <h2 class="card-title">{{ $pet->name }}</h2>
          <ul>
            <li>
                <strong>Kind: </strong>
                @if ($pet->kind == 'Dog')
                   <div class="badge badge-accent">{{ $pet->kind }}</div>
                @else
                   <div class="badge badge-error">{{ $pet->kind }}</div>
                @endif
            </li>
            <li><strong>Weight: </strong>{{ $pet->weight }}</li>
            <li><strong>Age: </strong>{{ $pet->age }}</li>
            <li><strong>Breed: </strong>{{ $pet->breed }}</li>
            <li><strong>Location: </strong>{{ $pet->location }}</li>
            <li>
                <strong>Status: </strong>
                @if ($pet->status == 0)
                   <div class="badge badge-success">Avaliable</div>
                @else
                   <div class="badge badge-error">Unavaliable</div>
                @endif
            </li>
          </ul>
          <strong>Description:</strong>
          <p>{{ $pet->description }}</p>

          <div class="card-actions justify-end">
            <a href="{{ url('view/blade') }}" class="btn btn-accent">
                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 16 16" fill="currentColor" class="size-4">
                    <path fill-rule="evenodd" d="M14 8a.75.75 0 0 1-.75.75H4.56l1.22 1.22a.75.75 0 1 1-1.06 1.06l-2.5-2.5a.75.75 0 0 1 0-1.06l2.5-2.5a.75.75 0 0 1 1.06 1.06L4.56 7.25h8.69A.75.75 0 0 1 14 8Z" clip-rule="evenodd" />
                  </svg>                  
            </a>
          </div>
        </div>
      </div>
    <script src="https://cdn.jsdelivr.net/npm/@tailwindcss/browser@4"></script>
</body>
</html>