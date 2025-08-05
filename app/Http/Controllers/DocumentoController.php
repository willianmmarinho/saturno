<?php

namespace App\Http\Controllers;

use App\Models\ModelDocumento;
use App\Models\ModelEmpresa;
use App\Models\ModelSetor;
use App\Models\ModelTipoDocumento;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class DocumentoController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $lista_de_documentos = ModelDocumento::with(['tipoDocumento', 'empresa'])->get();
        //dd($lista_de_documentos);
        $lista_de_empresas = ModelEmpresa::all();
        $tipo_de_tipos_documentos = ModelTipoDocumento::all();
        // dd($lista_documentos);


        return view('documento.index', compact('lista_de_documentos', 'lista_de_empresas', 'tipo_de_tipos_documentos'));

    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $empresas = ModelEmpresa::all();
        $tipos_documentos = ModelTipoDocumento::all();
        $setores = ModelSetor::all();

        return view('documento.create', compact('empresas', 'tipos_documentos', 'setores'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'documento.dt_doc' => 'required|date',
            'documento.id_tp_doc' => 'required|exists:tipo_documento,id',  // Corrigido anteriormente
            'documento.valor' => 'required|numeric',
            'documento.id_empresa' => 'required|exists:empresa,id',  // Aqui ajuste o nome da tabela
            'documento.id_setor' => 'required|exists:setores,id',
            'documento.dt_validade' => 'required|date',
            'documento.end_arquivo' => 'required|file|mimes:jpg,png,pdf,docx|max:2048',
        ]);
        // Armazenar o arquivo
        if ($request->hasFile('documento.end_arquivo')) {
            $file = $request->file('documento.end_arquivo');
            $fileName = time() . '_' . $file->getClientOriginalName();
            $filePath = $file->storeAs('public/uploads', $fileName);

            // Criar o novo documento e salvar no banco de dados
            DB::table('documento')->insert([
                'numero' => $request->input('documento.numero'), // Se você está gerando números ou tem um valor fixo
                'dt_doc' => $request->input('documento.dt_doc'),
                'id_tp_doc' => $request->input('documento.id_tp_doc'),
                'valor' => $request->input('documento.valor'),
                'id_empresa' => $request->input('documento.id_empresa'),
                'id_setor' => $request->input('documento.id_setor'),
                'vencedor' => $request->input('documento.vencedor', null), // Ajuste conforme necessidade
                'id_sol_sv' => $request->input('documento.id_sol_sv', null), // Ajuste conforme necessidade
                'is_sol_mat' => $request->input('documento.is_sol_mat', false), // Ajuste conforme necessidade
                'dt_validade' => $request->input('documento.dt_validade'),
                'end_arquivo' => $filePath,
            ]);

            return redirect()->route('documento.index')->with('success', 'Documento criado com sucesso!');
        }

        return back()->with('error', 'Erro ao enviar o arquivo.');

    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
