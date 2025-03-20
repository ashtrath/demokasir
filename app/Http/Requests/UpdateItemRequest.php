<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Auth;

class UpdateItemRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return Auth::check();
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            "name" => "required|string",
            "category_id" => "nullable|exists:categories,id",
            "image" => "exclude_if:image,null|nullable|image|extensions:jpg,png,webp,jpeg",
            "stock" => "required|integer|min:0",
            "buy_price" => "required|integer|min:1",
            "sell_price" => "required|integer|min:1"
        ];
    }
}
