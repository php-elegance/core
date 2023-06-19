# Cif

Aplica e remove cifra em strings

> A classe CIF utiliza um arquivo de certificado. Caso seu projeto não tenha um arquivo, o arquivo padrão será utilizado.

---

### Arquivo de certificado

Para criar um arquivo de certificado em seu projeto

    php mx cif nomeDoCertificado

> Todos os certifiados de cifra, devem estar em **library/certificate**

Para utilizar este certificado em seu projeto, adicione a linha em seu .env

    CIF_FILE=nomeDoCertificado

### Utilizando a classe estatica

> A classe estatica sempre usa o certificado definido nas variaveis de ambiente

    use Elegance\Cif;

Retorna a cifra de uma string

    Cif::on(string $string, string $key = null): string

Retorna a string de uma cifra

    Cif::off(string $string): string

Verifica se uma string atende os requisitos para ser uma cifra

    Cif::check(string $string): bool

Verifica se duas strings decifradas são iguais

    Cif::compare(string $string, string $compare): bool

### Criando objeto de CIF

Utilize instancias de CIF para compatibilidade com outros projetos que não compartilham o certificado padrão.
Defina o certificado que a instancia deve utilizar no parametro **$certificate**

> O arquivo de certificado deve estar dentro da pasta **.library/certificate** e ter a extensão **.crt**

    $cif = new \Elegance\Instance\InstanceCif($certificate);

Retorna a cifra de uma string

    $cif->on(string $string, string $key = null): string

Retorna a string de uma cifra

    $cif->off(string $string): string

Verifica se uma string atende os requisitos para ser uma cifra

    $cif->check(string $string): bool

Verifica se duas strings decifradas são iguais

    $cif->compare(string $string, string $compare): bool
