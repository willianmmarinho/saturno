<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\ModelUnidadeMedida;
use Illuminate\Support\Facades\DB;


class UnidadeMedidaController extends Controller
{
    public function index(Request $request)
    {
        $query = ModelUnidadeMedida::where('tipo', 1);

        if ($request->nomeUM) {
            $query->where('nome', 'ilike', '%' . $request->nomeUM . '%');
        }
        if ($request->siglaUM) {
            $query->where('sigla', 'ilike', '%' . $request->siglaUM . '%');
        }
        if ($request->filled('status')) {
            if ($request->status === 'ativo') {
                $query->where('ativo', true);
            } elseif ($request->status === 'inativo') {
                $query->where('ativo', false);
            }
        }

        $result = $query->orderBy('id', 'asc')->paginate(20);

        return view('/cadastro-geral/gerenciar-unidade-medida', compact('result'));
    }

    public function create()
    {
        //
    }

    public function store(Request $request)
    {
        $sigla = $request->input('sigla');
        $nome = $request->input('unidade_med');

        // Verifica se já existe uma unidade com a mesma sigla ou nome
        $existe = ModelUnidadeMedida::where(function ($query) use ($sigla, $nome) {
            $query->where('sigla', $sigla)
                ->orWhere('nome', $nome);
        })->where('tipo', 1)
            ->where('ativo', true)
            ->exists();

        if ($existe) {
            app('flasher')->addError('Já existe uma unidade de medida com essa sigla ou nome.');
            return redirect()->back();
        }

        ModelUnidadeMedida::create([
            'nome' => $nome,
            'sigla' => $sigla,
            'ativo' => 1,
            'tipo' => 1,
        ]);

        app('flasher')->addSuccess('Unidade de medida cadastrada com sucesso.');
        return redirect()->route('unidade-medida.index'); // <-- ajuste aqui conforme sua rota
    }

    public function show($id)
    {
        //
    }

    public function edit($id)
    {
       
    }

    public function update(Request $request, $id)
    {
        DB::table('tipo_unidade_medida')
            ->where('id', $id)
            ->update([
                'nome' => $request->input('unidade_med'),
                'sigla' => $request->input('sigla')
            ]);

        return redirect()->route('unidade-medida.index');
    }

    public function inativar($id)
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

        return redirect()->route('unidade-medida.index');
    }


    public function destroy($id)
    {
        $count = DB::table('embalagem')
            ->where('id_un_med_n1', $id)
            ->orWhere('id_un_med_n2', $id)
            ->count();

        if ($count == 0) {
            ModelUnidadeMedida::where('id', $id)->delete();
            app('flasher')->addSuccess('Unidade de medida excluída com sucesso!');
        } else {
            app('flasher')->addError('Não é possível excluir esta unidade de medida, pois ela está vinculada a um material.');
        }
        return redirect()->route('unidade-medida.index');
    }
}
