<?php

namespace App\Http\Requests\Admin;

use Carbon\Carbon;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class InventoryRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }

    protected function prepareForValidation()
    {
        $base64 = null;
        if ($this->cover_base64) {
            $name = Str::slug(Str::random(15)) . time() . '.png';
            $file = base64_decode(preg_replace('#^data:image/\w+;base64,#i', '', $this->cover_base64));
            $path = Storage::put('inventories/' . $name, $file);
            $base64 = $name;
        }

        $this->merge([
            'value'  => str_replace(',', '.', str_replace('.', '', str_replace('R$ ', '', $this->value))),
            'day' => $this->day ? Carbon::createFromFormat('d/m/Y', $this->day)->format('Y-m-d') : date('Y-m-d'),
            'validity' => $this->validity && $this->validity != 'Interminado' ? Carbon::createFromFormat('d/m/Y', $this->validity)->format('Y-m-d') : null,
            'input' => (int) $this->input,
            'output' => (int)$this->output,
            'photo' => $base64,
        ]);
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'product_id' => 'required|exists:products,id',
            'day' => 'required|date_format:Y-m-d',
            'validity' => 'nullable|date_format:Y-m-d',
            'value' => 'required|numeric|between:0,999999999.999',
            'input' => 'nullable|integer',
            'output' => 'nullable|integer',
            'job' => 'nullable|max:191',
            'liberator' => 'nullable|max:191',
            'stripper' => 'nullable|max:191',
            'lecturer' => 'nullable|max:191',
            'observations' => 'nullable|max:4000000000',
            'provider_id' => 'nullable|exists:providers,id',
            'subsidiary_id' => 'nullable|exists:subsidiaries,id',
            'photo' => 'nullable',
        ];
    }

    public function messages()
    {
        return [
            'value.between' => 'O valor deve ser entre 0 e 999.999.999,999.',
            'day.date_format' => 'Formato de data inválido',
            'validity.date_format' => 'Formato de data inválido',
        ];
    }
}
