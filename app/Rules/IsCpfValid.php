<?php

namespace App\Rules;

use Illuminate\Contracts\Validation\InvokableRule;

class IsCpfValid implements InvokableRule
{
    /**
     * Run the validation rule.
     *
     * @param  string  $attribute
     * @param  mixed  $value
     * @param  \Closure(string): \Illuminate\Translation\PotentiallyTranslatedString  $fail
     * @return void
     */
    public function __invoke($attribute, $value, $fail)
    {
        // Extrai somente os números
        $cpf = preg_replace('/[^0-9]/', '', (string) $value);

        if (! $this->isCpfValid($cpf)) {
            $fail('validation.cpf_is_not_valid')->translate();
        }
    }

    private function isCpfValid(string $cpf): bool
    {
        // Verifica se foi informado todos os digitos corretamente
        if (strlen($cpf) != 11)
            return false;

        // Verifica se foi informada uma sequência de digitos repetidos. Ex: 111.111.111-11
        if (preg_match('/(\d)\1{10}/', $cpf))
            return false;

        // Faz o calculo para validar o CPF
        for ($t = 9; $t < 11; $t++) {
            for ($d = 0, $c = 0; $c < $t; $c++) {
                $d += $cpf[$c] * (($t + 1) - $c);
            }

            $d = ((10 * $d) % 11) % 10;
            if ($cpf[$c] != $d)
                return false;
        }

        return true;
    }
}
