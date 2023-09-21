<?php

namespace App\Http\Controllers;

use App\Models\Preoperational;
use App\Models\PreoperationalCategory;
use App\Models\PreoperationalItem;
use App\Validators\FormValidator;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;

class FormController extends Controller
{
    public function save(Request $request)
    {


        $submitType = $request->input('submit_type');

        if ($submitType === 'Limpiar') {
            $request->session()->put('categories', []);
            return redirect()->back()->withInput();
        } elseif ($submitType === 'Enviar') {

            $validator = Validator::make($request->all(), FormValidator::rules(), FormValidator::messages());

            if ($validator->fails()) {
                return redirect()->back()->withErrors($validator)->withInput();
            }
            DB::beginTransaction();
            try {
                $withError = false;
                $form = new Preoperational();
                $form->name = $request->input('form');
                $form->save();
                $vector = $request->input('categories');
                foreach ($vector as $index => $value) {
                    $category = new PreoperationalCategory();
                    $category->Preoperational_id = $form->id;
                    $category->name = $value['name'];
                    $category->save();
                    $name = $value['name'];
                    $count = collect($vector)->filter(function ($category) use ($name) {
                        return  strtolower($category['name']) === strtolower($name);
                    })->count();

                    if ($count >= 2) {
                        $withError = true;
                        $validator->errors()->add(
                            "categories.$index.name",
                            "No puede haber más de una categoria con el mismo nombre
                             (" . $value["name"] . " => " . strtolower($value["name"]) . ")."
                        );
                    }
                    if (!isset($value['elements'])) {
                        $withError = true;
                        $validator->errors()->add(
                            "categories.$index.name",
                            "Debe tener al menos un elemento"
                        );
                    }
                    foreach ($value['elements'] ?? [] as $indexE => $itemE) {
                        $name = $itemE['name'];
                        $count = collect($value['elements'])->filter(function ($element) use ($name) {
                            return  strtolower($element['name']) === strtolower($name);
                        })->count();

                        if ($count >= 2) {
                            $validator->errors()->add(
                                "categories.$index.elements.$indexE.name",
                                "No puede haber más de un elemento de la categoria con el mismo nombre
                                 (" . $itemE["name"] . " => " . strtolower($itemE["name"]) . ")."
                            );
                        }
                        $elementSave = new PreoperationalItem();
                        $elementSave->name = $itemE['name'];
                        $elementSave->preoperational_item_type_id = $itemE['preoperational_item_type_id'];
                        $elementSave->preoperational_category_id = $category->id;
                        $elementSave->save();
                    }
                }
                $request->session()->put('categories', []);
                if ($withError) {
                    DB::rollBack();
                    $vector = $request->input('categories');
                    $request->session()->put('categories', $vector);
                    return redirect()->back()->withInput()->withErrors($validator);
                } else {
                    DB::commit();
                }
                return Redirect()->route('home')->with(["messageJD" => "Se ha guardado correctamente"]);
            } catch (\Throwable $th) {
                DB::rollback();
                dd($th);
            }
        } elseif ($submitType === 'Agregar Categoria') {
            $vector = $request->input('categories');
            $cantidad =  $request->input('cantidad');
            for ($i = 1; $i <= $cantidad; $i++) {
                $vector[] = ['name' => '', 'cantidad' => 1];
            }
            $request->session()->put('categories', $vector);
            return redirect()->back()->withInput();
        } elseif (str_contains($submitType, "Eliminar")) {
            $position = explode(".", $submitType)[1];
            $vector = $request->input('categories');
            unset($vector[$position]);
            $request->session()->put('categories', $vector);
            return redirect()->back()->withInput();
        } elseif (str_contains($submitType, "elemento")) {
            $position = explode(".", $submitType)[1];
            $vector = $request->input('categories');
            $cantidad = $vector[$position]['cantidad'];

            for ($i = 1; $i <= $cantidad; $i++) {
                $vector[$position]['elements'][] = ['name' => '', 'preoperational_item_type_id' => 1];
            }
            $request->session()->put('categories', $vector);

            return redirect()->back()->withInput();
        } elseif (str_contains($submitType, "delete")) {

            $position = explode(".", $submitType)[1];
            $position2 = explode(".", $submitType)[2];
            $vector = $request->input('categories');
            unset($vector[$position]['elements'][$position2]);
            $request->session()->put('categories', $vector);
            return redirect()->back()->withInput();
        } else {
            $vector = $request->input('categories');
            $request->session()->put('categories', $vector);
            return redirect()->back()->withInput();
        }
    }
}
