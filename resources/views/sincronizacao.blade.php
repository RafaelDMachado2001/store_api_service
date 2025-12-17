<!DOCTYPE html>
<html lang="pt-BR">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Sincronização de Produtos e Preços</title>
    <link rel="stylesheet" href="{{ asset('css/sincronizacao.css') }}">
    <link rel="stylesheet" href="{{ asset('css/filtros.css') }}">
    <link rel="stylesheet" href="{{ asset('css/cadastro-produto.css') }}">
</head>

<body>
    <div class="container">
        <div class="header-navigation">
            <a href="/cadastro-produto" class="nav-link">+ Cadastrar Novo Produto</a>
            <h1>Sincronização de Produtos e Preços</h1>
        </div>

        <div class="buttons-container">
            <button class="btn btn-primary" id="btnSincronizarProdutos">
                Sincronizar Produtos
            </button>
            <button class="btn btn-primary" id="btnSincronizarPrecos">
                Sincronizar Preços
            </button>
        </div>

        <div id="messageContainer"></div>
        <div id="loadingContainer"></div>

        <div class="products-container" id="productsContainer" style="display: none;">
            @include('partials.filtros')
            <div class="products-header">
                <h2>Produtos Processados</h2>
                <span class="products-count" id="productsCount">0 produtos</span>
            </div>
            <div class="products-list" id="productsList"></div>
        </div>
    </div>

    <script src="{{ asset('js/sincronizacao.js') }}"></script>
</body>

</html>