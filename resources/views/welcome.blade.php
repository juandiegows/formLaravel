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
                margin-bottom: 10px;
            }
            .col {
                flex-direction: column;
            }

            .group{
                margin-bottom: 40px;
            }
            .btn {
                background-color: red;
                color: white;
                padding: 3px 10px;
                cursor: pointer;
            }
            .btn-sucess{
                background-color: green;
            }

            .element{
                margin-left: 100px;
            }
        </style>
        {{ $messageJD  ?? "" }}
        <form action="{{ route('save') }}" method="post">
            @csrf
            <div class="flex col group">
                <div class="flex">
                    <input type="text" name="form" value="{{ old('form') }}"
                     placeholder="Ingrese el nomrbe del formulario">
                    <input type="submit" value="Enviar" id="save" name="submit_type">
                    <input type="submit" value="Limpiar" id="Limpiar" name="submit_type">
                </div>

                @error('form')
                <div class="alert alert-danger">{{ $message }}</div>
                @enderror
            </div>

                <div class="flex">
                    <input type="number" name="cantidad" min="1" value="{{ old('cantidad') }}" >
                    <input type="submit" id="addCategory" value="Agregar Categoria" name="submit_type">
                </div>

                @forelse (session('categories') ?? [] as $key => $category )
                <div class="flex col">
                    <div class="flex ">

                        <input type="text" name="categories[{{ $key }}][name]"
                        value="{{ old('categories.' . $key . '.name', $category['name']) }}" id="">

                        <input type="submit" value="Eliminar.{{ $key }}" id="Eliminar.{{ $key }}"
                         hidden name="submit_type">
                         <label class="btn" for="Eliminar.{{ $key }}">Eliminar</label>

                    </div>
                    <div class="flex">
                        <input type="number" name="categories[{{ $key }}][cantidad]" min="1"
                         value="{{ old('categories['.$key.'][cantidad]') }}" >
                        <input type="submit" hidden id="elemento.{{ $key }}"
                         value="elemento.{{ $key }}" name="submit_type">
                        <label class="btn btn-sucess" for="elemento.{{ $key }}">Agregar Elemento</label>
                    </div>
                    <div class="flex col">
                        @forelse ($category['elements'] ?? [] as $keyE => $element)
                        <div class="flex element">

                            <input type="text" name="categories[{{ $key }}][elements][]"
                             value="{{ old('categories.' . $key . '.elements'.$keyE) }}" id="">

                            <input type="submit" value="delete.{{ $key }}.{{ $keyE }}"
                             id="delete.{{ $key }}.{{ $keyE }}"
                             hidden name="submit_type">
                             <label class="btn" for="delete.{{ $key }}.{{ $keyE }}">Eliminar</label>

                        </div>
                        @empty
                        No hay elementos
                        @endforelse
                    </div>

                </div>


                @empty
                    <h2>No hay categorias</h2>
                @endforelse
        </form>
    </body>
</html>
