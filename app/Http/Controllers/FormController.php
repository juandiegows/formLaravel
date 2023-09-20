<?php

namespace App\Http\Controllers;

use App\Http\Requests\FormRequestJD;
use App\Models\Preoperational;
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
