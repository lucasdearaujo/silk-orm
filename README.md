# silk-orm

O ORM Silk (seda em inglês) é um sistema de mapeamento de objetos integrado com a estrutura do Zend Framework 2
que foi pensado para ser prático, leve, e de fácil configuração. Ele permite transformar tabela em objetos e posteriormente
acessar os dados utilizando o padrão de busca SQL do Zend. Em outras palavras, o papel dele é mapear seus objetos apenas
em nível de arrays. Todo o resto fica com o Zend - transação de arrays com o banco de dados.

### Como funciona

* Configure um banco de dados
* Configure um objeto
* Configure um objeto relacionado

#### Instanciamento
```php
$user = new User(1); // pelo valor da chave primária
$user = new User(["name"=>"lucas"]); // por um where com array
$user = new User(function(Select $select){ /* ... */ }); // Pelo select do zf2
```
