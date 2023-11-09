# Code

Aplica e remove codificação em hash MD5

### Chave de codificação

A classe **Code** utiliza uma chave para criar as strings codificadas.
Uma vez criada, so será possivel recuperar o **md5** da string.

Para altear a chave de codificação, adicione a linha em seu .env

    CODE=olaMundo

### Utilizando a classe estatica

> A classe estatica sempre usa a chave definida nas variaveis de ambiente

    use Elegance\Core\Code;

Retorna o codigo de uma string

    Code::on(string $string): string

Retonra o MD5 usado para gerar uma string codificada

    Code::off(string $string): string

Verifica se uma variavel é uma string codificada

    Code::check(mixed $var): bool

Verifica se duas strings tem a mesma string codificada

    Code::compare(string $string, string $compare): bool
