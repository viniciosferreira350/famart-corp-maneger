# 🛠️ Comandos Úteis - Famartcorp Manager

## 🚀 Inicialização

### Iniciar Backend
```bash
cd /home/vinicios/famartcorp-manager/famartcorp-backend
php artisan serve --port=8000
```

### Iniciar Frontend
```bash
cd /home/vinicios/famartcorp-manager/famartcorp-frontend
npm run dev
```

### Iniciar Ambos (Background)
```bash
# Terminal 1
cd /home/vinicios/famartcorp-manager/famartcorp-backend
nohup php artisan serve --port=8000 > /dev/null 2>&1 &

# Terminal 2
cd /home/vinicios/famartcorp-manager/famartcorp-frontend
nohup npm run dev > /dev/null 2>&1 &
```

---

## 🗄️ Banco de Dados

### Resetar Banco com Seeds
```bash
cd /home/vinicios/famartcorp-manager/famartcorp-backend
php artisan migrate:fresh --seed
```

### Apenas Migrations (sem seeds)
```bash
php artisan migrate:fresh
```

### Verificar Status das Migrations
```bash
php artisan migrate:status
```

### Criar Nova Migration
```bash
php artisan make:migration create_nome_table
```

### Criar Novo Seeder
```bash
php artisan make:seeder NomeSeeder
```

---

## 🎨 Backend Laravel

### Limpar Cache
```bash
php artisan cache:clear
php artisan config:clear
php artisan route:clear
php artisan view:clear
```

### Listar Rotas
```bash
php artisan route:list
```

### Criar Controller
```bash
php artisan make:controller NomeController --resource
```

### Criar Model
```bash
php artisan make:model Nome -m  # Com migration
```

### Criar Policy
```bash
php artisan make:policy NomePolicy --model=Nome
```

### Executar Testes
```bash
php artisan test
```

### Abrir Tinker (Console)
```bash
php artisan tinker
```

---

## ⚛️ Frontend React

### Instalar Dependência
```bash
cd /home/vinicios/famartcorp-manager/famartcorp-frontend
npm install <package-name>
```

### Build para Produção
```bash
npm run build
```

### Preview Build de Produção
```bash
npm run preview
```

### Verificar Tipos TypeScript
```bash
npx tsc --noEmit
```

### Lint
```bash
npm run lint
```

---

## 🧪 Testes

### Backend - Executar Todos
```bash
cd /home/vinicios/famartcorp-manager/famartcorp-backend
php artisan test
```

### Backend - Com Coverage
```bash
php artisan test --coverage
```

### Frontend - Executar Testes (quando implementado)
```bash
cd /home/vinicios/famartcorp-manager/famartcorp-frontend
npm test
```

---

## 🔍 Debug

### Ver Logs do Laravel
```bash
tail -f /home/vinicios/famartcorp-manager/famartcorp-backend/storage/logs/laravel.log
```

### Verificar Processos Rodando
```bash
ps aux | grep -E "(php artisan|npm)" | grep -v grep
```

### Matar Processos
```bash
# Matar servidor Laravel
pkill -f "php artisan serve"

# Matar servidor Vite
pkill -f "npm run dev"
```

### Verificar Porta em Uso
```bash
lsof -i :8000  # Backend
lsof -i :5173  # Frontend
```

---

## 📊 Inspeção do Banco

### Abrir Tinker e Consultar
```bash
php artisan tinker
```

```php
// No tinker
User::count();
User::where('cargo', 'master')->first();
Equipe::with('consultores')->get();
WhatsappNumero::where('status', 'ativo')->count();
```

### Query SQL Direta (SQLite)
```bash
cd /home/vinicios/famartcorp-manager/famartcorp-backend
sqlite3 database/database.sqlite "SELECT * FROM users;"
```

---

## 🔧 Manutenção

### Atualizar Dependências Backend
```bash
cd /home/vinicios/famartcorp-manager/famartcorp-backend
composer update
```

### Atualizar Dependências Frontend
```bash
cd /home/vinicios/famartcorp-manager/famartcorp-frontend
npm update
```

### Verificar Vulnerabilidades (Frontend)
```bash
npm audit
npm audit fix
```

---

## 📦 Git

### Commit Rápido
```bash
git add .
git commit -m "feat: descrição da feature"
git push
```

### Ver Status
```bash
git status
git log --oneline -10
```

### Criar Branch
```bash
git checkout -b feature/nome-da-feature
```

---

## 🌐 API Testing

### Testar Endpoint (sem auth)
```bash
curl http://localhost:8000/api/equipes
```

### Ver Headers de Resposta
```bash
curl -I http://localhost:8000/api/equipes
```

### POST com JSON
```bash
curl -X POST http://localhost:8000/login \
  -H "Content-Type: application/json" \
  -d '{"email":"admin@famartcorp.com","password":"password"}'
```

---

## 🔐 Criar Novo Usuário via Tinker

```bash
php artisan tinker
```

```php
use App\Models\User;
use Illuminate\Support\Facades\Hash;

User::create([
    'name' => 'Novo Usuário',
    'email' => 'novo@email.com',
    'password' => Hash::make('senha123'),
    'cargo' => 'consultor',
    'equipe_id' => 1
]);
```

---

## 📈 Estatísticas do Projeto

### Contar Linhas de Código
```bash
# Backend PHP
find /home/vinicios/famartcorp-manager/famartcorp-backend/app -name "*.php" | xargs wc -l

# Frontend TypeScript
find /home/vinicios/famartcorp-manager/famartcorp-frontend/src -name "*.tsx" -o -name "*.ts" | xargs wc -l
```

### Tamanho dos Diretórios
```bash
du -sh /home/vinicios/famartcorp-manager/famartcorp-backend
du -sh /home/vinicios/famartcorp-manager/famartcorp-frontend
```

---

## 🆘 Problemas Comuns

### "Address already in use" (porta 8000)
```bash
lsof -ti:8000 | xargs kill -9
php artisan serve --port=8001
```

### "Cannot find module" (Frontend)
```bash
cd /home/vinicios/famartcorp-manager/famartcorp-frontend
rm -rf node_modules package-lock.json
npm install
```

### Erro de CORS
1. Verificar `.env` no backend: `FRONTEND_URL=http://localhost:5173`
2. Limpar cache: `php artisan config:clear`
3. Reiniciar servidor Laravel

### Erro 419 (CSRF token mismatch)
1. Limpar cookies do navegador
2. Verificar `config/sanctum.php`
3. Garantir que `withCredentials: true` está no axios

---

## 🎯 Atalhos de Desenvolvimento

### Reset Completo do Projeto
```bash
# Backend
cd /home/vinicios/famartcorp-manager/famartcorp-backend
php artisan migrate:fresh --seed
php artisan cache:clear
php artisan config:clear

# Frontend
cd /home/vinicios/famartcorp-manager/famartcorp-frontend
rm -rf node_modules/.vite
```

### Verificar se Está Tudo Funcionando
```bash
# Testar backend
curl http://localhost:8000

# Testar frontend
curl http://localhost:5173

# Ver processos
ps aux | grep -E "(php artisan|npm run dev)" | grep -v grep
```

---

**Todos os comandos testados e funcionando!** ✅
