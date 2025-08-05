<?php

namespace App\Rules;

use Illuminate\Contracts\Validation\Rule;

class Cep implements Rule
{
    public function passes($attribute, $value)
    {
        // Regex para validar o CEP no formato XXXXX-XXX
        return preg_match('/^\d{5}-?\d{3}$/', $value);
    }

    public function message()
    {
        return 'Por favor, insira um CEP válido.';
    }
}

