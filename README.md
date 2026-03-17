# API de Transferência Bancária (Laravel)

API desenvolvida em **Laravel** que simula um sistema simples de transferências entre usuários e lojistas, inspirado em desafios técnicos de fintech.

O sistema permite:

* Cadastro de usuários
* Criação automática de carteira
* Transferências entre usuários
* Validação de saldo
* Restrição de transferências para lojistas
* Autorização externa de transações
* Envio de notificação após transferência

---

# Tecnologias utilizadas

* PHP
* Laravel
* MySQL
* Docker
* Postman

---

# Como rodar o projeto

Clone o repositório:

```
git clone https://github.com/seu-usuario/seu-repositorio.git
```

Entre na pasta:

```
cd BancoLaravel
```

Copie o arquivo de ambiente:

```
cp .env.example .env
```

Suba os containers:

```
docker compose up -d --build
```

Gere a chave do Laravel:

```
docker compose exec app php artisan key:generate
```

Execute as migrations:

```
docker compose exec app php artisan migrate
```

A API estará disponível em:

```
http://localhost:8000
```

---

# Endpoints da API

## Criar usuário

POST /api/users

Exemplo de requisição:

```
{
  "name": "João Silva",
  "email": "joao@example.com",
  "cpf_cnpj": "12345678901",
  "type": "user",
  "password": "123456"
}
```

Tipos de usuário:

* user
* merchant

---

## Consultar usuário

GET /api/users/{id}

Retorna dados do usuário e da carteira.

---

## Realizar transferência

POST /api/transfers

Exemplo:

```
{
  "payer_id": 1,
  "payee_id": 2,
  "value": 100
}
```

## Regras de negócio

- Usuários podem enviar e receber transferências
- Lojistas (merchant) apenas recebem transferências
- A transferência só ocorre se houver saldo suficiente
- Cada transferência passa por um serviço externo de autorização
- Após a transferência é enviada uma notificação por um serviço externo

---

# Serviços externos utilizados

Autorização de transferência:

```
https://util.dev.tools/api/v2/authorize
```

Envio de notificação:

```
https://util.devi.tools/api/v1/notify
```

---

# Estrutura do projeto

```
app
controllers
models
database
migrations
routes
Dockerfile
docker-compose.yml
```

---

# Autor

Projeto desenvolvido por Rodrigo Tunala.
