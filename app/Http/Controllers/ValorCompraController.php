<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;
use Illuminate\Support\Facades\Storage;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Support\Facades\Validator;
use App\Models\ModelValorCompra;
use App\Models\HistModelValorCompra;


use function Laravel\Prompts\select;

class ValorCompraController extends Controller
{

    public function index(Request $request)
    {
        $id_funcionario = session('usuario.id_usuario');
        // Verifica e atualiza valorServDIADM
        if ($request->input('valorServDIADM') != null) {
            $existingRecord = ModelValorCompra::where('tipo_sol', 1)
                ->where('tipo_compra', 1)
                ->whereNull('dt_fim') // Busca registros sem 'dt_fim'
                ->first();

            if (!$existingRecord || $existingRecord->valor != $request->input('valorServDIADM')) {
                // Atualiza o 'dt_fim' do registro existente, se necessário
                if ($existingRecord) {
                    $existingRecord->update([
                        'dt_fim' => now(),
                        'id_funcionario' => $id_funcionario,
                    ]);
                }
                // Insere um novo registro
                ModelValorCompra::create([
                    'valor' => $request->input('valorServDIADM'),
                    'tipo_sol' => 1,
                    'tipo_compra' => 1,
                    'dt_inicio' => now(),
                ]);

                app('flasher')->addSuccess('Valor máximo de serviço foi alterado com sucesso!');
            }
        }

        // Verifica e atualiza valorMatDIADM
        if ($request->input('valorMatDIADM') != null) {
            $existingRecord = ModelValorCompra::where('tipo_sol', 2)
                ->where('tipo_compra', 1)
                ->whereNull('dt_fim') // Busca registros sem 'dt_fim'
                ->first();

            if (!$existingRecord || $existingRecord->valor != $request->input('valorMatDIADM')) {
                // Atualiza o 'dt_fim' do registro existente, se necessário
                if ($existingRecord) {
                    $existingRecord->update([
                        'dt_fim' => now(),
                        'id_funcionario' => $id_funcionario,
                    ]);
                }
                // Insere um novo registro
                $segundo = ModelValorCompra::create([
                    'valor' => $request->input('valorMatDIADM'),
                    'tipo_sol' => 2,
                    'tipo_compra' => 1,
                    'dt_inicio' => now(),
                ]);

                app('flasher')->addSuccess('Valor máximo de material foi alterado com sucesso!');
            }
        }

        // Verifica e atualiza valorServ
        if ($request->input('valorMaxServ') != null) {
            $existingRecord = ModelValorCompra::where('tipo_sol', 1)
                ->where('tipo_compra', 2)
                ->whereNull('dt_fim') // Busca registros sem 'dt_fim'
                ->first();

            if (!$existingRecord || $existingRecord->valor != $request->input('valorMaxServ')) {
                // Atualiza o 'dt_fim' do registro existente, se necessário
                if ($existingRecord) {
                    $existingRecord->update([
                        'dt_fim' => now(),
                        'id_funcionario' => $id_funcionario,
                    ]);
                }
                // Insere um novo registro
                $terceiro = ModelValorCompra::create([
                    'valor' => $request->input('valorMaxServ'),
                    'tipo_sol' => 1,
                    'tipo_compra' => 2,
                    'dt_inicio' => now(),
                ]);

                app('flasher')->addSuccess('Valor máximo de compra sem necessidade de 3 proposta alterado com sucesso!');
            }
        }

        // Verifica e atualiza valorMat
        if ($request->input('valorMaxMat') != null) {
            $existingRecord = ModelValorCompra::where('tipo_sol', 2)
                ->where('tipo_compra', 2)
                ->whereNull('dt_fim') // Busca registros sem 'dt_fim'
                ->first();

            if (!$existingRecord || $existingRecord->valor != $request->input('valorMaxMat')) {
                // Atualiza o 'dt_fim' do registro existente, se necessário
                if ($existingRecord) {
                    $existingRecord->update([
                        'dt_fim' => now(),
                        'id_funcionario' => $id_funcionario,
                    ]);
                }
                // Insere um novo registro
                $quarto = ModelValorCompra::create([
                    'valor' => $request->input('valorMaxMat'),
                    'tipo_sol' => 2,
                    'tipo_compra' => 2,
                    'dt_inicio' => now(),
                ]);

                app('flasher')->addSuccess('Valor máximo de compra sem necessidade de 3 proposta alterado com sucesso!');
            }
        }

        $valorServDIADM = ModelValorCompra::where('tipo_sol', 1)//tipo 1 significa que se refere a um servico
            ->where('tipo_compra', 1)//tipo 1 significa que se refere ao valor max que a DIADM vê
            ->whereNull('dt_fim') // Busca registros sem 'dt_fim'
            ->first();

        $valorMatDIADM = ModelValorCompra::where('tipo_sol', 2)//tipo 2 significa que se refere a um material
            ->where('tipo_compra', 1)//tipo 1 significa que se refere ao valor max que a DIADM vê
            ->whereNull('dt_fim') // Busca registros sem 'dt_fim'
            ->first();

        $valorMaxServ = ModelValorCompra::where('tipo_sol', 1)//tipo 1 significa que se refere a um servico
            ->where('tipo_compra', 2)//tipo 2 significa que se refere ao valor max que  não necessita 3 propostas comerciais
            ->whereNull('dt_fim') // Busca registros sem 'dt_fim'
            ->first();

        $valorMaxMat = ModelValorCompra::where('tipo_sol', 2)//tipo 2 significa que se refere a um material
            ->where('tipo_compra', 2)//tipo 2 significa que se refere ao valor max que  não necessita 3 propostas comerciais
            ->whereNull('dt_fim') // Busca registros sem 'dt_fim'
            ->first();

        return view('ModelValorCompra.valor-compra', compact('valorServDIADM', 'valorMatDIADM', 'valorMaxServ', 'valorMaxMat'));
    }
}
