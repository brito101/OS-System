<?php

namespace App\Http\Requests\Admin;

use App\Models\Client;
use Carbon\Carbon;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

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
        $client = Client::find($this->client_id);

        $base64 = null;
        if ($this->cover_base64) {
            $name = Str::slug(Str::random(15)) . time() . '.png';
            $file = base64_decode(preg_replace('#^data:image/\w+;base64,#i', '', $this->cover_base64));
            $path = Storage::put('service-orders/' . $name, $file);
            $base64 = $name;
        }

        if ($base64) {
            $this->merge([
                'execution_date' => Carbon::createFromFormat('d/m/Y', $this->validateDate($this->execution_date))->format('Y-m-d'),
                'deadline' => Carbon::createFromFormat('d/m/Y', $this->validateDate($this->deadline))->format('Y-m-d'),
                'zipcode' => $this->zipcode ?? $client->zipcode,
                'street' => $this->street ?? $client->street,
                'number' => $this->number ?? $client->number,
                'complement' => $this->complement ?? $client->complement,
                'neighborhood' => $this->neighborhood ?? $client->neighborhood,
                'state' => $this->state ?? $client->state,
                'city' => $this->city ?? $client->city,
                'telephone' => $this->telephone ?? $client->telephone,
                'readiness_date' => $this->readiness_date ? Carbon::createFromFormat('d/m/Y', $this->validateDate($this->readiness_date))->format('Y-m-d') : null,
                'photo' => $base64,
            ]);
        } else {
            $this->merge([
                'execution_date' => Carbon::createFromFormat('d/m/Y', $this->validateDate($this->execution_date))->format('Y-m-d'),
                'deadline' => Carbon::createFromFormat('d/m/Y', $this->validateDate($this->deadline))->format('Y-m-d'),
                'zipcode' => $this->zipcode ?? $client->zipcode,
                'street' => $this->street ?? $client->street,
                'number' => $this->number ?? $client->number,
                'complement' => $this->complement ?? $client->complement,
                'neighborhood' => $this->neighborhood ?? $client->neighborhood,
                'state' => $this->state ?? $client->state,
                'city' => $this->city ?? $client->city,
                'telephone' => $this->telephone ?? $client->telephone,
                'readiness_date' => $this->readiness_date ? Carbon::createFromFormat('d/m/Y', $this->validateDate($this->readiness_date))->format('Y-m-d') : null,
            ]);
        }
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
            'status' => 'nullable|in:Aguardando orçamento,Orçamento enviado,Aguardando laudo,Laudo enviado,Não iniciado,Atrasado,Iniciado,Concluído,Concluído com envio de proposta,Cancelado',
            'deadline' => 'nullable|date',
            'appraisal' => 'nullable|Não avaliado,Péssimo,Ruim,Regular,Bom,Ótimo',
            'observations' => 'nullable|max:4000000000',
            'costumer_signature' => 'nullable',
            'contributor_signature' => 'nullable',
            'readiness_date' => 'nullable|required_if:status,==,Concluído|date',
            'start_time' => 'nullable|date_format:H:i',
            'end_time' => 'nullable|date_format:H:i',
            'remarks' => 'nullable|max:4000000000',
            'photo' => 'nullable',
            'costumer_name' => 'nullable|max:191',
            'costumer_document' => 'nullable|max:191',
            'subsidiary_id' => 'required|exists:subsidiaries,id'
        ];
    }

    public function validateDate($date)
    {
        if (preg_match('/^(0?[1-9]|[12][0-9]|3[01])[\/\-](0?[1-9]|1[012])[\/\-]\d{4}$/', $date)) {
            return $date;
        } else {
            return date('d/m/Y');
        }
    }
}
