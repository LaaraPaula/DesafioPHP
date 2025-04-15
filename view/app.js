let dadosUsuarios = [];
  
function carregarUsuarios() {
fetch('../api/lista_usuario.php')
    .then(response => response.json())
    .then(dados => {
    dadosUsuarios = dados;
    renderizarTabela(dadosUsuarios);
    });
}
function cadastrarUsuario(event) {
    event.preventDefault();

    const form = document.getElementById('formCadastro');
    const formData = new FormData(form);

    const fotoInput = form.querySelector('input[name="foto"]');
    const fotoUrlInput = document.getElementById('foto_url');

    if (fotoInput.files.length === 0 && fotoUrlInput.value) {
        formData.set('foto_url', fotoUrlInput.value);
    } else {
        formData.delete('foto_url'); 
    }

    fetch('../api/cadastra_usuario.php', {
        method: 'POST',
        body: formData
    })
    .then(resp => resp.json())
    .then(resp => {
        alert(resp.mensagem || resp.erro);
        form.reset();
        carregarUsuarios();
    })
    .catch(err => {
        console.error("Erro ao cadastrar:", err);
        alert("Erro ao cadastrar usuário.");
    });
}

function importarUsuario() {
    fetch('../api/usuario_aleatorio.php')
    .then(resp => resp.json())
    .then(usuario => {
        document.querySelector('[name="nome"]').value = usuario.nome;
        document.querySelector('[name="email"]').value = usuario.email;
        document.querySelector('[name="genero"]').value = usuario.genero;
        document.querySelector('[name="cidade"]').value = usuario.cidade;
        document.querySelector('[name="pais"]').value = usuario.pais;
        document.getElementById('foto_url').value = usuario.foto;

    alert("Usuário aleatório carregado! Você pode editar antes de cadastrar.");
    });
}
function renderizarTabela(dados) {
    const tbody = document.querySelector('#tabelaCorpo');
    tbody.innerHTML = '';
  
    dados.forEach(usuario => {
        const tr = document.createElement('tr');
        tr.innerHTML = `
        <td><img src="${usuario.foto && usuario.foto.startsWith('http') ? usuario.foto : '../' + usuario.foto}" alt="Foto"></td>
        <td contenteditable="true" data-campo="nome">${usuario.nome}</td>
        <td contenteditable="true" data-campo="email">${usuario.email}</td>
        <td contenteditable="true" data-campo="genero">${usuario.genero}</td>
        <td contenteditable="true" data-campo="cidade">${usuario.cidade}</td>
        <td contenteditable="true" data-campo="pais">${usuario.pais}</td>
        <td>
            <button class="atualizar" onclick="salvarUsuario(this, ${usuario.id})">💾</button>
            <button class="excluir" onclick="deletarUsuario(${usuario.id})">🗑️</button>
        </td>
        `;
        tbody.appendChild(tr);
    });
}
function salvarUsuario(botao, id) {
    const tr = botao.closest('tr');
    const campos = tr.querySelectorAll('[data-campo]');
    const dados = { id: id };
  
    campos.forEach(td => {
        const campo = td.getAttribute('data-campo');
        dados[campo] = td.textContent.trim();
    });
  
    fetch('../api/edita_usuario.php', {
        method: 'POST',
        headers: { 'Content-Type': 'application/json' },
        body: JSON.stringify(dados)
    })
    .then(resp => resp.json())
    .then(resp => alert(resp.mensagem || resp.erro));
}  
function deletarUsuario(id) {
    if (!confirm("Tem certeza que deseja deletar este usuário?")) return;
  
    fetch('../api/deleta_usuario.php', {
        method: 'POST',
        headers: { 'Content-Type': 'application/json' },
        body: JSON.stringify({ id: id })
    })
    .then(resp => resp.json())
    .then(resp => {
        alert(resp.mensagem || resp.erro);
        carregarUsuarios(); 
    });
}
function filtrarTabela() {
    const termo = document.getElementById('filtro').value.toLowerCase();
    const filtrados = dadosUsuarios.filter(usuario =>
        usuario.nome.toLowerCase().includes(termo)
    );
    renderizarTabela(filtrados);
}
  
carregarUsuarios();

const filtroInput = document.getElementById('filtro');
const formCadastro = document.getElementById('formCadastro');

filtroInput.addEventListener('focus', function() {
    formCadastro.style.display = 'none';
});

document.addEventListener('click', function(event) {
    if (!filtroInput.contains(event.target) && !formCadastro.contains(event.target)) {
        formCadastro.style.display = 'block';
    }
});

