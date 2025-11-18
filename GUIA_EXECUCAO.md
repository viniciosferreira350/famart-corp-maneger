# 🚀 Guia de Execução - Famartcorp Manager

## 📋 Visão Geral do Projeto

Sistema fullstack para gerenciamento de consultores, equipes, celulares e números WhatsApp.

**Stack:**
- **Backend:** Laravel 12 + PHP 8.2 + SQLite + Sanctum
- **Frontend:** React 19 + TypeScript + Vite + Zustand + React Router

---

## ✅ Status da Implementação

### Backend (100% Completo)
- ✅ Database migrations (8 tabelas)
- ✅ Models com relacionamentos (User, Equipe, Celular, WhatsappNumero)
- ✅ Controllers CRUD completos (4 controllers + auth)
- ✅ Rotas API registradas
- ✅ Autenticação com Laravel Sanctum
- ✅ Policies para controle de acesso por cargo
- ✅ Seeders com dados de demonstração
- ✅ CORS configurado

### Frontend (80% Completo)
- ✅ Estrutura de rotas com React Router
- ✅ Autenticação com Zustand + hooks
- ✅ Serviço API com Axios + interceptors Sanctum
- ✅ Tipos TypeScript completos
- ✅ Layout com navegação
- ✅ Páginas de Login e Register
- ✅ Dashboard
- ⚠️ Páginas CRUD (estrutura criada, implementação básica pendente)

---

## 🎯 Passo a Passo de Execução

### 1️⃣ Preparar Backend

```bash
# Navegar para o backend
cd /home/vinicios/famartcorp-manager/famartcorp-backend

# Instalar dependências (se necessário)
composer install

# Configurar ambiente (já feito)
# O arquivo .env já está criado

# Gerar chave da aplicação (já feito)
php artisan key:generate

# Executar migrations e seeders (já feito)
php artisan migrate:fresh --seed

# Iniciar servidor Laravel
php artisan serve --host=0.0.0.0 --port=8000
```

**Backend rodará em:** `http://localhost:8000`

### 2️⃣ Preparar Frontend

```bash
# Em outro terminal, navegar para o frontend
cd /home/vinicios/famartcorp-manager/famartcorp-frontend

# Instalar dependências (já feito)
npm install

# Iniciar servidor de desenvolvimento
npm run dev
```

**Frontend rodará em:** `http://localhost:5173`

### 3️⃣ Acessar a Aplicação

1. Abrir navegador em `http://localhost:5173`
2. Fazer login com uma das credenciais de demonstração:

---

## 👥 Credenciais de Demonstração

### Master (Acesso Total)
- **Email:** admin@famartcorp.com
- **Senha:** password
- **Permissões:** CRUD completo em todas as entidades

### Gestor - Equipe A
- **Email:** joao.silva@famartcorp.com
- **Senha:** password
- **Permissões:** Gerenciar apenas sua equipe

### Gestor - Equipe B
- **Email:** maria.santos@famartcorp.com
- **Senha:** password
- **Permissões:** Gerenciar apenas sua equipe

### Consultor - Equipe A
- **Email:** pedro.oliveira@famartcorp.com
- **Senha:** password
- **Permissões:** Ver e editar apenas seus próprios recursos

### Outros Consultores
- ana.costa@famartcorp.com / password (Equipe A)
- carlos.souza@famartcorp.com / password (Equipe A)
- fernanda.lima@famartcorp.com / password (Equipe B)
- roberto.alves@famartcorp.com / password (Equipe B)

---

## 🗂️ Estrutura do Banco de Dados

### Relacionamentos

```
User (consultor/gestor/master)
  ├─ belongsTo → Equipe (via equipe_id)
  ├─ hasMany → Celular
  └─ hasMany → WhatsappNumero

Equipe
  ├─ belongsTo → User (gestor via gestor_id)
  ├─ hasMany → User (consultores)
  ├─ hasMany → Celular
  └─ hasMany → WhatsappNumero

Celular
  ├─ belongsTo → User (consultor)
  ├─ belongsTo → Equipe
  └─ hasMany → WhatsappNumero

WhatsappNumero
  ├─ belongsTo → Celular
  ├─ belongsTo → User (consultor)
  └─ belongsTo → Equipe
```

### Status WhatsApp
- `ativo` - Número funcionando normalmente
- `restrito` - Número com restrições
- `banido` - Número banido temporariamente
- `banido_permanente` - Número banido definitivamente
- `emprestado` - Número emprestado para outro consultor

---

## 🔐 Regras de Acesso (Policies)

### Master
- ✅ Acesso total a todas as funcionalidades
- ✅ CRUD completo em todas as entidades
- ✅ Pode deletar qualquer recurso

### Gestor
- ✅ Criar consultores e recursos para sua equipe
- ✅ Ver e editar apenas recursos da sua equipe
- ✅ Deletar recursos da sua equipe
- ❌ Não pode acessar outras equipes

### Consultor
- ✅ Ver recursos da sua equipe
- ✅ Editar apenas seus próprios recursos
- ❌ Não pode criar novos recursos
- ❌ Não pode deletar

---

## 📡 Endpoints da API

### Autenticação
- `POST /login` - Login
- `POST /register` - Registro
- `POST /logout` - Logout
- `GET /api/user` - Usuário autenticado

### Equipes
- `GET /api/equipes` - Listar todas
- `POST /api/equipes` - Criar nova
- `GET /api/equipes/{id}` - Ver detalhes
- `PUT /api/equipes/{id}` - Atualizar
- `DELETE /api/equipes/{id}` - Deletar

### Celulares
- `GET /api/celulares` - Listar todos
- `POST /api/celulares` - Criar novo
- `GET /api/celulares/{id}` - Ver detalhes
- `PUT /api/celulares/{id}` - Atualizar
- `DELETE /api/celulares/{id}` - Deletar

### WhatsApp
- `GET /api/whatsapp?status=ativo&equipe_id=1` - Listar (com filtros)
- `POST /api/whatsapp` - Criar novo
- `GET /api/whatsapp/{id}` - Ver detalhes
- `PUT /api/whatsapp/{id}` - Atualizar
- `DELETE /api/whatsapp/{id}` - Deletar

### Consultores
- `GET /api/consultores?equipe_id=1` - Listar (com filtro)
- `POST /api/consultores` - Criar novo
- `GET /api/consultores/{id}` - Ver detalhes
- `PUT /api/consultores/{id}` - Atualizar
- `DELETE /api/consultores/{id}` - Deletar

---

## 🛠️ Comandos Úteis

### Backend

```bash
# Limpar cache
php artisan cache:clear
php artisan config:clear
php artisan route:clear

# Recriar banco de dados
php artisan migrate:fresh --seed

# Executar testes
php artisan test

# Verificar rotas
php artisan route:list
```

### Frontend

```bash
# Instalar nova dependência
npm install <package>

# Build para produção
npm run build

# Visualizar build de produção
npm run preview

# Verificar tipos TypeScript
npx tsc --noEmit
```

---

## 📦 Dependências Instaladas

### Backend (composer.json)
- laravel/framework: ^12.0
- laravel/sanctum: ^4.0
- laravel/breeze: ^2.3
- laravel/tinker: ^2.10

### Frontend (package.json)
- react: ^19.1.1
- react-router-dom: ^7.x
- axios: ^1.x
- zustand: ^5.x
- react-hook-form: ^7.x
- @tanstack/react-query: ^5.x
- zod: ^3.x

---

## 🚧 Próximos Passos de Desenvolvimento

### Alta Prioridade
1. **Implementar CRUDs completos no frontend**
   - Tabelas com listagem de dados
   - Formulários de criação/edição
   - Modals de confirmação para deleção
   - Filtros e busca

2. **Adicionar validações nos formulários**
   - React Hook Form + Zod
   - Feedback visual de erros
   - Validações customizadas

3. **Melhorar UI/UX**
   - Loading states
   - Error boundaries
   - Toast notifications
   - Skeleton loaders

### Média Prioridade
4. **Dashboard com estatísticas reais**
   - Queries para contar recursos
   - Gráficos (Chart.js ou Recharts)
   - Cards informativos

5. **Paginação no backend**
   - Laravel pagination
   - Frontend com navegação de páginas

6. **Soft Deletes**
   - Adicionar soft deletes nos models
   - Endpoints para restaurar

### Baixa Prioridade
7. **Testes automatizados**
   - PHPUnit no backend
   - Vitest + Testing Library no frontend

8. **Docker Compose**
   - Containerizar aplicação
   - MySQL/PostgreSQL no container

9. **CI/CD**
   - GitHub Actions
   - Deploy automático

---

## 🐛 Troubleshooting

### Backend não inicia
```bash
# Verificar se a porta 8000 está ocupada
lsof -i :8000

# Tentar outra porta
php artisan serve --port=8001
```

### Frontend não conecta com backend
- Verificar se backend está rodando
- Verificar CORS em `config/cors.php`
- Verificar proxy no `vite.config.ts`
- Limpar cookies do navegador

### Erro de autenticação
```bash
# Limpar cache de sessões
php artisan session:flush
php artisan cache:clear

# Recriar banco
php artisan migrate:fresh --seed
```

### Erro de CSRF token
- Verificar se `withCredentials: true` está configurado no axios
- Limpar cookies do navegador
- Verificar domínio em `config/sanctum.php`

---

## 📝 Notas Importantes

1. **Sanctum + SPA Authentication:**
   - Frontend e backend devem estar no mesmo domínio ou subdomínio em produção
   - Configurar `SANCTUM_STATEFUL_DOMAINS` para produção
   - Usar cookies para autenticação (não tokens)

2. **CORS:**
   - Já configurado para localhost:5173
   - Atualizar `FRONTEND_URL` no .env para produção

3. **Database:**
   - SQLite para desenvolvimento (arquivo: `database/database.sqlite`)
   - Migrar para MySQL/PostgreSQL em produção

4. **Segurança:**
   - Senhas são hasheadas com bcrypt
   - CSRF protection ativo
   - Rate limiting em rotas de auth

---

## 📞 Suporte

Para dúvidas ou problemas:
1. Verificar logs do Laravel em `storage/logs/laravel.log`
2. Verificar console do navegador (F12)
3. Revisar este guia

---

**Projeto implementado com sucesso! 🎉**

Versão: 1.0.0
Data: 17 de novembro de 2025
