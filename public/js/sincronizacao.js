const API_BASE_URL = '/api';

function showMessage(message, type) {
    const container = document.getElementById('messageContainer');
    container.innerHTML = `<div class="message message-${type}">${message}</div>`;
    setTimeout(() => {
        container.innerHTML = '';
    }, 5000);
}

function showLoading(message) {
    const container = document.getElementById('loadingContainer');
    container.innerHTML = `<div class="loading">${message}</div>`;
}

function hideLoading() {
    document.getElementById('loadingContainer').innerHTML = '';
}

function formatCurrency(value, currency = 'BRL') {
    if (!value) return 'N/A';
    return new Intl.NumberFormat('pt-BR', {
        style: 'currency',
        currency: currency
    }).format(value);
}

function formatDate(dateString) {
    if (!dateString) return 'N/A';
    const date = new Date(dateString);
    return new Intl.DateTimeFormat('pt-BR').format(date);
}

function formatPercent(value) {
    if (!value) return 'N/A';
    return `${parseFloat(value).toFixed(2)}%`;
}

async function sincronizarProdutos() {
    const btn = document.getElementById('btnSincronizarProdutos');
    btn.disabled = true;
    LoadingManager.start();
    showLoading('Sincronizando produtos...');

    try {
        const response = await fetch(`${API_BASE_URL}/sincronizar/produtos`, {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'Accept': 'application/json'
            }
        });

        const data = await response.json();
        LoadingManager.done();
        hideLoading();
        btn.disabled = false;

        if (data.sucesso) {
            showMessage(data.mensagem + ' - ' + data.quantidade + ' produtos processados', 'success');
            carregarProdutos();
        } else {
            showMessage(data.mensagem, 'error');
        }
    } catch (error) {
        LoadingManager.done();
        hideLoading();
        btn.disabled = false;
        showMessage('Erro ao sincronizar produtos: ' + error.message, 'error');
    }
}

async function sincronizarPrecos() {
    const btn = document.getElementById('btnSincronizarPrecos');
    btn.disabled = true;
    LoadingManager.start();
    showLoading('Sincronizando preços...');

    try {
        const response = await fetch(`${API_BASE_URL}/sincronizar/precos`, {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'Accept': 'application/json'
            }
        });

        const data = await response.json();
        LoadingManager.done();
        hideLoading();
        btn.disabled = false;

        if (data.sucesso) {
            showMessage(data.mensagem + ' - ' + data.quantidade + ' preços processados', 'success');
            carregarProdutos();
        } else {
            showMessage(data.mensagem, 'error');
        }
    } catch (error) {
        LoadingManager.done();
        hideLoading();
        btn.disabled = false;
        showMessage('Erro ao sincronizar preços: ' + error.message, 'error');
    }
}

function renderProducts(produtos) {
    const container = document.getElementById('productsContainer');
    const list = document.getElementById('productsList');
    const count = document.getElementById('productsCount');

    if (!produtos || produtos.length === 0) {
        list.innerHTML = `
            <div class="empty-state">
                <div class="empty-state-icon">📦</div>
                <div class="empty-state-text">Nenhum produto encontrado. Execute a sincronização primeiro.</div>
            </div>
        `;
        container.style.display = 'block';
        count.textContent = '0 produtos';
        return;
    }

    count.textContent = `${produtos.length} ${produtos.length === 1 ? 'produto' : 'produtos'}`;

    list.innerHTML = produtos.map(produto => {
        const precosHTML = produto.precos && produto.precos.length > 0
            ? produto.precos.map(preco => `
                <div class="price-card">
                    <div class="price-header">
                        <div class="price-value">
                            ${formatCurrency(preco.valor_promocional || preco.valor, preco.moeda)}
                        </div>
                        ${preco.tipo_cliente ? `<span class="price-type">${preco.tipo_cliente}</span>` : ''}
                    </div>
                    <div class="price-details">
                        ${preco.valor ? `<div><span class="product-info-label">Valor Original:</span> ${formatCurrency(preco.valor, preco.moeda)}</div>` : ''}
                        ${preco.desconto_percentual ? `<div><span class="product-info-label">Desconto:</span> ${formatPercent(preco.desconto_percentual)}</div>` : ''}
                        ${preco.acrescimo_percentual ? `<div><span class="product-info-label">Acréscimo:</span> ${formatPercent(preco.acrescimo_percentual)}</div>` : ''}
                        ${preco.data_inicio_promocao ? `<div><span class="product-info-label">Início Promoção:</span> ${formatDate(preco.data_inicio_promocao)}</div>` : ''}
                        ${preco.data_fim_promocao ? `<div><span class="product-info-label">Fim Promoção:</span> ${formatDate(preco.data_fim_promocao)}</div>` : ''}
                        ${preco.origem ? `<div><span class="product-info-label">Origem:</span> ${preco.origem}</div>` : ''}
                        ${preco.vendedor_responsavel ? `<div><span class="product-info-label">Vendedor:</span> ${preco.vendedor_responsavel}</div>` : ''}
                    </div>
                    ${preco.observacoes ? `<div style="margin-top: 10px; padding-top: 10px; border-top: 1px solid #e0e0e0; color: #666; font-size: 0.9em;"><strong>Observações:</strong> ${preco.observacoes}</div>` : ''}
                </div>
            `).join('')
            : '<div class="empty-state"><div class="empty-state-text">Nenhum preço cadastrado</div></div>';

        const precosValidos = produto.precos && produto.precos.length > 0 
            ? produto.precos
                .map(p => parseFloat(p.valor_promocional || p.valor))
                .filter(price => !isNaN(price) && price > 0)
            : [];
        const minPrice = precosValidos.length > 0 ? Math.min(...precosValidos) : 0;
        const maxPrice = precosValidos.length > 0 ? Math.max(...precosValidos) : 0;

        return `
            <div class="product-card product-row" 
                 data-name="${(produto.nome || '').toLowerCase()}" 
                 data-code="${(produto.codigo || '').toLowerCase()}" 
                 data-description="${(produto.descricao || '').toLowerCase()}" 
                 data-category="${produto.categoria || ''}" 
                 data-manufacturer="${produto.fabricante || ''}" 
                 data-min-price="${minPrice}" 
                 data-max-price="${maxPrice}">
                <div class="product-header">
                    <div>
                        <div class="product-title">${produto.nome}</div>
                        <div class="product-code">Código: ${produto.codigo}</div>
                    </div>
                    <div>
                        <a href="/editar-produto/${produto.id}" class="btn btn-primary" style="padding: 8px 16px; font-size: 0.9em;">Editar</a>
                    </div>
                </div>
                <div class="product-info">
                    ${produto.categoria ? `<div class="product-info-item"><span class="product-info-label">Categoria:</span> ${produto.categoria}</div>` : ''}
                    ${produto.subcategoria ? `<div class="product-info-item"><span class="product-info-label">Subcategoria:</span> ${produto.subcategoria}</div>` : ''}
                    ${produto.fabricante ? `<div class="product-info-item"><span class="product-info-label">Fabricante:</span> ${produto.fabricante}</div>` : ''}
                    ${produto.modelo ? `<div class="product-info-item"><span class="product-info-label">Modelo:</span> ${produto.modelo}</div>` : ''}
                    ${produto.cor ? `<div class="product-info-item"><span class="product-info-label">Cor:</span> ${produto.cor}</div>` : ''}
                    ${produto.peso ? `<div class="product-info-item"><span class="product-info-label">Peso:</span> ${produto.peso} ${produto.unidade || ''}</div>` : ''}
                    ${produto.largura && produto.altura && produto.profundidade ? `<div class="product-info-item"><span class="product-info-label">Dimensões:</span> ${produto.largura} x ${produto.altura} x ${produto.profundidade} cm</div>` : ''}
                    ${produto.data_cadastro ? `<div class="product-info-item"><span class="product-info-label">Data Cadastro:</span> ${formatDate(produto.data_cadastro)}</div>` : ''}
                </div>
                ${produto.descricao ? `<div style="margin-top: 15px; padding-top: 15px; border-top: 1px solid #e0e0e0; color: #666;"><strong>Descrição:</strong> ${produto.descricao}</div>` : ''}
                ${produto.precos && produto.precos.length > 0 ? `
                    <div class="prices-section">
                        <div class="prices-title">Preços (${produto.precos.length})</div>
                        <div class="prices-list">${precosHTML}</div>
                    </div>
                ` : ''}
            </div>
        `;
    }).join('');

    container.style.display = 'block';
}

async function carregarProdutos() {
    const container = document.getElementById('productsContainer');
    const list = document.getElementById('productsList');
    const skeletonLoader = document.getElementById('skeletonLoader');
    
    LoadingManager.start();
    
    if (container && list) {
        container.style.display = 'block';
        if (skeletonLoader) {
            skeletonLoader.style.display = 'block';
            skeletonLoader.innerHTML = createProductSkeleton(3);
        }
    }

    try {
        const { response, data } = await fetchWithLoading(`${API_BASE_URL}/produtos/lista`);

        if (skeletonLoader) {
            skeletonLoader.style.display = 'none';
        }

        if (data.sucesso) {
            renderProducts(data.produtos);
            populateFilterOptions(data.produtos);
        } else {
            if (container && list) {
                list.innerHTML = `
                    <div class="empty-state">
                        <div class="empty-state-icon">⚠️</div>
                        <div class="empty-state-text">Erro ao carregar produtos</div>
                    </div>
                `;
                container.style.display = 'block';
            }
            showMessage('Erro ao carregar produtos', 'error');
        }
    } catch (error) {
        LoadingManager.done();
        if (skeletonLoader) {
            skeletonLoader.style.display = 'none';
        }
        if (container && list) {
            list.innerHTML = `
                <div class="empty-state">
                    <div class="empty-state-icon">⚠️</div>
                    <div class="empty-state-text">Erro ao carregar produtos: ${error.message}</div>
                </div>
            `;
            container.style.display = 'block';
        }
        showMessage('Erro ao carregar produtos: ' + error.message, 'error');
    }
}

function populateFilterOptions(produtos) {
    const categories = new Set();
    const manufacturers = new Set();

    produtos.forEach(produto => {
        if (produto.categoria) categories.add(produto.categoria);
        if (produto.fabricante) manufacturers.add(produto.fabricante);
    });

    const categorySelect = document.getElementById('filter-category');
    const manufacturerSelect = document.getElementById('filter-manufacturer');

    while (categorySelect.children.length > 1) {
        categorySelect.removeChild(categorySelect.lastChild);
    }
    while (manufacturerSelect.children.length > 1) {
        manufacturerSelect.removeChild(manufacturerSelect.lastChild);
    }

    Array.from(categories).sort().forEach(category => {
        const option = document.createElement('option');
        option.value = category;
        option.textContent = category;
        categorySelect.appendChild(option);
    });

    Array.from(manufacturers).sort().forEach(manufacturer => {
        const option = document.createElement('option');
        option.value = manufacturer;
        option.textContent = manufacturer;
        manufacturerSelect.appendChild(option);
    });
}

function debounce(func, wait) {
    let timeout;
    return function executedFunction(...args) {
        const later = () => {
            clearTimeout(timeout);
            func(...args);
        };
        clearTimeout(timeout);
        timeout = setTimeout(later, wait);
    };
}

function normalizeText(text) {
    return (text || '').toLowerCase().trim().replace(/\s+/g, ' ');
}

function filterProducts() {
    const searchTerm = normalizeText(document.getElementById('product-search').value);
    const category = document.getElementById('filter-category').value;
    const manufacturer = document.getElementById('filter-manufacturer').value;
    const minPrice = parseFloat(document.getElementById('filter-price-min').value) || 0;
    const maxPrice = parseFloat(document.getElementById('filter-price-max').value) || Infinity;

    const productRows = document.querySelectorAll('.product-row');
    let visibleCount = 0;

    productRows.forEach(row => {
        const name = row.dataset.name || '';
        const code = row.dataset.code || '';
        const description = row.dataset.description || '';
        const rowCategory = row.dataset.category || '';
        const rowManufacturer = row.dataset.manufacturer || '';
        const rowMinPrice = parseFloat(row.dataset.minPrice) || 0;
        const rowMaxPrice = parseFloat(row.dataset.maxPrice) || 0;

        const matchesSearch = !searchTerm || 
            name.includes(searchTerm) || 
            code.includes(searchTerm) || 
            description.includes(searchTerm);

        const matchesCategory = !category || rowCategory === category;
        const matchesManufacturer = !manufacturer || rowManufacturer === manufacturer;
        let matchesPrice = true;
        if (minPrice > 0 || maxPrice < Infinity) {
            if (rowMinPrice === 0 && rowMaxPrice === 0) {
                matchesPrice = false;
            } else {
                matchesPrice = (rowMinPrice <= maxPrice && rowMaxPrice >= minPrice);
            }
        }

        if (matchesSearch && matchesCategory && matchesManufacturer && matchesPrice) {
            row.style.display = '';
            visibleCount++;
        } else {
            row.style.display = 'none';
        }
    });

    const countElement = document.getElementById('productsCount');
    const totalCount = productRows.length;
    countElement.textContent = `${visibleCount} de ${totalCount} ${totalCount === 1 ? 'produto' : 'produtos'}`;
}

function resetFilters() {
    document.getElementById('product-search').value = '';
    document.getElementById('filter-category').value = '';
    document.getElementById('filter-manufacturer').value = '';
    document.getElementById('filter-price-min').value = '';
    document.getElementById('filter-price-max').value = '';
    filterProducts();
}

document.addEventListener('DOMContentLoaded', function() {
    const debouncedFilter = debounce(filterProducts, 200);

    document.getElementById('product-search').addEventListener('input', debouncedFilter);
    document.getElementById('filter-category').addEventListener('change', filterProducts);
    document.getElementById('filter-manufacturer').addEventListener('change', filterProducts);
    document.getElementById('filter-price-min').addEventListener('input', debouncedFilter);
    document.getElementById('filter-price-max').addEventListener('input', debouncedFilter);
    document.getElementById('filter-reset').addEventListener('click', resetFilters);

    document.getElementById('btnSincronizarProdutos').addEventListener('click', sincronizarProdutos);
    document.getElementById('btnSincronizarPrecos').addEventListener('click', sincronizarPrecos);

    carregarProdutos();
});

