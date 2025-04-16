<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Informacion de la mascota</title>
    <link href="https://cdn.jsdelivr.net/npm/daisyui@5" rel="stylesheet" type="text/css" />
    <script src="https://cdn.jsdelivr.net/npm/@tailwindcss/browser@4"></script>
</head>

<body>
    @foreach ($pets as $pet)
        <!-- Open the modal using ID.showModal() method -->
        <dialog id="my_modal_1" class="modal">
            <div class="modal-box">
                <h3 class="text-lg font-bold">Informacion de la mascota</h3>
                <p class="py-4"></p>
                <div class="modal-action">
                    <div class="card bg-base-100 w-96 shadow-sm">
                        <figure>
                            <img src="{{ asset('images/' . $pet->image) }}" alt=" {{ $pet->name }}" width="130px"
                                height="130px" />
                        </figure>
                        <div class="card-body">
                            <h2 class="card-title">
                                {{ $pet->name }}
                                <div class="badge badge-secondary">{{ $pet->kind }}</div>
                            </h2>

                            <div class="card-actions justify-center">
                                <div class="text-left ">
                                    <p><strong>Nombre:</strong> <span id="modalName">{{$pet->name}} </span></p>
                                    <p><strong>Tipo:</strong> <span id="modalKind">{{ $pet->kind }}</span></p>
                                    <p><strong>Peso:</strong> <span id="modalWeight">{{ $pet->weight }}</span></p>
                                    <p><strong>Edad:</strong> <span id="modalAge">{{ $pet->age }}</span></p>
                                    <p><strong>Raza:</strong> <span id="modalBreed">{{ $pet->breed }}</span></p>
                                    <p><strong>Ubicación:</strong> <span id="modalLocation">{{ $pet->location }}</span></p>
                                    <p><strong>Descripción:</strong> <span
                                            id="modalDescription">{{ $pet->description }}</span></p>
                                </div>
                            </div>
                        </div>
                        <form method="dialog">
                            <!-- if there is a button in form, it will close the modal -->
                            <button class="btn">Close</button>
                        </form>
                    </div>
                </div>
            </div>
        </dialog>


    @endforeach
</body>
<script>
    my_modal_1.showModal();
</script>

</html>