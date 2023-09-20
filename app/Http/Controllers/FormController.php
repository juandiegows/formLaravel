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
                $vector[] = "";
            }
            $request->session()->put('categories', $vector);
            return redirect()->back()->withErrors($validator)->withInput();
        }

        return redirect()->back()->withErrors($validator)->withInput();
    }
}
