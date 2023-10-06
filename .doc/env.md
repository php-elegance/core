# Env

Carrega variaves de arquivos **.env** e **.conf**

    use Elegance\Env;

Uma variavel de ambiente pode ser recuperada utilizando a helper **env**

    env('var');

---

**loadFile**: Carrega variaveis de ambiente de um arquivo para o sistema

    Env::loadFile(string $filePath): bool
    
> Os arquivos .env e .conf na raiz do seu projeto são importados automaticamente

---

**set**: Define o valor de uma variavel de ambiente

    Env::set(string $name, mixed $value): void

---

**get**: Recupera o valor de uma variavel de ambiente

    Env::get(string $name): mixed

---

**default**: Define variaveis de ambiente padrão caso não tenha sido declarada

    Env::default(string $name, mixed $value): void

---