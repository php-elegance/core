# Helpers

## Command

**cif.on**: Aplica a cifra em um valor informado

    php cif.on valor

**cif.off**: Remove a cifra de um valor informado

    php cif.off valor
**code.on**: Aplica a codificação em um valor informado

    php code.on valor

**code.off**: Remove a codificação de um valor informado

    php code.off valor

**composer**: Atualiza as dependencias e helpers do arquivo **composer.json**

    php mx composer

**create.cif**: Cria um arquivo de certificado para o projeto

    php cif.create nomeDoCertificado

**create.command**: Cria um arquivo de comando em **src/command**

    php mx create.command [command]

**logo**: Mostra a logo do Mx-cmd (chamado por padrão)

    php mx logo

## Config

**CIF**: Arquivo que deve ser utilizado para cifras

    CIF = null

**CODE**: Chave para codificação

    CODE = null

**DEV**: Se o ambiente é de desenvolvimento

    DEV = false

## Constant

 - **IS_TERMINAL**: Se a requisição foi feita via terminal

 - **NORMAL_CHAR**: Array de caracteres especiais com os respectivos caracteres normais

## Function
    
**dbug**: Realiza o var_dump de variaveis

    dbug(mixed ...$params): void

**dbugpre**: Realiza o var_dump de variaveis dentro de uma tag HTML pre

    dbugpre(mixed ...$params): void

**dd**: Realiza o var_dump de variaveis finalizando o sistema

    dd(mixed ...$params): never

**ddpre**: Realiza o var_dump de variaveis dentro de uma tag HTML pre finalizando o sistema

    ddpre(mixed ...$params): never

**env**: Recupera o valor de uma variavel de ambiente

    env(string $name, mixed $defaultValue = null): mixed

**ipath**: Retorno o caminho para o arquivo que chamou esta helper

    ipath(int $limit = 1): string

**is_class**: Verifica se um objeto é ou extende uma classe

    is_class(mixed $object, object|string $class): bool

**is_extend**: Verifica se um objeto implementa uma interface

    is_extend(mixed $object, object|string $class): bool

**is_implement**: Verifica se um objeto implementa uma interface

    is_implement(mixed $object, object|string $interface): bool

**is_trait**: Verifica se um objeto utiliza uma trait

    is_trait(mixed $object, object|string|null $trait): bool

**is_blank**: Verifica se uma variavel é nula, vazia ou composta de espaços em branco

    is_blank(mixed $var): bool

**is_md5**: Verifica se uma variavel é hash MD5

    is_md5(mixed $string): bool

**is_json**: Verifica se uma variavel é uma string JSON

    is_json(mixed $string): bool

**is_closure**: Verifica se uma variavel é uma função anonima ou objeto callable

    is_closure(mixed $var): bool

**is_stringable**: Verifica se uma variavel é uma string ou um objeto Stringable

    is_stringable(mixed $var): bool

**is_base64**: Verifica se uma variavel é uma string base64

    is_base64(mixed $var): bool

**is_httpStatus**: Verifica se uma variavel corresponde a um status HTTP (100~599)

    is_httpStatus($var): bool

**is_serialized**: Verifica se uma variavel corresponde uma string serializada

    is_serialized($var, $strict = true): bool

**jsonFile**: Manipula arquivos JSON

    jsonFile(string $file, array $value = [], bool $merge = false): array
**mb_str_replace**: Substitua todas as ocorrências da string de pesquisa pela string de substituição

    mb_str_replace(array|string $search, array|string $replace, string $subject, &$count = 0): string

**mb_str_replace_all**: Substitui todas as ocorrências da string de procura com a string de substituição

    mb_str_replace_all(array|string $search, array|string $replace, string $subject, int $loop = 10): string

**mb_str_split**: Converte uma string em um array

    mb_str_split(string $string, int $string_length = 1): array
    
**num_format**: Formata um numero em float

    num_format(int|float|string $number, int $decimals = 2, int $roundType = -1): float

**num_round**: Arredonda um numero

    num_round(int|float|string $number, int $roundType = 0): int

**num_interval**: Garante que um numero esteja dentro de um intervalo

    num_interval(int|float|string $number, int|float|string $min = 0, int|float|string $max = 0): int|float

**num_positive**: Retorna o representativo positivo de um numero

    num_positive(int|float|string $number): int|float

**num_negative**: Retorna o representativo negativo de um numero

    num_negative(int|float|string $number): int|float

**path**: Formata um caminho de diretório

    path(): string

**prepare**: Prepara um texto para ser exibido subistituindo ocorrencias do template

    prepare(string $string, array|string $prepare = []): string

**remove_accents**: Remove a acentuação de uma string

    remove_accents(string $string): string

**str_replace_all**: Substitua todas as ocorrências da string de pesquisa pela string de substituição

    str_replace_all(array|string $search, array|string $replace, string $subject, int $loop = 10): string

**str_replace_first**: Substitua a primeira ocorrência da string de pesquisa pela string de substituição

    str_replace_first(array|string $search, array|string $replace, string $subject): string

**str_replace_last**: Substitua a ultima ocorrência da string de pesquisa pela string de substituição

    str_replace_last(array|string $search, array|string $replace, string $subject): string

**str_trim**: Tira o espaço em branco (ou outros caracteres) do início e do fim de uma substring dentro de uma string

    str_trim(string $string, array|string $substring, array|string $characters = " \t\n\r\0\x0B"): string
