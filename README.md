# reserva-restaurante
# Sistema de Reserva de Mesas para Restaurante 🍽️

Este é um sistema de reservas desenvolvido em Laravel, que permite gerenciar até 15 mesas de um restaurante, com controle de horários, dias permitidos e autenticação de usuários.

## 🧰 Tecnologias Utilizadas

- PHP 8+
- Laravel 10
- MySQL
- Bootstrap
- HTML/CSS/JavaScript
- PHPUnit

---

## 🚀 Como rodar o projeto localmente

### 1. Clone o repositório

```bash
git clone https://github.com/seu-usuario/reserva-restaurante.git
cd reserva-restaurante
```

### 2. Instale as dependências

```bash
composer install
```

# Instalar dependências do frontend
```bash
npm install
```

# Compilar os arquivos de CSS e JS
```bash
npm run dev
```

### 3. Copie o arquivo `.env` e configure

```bash
cp .env.example .env
```

Atualize as seguintes variáveis no `.env`:

```env
DB_DATABASE=reservas
DB_USERNAME=root
DB_PASSWORD= // coloque sua senha do Postgresql
```

### 4. Gere a chave da aplicação

```bash
php artisan key:generate
```

### 5. Rode as migrations, seeds e factories

```bash
php artisan migrate:fresh --seed --force
```

### 6. Inicie o servidor

```bash
php artisan serve
```

A aplicação estará disponível em [http://localhost:8000](http://localhost:8000)


---

## 👤 Login

Um usuário de teste é criado automaticamente:

- **Email:** `admin@admin.com`
- **Senha:** `password`

---

## 💡 Rodando os testes

```bash
php artisan test
```

## 🐳 Docker 

```bash
docker-compose up -d --build
```

Você poderá acessar via `http://localhost:8000` e os containers estarão configurados com Laravel, PostgreSQL e PHPMyAdmin.

---

## 📋 Funcionalidades

- Login de usuário
- Cadastro de reservas com validação
- Restrições:
  - Horário permitido: 18:00 às 23:00
  - Reservas não podem ser feitas aos domingos
  - Conflito de horários entre reservas
- Testes automatizados (Feature Tests)

---

## ✅ Checklist do projeto

- [x] Login de usuário
- [x] Criar reserva com regras de validação
- [x] Validação de conflitos
- [x] Seed e migration prontos
- [x] Testes automatizados
- [x] Docker

---

## 📬 Contato

Caso tenha dúvidas, entre em contato:

Cainan Rhoden e Ribeiro – cainanrhoden@gmail.com  
GitHub: [@cxinxnr](https://github.com/cxinxnr)

