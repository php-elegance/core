# MxCmd

Abre um projeto Elegance para acesso via terminal

    php ./vendor/elegance/core/mxinstall

---

### Testando

Para testar o funcionamento do **mxcmd**, execute o comando no terminal

    php mx

Se tudo estiver funcionando, uma logo do **MX-CMD** vai aparecer.

### Executando comandos

Todo comando no terminal deve iniciar com **php mx**

    php mx [comando] [parametros]

Os **comando** é a classe de comando que deve ser executada.
Se esviter dentro de um namespace, deve-se separar por **.** (ponto)

    php mx [command]

    php mx [namespace].[command]

O metodo da classe de comendo deve ser informado após o **:**

    php mx [namespace].[command]:[method]

### Criando comandos

Para um comando funcionar corretamente, crie uma classe com o prefixo **Mx** dentro do namespace **Terminal**

    namespace Command;

    use Elegance\MxCmd;

    abstract class MxClass
    {
        static function __default()
        {
            MxCmd::echo('Comando [class] funcionando');
        }
    }

Você pode criar uma comando automáticamente utilizando o comando **mx create.command**

    php mx create.command [nome do comando]

Para criar e testar um comando utilize as linhas abaixo no terminal

    php mx create.command teste
    php mx teste

O resultado esperado é algo como

    ---< MXCMD >---

    Comando [teste] funcionando

    ---< MXCMD >---