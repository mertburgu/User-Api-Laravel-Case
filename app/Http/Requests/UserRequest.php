<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Http\JsonResponse;

class UserRequest extends FormRequest
{
    public function authorize()
    {
        return true;
    }

    public function rules()
    {
        return [
            'name' => 'required',
            'username' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email',
            'password' => 'required|string|min:8',
        ];
    }

    protected function failedValidation(Validator $validator)
    {
        $response = new JsonResponse(['message' => 'Kullanıcı işlemi yapılırken bir hata oluştu, parametreleri kontrol edin'], 400);
        throw new \Illuminate\Validation\ValidationException($validator, $response);
    }
}
