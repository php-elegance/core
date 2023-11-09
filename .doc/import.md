# Import

Importa arquivos retornando conteúdo

    use Elegance\Core\Import;

---

**only**: Importa um arquivo PHP

    Import::only(string $filePath, bool $once = true): bool

---

**content**: Retorna o conteúdo de um aquivo

    Import::content(string $filePath, string|array $prepare = []): ?string

---

**return**: Retorna o resultado (return) em um arquivo php 

    Import::return(string $filePath, array $params = []): mixed

---

**var**: Retorna o valor de uma variavel dentro de em um arquivo php

    Import::var(string $filePath, string $varName, array $params = []): mixed

---

**output**: Retorna a saída de texto gerada por um arquivo

    Import::output(string $filePath, array $params = []): string

---