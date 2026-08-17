# Paróquia Aqui V2

Nova plataforma Laravel multi-tenant para substituir gradualmente o sistema PHP da Hostinger.

## Arquitetura

- Laravel 13 e PHP 8.3;
- PostgreSQL para dados transacionais;
- MinIO/S3 privado para logos, documentos, recibos, avisos e áudios;
- três processos: aplicação HTTP, worker de filas e scheduler;
- resolução de tenant por domínio próprio ou pela URL legada `/{slug}`.

O sistema legado continua sendo a única fonte de escrita até a validação do tenant piloto. A conexão `legacy_mysql` deve usar um usuário de banco **somente leitura**.

## Homologação

O endereço previsto é `v2.paroquiaaqui.com.br`, com o curinga `*.v2.paroquiaaqui.com.br`. Cada tenant de teste deve ter um registro em `tenant_domains`; por exemplo, `paroquia-piloto.v2.paroquiaaqui.com.br`.

Para um domínio próprio, o painel irá gerar um token e instruções DNS. O domínio só ficará `active` após a verificação. O endereço padrão do tenant continua disponível como contingência.

## Desenvolvimento local

1. Instale PHP 8.3+, Composer 2 e Docker Desktop.
2. Copie `.env.example` para `.env`; preencha apenas credenciais locais/de homologação.
3. Execute `composer install`, `php artisan key:generate`, `php artisan migrate` e `php artisan test`.

Nunca versione `.env`, credenciais Asaas/Evolution/MinIO, dumps de produção ou documentos de fiéis.

Após migrar o banco, crie um tenant de teste com `php artisan tenant:create paroquia-piloto "Paróquia Piloto" admin@exemplo.test` e informe a senha somente no prompt seguro.

## Portainer

Crie uma Stack a partir deste repositório, forneça as variáveis de ambiente como segredos e conecte-a às redes já existentes do PostgreSQL, MinIO e proxy reverso. Execute `php artisan migrate --force` como tarefa única antes de iniciar o worker.

Na homologação, defina `APP_HOST=v2.paroquiaaqui.com.br`, `SHARED_NETWORK=360Network` e `PAROQUIAAQUI_IMAGE=paroquiaaqui:<sha>`. A Stack não publica portas diretamente: o Traefik termina o TLS e encaminha para a aplicação na porta 8000. A imagem deve ser construída antes da Stack ser atualizada.

O arquivo `compose.yaml` não cria banco nem bucket: ele consome os serviços já mantidos na VPS. A publicação externa, DNS e TLS só serão configurados após os testes locais e de homologação.

## Migração legada

`php artisan legacy:inspect` somente lista tabelas e colunas da fonte MySQL. Ele é o primeiro passo antes de implementar cada importador idempotente e não altera a Hostinger.
