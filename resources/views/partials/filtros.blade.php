<div class="filters-section">
    <div class="filters-grid">
        <div class="filter-group">
            <label class="filter-label" for="product-search">Pesquisar Produtos</label>
            <input type="text" id="product-search" class="filter-input" placeholder="Nome, código ou descrição...">
        </div>
        <div class="filter-group">
            <label class="filter-label" for="filter-category">Categoria</label>
            <select id="filter-category" class="filter-select">
                <option value="">Todas as categorias</option>
            </select>
        </div>
        <div class="filter-group">
            <label class="filter-label" for="filter-manufacturer">Fabricante</label>
            <select id="filter-manufacturer" class="filter-select">
                <option value="">Todos os fabricantes</option>
            </select>
        </div>
        <div class="filter-group">
            <label class="filter-label">Faixa de Preço</label>
            <div class="filter-input-group">
                <input type="number" id="filter-price-min" class="filter-input" placeholder="Mínimo" step="0.01" min="0">
                <input type="number" id="filter-price-max" class="filter-input" placeholder="Máximo" step="0.01" min="0">
            </div>
        </div>
    </div>
    <button class="filter-reset" id="filter-reset">Limpar Filtros</button>
</div>

