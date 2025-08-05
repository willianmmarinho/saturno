<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\ModelCatalogoMaterial;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;
use App\Models\ModelSolMaterial;
use App\Models\ModelTipoCategoriaMt;
use App\Models\ModelTipoStatusSolMt;
use App\Models\ModelSetor;
use App\Models\ModelCor;
use App\Models\ModelDocumento;
use App\Models\ModelEmbalagem;
use App\Models\ModelFaseEtaria;
use App\Models\ModelMarca;
use App\Models\ModelSexo;
use App\Models\ModelTamanho;
use App\Models\ModelEmpresa;
use App\Models\ModelCadastroInicial;
use App\Models\ModelItemCatalogoMaterial;
use App\Models\ModelMatProposta;
use App\Models\ModelUnidadeMedida;
use App\Models\ModelPessoa;
use App\Models\ModelValorAvariado;
use Illuminate\Support\Facades\Storage;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Support\Facades\Validator;


use function Laravel\Prompts\select;

class PesquisaController extends Controller
{

    public function getMarcas($categoriaId)
    {
        $marcas = ModelMarca::where('id_categoria_material', $categoriaId)->get(['id', 'nome']);
        return response()->json($marcas);
    }

    public function getTamanhos($categoriaId)
    {
        $tamanhos = ModelTamanho::where('id_categoria_material', $categoriaId)->get(['id', 'nome']);
        return response()->json($tamanhos);
    }

    public function getCores($categoriaId)
    {
        $cores = ModelCor::where('id_categoria_material', $categoriaId)->get(['id', 'nome']);
        return response()->json($cores);
    }

    public function getFases($categoriaId)
    {
        $fases = ModelFaseEtaria::where('id_categoria_material', $categoriaId)->get(['id', 'nome']);
        return response()->json($fases);
    }
    public function getNomes($categoriaId)
    {
        $nomes = ModelItemCatalogoMaterial::where('id_categoria_material', $categoriaId)->get(['id', 'nome']);
        return response()->json($nomes);
    }
    public function getEmbalagens($nomeId)
    {
        $embalagens = ModelEmbalagem::with([
            'unidadeMedida',       // n1
            'unidadeMedida2',      // n2
            'unidadeMedida3',      // n3
            'unidadeMedida4'       // n4
        ])
            ->where('id_item_catalogo', $nomeId)
            ->get();

        $embalagensFormatadas = $embalagens->map(function ($emb) {
            $partes = [];

            if ($emb->qtde_n4 && $emb->unidadeMedida4) {
                $partes[] = "{$emb->qtde_n4} {$emb->unidadeMedida4->nome}";
            }

            if ($emb->qtde_n3 && $emb->unidadeMedida3) {
                $partes[] = "{$emb->qtde_n3} {$emb->unidadeMedida3->nome}";
            }

            if ($emb->qtde_n2 && $emb->unidadeMedida2) {
                $partes[] = "{$emb->qtde_n2} {$emb->unidadeMedida2->nome}";
            }

            if ($emb->qtde_n1 && $emb->unidadeMedida) {
                $partes[] = "{$emb->qtde_n1} {$emb->unidadeMedida->nome}";
            }

            $desc = implode(' / ', $partes);

            return [
                'id' => $emb->id,
                'nome' => $desc
            ];
        });

        return response()->json($embalagensFormatadas);
    }
    public function getTipo($nomeId)
    {
        $item = ModelItemCatalogoMaterial::with('tipoMaterial')->find($nomeId);

        return response()->json([
            'id' => $item->tipoMaterial->id ?? null,
            'nome' => $item->tipoMaterial->nome ?? null,
        ]);
    }
    public function getValorAquisicao($nomeId)
    {
        $nomes = ModelCadastroInicial::where('id_item_catalogo', $nomeId)
            ->get(['valor_aquisicao'])
            ->filter(function ($item) {
                return !is_null($item->valor_aquisicao);
            })
            ->map(function ($item) {
                return [
                    'id' => $item->valor_aquisicao,
                    'nome' => number_format($item->valor_aquisicao, 2, ',', '')
                ];
            });
        return response()->json($nomes->values());
    }

    public function getValorVenda($nomeId)
    {
        $nomes = ModelCadastroInicial::where('id_item_catalogo', $nomeId)
            ->get(['valor_venda'])
            ->filter(function ($item) {
                return !is_null($item->valor_venda);
            })
            ->map(function ($item) {
                return [
                    'id' => $item->valor_venda,
                    'nome' => number_format($item->valor_venda, 2, ',', '')
                ];
            });
        return response()->json($nomes->values());
    }

    public function getValorVendaAvariado($nomeId)
    {
        $nomes = ModelValorAvariado::get(['valor'])
            ->filter(function ($item) {
                return !is_null($item->valor);
            })
            ->map(function ($item) {
                return [
                    'id' => $item->valor,
                    'nome' => number_format($item->valor, 2, ',', '')
                ];
            });

        return response()->json($nomes->values());
    }
}
