<?php

namespace App\Http\Requests;

use App\Models\Item;
use Closure;
use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Auth;

class CashierPostRequest extends FormRequest
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
     * @return array<string, ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            "items" => "array|required|min:1",
            "items.*.id" => "required|exists:items,id",
            "items.*.stock" => "required",
            "items.*.qty" => [
                "required",
                "min:1",
                "integer",
                function (string $attribute, mixed $value, Closure $fail) {
                    $index = explode(".", $attribute)[1];
                    $item = Item::find($this->input("items.$index.id"));
                    if ($item->stock < $value) {
                        $fail("Quantity exceed stock of $item->name product!");
                    }
                },
            ],
            "items.*.sell_price" => "required|integer|exists:items,sell_price",
            'cash_tendered' => [
                'required',
                'numeric',
                function ($attribute, $value, $fail) {
                    // Hitung subtotal dari item
                    $subtotal = collect($this->input('items'))->sum(function ($item) {
                        return $item['sell_price'] * $item['qty'];
                    });
                    // Validasi cash_tendered minimal harus sama dengan subtotal
                    if ($value < $subtotal) {
                        $fail("Nilai {$attribute} harus minimal Rp".number_format($subtotal, 0, ',', '.'));
                    }
                },
            ]
        ];
    }
}
