# LifeLoom - Backend (Laravel 11)

Este é o backend do projeto **LifeLoom**, desenvolvido com **Laravel 11** e utilizando **MySQL** como banco de dados. O sistema já possui uma estrutura de banco de dados pré-configurada, incluindo as tabelas e registros essenciais para o funcionamento.
- Emilly Eduarda Bitencourt Cardoso - 2210568
- Edwin Nichollas Rocha Medina - 221152
- Felipe Brian Marques Gonçalves - 2210360
- João Vitor Luiz Soares Silva - 2212349 
- João Victor Guimarães Santos - 2212057
- João Marcos Fleury - 2211142
- Marcos Vinícius Silva Andrade - 2210372

## Funcionalidades
- Gerenciamento de usuários (doadores, receptores e administradores).
- Gerenciamento de órgãos, tipos de órgãos, e associações com hospitais.
- Autenticação com **Laravel Passport** para APIs seguras.
- Registro e login de usuários.
- CRUD completo para usuários, órgãos e hospitais.

---

## Pré-requisitos

Certifique-se de que seu ambiente possui as seguintes ferramentas instaladas:

- PHP >= 8.1
- Composer
- MySQL >= 5.7
- Node.js (para gerenciamento de assets, se necessário)
- Git

---

## Passos para Rodar o Projeto

### 1. Clone o Repositório
Clone o repositório do projeto em sua máquina local:

---

### 2. Instale as Dependências
Use o Composer para instalar as dependências do Laravel:

```bash
composer install
```

---

### 3. Configure o Arquivo `.env`
Copie o arquivo de configuração `.env.example` para `.env`:

```bash
cp .env.example .env
```

Edite o arquivo `.env` e configure as variáveis de ambiente para conectar ao banco de dados MySQL:

```env
DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=lifeloom
DB_USERNAME=seu_usuario
DB_PASSWORD=sua_senha
```

---

### 4. Geração da Chave da Aplicação
Gere a chave única para a aplicação:

```bash
php artisan key:generate
```

---

### 5. Configure o Banco de Dados
Certifique-se de que o banco de dados **MySQL** está rodando e crie o banco de dados definido no arquivo `.env`.

O sistema já possui um banco de dados pré-configurado com os seguintes dados básicos:
- Tabelas para **usuários**, **órgãos**, **hospitais** e **tipos de órgãos**.
- Registros iniciais que permitem o funcionamento da aplicação.

Para popular as tabelas com os dados necessários, execute as migrações e seeders:

```bash
php artisan migrate --seed
```

---

### 6. Instale o Laravel Passport
Configure o **Laravel Passport** para autenticação de APIs:

```bash 
php artisan passport:install
```

---

### 7. Criando credenciais do passport
Para criar as credenciais do passport, execute o comando:

```bash
php artisan passport:client --personal
php artisan passport:client --password

```


### 7. Inicie o Servidor
Inicie o servidor local para acessar a aplicação:

```bash
php artisan serve
```

A aplicação estará disponível em: [http://localhost:8000](http://localhost:8000)

---


### Scripts Úteis

#### Resetar Banco de Dados
Caso precise resetar o banco de dados, use o comando:

```bash
php artisan migrate:refresh --seed
```


#### Limpar Cache
Para limpar o cache da aplicação, use o comando:

```bash
php artisan cache:clear
```

### Exemplos de body para requisições

#### Registro de Usuário
```json
{
  "name": "John Doe",
  "cpf": "00100101110",
  "birth_date": "2004-05-30",
  "gender": "male",
  "mother_name": "Jaciara da Silva",
  "email": "john@example.com",
  "password": "password123",
  "profile_id": 1,
  "phone": "62999999999",
  "blood_type": "O+",
  "address": {
    "street": "Rua das Flores",
    "number": "123",
    "complement": "Apto 101",
    "neighborhood": "Centro",
    "city": "São Paulo",
    "state": "SP",
    "zip_code": "01000-000"
  }
}
```
