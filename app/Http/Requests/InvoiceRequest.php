<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class InvoiceRequest extends FormRequest
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

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'seller_id' =>['required', 'int', 'exists:sellers,id'],
            'customer_id' =>['required', 'int', 'exists:customers,id'],
            'product_id' =>['required', 'int', 'exists:products,id'],
            'amount' => ['required', 'numeric'],
            'invoice_date' => ['required'],
        ];
    }

}
