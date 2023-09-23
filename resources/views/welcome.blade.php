<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <title>Laravel</title>


</head>

<body class="antialiased">

    @php
        $itemTypes = App\Models\PreoperationalItemType::all();
    @endphp
    <style>
        .flex {
            display: flex;
            gap: 20px;
            margin-bottom: 10px;
            align-items: flex-start;
            flex-wrap: wrap;
        }

        .col {
            flex-direction: column;
        }

        .group {
            margin-bottom: 40px;
        }

        .btn {
            background-color: red;
            color: white;
            padding: 3px 10px;
            cursor: pointer;
        }

        .btn-sucess {
            background-color: green;
        }

        .element {
            margin-left: 100px;
        }

        .form {
            width: 80%;
            margin: 100px auto;
            background-color: #ffffff;
            border-radius: 10rem;
        }

        input[type='text'] {

            color: #000000;
            padding: 10px 20px;
            outline: none;
            border: 1px solid #333;
            border-radius: 5px;
            width: min-content;
            min-width: 300px;
        }

        input[type='number'] {

            color: #000000;
            padding: 10px 20px;
            outline: none;
            border: 1px solid #333;
            border-radius: 5px;
        }

        select {

            color: #000000;
            padding: 10px 20px;
            outline: none;
            border: 1px solid #333;
            border-radius: 4px;
        }

        .btn {
            color: #ffffff;
            padding: 10px 20px;
            outline: none;
            border: none;
            border-radius: 5px;
        }

        .green {
            background-color: green;
        }

        .clean {
            background-color: red;
        }

        .category {
            border: 1px solid green;
            margin-bottom: 30px;
            padding: 20px;
            border-radius: 10px;
        }

        .alert-danger {
            color: red;
        }
    </style>
    {{ $messageJD ?? '' }}
    <form action="{{ route('save') }}" class="form" method="post" id="form">
        @csrf
        <div class="flex col group">
            <div class="flex">
                <input type="text" name="form" value="{{ old('form') }}"
                    placeholder="Ingrese el nomrbe del formulario">
                <input type="submit" value="Enviar" class=" btn green" id="save" name="submit_type">
                <input type="submit" value="Limpiar" class=" btn clean " id="Limpiar" name="submit_type">
            </div>

            @error('form')
                <div class="alert alert-danger">{{ $message }}</div>
            @enderror
        </div>

        <div class="flex">
            <input type="number" placeholder="Cantidad de categoria" name="cantidad" min="1"
                value="{{ old('cantidad') }}">
            <input type="submit" id="addCategory" class=" btn green" value="Agregar Categoria" name="submit_type">
        </div>

        @forelse (session('categories') ?? [] as $key => $category )
            <div class="flex col category">
                <div class="flex ">

                    <input type="text" placeholder="nombre de la catetoria"
                        name="categories[{{ $key }}][name]" value="{{ old('categories.' . $key . '.name') }}"
                        id="">

                    <input type="submit" value="Eliminar.{{ $key }}" id="Eliminar.{{ $key }}" hidden
                        name="submit_type">
                    <label class="btn" for="Eliminar.{{ $key }}">Eliminar</label>

                </div>
                @error('categories.' . $key . '.name')
                    <div class="alert alert-danger">{{ $message }}</div>
                @enderror
                <div class="flex">
                    <input type="number" name="categories[{{ $key }}][cantidad]" min="1"
                        value="{{ $categories[$key]['cantidad'] ?? 1 }}">
                    <input type="submit" hidden id="elemento.{{ $key }}"
                        value="elemento.{{ $key }}" value="{{ old('categories.' . $key . '.cantidad') }}"
                        name="submit_type">
                    <label class="btn btn-sucess green" for="elemento.{{ $key }}">Agregar Elemento</label>
                </div>
                <div class="flex col">
                    @forelse ($category['elements'] ?? [] as $keyE => $element)
                        <div class="flex element">

                            <div class="flex col">
                                <input type="text"placeholder="nombre del elemento"
                                    name="categories[{{ $key }}][elements][{{ $keyE }}][name]"
                                    value="{{ old('categories.' . $key . '.elements.' . $keyE . '.name') }}"
                                    id="">
                                @error('categories.' . $key . '.elements.' . $keyE . '.name')
                                    <div class="alert alert-danger">{{ $message }}</div>
                                @enderror
                            </div>


                            <input type="submit" value="delete.{{ $key }}.{{ $keyE }}"
                                id="delete.{{ $key }}.{{ $keyE }}" hidden name="submit_type">
                            <label class="btn"
                                for="delete.{{ $key }}.{{ $keyE }}">Eliminar</label>

                            <script>
                                function enviarForm() {
                                    let formulario = document.getElementById('form').submit();
                                    formulario.submit();

                                }
                            </script>

                            <select
                                name="categories[{{ $key }}][elements][{{ $keyE }}][preoperational_item_type_id]"
                                onchange="enviarForm()">
                                @forelse ($itemTypes as $type)
                                    @if ($category['elements'][$keyE]['preoperational_item_type_id'] == $type->id)
                                        <option value="{{ $type->id }}" selected> {{ $type->id }}
                                            {{ $type->name }}</option>
                                    @else
                                        <option value="{{ $type->id }}">
                                            {{ $type->id }}
                                            {{ $type->name }}</option>
                                    @endif

                                @empty
                                    No hay datos
                                @endforelse
                            </select>
                            @if ($category['elements'][$keyE]['preoperational_item_type_id'] == 1)
                                <input type="text">
                            @else
                                <div class="flex">
                                    <div class="flex">
                                        <input type="radio" name="check-{{ $key }}-{{ $keyE }}"
                                            id="bueno-{{ $key }}-{{ $keyE }}">
                                        <label for="bueno-{{ $key }}-{{ $keyE }}"> Bueno</label>
                                    </div>
                                    <div class="flex">
                                        <input type="radio" name="check-{{ $key }}-{{ $keyE }}"
                                            id="malo-{{ $key }}-{{ $keyE }}">
                                        <label for="malo-{{ $key }}-{{ $keyE }}"> Malo</label>
                                    </div>
                                </div>
                            @endif
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
