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

function clearFieldErrors() {
    const errorElements = document.querySelectorAll('.field-error');
    errorElements.forEach(el => {
        el.textContent = '';
        el.style.display = 'none';
    });
    
    const inputs = document.querySelectorAll('.form-input, .form-textarea');
    inputs.forEach(input => {
        input.classList.remove('error');
    });
}

function showFieldError(fieldName, message) {
    const errorElement = document.getElementById(`error-${fieldName}`);
    let input = document.getElementById(fieldName) || 
                document.querySelector(`[name="${fieldName}"]`) ||
                document.querySelector(`[name*="${fieldName}"]`);
    
    if (!input && fieldName.includes('_')) {
        const altName = fieldName.replace(/_/g, '-');
        input = document.getElementById(altName) || 
                document.querySelector(`[name="${altName}"]`);
    }
    
    if (errorElement) {
        errorElement.textContent = message;
        errorElement.style.display = 'block';
    }
    
    if (input) {
        input.classList.add('error');
    }
}

function validateForm() {
    let isValid = true;
    clearFieldErrors();

    const codigo = document.getElementById('codigo').value.trim();
    const nome = document.getElementById('nome').value.trim();
    const categoria = document.getElementById('categoria').value.trim();
    const precoValor = document.getElementById('preco_valor').value.trim();
    const precoMoeda = document.getElementById('preco_moeda').value.trim();
    const dataInicioPromocao = document.getElementById('preco_data_inicio_promocao').value;
    const dataFimPromocao = document.getElementById('preco_data_fim_promocao').value;

    if (!codigo) {
        showFieldError('codigo', 'O código do produto é obrigatório.');
        isValid = false;
    } else if (codigo.length > 30) {
        showFieldError('codigo', 'O código não pode ter mais de 30 caracteres.');
        isValid = false;
    }

    if (!nome) {
        showFieldError('nome', 'O nome do produto é obrigatório.');
        isValid = false;
    } else if (nome.length > 150) {
        showFieldError('nome', 'O nome não pode ter mais de 150 caracteres.');
        isValid = false;
    }

    if (!categoria) {
        showFieldError('categoria', 'A categoria é obrigatória.');
        isValid = false;
    } else if (categoria.length > 50) {
        showFieldError('categoria', 'A categoria não pode ter mais de 50 caracteres.');
        isValid = false;
    }

    if (!precoValor) {
        showFieldError('preco-valor', 'O valor do preço é obrigatório.');
        isValid = false;
    } else {
        const valor = parseFloat(precoValor);
        if (isNaN(valor) || valor < 0) {
            showFieldError('preco-valor', 'O valor deve ser um número positivo.');
            isValid = false;
        }
    }

    if (!precoMoeda) {
        showFieldError('preco-moeda', 'A moeda é obrigatória.');
        isValid = false;
    } else if (precoMoeda.length > 10) {
        showFieldError('preco-moeda', 'A moeda não pode ter mais de 10 caracteres.');
        isValid = false;
    }

    if (dataInicioPromocao && dataFimPromocao) {
        const inicio = new Date(dataInicioPromocao);
        const fim = new Date(dataFimPromocao);
        if (fim < inicio) {
            showFieldError('preco-data-fim', 'A data de fim da promoção deve ser igual ou posterior à data de início.');
            isValid = false;
        }
    }

    return isValid;
}

function buildFormData() {
    const formData = {
        codigo: document.getElementById('codigo').value.trim(),
        nome: document.getElementById('nome').value.trim(),
        categoria: document.getElementById('categoria').value.trim(),
        subcategoria: document.getElementById('subcategoria').value.trim() || null,
        descricao: document.getElementById('descricao').value.trim() || null,
        fabricante: document.getElementById('fabricante').value.trim() || null,
        modelo: document.getElementById('modelo').value.trim() || null,
        cor: document.getElementById('cor').value.trim() || null,
        peso: document.getElementById('peso').value ? parseFloat(document.getElementById('peso').value) : null,
        largura: document.getElementById('largura').value ? parseFloat(document.getElementById('largura').value) : null,
        altura: document.getElementById('altura').value ? parseFloat(document.getElementById('altura').value) : null,
        profundidade: document.getElementById('profundidade').value ? parseFloat(document.getElementById('profundidade').value) : null,
        unidade: document.getElementById('unidade').value.trim() || null,
        data_cadastro: document.getElementById('data_cadastro').value || null,
        preco: {
            valor: parseFloat(document.getElementById('preco_valor').value),
            moeda: document.getElementById('preco_moeda').value.trim(),
            desconto_percentual: document.getElementById('preco_desconto_percentual').value ? parseFloat(document.getElementById('preco_desconto_percentual').value) : null,
            acrescimo_percentual: document.getElementById('preco_acrescimo_percentual').value ? parseFloat(document.getElementById('preco_acrescimo_percentual').value) : null,
            valor_promocional: document.getElementById('preco_valor_promocional').value ? parseFloat(document.getElementById('preco_valor_promocional').value) : null,
            data_inicio_promocao: document.getElementById('preco_data_inicio_promocao').value || null,
            data_fim_promocao: document.getElementById('preco_data_fim_promocao').value || null,
            origem: document.getElementById('preco_origem').value.trim() || null,
            tipo_cliente: document.getElementById('preco_tipo_cliente').value.trim() || null,
            vendedor_responsavel: document.getElementById('preco_vendedor_responsavel').value.trim() || null,
            observacoes: document.getElementById('preco_observacoes').value.trim() || null
        }
    };

    Object.keys(formData).forEach(key => {
        if (formData[key] === null || formData[key] === '') {
            delete formData[key];
        }
    });

    Object.keys(formData.preco).forEach(key => {
        if (formData.preco[key] === null || formData.preco[key] === '') {
            delete formData.preco[key];
        }
    });

    return formData;
}

function isEditMode() {
    const produtoIdInput = document.getElementById('produto_id');
    return produtoIdInput && produtoIdInput.value;
}

function getProdutoId() {
    const produtoIdInput = document.getElementById('produto_id');
    return produtoIdInput ? produtoIdInput.value : null;
}

function formatDateForInput(dateString) {
    if (!dateString) return '';
    const date = new Date(dateString);
    return date.toISOString().split('T')[0];
}

function fillFormWithProductData(produto) {
    document.getElementById('codigo').value = produto.codigo || '';
    document.getElementById('nome').value = produto.nome || '';
    document.getElementById('categoria').value = produto.categoria || '';
    document.getElementById('subcategoria').value = produto.subcategoria || '';
    document.getElementById('descricao').value = produto.descricao || '';
    document.getElementById('fabricante').value = produto.fabricante || '';
    document.getElementById('modelo').value = produto.modelo || '';
    document.getElementById('cor').value = produto.cor || '';
    document.getElementById('peso').value = produto.peso || '';
    document.getElementById('largura').value = produto.largura || '';
    document.getElementById('altura').value = produto.altura || '';
    document.getElementById('profundidade').value = produto.profundidade || '';
    document.getElementById('unidade').value = produto.unidade || '';
    document.getElementById('data_cadastro').value = formatDateForInput(produto.data_cadastro);

    if (produto.precos && produto.precos.length > 0) {
        const preco = produto.precos[0];
        document.getElementById('preco_valor').value = preco.valor || '';
        document.getElementById('preco_moeda').value = preco.moeda || 'BRL';
        document.getElementById('preco_desconto_percentual').value = preco.desconto_percentual || '';
        document.getElementById('preco_acrescimo_percentual').value = preco.acrescimo_percentual || '';
        document.getElementById('preco_valor_promocional').value = preco.valor_promocional || '';
        document.getElementById('preco_data_inicio_promocao').value = formatDateForInput(preco.data_inicio_promocao);
        document.getElementById('preco_data_fim_promocao').value = formatDateForInput(preco.data_fim_promocao);
        document.getElementById('preco_origem').value = preco.origem || '';
        document.getElementById('preco_tipo_cliente').value = preco.tipo_cliente || '';
        document.getElementById('preco_vendedor_responsavel').value = preco.vendedor_responsavel || '';
        document.getElementById('preco_observacoes').value = preco.observacoes || '';
    }
}

async function carregarProdutoParaEdicao(id) {
    LoadingManager.start();
    showLoading('Carregando produto...');

    try {
        const response = await fetch(`${API_BASE_URL}/produtos/${id}`, {
            method: 'GET',
            headers: {
                'Accept': 'application/json'
            }
        });

        const data = await response.json();
        LoadingManager.done();
        hideLoading();

        if (response.ok && data.sucesso && data.dados) {
            fillFormWithProductData(data.dados);
        } else {
            showMessage(data.mensagem || 'Erro ao carregar produto.', 'error');
            setTimeout(() => {
                window.location.href = '/';
            }, 2000);
        }
    } catch (error) {
        LoadingManager.done();
        hideLoading();
        showMessage('Erro ao carregar produto: ' + error.message, 'error');
        setTimeout(() => {
            window.location.href = '/';
        }, 2000);
    }
}

async function submitForm(event) {
    event.preventDefault();
    
    if (!validateForm()) {
        showMessage('Por favor, corrija os erros no formulário antes de continuar.', 'error');
        return;
    }

    const btnCadastrar = document.getElementById('btnCadastrar');
    btnCadastrar.disabled = true;
    LoadingManager.start();
    
    const editMode = isEditMode();
    showLoading(editMode ? 'Atualizando produto...' : 'Cadastrando produto...');
    clearFieldErrors();

    try {
        const formData = buildFormData();
        const produtoId = getProdutoId();
        const url = editMode ? `${API_BASE_URL}/produtos/${produtoId}` : `${API_BASE_URL}/produtos`;
        const method = editMode ? 'PUT' : 'POST';
        
        const response = await fetch(url, {
            method: method,
            headers: {
                'Content-Type': 'application/json',
                'Accept': 'application/json'
            },
            body: JSON.stringify(formData)
        });

        const data = await response.json();
        LoadingManager.done();
        hideLoading();
        btnCadastrar.disabled = false;

        if (response.ok && data.sucesso) {
            showMessage(data.mensagem || (editMode ? 'Produto atualizado com sucesso!' : 'Produto cadastrado com sucesso!'), 'success');
            
            if (!editMode) {
                document.getElementById('formCadastroProduto').reset();
                clearFieldErrors();
            }
            
            setTimeout(() => {
                window.location.href = '/';
            }, 2000);
        } else {
            if (data.errors) {
                Object.keys(data.errors).forEach(field => {
                    let fieldName = field;
                    if (field.startsWith('preco.')) {
                        fieldName = field.replace('preco.', 'preco_').replace('.', '_');
                    }
                    const messages = Array.isArray(data.errors[field]) 
                        ? data.errors[field].join(', ') 
                        : data.errors[field];
                    showFieldError(fieldName, messages);
                });
            }
            showMessage(data.mensagem || (editMode ? 'Erro ao atualizar produto. Verifique os campos destacados.' : 'Erro ao cadastrar produto. Verifique os campos destacados.'), 'error');
        }
    } catch (error) {
        LoadingManager.done();
        hideLoading();
        btnCadastrar.disabled = false;
        showMessage((isEditMode() ? 'Erro ao atualizar produto: ' : 'Erro ao cadastrar produto: ') + error.message, 'error');
    }
}

document.addEventListener('DOMContentLoaded', function() {
    const form = document.getElementById('formCadastroProduto');
    const btnLimpar = document.getElementById('btnLimpar');

    form.addEventListener('submit', submitForm);

    btnLimpar.addEventListener('click', function() {
        clearFieldErrors();
    });

    const produtoId = getProdutoId();
    if (produtoId) {
        carregarProdutoParaEdicao(produtoId);
    } else {
        const dateInput = document.getElementById('data_cadastro');
        if (dateInput && !dateInput.value) {
            const today = new Date().toISOString().split('T')[0];
            dateInput.value = today;
        }
    }
});

