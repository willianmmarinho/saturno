<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\ModelTipoCategoriaMt;
use Illuminate\Support\Facades\DB;


class CatMaterialController extends Controller
{

    private $objTpMat;

    public function __construct()
    {
        $this->objTpMat = new ModelTipoCategoriaMt();
    }

    public function index(Request $request)
    {
        $query = $this->objTpMat->query();

        if ($request->razaoSocial) {
            $query->where('nome', 'ilike', '%' . $request->razaoSocial . '%');        }

        // Executando a consulta
        $result = $query->orderBy('id')->paginate(30);

        return view('/cadastro-geral/cad-cat-material', ['result' => $result]);
    }

    public function create(Request $request)
    {





        return view('/cadastro-geral/inserir-cat-material');
    }

    public function store(Request $request)
    {

        try {
            // Criação do registro no banco
            ModelTipoCategoriaMt::create([
                'nome' => $request->categoria,
            ]);

            // Feedback de sucesso
            app('flasher')->addSuccess('Categoria criada com sucesso!');
        } catch (\Exception $e) {
            // Feedback de erro
            app('flasher')->addError('Erro ao criar a categoria. Por favor, tente novamente.');
            return redirect()->back()->withInput();
        }

        // Redireciona após sucesso
        return redirect('/cad-cat-material');
    }

    public function show($id)
    {
        //
    }

    public function edit($id)
    {
        $resultCatMaterial = DB::select("select id,nome from tipo_categoria_material where id = $id ");

        return view('/cadastro-geral/alterar-cat-material', compact("resultCatMaterial"));
    }

    public function update(Request $request, $id)
    {
        try {
            // Busca o registro pelo ID
            $categoria = ModelTipoCategoriaMt::findOrFail($id);

            // Verificar e armazenar novos valores somente se forem diferentes
            if ($request->filled("categoria") && $categoria->nome !== $request->categoria) {
                $categoria->update([
                    'nome' => $request->categoria,
                ]);
            }

            // Feedback de sucesso
            app('flasher')->addSuccess('Categoria atualizada com sucesso!');
        } catch (\Exception $e) {
            // Feedback de erro
            app('flasher')->addError('Erro ao atualizar a categoria. Por favor, tente novamente.');
            return redirect()->back()->withInput();
        }

        // Redireciona após sucesso
        return redirect('/cad-cat-material');
    }

    public function destroy($id)
    {
        try {
            // Busca o registro pelo ID
            $categoria = ModelTipoCategoriaMt::findOrFail($id);

            // Deleta o registro
            $categoria->delete();

            // Feedback de sucesso
            app('flasher')->addSuccess('Categoria removida com sucesso!');
        } catch (\Exception $e) {
            // Feedback de erro
            app('flasher')->addError('Erro ao remover a categoria. Por favor, tente novamente.');
        }

        // Redireciona para a página de gerenciamento
        return redirect()->route('cadcat.index');
    }
}

