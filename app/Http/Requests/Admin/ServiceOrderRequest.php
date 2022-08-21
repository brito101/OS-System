<?php

namespace App\Http\Requests\Admin;

use Carbon\Carbon;
use Illuminate\Foundation\Http\FormRequest;

class ServiceOrderRequest extends FormRequest
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
        $this->merge([
            'execution_date' => Carbon::createFromFormat('d/m/Y', $this->execution_date)->format('Y-m-d'),
            'deadline' => Carbon::createFromFormat('d/m/Y', $this->deadline)->format('Y-m-d'),
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
            'activity_id' => 'required|exists:activities,id',
            'zipcode' => 'required|min:8|max:13',
            'street' => 'required|min:3|max:100',
            'number' => 'required|min:1|max:100',
            'complement' => 'max:100',
            'neighborhood' => 'max:100',
            'state' => 'required|min:2|max:3',
            'city' => 'required|min:2|max:100',
            'telephone' => 'nullable|min:8|max:25',
            'client_id' => 'required|exists:clients,id',
            'description'  => 'nullable|max:4000000000',
            'user_id' => 'required|exists:users,id',
            'execution_date' => 'required|date',
            'priority' => 'required|in:Baixa,Média,Alta,Urgente',
            'status' => 'nullable|in:Não inicado, Atrasado, Iniciado, Concluído, Cancelado',
            'deadline' => 'nullable|date',
            'appraisal' => 'nullable|Não avaliado, Péssimo, Ruim, Regular, Bom, Ótimo',
            'observations' => 'nullable|max:4000000000',
        ];
    }
}
