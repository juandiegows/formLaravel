<?php

namespace App\Http\Controllers;

use App\Http\Requests\FormRequestJD;
use App\Models\Preoperational;
use App\Models\PreoperationalCategory;
use App\Models\PreoperationalItem;
use Illuminate\Support\Facades\Validator;

class FormController extends Controller
{
    public function save(FormRequestJD $request)
    {

        $submitType = $request->input('submit_type');

        $validator = Validator::make($request->all(), $request->rules());

        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput();
        }
        if ($submitType === 'Enviar') {


            $form = new Preoperational();
            $form->name = $request->input('form');
            $form->save();
            $vector = $request->input('categories');
            foreach ($vector as  $value) {
                $category = new PreoperationalCategory();
                $category->Preoperational_id = $form->id;
                $category->name = $value['name'];
                $category->save();
                foreach ($value['elements'] as $element) {
                    $elementSave = new PreoperationalItem();
                    $elementSave->name = $element;
                    $elementSave->preoperational_item_type_id = 1;
                    $elementSave->preoperational_category_id = $category->id;
                    $elementSave->save();
                }
            }
        } elseif ($submitType === 'Agregar Categoria') {
            $vector = $request->input('categories');
            $cantidad =  $request->input('cantidad');
            for ($i = 1; $i <= $cantidad; $i++) {
                $vector[] = ['name' => ''];
            }
            $request->session()->put('categories', $vector);
            return redirect()->back()->withErrors($validator)->withInput();
        } elseif (str_contains($submitType, "Eliminar")) {
            $position = explode(".", $submitType)[1];
            $vector = $request->input('categories');
            unset($vector[$position]);
            $request->session()->put('categories', $vector);
            return redirect()->back()->withErrors($validator)->withInput();
        } elseif (str_contains($submitType, "elemento")) {
            $position = explode(".", $submitType)[1];
            $vector = $request->input('categories');
            $cantidad = $vector[$position]['cantidad'];


            for ($i = 1; $i <= $cantidad; $i++) {
                $vector[$position]['elements'][] = "";
            }
            $request->session()->put('categories', $vector);
            return redirect()->back()->withErrors($validator)->withInput();
        } elseif (str_contains($submitType, "delete")) {

            $position = explode(".", $submitType)[1];
            $position2 = explode(".", $submitType)[2];
            $vector = $request->input('categories');
            unset($vector[$position]['elements'][$position2]);
            $request->session()->put('categories', $vector);
            return redirect()->back()->withErrors($validator)->withInput();
        }

        return redirect()->back()->withErrors($validator)->withInput();
    }
}
