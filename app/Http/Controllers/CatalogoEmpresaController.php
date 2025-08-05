<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\ModelEmpresa;
use App\Models\ModelTipoCidade;
use App\Models\ModelTipoUf;
use App\Models\ModelTipoPais;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Rules\CpfCnpj;
use App\Rules\Telefone;
use App\Rules\Cep;
use Carbon\Carbon;

use function Laravel\Prompts\select;

class CatalogoEmpresaController extends Controller
{

    public function index(Request $request)
    {

        $query = ModelEmpresa::with(['ModelTipoUf']);

        if ($request->razaoSocial) {
            $query->where('razaosocial', 'ILIKE', '%' . $request->razaoSocial . '%');
        }
        if ($request->nomeFantasia) {
            $query->where('nomefantasia', 'ILIKE', '%' . $request->nomeFantasia . '%');
        }

        $empresa = $query->orderby('nomefantasia')->paginate(20);


        return view('empresa.catalogo-empresa', compact('empresa'));
    }

    public function create()
    {

        $tp_uf = ModelTipoUf::all();
        $tipoPais = ModelTipoPais::all();


        return view('empresa.incluir-empresa', compact('tp_uf', 'tipoPais'));
    }

    public function store(Request $request)
    {
        // $request->validate([
        //     'cnpj' => ['required', new CpfCnpj],
        //     'inscricaoEmail' => 'required|email',
        //     'inscricaoCep' => ['required', new Cep],
        // ]);

        // Verifica se o CNPJ ou CPF já existe
        $cnpjCpfExistente = ModelEmpresa::where('cnpj_cpf', $request->input('cnpj'))->exists();

        if ($cnpjCpfExistente) {

            app('flasher')->addError('Não é possível incluir esta empresa, pois ela ja foi registrada.');
            return redirect()->back()->withInput();
        }

        $empresa = ModelEmpresa::create([
            'razaosocial' => $request->input('razaoSocial'),
            'nomefantasia' => $request->input('nomeFantasia'),
            'cnpj_cpf' => $request->input('cnpj'),
            'inscestadual' => $request->input('inscricaoEstadual'),
            'inscmunicipal' => $request->input('inscricaoMunicipal'),
            'cep' => $request->input('inscricaoCep'),
            'logradouro' => $request->input('logradouro'),
            'numero' => $request->input('inscricaoNumero'),
            'complemento' => $request->input('inscricaoComplemento'),
            'bairro' => $request->input('bairro'),
            'pais_cod' => $request->input('pais'),
            'uf_cod' => $request->input('tp_uf'),
            'telefone' => $request->input('inscricaoTelefone'),
            'email' => $request->input('inscricaoEmail'),
            'municipio_cod' => $request->input('cidade')
        ]);

        app('flasher')->addSuccess('Empresa criada com sucesso.');
        return redirect()->route('empresa.index');
    }

    public function retornaCidadeDadosResidenciais($id)
    {
        $cidadeDadosResidenciais = ModelTipoCidade::with('ModelTipoUf')->where('id_uf', $id)->orderby('descricao')->get();

        return response()->json($cidadeDadosResidenciais);
    }

    public function edit($id)
    {

        $buscaEmpresa = ModelEmpresa::with(['ModelTipoUf', 'TipoPais', 'TipoCidade'])->find($id);
        $tiposUf = ModelTipoUf::all();
        $tipoPais = ModelTipoPais::all();
        $tipoCidade = ModelTipoCidade::all();

        //dd($buscaEmpresa->ModelTipoUf->id);



        return view('empresa.editar-empresa', compact('buscaEmpresa', 'tiposUf', 'tipoPais', 'tipoCidade'));
    }

    public function update(Request $request)
    {
        $empresa = ModelEmpresa::find($request->input('id'));

        // $request->validate([
        //     'cnpj' => ['required', new CpfCnpj],
        //     'inscricaoEmail' => 'required|email',
        //     'inscricaoTelefone' => ['required', new Telefone],
        //     'cep' => ['required', new Cep],
        // ]);

        $empresa->fill([
            'razaosocial' => $request->input('razaoSocial'),
            'nomefantasia' => $request->input('nomeFantasia'),
            'cnpj_cpf' => $request->input('cnpj'),
            'inscestadual' => $request->input('inscricaoEstadual'),
            'inscmunicipal' => $request->input('inscricaoMunicipal'),
            'cep' => $request->input('cep'),
            'logradouro' => $request->input('logradouro'),
            'numero' => $request->input('inscricaoNumero'),
            'complemento' => $request->input('inscricaoComplemento'),
            'bairro' => $request->input('bairro'),
            'pais_cod' => $request->input('pais'),
            'uf_cod' => $request->input('tp_uf'),
            'telefone' => $request->input('inscricaoTelefone'),
            'email' => $request->input('inscricaoEmail'),
            'municipio_cod' => $request->input('cidade')
        ]);

        //dd($empresa);

        $empresa->save();

        return redirect()->route('empresa.index');
    }

    public function delete($id)
    {
        $empresa = ModelEmpresa::with('documento')->find($id);


        if (!$empresa) {
            app('flasher')->addWarning('Empresa não encontrada.');
            return redirect()->route('empresa.index');
        }

        // Verifica se há documentos associados à empresa
        if ($empresa->documento->count() > 0) {
            app('flasher')->addError('Não é possível excluir esta empresa, pois há documentos associados a ela.');
            return redirect()->route('empresa.index');
        }

        // Se não houver documentos, a empresa é excluída
        $empresa->delete();

        app('flasher')->addSuccess('Empresa deletada com sucesso.');
        return redirect()->route('empresa.index');
    }
}
