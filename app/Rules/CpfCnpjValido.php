<?php

namespace App\Rules;

use Illuminate\Contracts\Validation\Rule;

class CpfCnpjValido implements Rule
{
    public function passes($attribute, $value)
    {
        $documento = preg_replace('/\D/', '', (string) $value);

        if (strlen($documento) === 11) {
            return $this->cpfValido($documento);
        }

        if (strlen($documento) === 14) {
            return $this->cnpjValido($documento);
        }

        return false;
    }

    public function message()
    {
        return 'Informe um CPF ou CNPJ válido.';
    }

    private function cpfValido(string $cpf): bool
    {
        if (preg_match('/^(\d)\1{10}$/', $cpf)) {
            return false;
        }

        for ($digito = 9; $digito <= 10; $digito++) {
            $soma = 0;
            for ($indice = 0; $indice < $digito; $indice++) {
                $soma += (int) $cpf[$indice] * (($digito + 1) - $indice);
            }

            $verificador = ($soma * 10) % 11;
            if ($verificador === 10) {
                $verificador = 0;
            }
            if ($verificador !== (int) $cpf[$digito]) {
                return false;
            }
        }

        return true;
    }

    private function cnpjValido(string $cnpj): bool
    {
        if (preg_match('/^(\d)\1{13}$/', $cnpj)) {
            return false;
        }

        $pesos = [5, 4, 3, 2, 9, 8, 7, 6, 5, 4, 3, 2];
        $soma = 0;
        for ($indice = 0; $indice < 12; $indice++) {
            $soma += (int) $cnpj[$indice] * $pesos[$indice];
        }
        $resto = $soma % 11;
        $primeiroDigito = $resto < 2 ? 0 : 11 - $resto;

        $soma = 0;
        $pesos = [6, 5, 4, 3, 2, 9, 8, 7, 6, 5, 4, 3, 2];
        for ($indice = 0; $indice < 13; $indice++) {
            $digito = $indice === 12 ? $primeiroDigito : (int) $cnpj[$indice];
            $soma += $digito * $pesos[$indice];
        }
        $resto = $soma % 11;
        $segundoDigito = $resto < 2 ? 0 : 11 - $resto;

        return $primeiroDigito === (int) $cnpj[12]
            && $segundoDigito === (int) $cnpj[13];
    }
}
