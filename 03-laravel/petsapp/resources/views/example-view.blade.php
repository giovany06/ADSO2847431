<!DOCTYPE html>
<html lang="en" data-theme="dark">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>{{$title}}</title>
    <link href="https://cdn.jsdelivr.net/npm/daisyui@5" rel="stylesheet" type="text/css" />
</head>
<body>
    <h1 class="text-4xl mx-auto my-10 border-b w-[fit-content]">{{$title}}</h1>

    <div class="overflow-x-auto w-2/3 mx-auto">
        <table class="table">
          <!-- head -->
          <thead>
            <tr>
              <th>Name</th>
              <th>Breed</th>
              <th>Location</th>
              <th>Actions</th>
            </tr>
          </thead>
          <tbody>
            @foreach ($pets as $pet)
                <tr class="hover:bg-base-300">
                <td>
                    <div class="flex items-center gap-3">
                    <div class="avatar">
                        <div class="mask mask-squircle h-12 w-12">
                        <img
                            src="{{ asset('images/'.$pet->image) }}"
                            alt="{{ $pet->name }}" />
                        </div>
                    </div>
                    <div>
                        
                        <div class="font-bold">{{ $pet->name }}</div>
                        @if ($pet->kind == 'Dog')
                            <div class="badge badge-sm badge-accent">{{ $pet->kind }}</div>
                        @else
                            <div class="badge badge-sm badge-error">{{ $pet->kind }}</div>
                        @endif
                    </div>
                    </div>
                </td>
                <td>
                    <span class="badge badge-outline badge-sm badge-accent">{{ $pet->breed }}</span>
                </td>
                <td>{{ $pet->location }}</td>
                <td>
                    <a href="{{ url('show/pet/'.$pet->id) }}" class="btn btn-sm btn-outline btn-accent">
                        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 16 16" fill="currentColor" class="size-4">
                            <path fill-rule="evenodd" d="M9.965 11.026a5 5 0 1 1 1.06-1.06l2.755 2.754a.75.75 0 1 1-1.06 1.06l-2.755-2.754ZM10.5 7a3.5 3.5 0 1 1-7 0 3.5 3.5 0 0 1 7 0Z" clip-rule="evenodd" />
                        </svg>                                                   
                    </a>
                </td>
                </tr>
            @endforeach
          </tbody>
          <!-- foot -->
          <tfoot>
            <tr>
                <th>Name</th>
                <th>Breed</th>
                <th>Location</th>
                <th>Actions</th>
            </tr>
          </tfoot>
        </table>
      </div>
    <script src="https://cdn.jsdelivr.net/npm/@tailwindcss/browser@4"></script>
</body>
</html>