@extends('layouts.app')

@section('content')
    <br>
    <div class="container">
        <div class="card">
            <div class="card-header">Editar Depósito</div>
            <div class="card-body">
                <form action="{{ route('deposito.update', ['id' => $deposito->id]) }}" method="POST">
                    @csrf
                    @method('PUT') <!-- Método para atualização -->

                    <div class="row g-3 mb-4">
                        <div class="col-md-3">
                            <label for="id_nome" class="form-label">Nome do Depósito</label>
                            <input type="text" name="nome" id="id_nome"
                                class="form-control @error('nome') is-invalid @enderror"
                                value="{{ old('nome', $deposito->nome) }}" required>
                            @error('nome')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="col-md-2">
                            <label for="id_sigla" class="form-label">Sigla</label>
                            <input type="text" name="sigla" id="id_sigla"
                                class="form-control @error('sigla') is-invalid @enderror"
                                value="{{ old('sigla', $deposito->sigla) }}" required>
                            @error('sigla')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="col-md-3">
                            <label for="id_tipo_deposito" class="form-label">Tipo de Depósito</label>
                            <select name="tipo_deposito" id="id_tipo_deposito"
                                class="form-select @error('tipo_deposito') is-invalid @enderror" required>
                                @foreach ($tipo_deposito as $tipo)
                                    <option value="{{ $tipo->id }}"
                                        {{ old('tipo_deposito', $deposito->id_tp_deposito) == $tipo->id ? 'selected' : '' }}>
                                        {{ $tipo->nome }}
                                    </option>
                                @endforeach
                            </select>
                            @error('tipo_deposito')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="col-md-3">
                            <label for="id_sala" class="form-label">Sala</label>
                            <select name="sala" id="id_sala" class="form-select @error('sala') is-invalid @enderror"
                                required>
                                @foreach ($sala as $s)
                                    <option value="{{ $s->id }}"
                                        {{ old('sala', $deposito->id_sala) == $s->id ? 'selected' : '' }}>
                                        {{ $s->nome }} - {{ $s->numero }}
                                    </option>
                                @endforeach
                            </select>
                            @error('sala')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>

                    <div class="row g-3 mb-4">
                        <div class="col-md-2">
                            <label for="id_comprimento" class="form-label">Comprimento (m)</label>
                            <input type="number" name="comprimento" id="id_comprimento" step="0.01" min="0"
                                class="form-control @error('comprimento') is-invalid @enderror"
                                value="{{ $deposito->comprimento }}" required>
                            @error('comprimento')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="col-md-2">
                            <label for="id_largura" class="form-label">Largura (m)</label>
                            <input type="number" name="largura" id="id_largura" step="0.01" min="0"
                                class="form-control @error('largura') is-invalid @enderror"
                                value="{{ old('largura', $deposito->largura) }}" required>
                            @error('largura')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="col-md-2">
                            <label for="id_altura" class="form-label">Altura (m)</label>
                            <input type="number" name="altura" id="id_altura" step="0.01" min="0"
                                class="form-control @error('altura') is-invalid @enderror"
                                value="{{ old('altura', $deposito->altura) }}" required>
                            @error('altura')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="col-md-2">
                            <label for="id_largura_porta" class="form-label">Largura Porta (m)</label>
                            <input type="number" name="largura_porta" id="id_largura_porta" step="0.01" min="0"
                                class="form-control @error('largura_porta') is-invalid @enderror"
                                value="{{ old('largura_porta', $deposito->largura_porta) }}" required>
                            @error('largura_porta')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="col-md-2">
                            <label for="id_altura_porta" class="form-label">Altura Porta (m)</label>
                            <input type="number" name="altura_porta" id="id_altura_porta" step="0.01" min="0"
                                class="form-control @error('altura_porta') is-invalid @enderror"
                                value="{{ old('altura_porta', $deposito->altura_porta) }}" required>
                            @error('altura_porta')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="col-md-2">
                            <label for="id_capacidade" class="form-label">Capacidade (m³)</label>
                            <input type="number" id="id_capacidade" class="form-control" readonly
                                value="{{ old('capacidade', $deposito->capacidade_volume) }}">
                        </div>
                    </div>

                    <div class="row g-3 justify-content-around">
                        <div class="col-md-3">
                            <button type="button" class="btn btn-danger w-100"
                                onclick="history.back()">Cancelar</button>
                        </div>
                        <div class="col-md-3">
                            <button type="submit" class="btn btn-primary w-100">Salvar</button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <script>
        document.addEventListener('DOMContentLoaded', () => {
            function calcularCapacidade() {
                let comprimento = parseFloat(document.getElementById('id_comprimento').value.replace(',', '.')) ||
                    0;
                let largura = parseFloat(document.getElementById('id_largura').value.replace(',', '.')) || 0;
                let altura = parseFloat(document.getElementById('id_altura').value.replace(',', '.')) || 0;

                let capacidade = comprimento * largura * altura;
                if (capacidade > 0) {
                    document.getElementById('id_capacidade').value = capacidade.toFixed(2);
                } else {
                    document.getElementById('id_capacidade').value = '';
                }
            }

            ['id_comprimento', 'id_largura', 'id_altura'].forEach(id => {
                document.getElementById(id).addEventListener('input', calcularCapacidade);
            });
        });
    </script>
@endsection
