<!DOCTYPE html>
<html lang="pt-BR">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ isset($produtoId) ? 'Editar Produto' : 'Cadastro de Produto' }}</title>
    <link rel="stylesheet" href="{{ asset('css/sincronizacao.css') }}">
    <link rel="stylesheet" href="{{ asset('css/cadastro-produto.css') }}">
    <link rel="stylesheet" href="{{ asset('css/nprogress.css') }}">
    <link rel="stylesheet" href="{{ asset('css/loading.css') }}">
</head>

<body>
    <div class="container">
        <div class="header-navigation">
            <a href="/" class="nav-link">← Voltar para Sincronização</a>
            <h1>{{ isset($produtoId) ? 'Editar Produto' : 'Cadastro de Produto' }}</h1>
        </div>

        <div id="messageContainer"></div>
        <div id="loadingContainer"></div>

        <form id="formCadastroProduto" class="product-form">
            @if(isset($produtoId))
            <input type="hidden" id="produto_id" value="{{ $produtoId }}">
            @endif
            <div class="form-section">
                <h2 class="section-title">Informações do Produto</h2>
                <div class="form-grid">
                    <div class="form-group">
                        <label for="codigo" class="form-label required">Código do Produto</label>
                        <input type="text" id="codigo" name="codigo" class="form-input" maxlength="30" required>
                        <span class="field-error" id="error-codigo"></span>
                    </div>

                    <div class="form-group">
                        <label for="nome" class="form-label required">Nome do Produto</label>
                        <input type="text" id="nome" name="nome" class="form-input" maxlength="150" required>
                        <span class="field-error" id="error-nome"></span>
                    </div>

                    <div class="form-group">
                        <label for="categoria" class="form-label required">Categoria</label>
                        <input type="text" id="categoria" name="categoria" class="form-input" maxlength="50" required>
                        <span class="field-error" id="error-categoria"></span>
                    </div>

                    <div class="form-group">
                        <label for="subcategoria" class="form-label">Subcategoria</label>
                        <input type="text" id="subcategoria" name="subcategoria" class="form-input" maxlength="50">
                    </div>

                    <div class="form-group full-width">
                        <label for="descricao" class="form-label">Descrição</label>
                        <textarea id="descricao" name="descricao" class="form-textarea" rows="4"></textarea>
                    </div>

                    <div class="form-group">
                        <label for="fabricante" class="form-label">Fabricante</label>
                        <input type="text" id="fabricante" name="fabricante" class="form-input" maxlength="100">
                    </div>

                    <div class="form-group">
                        <label for="modelo" class="form-label">Modelo</label>
                        <input type="text" id="modelo" name="modelo" class="form-input" maxlength="50">
                    </div>

                    <div class="form-group">
                        <label for="cor" class="form-label">Cor</label>
                        <input type="text" id="cor" name="cor" class="form-input" maxlength="30">
                    </div>

                    <div class="form-group">
                        <label for="peso" class="form-label">Peso</label>
                        <input type="number" id="peso" name="peso" class="form-input" step="0.001" min="0">
                    </div>

                    <div class="form-group">
                        <label for="largura" class="form-label">Largura (cm)</label>
                        <input type="number" id="largura" name="largura" class="form-input" step="0.01" min="0">
                    </div>

                    <div class="form-group">
                        <label for="altura" class="form-label">Altura (cm)</label>
                        <input type="number" id="altura" name="altura" class="form-input" step="0.01" min="0">
                    </div>

                    <div class="form-group">
                        <label for="profundidade" class="form-label">Profundidade (cm)</label>
                        <input type="number" id="profundidade" name="profundidade" class="form-input" step="0.01" min="0">
                    </div>

                    <div class="form-group">
                        <label for="unidade" class="form-label">Unidade</label>
                        <input type="text" id="unidade" name="unidade" class="form-input" maxlength="10">
                    </div>

                    <div class="form-group">
                        <label for="data_cadastro" class="form-label">Data de Cadastro</label>
                        <input type="date" id="data_cadastro" name="data_cadastro" class="form-input">
                    </div>
                </div>
            </div>

            <div class="form-section">
                <h2 class="section-title">Informações de Preço</h2>
                <div class="form-grid">
                    <div class="form-group">
                        <label for="preco_valor" class="form-label required">Valor</label>
                        <input type="number" id="preco_valor" name="preco[valor]" class="form-input" step="0.01" min="0" required>
                        <span class="field-error" id="error-preco-valor"></span>
                    </div>

                    <div class="form-group">
                        <label for="preco_moeda" class="form-label required">Moeda</label>
                        <input type="text" id="preco_moeda" name="preco[moeda]" class="form-input" maxlength="10" value="BRL" required>
                        <span class="field-error" id="error-preco-moeda"></span>
                    </div>

                    <div class="form-group">
                        <label for="preco_desconto_percentual" class="form-label">Desconto Percentual (%)</label>
                        <input type="number" id="preco_desconto_percentual" name="preco[desconto_percentual]" class="form-input" step="0.01" min="0" max="100">
                    </div>

                    <div class="form-group">
                        <label for="preco_acrescimo_percentual" class="form-label">Acréscimo Percentual (%)</label>
                        <input type="number" id="preco_acrescimo_percentual" name="preco[acrescimo_percentual]" class="form-input" step="0.01" min="0" max="100">
                    </div>

                    <div class="form-group">
                        <label for="preco_valor_promocional" class="form-label">Valor Promocional</label>
                        <input type="number" id="preco_valor_promocional" name="preco[valor_promocional]" class="form-input" step="0.01" min="0">
                    </div>

                    <div class="form-group">
                        <label for="preco_data_inicio_promocao" class="form-label">Data Início Promoção</label>
                        <input type="date" id="preco_data_inicio_promocao" name="preco[data_inicio_promocao]" class="form-input">
                    </div>

                    <div class="form-group">
                        <label for="preco_data_fim_promocao" class="form-label">Data Fim Promoção</label>
                        <input type="date" id="preco_data_fim_promocao" name="preco[data_fim_promocao]" class="form-input">
                        <span class="field-error" id="error-preco-data-fim"></span>
                    </div>

                    <div class="form-group">
                        <label for="preco_origem" class="form-label">Origem</label>
                        <input type="text" id="preco_origem" name="preco[origem]" class="form-input" maxlength="50">
                    </div>

                    <div class="form-group">
                        <label for="preco_tipo_cliente" class="form-label">Tipo de Cliente</label>
                        <input type="text" id="preco_tipo_cliente" name="preco[tipo_cliente]" class="form-input" maxlength="30">
                    </div>

                    <div class="form-group">
                        <label for="preco_vendedor_responsavel" class="form-label">Vendedor Responsável</label>
                        <input type="text" id="preco_vendedor_responsavel" name="preco[vendedor_responsavel]" class="form-input" maxlength="100">
                    </div>

                    <div class="form-group full-width">
                        <label for="preco_observacoes" class="form-label">Observações</label>
                        <textarea id="preco_observacoes" name="preco[observacoes]" class="form-textarea" rows="3"></textarea>
                    </div>
                </div>
            </div>

            <div class="form-actions">
                <button type="submit" class="btn btn-primary" id="btnCadastrar">
                    {{ isset($produtoId) ? 'Atualizar Produto' : 'Cadastrar Produto' }}
                </button>
                <button type="reset" class="btn btn-secondary" id="btnLimpar">
                    Limpar Formulário
                </button>
            </div>
        </form>
    </div>

    <script src="{{ asset('js/nprogress.js') }}"></script>
    <script src="{{ asset('js/loading.js') }}"></script>
    <script src="{{ asset('js/cadastro-produto.js') }}"></script>
</body>

</html>