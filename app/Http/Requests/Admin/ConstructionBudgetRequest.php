<?php

namespace App\Http\Requests\Admin;

use Illuminate\Foundation\Http\FormRequest;

class ConstructionBudgetRequest extends FormRequest
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
            'item_1_total_tax'  => str_replace(',', '.', str_replace('.', '', str_replace('R$ ', '', $this->item_1_total_tax))),
            'item_2_total_tax'  => str_replace(',', '.', str_replace('.', '', str_replace('R$ ', '', $this->item_2_total_tax))),
            'item_3_total_tax'  => str_replace(',', '.', str_replace('.', '', str_replace('R$ ', '', $this->item_3_total_tax))),
            'item_4_total_tax'  => str_replace(',', '.', str_replace('.', '', str_replace('R$ ', '', $this->item_4_total_tax))),
            'item_5_total_tax'  => str_replace(',', '.', str_replace('.', '', str_replace('R$ ', '', $this->item_5_total_tax))),
            'item_6_total_tax'  => str_replace(',', '.', str_replace('.', '', str_replace('R$ ', '', $this->item_6_total_tax))),
            'item_7_total_tax'  => str_replace(',', '.', str_replace('.', '', str_replace('R$ ', '', $this->item_7_total_tax))),
            'item_8_total_tax'  => str_replace(',', '.', str_replace('.', '', str_replace('R$ ', '', $this->item_8_total_tax))),
            'item_9_total_tax'  => str_replace(',', '.', str_replace('.', '', str_replace('R$ ', '', $this->item_9_total_tax))),
            'item_10_total_tax'  => str_replace(',', '.', str_replace('.', '', str_replace('R$ ', '', $this->item_10_total_tax))),
            'item_11_total_tax'  => str_replace(',', '.', str_replace('.', '', str_replace('R$ ', '', $this->item_11_total_tax))),
            'item_12_total_tax'  => str_replace(',', '.', str_replace('.', '', str_replace('R$ ', '', $this->item_12_total_tax))),
            'item_13_total_tax'  => str_replace(',', '.', str_replace('.', '', str_replace('R$ ', '', $this->item_13_total_tax))),
            'item_14_total_tax'  => str_replace(',', '.', str_replace('.', '', str_replace('R$ ', '', $this->item_14_total_tax))),
            'item_15_total_tax'  => str_replace(',', '.', str_replace('.', '', str_replace('R$ ', '', $this->item_15_total_tax))),
            'item_16_total_tax'  => str_replace(',', '.', str_replace('.', '', str_replace('R$ ', '', $this->item_16_total_tax))),
            'item_17_total_tax'  => str_replace(',', '.', str_replace('.', '', str_replace('R$ ', '', $this->item_17_total_tax))),
            'item_18_total_tax'  => str_replace(',', '.', str_replace('.', '', str_replace('R$ ', '', $this->item_18_total_tax))),
            'item_19_total_tax'  => str_replace(',', '.', str_replace('.', '', str_replace('R$ ', '', $this->item_19_total_tax))),
            'item_20_total_tax'  => str_replace(',', '.', str_replace('.', '', str_replace('R$ ', '', $this->item_20_total_tax))),
            'item_21_total_tax'  => str_replace(',', '.', str_replace('.', '', str_replace('R$ ', '', $this->item_21_total_tax))),
            'item_22_total_tax'  => str_replace(',', '.', str_replace('.', '', str_replace('R$ ', '', $this->item_22_total_tax))),
            'item_23_total_tax'  => str_replace(',', '.', str_replace('.', '', str_replace('R$ ', '', $this->item_23_total_tax))),
            'item_24_total_tax'  => str_replace(',', '.', str_replace('.', '', str_replace('R$ ', '', $this->item_24_total_tax))),
            'item_25_total_tax'  => str_replace(',', '.', str_replace('.', '', str_replace('R$ ', '', $this->item_25_total_tax))),
            'item_26_total_tax'  => str_replace(',', '.', str_replace('.', '', str_replace('R$ ', '', $this->item_26_total_tax))),
            'item_27_total_tax'  => str_replace(',', '.', str_replace('.', '', str_replace('R$ ', '', $this->item_27_total_tax))),
            'item_28_total_tax'  => str_replace(',', '.', str_replace('.', '', str_replace('R$ ', '', $this->item_28_total_tax))),
            'item_29_total_tax'  => str_replace(',', '.', str_replace('.', '', str_replace('R$ ', '', $this->item_29_total_tax))),
            'item_30_total_tax'  => str_replace(',', '.', str_replace('.', '', str_replace('R$ ', '', $this->item_30_total_tax))),
            'item_31_total_tax'  => str_replace(',', '.', str_replace('.', '', str_replace('R$ ', '', $this->item_31_total_tax))),
            'item_32_total_tax'  => str_replace(',', '.', str_replace('.', '', str_replace('R$ ', '', $this->item_32_total_tax))),
            'item_33_total_tax'  => str_replace(',', '.', str_replace('.', '', str_replace('R$ ', '', $this->item_33_total_tax))),
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
            'item_1_qtd' => 'nullable|numeric|between:0,999999999.999',
            'item_2_qtd' => 'nullable|numeric|between:0,999999999.999',
            'item_3_qtd' => 'nullable|numeric|between:0,999999999.999',
            'item_4_qtd' => 'nullable|numeric|between:0,999999999.999',
            'item_5_qtd' => 'nullable|numeric|between:0,999999999.999',
            'item_6_qtd' => 'nullable|numeric|between:0,999999999.999',
            'item_7_qtd' => 'nullable|numeric|between:0,999999999.999',
            'item_8_qtd' => 'nullable|numeric|between:0,999999999.999',
            'item_9_qtd' => 'nullable|numeric|between:0,999999999.999',
            'item_10_qtd' => 'nullable|numeric|between:0,999999999.999',
            'item_11_qtd' => 'nullable|numeric|between:0,999999999.999',
            'item_12_qtd' => 'nullable|numeric|between:0,999999999.999',
            'item_13_qtd' => 'nullable|numeric|between:0,999999999.999',
            'item_14_qtd' => 'nullable|numeric|between:0,999999999.999',
            'item_15_qtd' => 'nullable|numeric|between:0,999999999.999',
            'item_16_qtd' => 'nullable|numeric|between:0,999999999.999',
            'item_17_qtd' => 'nullable|numeric|between:0,999999999.999',
            'item_18_qtd' => 'nullable|numeric|between:0,999999999.999',
            'item_19_qtd' => 'nullable|numeric|between:0,999999999.999',
            'item_20_qtd' => 'nullable|numeric|between:0,999999999.999',
            'item_21_qtd' => 'nullable|numeric|between:0,999999999.999',
            'item_22_qtd' => 'nullable|numeric|between:0,999999999.999',
            'item_23_qtd' => 'nullable|numeric|between:0,999999999.999',
            'item_24_qtd' => 'nullable|numeric|between:0,999999999.999',
            'item_25_qtd' => 'nullable|numeric|between:0,999999999.999',
            'item_26_qtd' => 'nullable|numeric|between:0,999999999.999',
            'item_27_qtd' => 'nullable|numeric|between:0,999999999.999',
            'item_28_qtd' => 'nullable|numeric|between:0,999999999.999',
            'item_29_qtd' => 'nullable|numeric|between:0,999999999.999',
            'item_30_qtd' => 'nullable|numeric|between:0,999999999.999',
            'item_31_qtd' => 'nullable|numeric|between:0,999999999.999',
            'item_32_qtd' => 'nullable|numeric|between:0,999999999.999',
            'item_33_qtd' => 'nullable|numeric|between:0,999999999.999',
            'item_1_total_tax' => 'nullable|numeric|between:0,999999999.999',
            'item_2_total_tax' => 'nullable|numeric|between:0,999999999.999',
            'item_3_total_tax' => 'nullable|numeric|between:0,999999999.999',
            'item_4_total_tax' => 'nullable|numeric|between:0,999999999.999',
            'item_5_total_tax' => 'nullable|numeric|between:0,999999999.999',
            'item_6_total_tax' => 'nullable|numeric|between:0,999999999.999',
            'item_7_total_tax' => 'nullable|numeric|between:0,999999999.999',
            'item_8_total_tax' => 'nullable|numeric|between:0,999999999.999',
            'item_9_total_tax' => 'nullable|numeric|between:0,999999999.999',
            'item_10_total_tax' => 'nullable|numeric|between:0,999999999.999',
            'item_11_total_tax' => 'nullable|numeric|between:0,999999999.999',
            'item_12_total_tax' => 'nullable|numeric|between:0,999999999.999',
            'item_13_total_tax' => 'nullable|numeric|between:0,999999999.999',
            'item_14_total_tax' => 'nullable|numeric|between:0,999999999.999',
            'item_15_total_tax' => 'nullable|numeric|between:0,999999999.999',
            'item_16_total_tax' => 'nullable|numeric|between:0,999999999.999',
            'item_17_total_tax' => 'nullable|numeric|between:0,999999999.999',
            'item_18_total_tax' => 'nullable|numeric|between:0,999999999.999',
            'item_19_total_tax' => 'nullable|numeric|between:0,999999999.999',
            'item_20_total_tax' => 'nullable|numeric|between:0,999999999.999',
            'item_21_total_tax' => 'nullable|numeric|between:0,999999999.999',
            'item_22_total_tax' => 'nullable|numeric|between:0,999999999.999',
            'item_23_total_tax' => 'nullable|numeric|between:0,999999999.999',
            'item_24_total_tax' => 'nullable|numeric|between:0,999999999.999',
            'item_25_total_tax' => 'nullable|numeric|between:0,999999999.999',
            'item_26_total_tax' => 'nullable|numeric|between:0,999999999.999',
            'item_27_total_tax' => 'nullable|numeric|between:0,999999999.999',
            'item_28_total_tax' => 'nullable|numeric|between:0,999999999.999',
            'item_29_total_tax' => 'nullable|numeric|between:0,999999999.999',
            'item_30_total_tax' => 'nullable|numeric|between:0,999999999.999',
            'item_31_total_tax' => 'nullable|numeric|between:0,999999999.999',
            'item_32_total_tax' => 'nullable|numeric|between:0,999999999.999',
            'item_33_total_tax' => 'nullable|numeric|between:0,999999999.999',
        ];
    }

    public function messages()
    {
        return [
            // 'total.between' => 'O valor total deve ser entre 0 e 999.999.999,999.',
        ];
    }
}
