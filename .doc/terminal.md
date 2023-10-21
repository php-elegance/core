# Terminal
Abre um projeto Elegance para utilizaçao via terminal

### Instalação
Utilize os comandos abaixo para preparar o projeto para o terminal

    php ./vendor/elegance/core/mxcmd

### Testando

Para testar o funcionamento do **terminal**, execute o comando no terminal

    php mx

Se tudo estiver funcionando, uma logo do **MX-CMD** vai aparecer.

### Executando comandos

Todo comando no terminal deve iniciar com **php mx**

    php mx [comando] [parametros]

Um **comando** é um arquivo que retorna um metodo que será executado no terminal. 
Para acessar o arquivo, separe os diretórios com **.** (ponto)

    php mx [command]

    php mx [path].[command]

    php mx [path].[path].[command]

### Criando comandos

Você pode criar uma comando automáticamente utilizando o comando **mx create.command**.

    php mx create.command [nome do comando]

Isso vai criar um arquivo de comando dentro do diretório **source/command** de seu projeto

Para criar e testar um comando utilize as linhas abaixo no terminal

    php mx create.command teste
    php mx teste

O resultado esperado é algo como

    ---< MX >---

    Comando [teste] funcionando

    ---< MX >---
