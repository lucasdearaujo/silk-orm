# silk-orm

[![License](https://poser.pugx.org/hamboldt/silk-orm/license)](https://packagist.org/packages/hamboldt/silk-orm) [![Build Status](https://scrutinizer-ci.com/g/hamboldt/silk-orm/badges/build.png?b=master)](https://scrutinizer-ci.com/g/hamboldt/silk-orm/build-status/master) [![Scrutinizer Code Quality](https://scrutinizer-ci.com/g/hamboldt/silk-orm/badges/quality-score.png?b=master)](https://scrutinizer-ci.com/g/hamboldt/silk-orm/?branch=master) [![Total Downloads](https://poser.pugx.org/hamboldt/silk-orm/downloads)](https://packagist.org/packages/hamboldt/silk-orm) [![Latest Stable Version](https://poser.pugx.org/hamboldt/silk-orm/v/stable)](https://packagist.org/packages/hamboldt/silk-orm)  [![Latest Stable Version](https://img.shields.io/badge/size-21KB-lightgrey.svg)](https://packagist.org/packages/hamboldt/silk-orm)

O ORM Silk (seda em inglês) é um sistema de mapeamento de objetos integrado com a estrutura do Zend Framework 2
que foi pensado para ser prático, leve, e de fácil configuração. Ele permite transformar tabela em objetos e posteriormente
acessar os dados utilizando o padrão de busca SQL do Zend. Em outras palavras, o papel dele é mapear seus objetos apenas
em nível de arrays. Todo o resto fica com o Zend - transação de arrays com o banco de dados.

`composer require hamboldt/silk-orm`

### Como funciona

* [Configure um banco de dados](https://gist.github.com/hamboldt/b873f19576623f06607a)
* [Configure um objeto](https://gist.github.com/hamboldt/ad2ed7cf50c028b57373)
* [Configure um objeto relacionado](https://gist.github.com/hamboldt/463eab6bbb92559ee2cb)

### Configurações

* `@configure {"table":"table_name"}` - Especifica qual é a tabela do objeto no banco de dados.
* `@configure {"primary_key":"idtable"}` - Especifica qual é a chave primária da tabela.
* `@configure {"ignore":true}` - Ignora a propriedade do objeto na construção das queries.
* `@configure {"ignoreIfNull":true}` - Ignora a propriedade do objeto, apenas se nula.
* `@configure {"alias":"somecolumn"}` -  Especifica o nome da coluna da propriedade na tabela.
* `@configure {"type":"\\Silk\\Test\\Company"}` - Instanciamento automático de objetos mapeáveis.

### Como usar

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

#### Inserindo novo registro
Quando o objeto é instanciado e não se passa nenhum valor no construtor como parâmetro ele é criado vazio, isto é, não vai ter nenhum valor, nem uma id definida para o mesmo. Quando o objeto tem um id nulo (`$company->getId() == null`) ao chamar o método _save()_ um novo registro será inserido no banco. Se ele ja tiver um id definido, o registro será atualizado.

```php
$company = new Company();
$company->setName("Softwerk");
$company->save();

echo $company->getId(); // 1
```
![](http://i.imgur.com/JR1UOIv.png?1)

#### Atualizando um registro
Quando o objeto já possui uma id definida, e chamamos o método `save()`o registro cuja chave primária for a id do objeto será atualizado no banco de dados, conforme o exemplo abaixo.

##### Instanciamento por chave primária
```php
$company = new Company(1);
$company->setName("Softwerk LTDA");
$company->save();
```

##### Instanciamento por array explicita
```php
$company = new Company(['idcompany' => 1]);
$company->setName("Softwerk LTDA");
$company->save();
```

##### Instanciamento por where do ZF2
```php
$company = new Company(function(Select $select){
   $select->where->equalTo('idcompany', '1');
   $select->limit(1);
});
$company->setName("Softwerk LTDA");
$company->save();
```

##### Atualizando múltiplos registros
Atualiza todos os registros onde a coluna nome tiver o valor 'Softwerk'.

```php
Company::select(['name' => 'Softwerk'])->map(function(Company $company){
   $company->setName('The name has changed!');
   $company->save();
});
```

#### Removendo um registro
Um objeto só será removido quando o sua id estiver definida, assim como nas operações de atualização. Para remover um registro do banco de dados basta chamar o método `delete()` do objeto, assim como no exemplo abaixo.

```php
$company = new Company(1);
$company->setName("Softwerk LTDA");
$company->delete();
```

##### Removendo vários registros
Exemplo abaixo irá remover todos os objetos onde o valor da coluna `name` for igual a `Softwerk`.

```php
Company::select(['name' => 'Softwerk'])->map(function(Company $company){
   $company->delete();
});
```
