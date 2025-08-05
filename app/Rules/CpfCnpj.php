<?php

namespace App\Rules;

use Illuminate\Contracts\Validation\Rule;

class CpfCnpj implements Rule
{
    public function passes($attribute, $value)
    {
        // Remove quaisquer caracteres não numéricos
        $value = preg_replace('/\D/', '', $value);

        // Verifica se o valor tem 11 dígitos (CPF) ou 14 dígitos (CNPJ)
        if (strlen($value) === 11) {
            return $this->validarCPF($value);
        } elseif (strlen($value) === 14) {
            return $this->validarCNPJ($value);
        }

        return false;
    }

    public function message()
    {
        //app('flasher')->addError('Por favor, insira um CNPJ ou CPF válido.');
        return 'Pof favor, insira um CPF ou CNPJ válido.';
    }

    private function validarCPF($cpf)
    {
        // Validação de CPF
        if (strlen($cpf) != 11) {
            return false;
        }

        // Verifica se todos os dígitos são iguais (ex: 111.111.111-11)
        if (preg_match('/(\d)\1{10}/', $cpf)) {
            return false;
        }

        // Calcula os dígitos verificadores para validar o CPF
        for ($t = 9; $t < 11; $t++) {
            for ($d = 0, $c = 0; $c < $t; $c++) {
                $d += $cpf[$c] * (($t + 1) - $c);
            }
            $d = ((10 * $d) % 11) % 10;
            if ($cpf[$c] != $d) {
                return false;
            }
        }

        return true;
    }

    private function validarCNPJ($cnpj)
    {
        // Validação de CNPJ
        if (strlen($cnpj) != 14) {
            return false;
        }

        // Elimina CNPJs inválidos conhecidos
        if (preg_match('/(\d)\1{13}/', $cnpj)) {
            return false;
        }

        // Valida os dígitos verificadores para o CNPJ
        $tamanho = strlen($cnpj) - 2;
        $numeros = substr($cnpj, 0, $tamanho);
        $digitos = substr($cnpj, $tamanho);

        $soma = 0;
        $pos = $tamanho - 7;
        for ($i = $tamanho; $i >= 1; $i--) {
            $soma += $numeros[$tamanho - $i] * $pos--;
            if ($pos < 2) {
                $pos = 9;
            }
        }

        $resultado = $soma % 11 < 2 ? 0 : 11 - $soma % 11;
        if ($resultado != $digitos[0]) {
            return false;
        }

        $tamanho = $tamanho + 1;
        $numeros = substr($cnpj, 0, $tamanho);
        $soma = 0;
        $pos = $tamanho - 7;
        for ($i = $tamanho; $i >= 1; $i--) {
            $soma += $numeros[$tamanho - $i] * $pos--;
            if ($pos < 2) {
                $pos = 9;
            }
        }

        $resultado = $soma % 11 < 2 ? 0 : 11 - $soma % 11;
        if ($resultado != $digitos[1]) {
            return false;
        }

        return true;
    }
}
