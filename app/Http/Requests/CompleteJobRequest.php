<?php

namespace App\Http\Requests;

use App\Rules\NotWeekend;
use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Exceptions\HttpResponseException;

class CompleteJobRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }
    /**
     * Handle a failed validation attempt.
     *
     * This method throws an HTTP response exception with a status code of 422
     * and a JSON body containing the validation errors.
     *
     * @param Validator $validator The validator instance
     * @throws HttpResponseException An HTTP response exception with the validation errors
     */
    protected function failedValidation(Validator $validator)
    {
        throw new HttpResponseException(response()->json(['errors' => $validator->errors()], 422));
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, ValidationRule|array|string>
     */
    public function rules(): array
    {
        return [
            'auditor_id' => 'required|exists:auditors,id',
            'note' => 'required|string',
        ];
    }
}
