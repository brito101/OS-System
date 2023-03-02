<?php

namespace App\Http\Requests\Admin;

use Illuminate\Foundation\Http\FormRequest;

class ProviderRequest extends FormRequest
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
            'coverage' => $this->coverage ? \implode(',', $this->coverage) : null
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
            'social_name' => 'required|min:2|max:191',
            'alias_name' => 'required|min:2|max:191',
            'document_company' => "required|min:11|max:20|unique:providers,document_company,{$this->id},id,deleted_at,NULL",
            'document_company_secondary' => 'nullable|min:5|max:20',
            'activity' => 'nullable|min:2|max:191',
            'email' => 'nullable|min:8|max:191|email',
            'telephone' => 'nullable|min:8|max:25',
            'cell' => 'nullable|max:25',
            'contact' => 'nullable|min:2|max:191',
            'function' => 'nullable|min:2|max:191',
            'average_delivery_time' => 'nullable|max:191',
            'payment_conditions' => 'nullable|max:191',
            'discounts' => 'nullable|max:191',
            'products_offered' => 'nullable|max:191',
            'promotion_funds' => 'nullable|max:191',
            'technical_assistance' => 'nullable|max:191',
            'total_purchases_previous_year' => 'nullable|max:191',
            'zipcode' => 'nullable|min:8|max:13',
            'street' => 'nullable|min:3|max:100',
            'number' => 'nullable|min:1|max:100',
            'complement' => 'nullable|max:100',
            'neighborhood' => 'nullable|max:100',
            'state' => 'nullable|min:2|max:2',
            'city' => 'nullable|min:2|max:100',
            'observations' => 'nullable|max:4000000000',
            'coverage' => 'nullable|max:191',
        ];
    }
}
