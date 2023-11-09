# Cif

Aplica e remove cifra em strings

> A classe CIF utiliza um arquivo de certificado. Caso seu projeto não tenha um arquivo, o arquivo padrão será utilizado.

---

### Arquivo de certificado

Para criar um arquivo de certificado em seu projeto

    php mx crete.cif nomeDoCertificado

> Todos os certifiados de cifra, devem estar em **library/certificate**

Para utilizar este certificado em seu projeto, adicione a linha em seu .env

    CIF=nomeDoCertificado

### Utilizando a classe estatica

> A classe estatica sempre usa o certificado definido nas variaveis de ambiente

    use Elegance\Core\Cif;

Retorna a cifra de uma string

    Cif::on(string $string, string $key = null): string

Retorna a string de uma cifra

    Cif::off(string $string): string

Verifica se uma string atende os requisitos para ser uma cifra

    Cif::check(string $string): bool

Verifica se duas strings decifradas são iguais

    Cif::compare(string $string, string $compare): bool