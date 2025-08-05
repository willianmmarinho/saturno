<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;
use App\Models\ModelSolServico;
use App\Models\ModelCatalogoServico;
use App\Models\ModelTipoClasseSv;


use function Laravel\Prompts\select;

class CatalogoServicoController extends Controller
{

    public function index(Request $request)
    {
        $query = ModelCatalogoServico::with('tipoClasseSv');

        // Aplicar filtros se forem fornecidos
        if ($request->classe) {
            $query->where('id_cl_sv', $request->classe);
        }

        if ($request->servicos) {
            $query->where('id', $request->servicos);
        }

        if ($request->classeSituacao) {
            $query->whereHas('tipoClasseSv', function ($q) use ($request) {
                $q->where('situacao', $request->classeSituacao);
            });
        }

        if ($request->servSituacao) {
            $query->where('situacao', $request->servSituacao);
        }


        $aquisicao = $query->orderBy('id_cl_sv')->paginate(20);

        //dd($aquisicao);

        // Pegar todas as classes e os serviços
        $classeAquisicao = ModelTipoClasseSv::all();

        return view('servico.catalogo-servico', compact('aquisicao', 'classeAquisicao'));
    }

    public function create()
    {

        $classes = ModelTipoClasseSv::all();

        return view('servico.incluir-servico', compact('classes'));
    }

    public function store(Request $request)
    {
        // Verifica se uma nova classe foi fornecida ou se uma classe existente foi selecionada
        $classeId = $request->input('classe_servico');
        $servicoId = $request->input('tipos_servico');

        // Cria uma nova classe de serviço se o campo de nova classe foi preenchido
        if (!$classeId && $request->filled('nova_classe_servico')) {
            $novaClasse = ModelTipoClasseSv::create([
                'descricao' => $request->input('nova_classe_servico'),
                'sigla' => $request->input('sigla_classe_servico'),
                'situacao' => 'true',
            ]);
            $classeId = $novaClasse->id;
        }

        if (!is_null($servicoId)) {
            // Filtra os tipos de serviço para remover valores vazios ou nulos
            $servicosValidos = array_filter($request->input('tipos_servico'), function ($tipoServico) {
                return !is_null($tipoServico) && trim($tipoServico) !== '';
            });

            // Adiciona os tipos de serviço relacionados à classe
            foreach ($servicosValidos as $tipoServico) {
                ModelCatalogoServico::create([
                    'id_cl_sv' => $classeId,
                    'descricao' => $tipoServico,
                    'situacao' => 'true',
                ]);
            }
        }

        app('flasher')->addSuccess('Serviço criado com sucesso.');
        return redirect()->route('catalogo-servico.index');
    }


    public function edit($id)
    {
        // Encontre o serviço pelo ID
        $servico = ModelCatalogoServico::with('tipoClasseSv')->findOrFail($id);

        // Busque todas as classes disponíveis
        $classes = ModelTipoClasseSv::all(); // ou qualquer lógica que você tenha para pegar as classes

        return view('servico.editar-servico', [
            'servico' => $servico,
            'classes' => $classes,
            'classeSelecionada' => $servico->tipoClasseSv, // passando a classe selecionada
        ]);
    }

    public function update(Request $request, $id)
    {
        // Validação dos dados
        $request->validate([
            'classe_servico' => 'required|exists:tipo_classe_sv,id', // Valida se a classe existe
            'nomeServico' => 'required|string|max:255',
            'servicoSituacao' => 'required|boolean', // Verifica se o valor é booleano (true/false) para o serviço
            'classeSituacao' => 'required|boolean', // Verifica se o valor é booleano (true/false) para a classe
        ]);

        // Encontre o serviço pelo ID
        $servico = ModelCatalogoServico::findOrFail($id);
        $classe = ModelTipoClasseSv::findOrFail($servico->id_cl_sv);

        // Atualize os dados do serviço
        $servico->descricao = $request->input('nomeServico');
        $servico->id_cl_sv = $request->input('classe_servico');
        $servico->situacao = (bool) $request->input('servicoSituacao');

        // Atualize a situação da classe
        $classe->situacao = (bool) $request->input('classeSituacao');

        // Se a classe for inativada, inative todos os serviços dessa classe
        if ($classe->situacao === false) {
            // Atualiza a situação de todos os serviços associados a essa classe
            ModelCatalogoServico::where('id_cl_sv', $classe->id)->update(['situacao' => false]);
        }

        // Salve as alterações no banco
        $servico->save();
        $classe->save();

        // Adiciona a mensagem de sucesso e redireciona
        app('flasher')->addSuccess('Serviço alterado com sucesso.');
        return redirect()->route('catalogo-servico.index');
    }

    public function delete($id)
    {
        $tipoServico = ModelCatalogoServico::with('SolServico')->find($id);
        if (!$tipoServico) {
            app('flasher')->addWarning('Serviço não encontrado.');
            return redirect()->route('catalogo-servico.index');
        }
        if ($tipoServico->SolServico->count() > 0) {

            $tipoServico->update(['situacao' => 'false']);

            app('flasher')->addWarning('Este serviço foi inativado, pois há documentos associados a ele.');
            return redirect()->route('catalogo-servico.index');
        }

        $tipoServico->delete();

        app('flasher')->addSuccess('Serviço deletado com sucesso.');
        return redirect()->route('catalogo-servico.index');
    }

    public function deleteClasse(request $request)
    {
        $id = $request->input('classeExcluir');
        $classeServico = ModelTipoClasseSv::with('SolServico', 'catalogoServico')->find($id);
        if (!$classeServico) {
            app('flasher')->addError('Serviço não encontrado.');
            return redirect()->route('catalogo-servico.index');
        }
        if ($classeServico->SolServico->count() > 0) {

            foreach ($classeServico->catalogoServico as $catalogo) {
                $catalogo->update(['situacao' => 'false']); // Atualiza o status do catálogo
            }

            $classeServico->update(['situacao' => 'false']);


            app('flasher')->addWarning('Esta classe e seus serviços foram inativados, pois há documentos associados a eles.');
            return redirect()->route('catalogo-servico.index');
        }

        $classeServico->delete();

        foreach ($classeServico->catalogoServico as $catalogo) {
            $catalogo->delete(); // Atualiza o status do catálogo
        }

        app('flasher')->addSuccess('A classe e seus serviços foram deletados com sucesso.');
        return redirect()->route('catalogo-servico.index');
    }
}
