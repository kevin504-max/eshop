# 🛒 Eshop - Visão Geral
Este é um documento para a aplicação "Eshop". O projeto é um sistema de comércio eletrônico, desenvolvido inteiramente em Laravel, com funcionalidades para administradores e usuários. Os administradores têm acesso a um painel onde podem gerenciar produtos, categorias, visualizar detalhes do usuário e histórico de compras. Usuários comuns podem visualizar produtos, adicionar itens ao carrinho de compras especificando a quantidade e adicionar produtos à lista de desejos.

O sistema oferece suporte a pagamentos via PayPal, Razorpay e pagamento na entrega (COD). O projeto está disponível em `https://eshop.leklob.com/`.

## 🛠 Tecnologias Utilizadas

### 🔙 Backend
* Laravel: Um framework PHP utilizado para o desenvolvimento backend e frontend.
* MySQL: Banco de dados relacional utilizado para armazenar dados da aplicação.

### 👩‍💻 Frontend
* HTML: Linguagem de marcação para estruturar a interface do usuário.
* CSS: Linguagem de estilização usada para estilizar a interface do usuário.
* JavaScript: Linguagem de programação usada para adicionar interatividade à interface do usuário.
* Bootstrap: Um framework CSS usado para criar layouts responsivos e estilização de componentes.
* JQuery: Uma biblioteca JavaScript usada para simplificar a manipulação do DOM.

### 💲 Pagementos
* PayPal: Um serviço de pagamento online usado para processar pagamentos eletrônicos.
* Razorpay: Uma plataforma de pagamento online oferecendo serviços simplificados de pagamento.
* Pagamento na Entrega (COD): Opção de pagamento na entrega, onde o pagamento é feito no momento da entrega do produto.

## 🚀 Instalação e Configuração
To run the project locally, follow the steps below:

1. Clone o repositório do projeto:
```bash
git clone https://github.com/kevin504-max/eshop.git
```

2. Acesse a branch "feature/TPBD":
```bash	
git checkout feature/TPBD
```

3. Instale as dependências do Composer
```bash
composer install
```

4. Crie o arquivo de ambiente .env com base no arquivo .env.example e configure o banco de dados (nome/senha).

5. Gere a chave de criptografia da aplicação:
```bash
php artisan key:generate 
```
6. Execute o script SQL em seu SGDB para criar o banco de dados e as tabelas. Os scripts estão localizados na pasta `database`.

7. Inicie o servidor de desenvolvimento:
```bash
php artisan serve
```

# 📖 Uso da Aplicação
## Acesse a Aplicação no seu Navegador e Explore as Seguintes Funcionalidades

### Administration
1. Faça Login no Painel de Administração:
* Utilize suas credenciais de administrador para acessar o painel exclusivo.    * From the admin panel, you can:

2. Gerencie Produtos e Categorias:
* Execute operações CRUD (Create, Read, Update, Delete) em produtos e categorias diretamente do painel administrativo.

3. Visualize Detalhes do Usuário:

* Obtenha informações detalhadas sobre os usuários registrados para um gerenciamento mais eficiente.

4. Explore Histórico de Compras:
* Tenha acesso ao histórico completo de compras, permitindo uma análise detalhada das transações realizadas.

### OBS:
* Para acessar o painel de administração, adicione `/dashboard` ao final da URL da aplicação.
* Para ser um administrador, é necessário alterar o campo `role_as` para `1` na tabela `users` do banco de dados.

### Usuários Comuns
1. Navegue pelos Produtos Disponíveis:
* Descubra uma ampla variedade de produtos disponíveis na loja, organizados de forma intuitiva por categorias.

2. Adicione Itens ao Carrinho de Compras:
* Personalize sua experiência de compra adicionando itens ao carrinho e especificando a quantidade desejada.

3. Crie uma Lista de Desejos:
* Salve produtos na lista de desejos para uma fácil referência e planejamento de futuras compras.

4. Escolha entre Diversas Opções de Pagamento:
* Selecione o método de pagamento mais conveniente entre as opções oferecidas, como PayPal, Razorpay ou pagamento na entrega (COD).

### Funcionalidades Adicionais

1. Aprimore Produtos com Avaliações e Comentários:
* Deixe avaliações e comentários sobre os produtos, fornecendo feedback valioso para outros usuários.

2. Receba Recomendações Personalizadas:
* Explore recomendações personalizadas com base no histórico de compras e interesses, tornando a experiência de compra mais personalizada.

3. Acompanhe Pedidos em Tempo Real:
* Fique atualizado sobre o status dos pedidos em tempo real, desde a confirmação até a entrega.

4. Ofertas Especiais e Descontos Personalizados:
* Desfrute de ofertas exclusivas e descontos personalizados com base no comportamento de compra e preferências.
