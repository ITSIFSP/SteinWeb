# Intelligent Transport System

Para iniciar o projeto siga os seguintes passos:

## Preparo de ambiente

Realize o download e instale o utilitário de ambiente de desenvolvimento [Laragon](https://laragon.org/).

Configure as dependências do `apache` ou `nginx` e `MySQL/phpmyadmin` em seu computador através do Laragon

Acesse as configurações do laragon e altere de:

```bash
{name}.laravel
```

para:

```bash
{name}.wip
```

Execute os seguintes comandos no diretório laragon/www/ para obter e configurar o projeto:

```bash
git clone https://github.com/ITSIFSP/SteinWeb.git
```

```bash
cd/SteinWeb
```

<!-- Instale as dependências do `composer` e `npm`  no diretório raíz do projeto -->

```bash
composer install
```

```bash
npm install && npm run dev
```

```bash
cp .env.example .env
```

```bash
php artisan key:generate
```

Abra o arquivo .env e altere o DB_DATABASE para DB_DATABASE=intervention

Crie um banco de dados no `MySQL/phpmyadmin` com o nome de `intervention` e a `collation uft8mb4_unicode_ci`

Execute o comando para popular o banco de dados com o usuário administrador padrão:

```bash
php artisan migrate --seed
```

## Firebase

Por questões de segurança é necessária a utilização de um projeto privado no Firebase.

Acesse o [console do firebase](https://console.firebase.google.com/) e crie um novo projeto com o nome

```bash
project-intervention
```

Após criar o projeto clique no botão: \
\
![Botão Adicionar app](https://i.imgur.com/031O7ep.png)

Seleciona a aplicação web

![Botão Adicionar app](https://i.imgur.com/JfN5wwX.png)

Após isso registre seu app, copie o código do `firebaseConfig` e substitua no diretório

```bash
SteinWeb/public/assets/js/firebase.js
```

Entre em `Configurações do projeto` no canto superior esquerdo ao lado de `Visão geral do projeto`

![Visão geral do projeto](https://i.imgur.com/RrwQ7r8.png)

Acesse `Contas de serviço`

![Conta de serviço](https://i.imgur.com/Pkcbq9n.png)

Selecione o snippet do `Node.js` e clique em `Gerar nova chave privada` para realizar o download da mesma.

![Download SDK](https://i.imgur.com/8cvCDTc.png)

Renomeie o arquivo baixado para `FirebaseKey` e coloque-o no diretório do projeto:

```bash
SteinWeb/app/Http/Controllers/
```

## Inicializar projeto

Acesse pelo seu navegador o endereço:

```bash
SteinWeb.wip/
```

Insira o usuário e senha padrão de administrador:

Usuário:

```bash
admin@admin.com
```

Senha

```bash
admin1
```
