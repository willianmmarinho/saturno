<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class ModelContaContabil extends Model
{
    protected $table = "conta_contabil";
    protected $fillable = [
        "data_inicio",
        "data_fim",
        "id_tipo_catalogo",
        "descricao",
        "id_tipo_natureza_conta_contabil",
        "id_tipo_grupo_conta_contabil",
        "id_tipo_classe_conta_contabil",
        "nivel_1",
        "nivel_2",
        "nivel_3",
        "nivel_4",
        "nivel_5",
        "nivel_6",
        "grau"
    ];
    public $timestamps = false;

    public function natureza_contabil()
    {
        return $this->belongsTo(
            ModelTipoNaturezaContaContabil::class,
            "id_tipo_natureza_conta_contabil",
            "id"
        );
    }

    public function catalogo_contabil()
    {
        return $this->belongsTo(
            ModelTipoCatalogoContaContabil::class,
            'id_tipo_catalogo',
            'id'
        );
    }

    public function grupo_contabil()
    {
        return $this->belongsTo(
            ModelTipoGrupoContaContabil::class,
            'id_tipo_grupo_conta_contabil',
            'id'
        );
    }

    public function classe_contabil()
    {
        return $this->belongsTo(
            ModelTipoClasseContaContabil::class,
            'id_tipo_classe_conta_contabil',
            'id'
        );
    }
    public function nivel1()
    {
        return $this->belongsTo(ModelContaContabil::class, 'nivel_1');
    }

    public function nivel2()
    {
        return $this->belongsTo(ModelContaContabil::class, 'nivel_2');
    }

    public function nivel3()
    {
        return $this->belongsTo(ModelContaContabil::class, 'nivel_3');
    }

    public function nivel4()
    {
        return $this->belongsTo(ModelContaContabil::class, 'nivel_4');
    }

    public function nivel5()
    {
        return $this->belongsTo(ModelContaContabil::class, 'nivel_5');
    }

    public function nivel6()
    {
        return $this->belongsTo(ModelContaContabil::class, 'nivel_6');
    }
    // Getters

    public function getConcatenatedLevelsAttribute()
    {
        $niveis = [
            $this->nivel_1,
            $this->nivel_2,
            $this->nivel_3,
            $this->nivel_4,
            $this->nivel_5,
            $this->nivel_6,
        ];

        $result = [];
        foreach ($niveis as $nivel) {
            if ($nivel != 0) {
                $result[] = $nivel;
            } else {
                break;
            }
        }

        return implode('.', $result);
    }

    /**
     * Retrieve concatenated names of account levels for a given account ID.
     *
     * This method fetches the descriptions of up to six levels of an account
     * from the 'conta_contabil' table and concatenates them into a single string.
     * If a level description is not available, it will be replaced with an empty string.
     *
     * @param int $id The ID of the account to retrieve the concatenated names for.
     * @return string|null The concatenated names of the account levels, separated by ' - ',
     *                     or null if the account ID does not exist.
     */
    public function getNomesConcatenados($id)
    {
        // Recuperando o modelo da ContaContabil com os relacionamentos
        $contaContabil = ModelContaContabil::with([
            'nivel1',
            'nivel2',
            'nivel3',
            'nivel4',
            'nivel5',
            'nivel6'
        ])
        ->where('id', $id)
        ->first();

        // Se algum valor foi retornado, concatena os campos
        $nome_concatenado = null;
        if ($contaContabil) {
            // Usando os relacionamentos para acessar as descrições
            $nome_concatenado = implode(' - ', [
                $contaContabil->nivel1 ? $contaContabil->nivel1->descricao : '',
                $contaContabil->nivel2 ? $contaContabil->nivel2->descricao : '',
                $contaContabil->nivel3 ? $contaContabil->nivel3->descricao : '',
                $contaContabil->nivel4 ? $contaContabil->nivel4->descricao : '',
                $contaContabil->nivel5 ? $contaContabil->nivel5->descricao : '',
                $contaContabil->nivel6 ? $contaContabil->nivel6->descricao : '',
            ]);
        }

        return $nome_concatenado;
    }



    public static function hasDuplicateLevels(Request $request): bool
    {
        return self::query()
            ->where('nivel_1', $request->input('nivel_1'))
            ->where('nivel_2', $request->input('nivel_2'))
            ->where('nivel_3', $request->input('nivel_3'))
            ->where('nivel_4', $request->input('nivel_4'))
            ->where('nivel_5', $request->input('nivel_5'))
            ->where('nivel_6', $request->input('nivel_6'))
            ->exists();
    }
}
