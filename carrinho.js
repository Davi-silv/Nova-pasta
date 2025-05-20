// Funções utilitárias para o carrinho
function getCarrinho() {
    return JSON.parse(localStorage.getItem('carrinho')) || [];
}

function setCarrinho(carrinho) {
    localStorage.setItem('carrinho', JSON.stringify(carrinho));
}

function removerItem(index) {
    const carrinho = getCarrinho();
    carrinho.splice(index, 1);
    setCarrinho(carrinho);
    renderCarrinho();
}

function finalizarCompra() {
    window.location.href = 'login.html';
}

function renderCarrinho() {
    const carrinho = getCarrinho();
    const tbody = document.querySelector('.carrinho-tabela tbody');
    const totalSpan = document.querySelector('.carrinho-total strong');
    tbody.innerHTML = '';
    let total = 0;
    carrinho.forEach((item, idx) => {
        const subtotal = item.preco * item.quantidade;
        total += subtotal;
        const tr = document.createElement('tr');
        tr.innerHTML = `
            <td>${item.nome}</td>
            <td>R$ ${item.preco.toFixed(2)}</td>
            <td>${item.quantidade}</td>
            <td>R$ ${(subtotal).toFixed(2)}</td>
            <td><button class="remover-btn" onclick="removerItem(${idx})">Remover</button></td>
        `;
        tbody.appendChild(tr);
    });
    totalSpan.textContent = `R$ ${total.toFixed(2)}`;
}

// Eventos
if (document.querySelector('.carrinho-tabela')) {
    renderCarrinho();
    document.querySelector('.finalizar-btn').onclick = finalizarCompra;
}

// Adicionar ao carrinho (catalogo.html)
document.querySelectorAll('.add-to-cart-btn').forEach(function(btn) {
    btn.addEventListener('click', function() {
        const nome = btn.getAttribute('data-nome');
        const preco = Number(btn.getAttribute('data-preco'));
        const carrinho = getCarrinho();
        const idx = carrinho.findIndex(item => item.nome === nome);
        if (idx > -1) {
            carrinho[idx].quantidade += 1;
        } else {
            carrinho.push({ nome, preco, quantidade: 1 });
        }
        setCarrinho(carrinho);
        alert('Produto adicionado ao carrinho!');
    });
}); 