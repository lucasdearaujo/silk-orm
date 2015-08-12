# silk-orm

O ORM Silk (seda em inglês) é um sistema de mapeamento de objetos integrado com a estrutura do Zend Framework 2
que foi pensado para ser prático, leve, e de fácil configuração. Ele permite transformar tabela em objetos e posteriormente
acessar os dados utilizando o padrão de busca SQL do Zend. Em outras palavras, o papel dele é mapear seus objetos apenas
em nível de arrays. Todo o resto fica com o Zend - transação de arrays com o banco de dados.

### Como funciona

* [Configure um banco de dados](https://gist.github.com/hamboldt/b873f19576623f06607a)
* [Configure um objeto](https://gist.github.com/hamboldt/ad2ed7cf50c028b57373)
* [Configure um objeto relacionado](https://gist.github.com/hamboldt/463eab6bbb92559ee2cb)

#### Instanciamento
O exemplo abaixo deve ser seguido quando formos instanciar apenas um objeto. Pode-se usar perfeitamente as clausulas where do Zend tal como usa-se em seus TableGateways, afinal, o Silk usa o TableGateway do ZF2 para construir seus resultados.
```php
$user = new User(1); // pelo valor da chave primária
$user = new User(["name"=>"lucas"]); // por um where com array
$user = new User(function(Select $select){ /* ... */ }); // Pelo select do zf2
```
#### Multipla seleção
O exemplo abaixo deve ser seguido quando formos instanciar múltiplos objetos. Para armazenar coleções de objetos, usamos a biblioteca [easyframework/collections](https://github.com/italolelis/collections).
```php
$collection = User::select(["name"=>"lucas"]);
$collection = User::select(function(Select $select){ /* ... */ });

$collection->map(function(User $user){
   echo $user->getCompany()->getName() . "\n";
});

```
