### Insomnia API

Dentro da pasta <b>docs/Insomnia/</b> exite o arquivo <b>insomnia.json </b> para ser importado no Insomnia com as rotas do Serviço e as variaveis de ambiente local, QA, Prod.

Todas vez que for mecher no projeto sempre fazer o import no Insomnia e quando criar as rotas sempre exportar e subir no git assim sempre mantemos atualizado.

Para vizualizar a documentação do insomnia web:

necessario ter o node instalado na maquina

depois instalar as duas dependencias:

```
npm i -g insomnia-documenter
npm install -g serve
```

acessar a pasta onde encontra o arquivo Insomnia.json dentro da pasta rodar o seguinte comando:

```
insomnia-documenter --config "Insomnia.json"
```

após rodar o comando acima dentro da mesma pasta executar o seguinte comando:

```
serve
```

depois de rodar so chamar a rota http://localhost:3000
