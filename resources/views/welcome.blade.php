<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">

        <title>Laravel</title>


    </head>
    <body class="antialiased">

        <style>
            .flex {
                display: flex;
                gap: 20px;
            }
            .col {
                flex-direction: column;
            }

            .group{
                margin-bottom: 40px;
            }
        </style>
        <form action="{{ route('save') }}" method="post">
            @csrf
            <div class="flex col group">
                <div class="flex">
                    <input type="text" name="form" value="{{ old('form') }}"
                     placeholder="Ingrese el nomrbe del formulario">
                    <input type="submit" value="Enviar" id="save" name="submit_type">
                </div>

                @error('form')
                <div class="alert alert-danger">{{ $message }}</div>
                @enderror
            </div>

                <div class="flex">
                    <input type="number" name="cantidad" min="1" value="{{ old('cantidad') }}" >
                    <input type="submit" id="addCategory" value="Agregar Categoria" name="submit_type">
                </div>

                @forelse (session('categories') ?? [] as $category )
                   <input type="text" name="categories[]" value="{{ $category }}" id="">
                @empty
                    <h2>No hay categorias</h2>
                @endforelse
        </form>
    </body>
</html>
