<p align="center"><a href="https://laravel.com" target="_blank"><img src="https://raw.githubusercontent.com/laravel/art/master/logo-lockup/5%20SVG/2%20CMYK/1%20Full%20Color/laravel-logolockup-cmyk-red.svg" width="300" alt="Laravel Logo"></a></p>

# WaaS — Website as a Service

Plataforma que vende **sites por assinatura mensal**: o cliente escolhe um modelo (template) e um plano, paga via **Asaas** (Pix, Boleto ou Cartão) e acompanha a produção do seu site em um painel próprio, enquanto a equipe interna gerencia tudo em um painel administrativo.

## Stack

- **Laravel 13** (PHP ^8.3)
- **Filament v5** — dois painéis administrativos
- **Livewire 4** + **Alpine.js**
- **Tailwind CSS 4** + **Vite**
- **Asaas** — gateway de pagamentos (assinaturas recorrentes, Pix/Boleto/Cartão)
- **Resend** — envio de e-mails transacionais

## Como funciona

### Domínio

| Modelo | Descrição |
|---|---|
| `Plan` | Plano de assinatura (preço, ciclo, recursos, se é "recomendado") |
| `Template` | Modelo de site vinculado a um plano e categoria |
| `Category` | Categoria dos templates |
| `Lead` | Captura de quem iniciou o checkout mas não finalizou (recuperação de carrinho) |
| `User` | Cliente ou administrador (`is_admin`), com CPF/CNPJ e `asaas_customer_id` |
| `Subscription` | Assinatura de um usuário para um plano + template (`pending`, `active`, `past_due`, `canceled`) |
| `Order` | Cobrança paga, vinculada a uma assinatura (idempotente por `asaas_payment_id`) |
| `SiteConfig` | Configuração/briefing do site do cliente, com pipeline de produção (`STAGES`: Recebido → Em configuração → Em ajustes → No ar) |
| `SupportTicket` | Chamados de suporte abertos pelo cliente |
| `Faq` | Perguntas frequentes exibidas no site institucional |

### Fluxo de assinatura e pagamento

1. Cliente acessa `/assinar/modelo/{template}`, preenche dados e envia o checkout (`SubscriptionController`).
2. `SubscriptionService` cria/atualiza o cliente no Asaas, cria uma assinatura recorrente (`AsaasService`) e persiste uma `Subscription` local com status `pending`.
3. Cliente é redirecionado à página de pagamento hospedada do Asaas.
4. O Asaas confirma o pagamento via webhook (`POST /webhooks/asaas`), validado com `hash_equals` contra `ASAAS_WEBHOOK_TOKEN`.
5. O evento é processado assincronamente pela fila (`ProcessAsaasWebhook`, com retries) e tratado por `PaymentService`:
   - `PAYMENT_RECEIVED` / `PAYMENT_CONFIRMED` → ativa a assinatura, cria o `Order` e o `SiteConfig` inicial, dispara eventos de domínio (`SubscriptionActivated`, `PaymentReceived`) que acionam as notificações (boas-vindas, confirmação de pagamento).
   - `PAYMENT_OVERDUE` → marca a assinatura como `past_due`.
   - `PAYMENT_REFUNDED` → marca o pedido como `refunded`.
   - `SUBSCRIPTION_DELETED` → cancela a assinatura local.

Todo o processamento é **idempotente**: pagamentos já registrados (`asaas_payment_id`) e assinaturas já canceladas não são reprocessados.

### Acesso ao painel do cliente

O cliente mantém acesso ao painel (`/painel`) enquanto estiver dentro do período pago: assinatura `active`, ou `canceled`/`past_due` com `expires_at` ainda no futuro (`User::hasPanelAccess()`).

## Painéis Filament

- **Admin** (`/admin`) — apenas usuários com `is_admin = true`. Gerencia Plans, Templates, Categories, Orders, Subscriptions, Users, FAQs, SupportTickets e SiteConfigs (incluindo upload de fotos do site do cliente), com widgets de receita e estatísticas de assinaturas.
- **Client** (`/painel`) — clientes (`is_admin = false`) com acesso válido. Perfil (com sincronização de dados no Asaas), assinaturas, pedidos, configuração do site e abertura de tickets de suporte.

## Configuração local

```bash
composer install
npm install

cp .env.example .env
php artisan key:generate
```

Variáveis relevantes no `.env`:

- `ADMIN_EMAILS` — e-mails (separados por vírgula) que recebem `is_admin = true` na migration correspondente.
- `ASAAS_ENV` — `sandbox` ou `production`.
- `ASAAS_SANDBOX_TOKEN` / `ASAAS_TOKEN` — chaves de API do Asaas.
- `ASAAS_SANDBOX_WEBHOOK_TOKEN` / `ASAAS_WEBHOOK_TOKEN` — token enviado no header `asaas-access-token` para validar o webhook.
- `ASAAS_CALLBACK_ENABLED` — habilita o redirecionamento pós-pagamento (`callback.successUrl`); exige domínio cadastrado na conta Asaas. Deixe `false` em ambientes cujo domínio ainda não foi cadastrado.
- `RESEND_API_KEY` — envio de e-mails transacionais.

```bash
php artisan migrate --seed
```

## Rodando o projeto

```bash
composer run dev
```

Sobe em paralelo: servidor Laravel, worker da fila (`queue:listen`), logs (`pail`) e Vite. Acesse:

- Site público: `http://localhost:8000`
- Painel admin: `http://localhost:8000/admin`
- Painel do cliente: `http://localhost:8000/painel`

## Testes

```bash
composer test
```

Cobre os painéis admin/cliente e o fluxo de assinatura via Asaas (`tests/Feature/AsaasSubscriptionTest.php`).

## Webhook do Asaas em desenvolvimento

Para testar webhooks localmente, exponha a aplicação (ex.: `ngrok`) e cadastre a URL `https://SEU_DOMINIO/webhooks/asaas` no painel do Asaas (ambiente sandbox), com o mesmo token configurado em `ASAAS_SANDBOX_WEBHOOK_TOKEN`.
