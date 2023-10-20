## Desafio Técnico

Indice:
[Rodando projeto](#passo-a-passo) | [Checar e-mails](#validar-envido-e-mails-locais) | [Teste externos do endpoint](#testes-endpoints)

Instruções para entrega:

*   Versione, com git, e hóspede seu código em algum serviço de sua preferência: github, bitbucket, gitlab ou outro.
*   Crie um README com instruções claras sobre como executar sua obra.
*   Envie um e-mail com o link do repositório

## Sobre o projeto

A API Restful deve contemplar os módulos _**Cliente**_, _**Produto**_ e _**Pedido**_, sendo que cada um deverá conter endpoints **CRUDL**.

---

**As tabelas devem conter as seguintes informações:**

*   ✔ Clientes: _nome, e-mail, telefone, data de nascimento, endereço, complemento, bairro, cep, data de cadastro_; @done
*   ✔ Produtos: _nome, preço, foto_; @done
*   ✔ Pedidos: _código do cliente, código do produto, data da criação_; @done

---

**Requisitos:**

*   ✔ Não devem existir dois clientes com o mesmo e-mail. @done
*   ✔ O produto deve possuir foto. @done
*   ✔ Os dados devem ser validados. @done
*   ✔ O sistema deve conter uma série de tipos de produtos já definidos. @done
*   ✔ O pedido deve contemplar N produtos. @done
*   ✔ O cliente pode contemplar N pedidos. @done
*   ✔ Após a criação do pedido o sistema deve disparar um e-mail para o cliente contendo os detalhes do seu pedido. @done
*   ✔ Os registros devem conter a funcionalidade de soft deleting. @done
*   ✔ Padronização PSR @done
*   ✔ Nomenclatura de classes, métodos e rotas no padrão americano. @done

---

**Requisitos adicionais:**

*   ✔ Testes unitários. @done
*   ✔ Dockerizar a aplicação @done

---

**Critérios de avaliação:**

*   _Profundidade do conhecimento e utilização das funcionalidades do framework._
*   _Organização do código._
*   _Padronização PSR_
*   _Fidelidade aos requisitos solicitados._

## Utilizaando

*   Laravel 10
*   Docker
*   MailHog
*   Mysql
*   Redis

## Passo a passo

Clone Repositório

```sh
git clone -b git@github.com:elisonsilva/desafio-disys-restfull.git desafio-disys-restfull
```

```sh
cd desafio-disys-restfull
```

Crie o Arquivo .env

```sh
cp .env.example .env
```

_Atualize as variáveis de ambiente do arquivo .env se ncessario_

### Utilizando Makefile

_Obsevação: O desafio foi desenvolvido no Windows 11 com WSL2 (Ubuntu 20.04), Docker e Docker Composer instalado dentro do mesmo, com isso a chamada 'docker-compose' muda para 'docker compose' (espaços). Você pode alterar a chamada diretamente arquivo Makefile, em DOCKER\_COMPOSE ou DOCKER\_EXEC_

Rode o comando abaixo para:

1.  _Subir o Containers_
2.  \*Acessa o Container de App
3.  _Instala as dependencias (Composer install)_
4.  _Configurações do Laravel_
5.  _Importa as Migrations_
6.  _Popula o banco (Seeders)_
7.  _Roda os testes (PHPUnit)_

```sh
# Todas as configuração
make run
```

Rodar apenas os testes

```sh
make test
```

Acesse os endoints via Postman ou Insominia

[http://localhost:8989/api/v1](http://localhost:8989/api/v1)

Acessar o container com o Laravel

```sh
make test
```

### Utilizando Docker Composer

_Observação: O desafio foi desenvolvido no Windows 11 com WSL2 (Ubuntu 20.04), Docker e Docker Composer instalado dentro do mesmo, com isso a chamada 'docker-compose' muda para 'docker compose' (espaços)._

Suba os containers do projeto

```sh
docker compose up -d
```

Acesse o container app

```sh
docker compose exec app bash
```

Instale as dependências do projeto

```sh
composer install
```

Gere a key do projeto Laravel

```sh
php artisan key:generate
```

Acesse os endoints via Postman ou Insominia

[http://localhost:8989/api/v1](http://localhost:8989/api/v1)

## Validar envido e-mails locais

Foi utilizado **MailHog** para testar o envio e recebimento de e-mails local, o link para visualizá-los é [http://localhost:8025](http://localhost:8025)

## Testes endpoints

### VsCode REST Client
Instale a extensão [REST Client](https://github.com/Huachao/vscode-restclient) no VsCode, para testar os arquivos abaixo:

*   [HttpTests_Custumers.http](RestClientTests/HttpTests_Custumers.http)
*   [HttpTests_Products.http](RestClientTests/HttpTests_Products.http)
*   [HttpTests_Orders.http](RestClientTests/HttpTests_Orders.http)

### Postman

Utilizando [Postman](https://www.postman.com/), com o abaixo link você pode criar um fork ou rodar diretamente as coleções, environments e os testes de endpoints no programa. [_Run Collections_](https://learning.postman.com/docs/collections/running-collections/intro-to-collection-runs/);

Link coleção: https://documenter.getpostman.com/view/4246747/2s9YRB3XnS

Arquivos para importar

* [Back-end Challenge.postman_collection](Postman/Back-endChallenge.postman_collection.json)
* [Back-end Challenge.postman_environment](Postman/Back-endChallenge.postman_environment.json)
