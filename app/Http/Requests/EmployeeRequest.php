<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;
use Illuminate\Validation\Rules\Password;

class EmployeeRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255', Rule::unique('users', 'email')->ignore($this->userID)],
            'nik' => ['required', 'string', 'max:20', 'alpha_dash', Rule::unique('employees', 'nik')->ignore($this->employeeID)],
            'password' => [Rule::requiredIf(is_null($this->userID)), Password::defaults()],
            'status' => ['required', 'string', Rule::in(['kontrak', 'permanen']),],
            'tanggal_masuk' => ['required', 'date_format:d-m-Y'],
            'kesehatan' => ['required', 'string', 'max:12', 'regex:/^[\d.,]+$/'],
            'bencana' => ['required', 'string', 'max:12', 'regex:/^[\d.,]+$/'],
            'transportasi' => ['required', 'string', 'max:12', 'regex:/^[\d.,]+$/'],
            'jabatan' => ['required', 'string', 'max:12', 'regex:/^[\d.,]+$/'],
            'makanan' => ['required', 'string', 'max:12', 'regex:/^[\d.,]+$/'],
        ];
    }
}
