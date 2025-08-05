<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\ModelEmbalagem;
use App\Models\ModelItemCatalogoMaterial;
use App\Models\ModelUnidadeMedida;
use App\Models\ModelTipoCategoriaMt;
use Illuminate\Support\Facades\DB;

class EmbalagemController extends Controller
{
    public function index(Request $request)
    {
        $query = ModelItemCatalogoMaterial::with('tipoCategoriaMt', 'unidadeMedida');
        if ($request->categoria) {
            $query->where('id_categoria_material', $request->categoria);
        }
        if ($request->nomeMaterial) {
            $query->where('nome', $request->nomeMaterial);
        }
        if ($request->filled('status')) {
            if ($request->status === 'ativo') {
                $query->where('ativo', true);
            } elseif ($request->status === 'inativo') {
                $query->where('ativo', false);
            }
        }

        $result = $query->orderBy('id', 'desc')->paginate(20);

        $categoria = ModelTipoCategoriaMt::all();
        $nomeMaterial = ModelItemCatalogoMaterial::all();

        return view('/embalagem/gerenciar-embalagem', compact('result', 'categoria', 'nomeMaterial'));
    }

    public function create()
    {
        //
    }

    public function store(Request $request, $id)
    {
        $unidadeMedida = ModelItemCatalogoMaterial::where('id', $id)->value('tp_unidade_medida');

        $existe = ModelEmbalagem::where('id_item_catalogo', $id)
            ->where('qtde_n1', $request->input('qtdUM'))
            ->where('id_un_med_n2', $request->input('embalagem1'))
            ->exists();

        if ($existe) {
            app('flasher')->addError('Essa embalagem já está cadastrada para este item.');
            return redirect()->back();
        }

        ModelEmbalagem::create([
            'id_item_catalogo' => $id,
            'id_un_med_n1' => $unidadeMedida,
            'qtde_n1' => $request->input('qtdUM'),
            'id_un_med_n2' => $request->input('embalagem1'),
            'qtde_n2' => 1,
            'ativo' => 1,
        ]);

        app('flasher')->addSuccess('Embalagem criada com sucesso!');
        return redirect()->route('embalagem.alterar', ['id' => $id]);
    }

    public function edit($id)
    {
        $itemMaterial = ModelItemCatalogoMaterial::with('tipoCategoriaMt', 'tipoMaterial')->findOrFail($id);
        $embalagem = ModelUnidadeMedida::where('tipo', 2)->get();
        $result = ModelEmbalagem::with('unidadeMedida', 'unidadeMedida2', 'unidadeMedida3', 'unidadeMedida4')->where('id_item_catalogo', $id)->orderby('id', 'asc')->get();

        return view('/embalagem/editar-embalagem', compact('itemMaterial', 'result', 'embalagem'));
    }

    public function update(Request $request, $id)
    {
        $itemMaterial = ModelEmbalagem::where('id', $id)->value('id_item_catalogo');

        $existe = ModelEmbalagem::where('id_item_catalogo', $itemMaterial)
            ->where('qtde_n1', $request->input('editQtdUM'))
            ->where('id_un_med_n2', $request->input('editEmbalagem1'))
            ->exists();

        if ($existe) {
            app('flasher')->addError('Essa embalagem já está cadastrada para este item.');
            return redirect()->back();
        }

        ModelEmbalagem::where('id', $id)
            ->update([
                'qtde_n1' => $request->input('editQtdUM'),
                'id_un_med_n2' => $request->input('editEmbalagem1'),
            ]);

        app('flasher')->addSuccess('Embalagem alterada com sucesso!');
        return redirect()->back();
    }

    public function inativar($id)
    {
        $embalagem = ModelEmbalagem::find($id);

        if (!$embalagem) {
            app('flasher')->addError('Embalagem não encontrada.');
            return redirect()->back();
        }

        // Se estiver ativa e vinculada a algum material, impede a inativação
        if ($embalagem->ativo == 1) {
            $count = DB::table('cadastro_inicial')
                ->where('id_embalagem', $id)
                ->count();

            if ($count > 0) {
                app('flasher')->addError('Não é possível inativar esta embalagem, pois ela está vinculada a um material.');
                return redirect()->back();
            }
        }

        // Inverte o estado atual de "ativo"
        $embalagem->ativo = $embalagem->ativo == 1 ? 0 : 1;
        $embalagem->save();

        $mensagem = $embalagem->ativo == 1
            ? 'Embalagem ativada com sucesso!'
            : 'Embalagem inativada com sucesso!';

        app('flasher')->addSuccess($mensagem);

        return redirect()->back();
    }

    public function delete($id)
    {
        $count = DB::table('cadastro_inicial')
            ->where('id_embalagem', $id)
            ->count();

        if ($count == 0) {
            ModelEmbalagem::where('id', $id)->delete();
            app('flasher')->addSuccess('Embalagem excluída com sucesso!');
        } else {
            app('flasher')->addError('Não é possível excluir esta embalagem, pois ela está vinculada a um material.');
        }
        return redirect()->back();
    }

    public function indexCad(Request $request)
    {
        $query = ModelUnidadeMedida::where('tipo', 2);

        if ($request->nomeEmb) {
            $query->where('nome', 'ilike', '%' . $request->nomeEmb . '%');
        }
        if ($request->siglaEmb) {
            $query->where('sigla', 'ilike', '%' . $request->siglaEmb . '%');
        }
        if ($request->filled('status')) {
            if ($request->status === 'ativo') {
                $query->where('ativo', true);
            } elseif ($request->status === 'inativo') {
                $query->where('ativo', false);
            }
        }

        $result = $query->orderBy('id', 'asc')->paginate(20);

        return view('/embalagem/cad-embalagem', compact('result'));
    }

    public function storeCad(Request $request)
    {
        ModelUnidadeMedida::Create([
            'nome' => $request->input('unidade_med'),
            'sigla' => $request->input('sigla'),
            'ativo' => 1,
            'tipo' => 2,
        ]);

        return redirect()->route('cadEmbalagem.index');
    }

    public function updateCad(Request $request, $id)
    {
        $embalagem = ModelUnidadeMedida::findOrFail($id);
        $embalagem->nome = $request->unidade_med;
        $embalagem->sigla = $request->sigla;
        $embalagem->save();

        app('flasher')->addSuccess('Embalagem atualizada com sucesso!');
        return redirect()->route('cadEmbalagem.index');
    }

    public function inativarCad($id)
    {
        $unidade = ModelUnidadeMedida::findOrFail($id);

        // Se estiver ativa, verifica se pode ser inativada
        if ($unidade->ativo) {
            $count = DB::table('embalagem')
                ->where('id_un_med_n1', $id)
                ->orWhere('id_un_med_n2', $id)
                ->orWhere('id_un_med_n3', $id)
                ->orWhere('id_un_med_n4', $id)
                ->count();

            if ($count == 0) {
                $unidade->ativo = 0;
                $unidade->save();
                app('flasher')->addSuccess('Unidade de medida inativada com sucesso!');
            } else {
                app('flasher')->addError('Não é possível inativar esta unidade de medida, pois ela está vinculada a um material.');
            }
        } else {
            // Se estiver inativa, ativa diretamente
            $unidade->ativo = 1;
            $unidade->save();
            app('flasher')->addSuccess('Unidade de medida ativada com sucesso!');
        }

        return redirect()->route('cadEmbalagem.index');
    }

    public function deleteCad($id)
    {
        $count = DB::table('embalagem')
            ->where('id_un_med_n1', $id)
            ->orWhere('id_un_med_n2', $id)
            ->orWhere('id_un_med_n3', $id)
            ->orWhere('id_un_med_n4', $id)
            ->count();

        if ($count == 0) {
            ModelUnidadeMedida::where('id', $id)->delete();
            app('flasher')->addSuccess('Unidade de medida excluída com sucesso!');
        } else {
            app('flasher')->addError('Não é possível excluir esta unidade de medida, pois ela está vinculada a um material.');
        }
        return redirect()->route('cadEmbalagem.index');
    }
}
