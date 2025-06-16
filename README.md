# Portal Tech S.A. - Plataforma de Cursos Online

Portal Tech S.A. é uma plataforma de cursos online focada em programação e desenvolvimento web. O sistema permite que usuários se cadastrem, explorem cursos por categoria, adicionem cursos ao carrinho e realizem compras.

## 🚀 Tecnologias Utilizadas

- **Frontend:**
  - HTML5
  - CSS3
  - JavaScript (ES6+)
  - Font Awesome (ícones)

- **Backend:**
  - PHP 8.0+
  - MySQL 8.0+

- **Servidor:**
  - Apache (XAMPP)

## 📋 Pré-requisitos

- XAMPP (ou similar) instalado
- PHP 8.0 ou superior
- MySQL 8.0 ou superior
- Navegador web moderno

## 🔧 Instalação

1. Clone este repositório:
```bash
git clone https://github.com/seu-usuario/portal-tech.git
```

2. Coloque os arquivos na pasta do XAMPP:
```
C:\xampp\htdocs\portal_tech\
```

3. Inicie o XAMPP Control Panel e ative:
   - Apache
   - MySQL

4. Crie o banco de dados:
   - Acesse: http://localhost/phpmyadmin
   - Crie um novo banco de dados chamado "portal_tech"
   - Importe o arquivo `database/schema.sql`

5. Configure o banco de dados:
   - Abra `config/database.php`
   - Verifique se as credenciais estão corretas:
     ```php
     define('DB_HOST', 'localhost');
     define('DB_USER', 'root');
     define('DB_PASS', '');
     define('DB_NAME', 'portal_tech');
     ```

6. Acesse o site:
```
http://localhost/portal_tech/
```

## 📦 Estrutura do Projeto

```
portal_tech/
├── api/
│   └── api.php           # Endpoints da API
├── config/
│   ├── config.php        # Configurações gerais
│   └── database.php      # Configuração do banco de dados
├── database/
│   └── schema.sql        # Estrutura do banco de dados
├── models/
│   ├── Usuario.php       # Modelo de usuários
│   ├── Curso.php         # Modelo de cursos
│   ├── Carrinho.php      # Modelo do carrinho
│   └── Compra.php        # Modelo de compras
├── index.html            # Página inicial
├── catalogo.html         # Página de cursos
├── carrinho.html         # Página do carrinho
├── sobre.html            # Página sobre
└── style.css            # Estilos CSS
```

## 🛠️ Funcionalidades

### Usuários
- Cadastro de novos usuários
- Login/Autenticação
- Perfil do usuário

### Cursos
- Listagem de cursos por categoria
- Detalhes do curso
- Imagens e descrições

### Carrinho
- Adicionar cursos ao carrinho
- Remover cursos do carrinho
- Visualizar total da compra

### Compras
- Finalizar compra
- Histórico de compras
- Detalhes da compra

## 🔐 Segurança

- Senhas criptografadas com `password_hash()`
- Proteção contra SQL Injection usando PDO
- Validação de dados no frontend e backend
- Sessões seguras

## 📝 API Endpoints

### Autenticação
- `POST /api/api.php?action=cadastro` - Cadastro de usuário
- `POST /api/api.php?action=login` - Login
- `GET /api/api.php?action=logout` - Logout

### Cursos
- `GET /api/api.php?action=cursos` - Listar todos os cursos
- `GET /api/api.php?action=cursos&categoria_id=1` - Listar cursos por categoria

### Carrinho
- `GET /api/api.php?action=carrinho` - Listar itens do carrinho
- `POST /api/api.php?action=carrinho` - Adicionar item ao carrinho
- `DELETE /api/api.php?action=carrinho` - Remover item do carrinho

### Compras
- `GET /api/api.php?action=compras` - Listar compras
- `GET /api/api.php?action=compras&id=1` - Detalhes de uma compra
- `POST /api/api.php?action=compras` - Finalizar compra

## 👥 Contribuição

1. Faça um Fork do projeto
2. Crie uma Branch para sua Feature (`git checkout -b feature/AmazingFeature`)
3. Faça o Commit das suas mudanças (`git commit -m 'Add some AmazingFeature'`)
4. Faça o Push para a Branch (`git push origin feature/AmazingFeature`)
5. Abra um Pull Request

## 📄 Licença

Este projeto está sob a licença MIT. Veja o arquivo [LICENSE](LICENSE) para mais detalhes.

## ✨ Melhorias Futuras

- [ ] Sistema de avaliações e comentários
- [ ] Área do aluno com progresso dos cursos
- [ ] Sistema de pagamento integrado
- [ ] Certificados automáticos
- [ ] Fórum de discussão
- [ ] Sistema de notificações
- [ ] Área administrativa
- [ ] Relatórios e estatísticas

## 📞 Suporte

Para suporte, envie um email para seu-email@exemplo.com ou abra uma issue no GitHub. 