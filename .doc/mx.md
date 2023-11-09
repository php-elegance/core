# Mx
Abre um projeto Elegance para utilizaçao via terminal

### Instalação
Utilize os comandos abaixo para preparar o projeto para o terminal

    php ./vendor/elegance/core/mxcmd

### Testando

Para testar o funcionamento do **mx**, execute o comando no mx

    php mx

Se tudo estiver funcionando, uma logo do **MX-CMD** vai aparecer.

### Executando comandos

Todo comando no terminal deve iniciar com **php mx**

    php mx [comando] [parametros]

Um **comando** é uma classe com o metodo **__invoke** que será executado no terminal. 
Uma classe de comando deve obrigatóriamente extender a classe **\Mx\Mx**

    php mx [command] // MxCommand

    php mx [prefix].[command] // MxPrefixCommand

    php mx [prefix].[prefix].[command] // MxPrefixPrefixCommand

### Criando comandos

Você pode criar uma comando automáticamente utilizando o comando **mx create.command**.

    php mx create.command [nome do comando]

Isso vai criar um arquivo de comando dentro do diretório **source/Mx** de seu projeto

Para criar e testar um comando utilize as linhas abaixo no terminal

    php mx create.command teste
    php mx teste

O resultado esperado é algo como

    ---< MX >---

    Comando [teste] funcionando

    ---< MX >---
