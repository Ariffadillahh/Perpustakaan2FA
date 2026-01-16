<?php

namespace App\Http\Requests\Loan;

use Illuminate\Foundation\Http\FormRequest;

class LoanRequest extends FormRequest
{
    public function authorize()
    {
        return true;
    }

    public function rules()
    {
        return [
            'book_id' => 'required|exists:books,id',
            'return_date' => 'required|date|after:today',
        ];
    }
}
