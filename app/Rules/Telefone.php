<?php

namespace App\Rules;

use Illuminate\Contracts\Validation\Rule;

class Telefone implements Rule
{
    public function passes($attribute, $value)
    {
        // Regex para validar o telefone no formato (XX) XXXX-XXXX ou (XX) XXXXX-XXXX
        return preg_match('/^\(\d{2}\) \d{4,5}-\d{4}$/', $value);
    }

    public function message()
    {
        return 'Por favor, insira um telefone válido.';
    }
}

