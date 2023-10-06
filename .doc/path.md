# Path

Gerencia referencia para diretórios

    use Elegance\Path;

---

**alias**: Define um atalho para um diretório

    Path::alias(string $name, string $path)

---

**path**: Formata um caminho de diretório

    Path::path(...$path): string

---

**ipath**: Retorno o caminho para o arquivo que chamou esta helper

    Path::ipath(int $limit = 1): string
