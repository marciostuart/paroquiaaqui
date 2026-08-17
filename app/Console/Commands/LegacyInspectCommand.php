<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\DB;
use Throwable;

class LegacyInspectCommand extends Command
{
    protected $signature = 'legacy:inspect';

    protected $description = 'Lista tabelas e colunas do MySQL legado sem alterar dados.';

    public function handle(): int
    {
        if (! config('database.connections.legacy_mysql.host')) {
            $this->error('LEGACY_DB_HOST nao foi configurado. A fonte deve ser somente-leitura.');

            return self::FAILURE;
        }

        try {
            $database = config('database.connections.legacy_mysql.database');
            $rows = DB::connection('legacy_mysql')->select(
                'SELECT table_name, column_name, data_type FROM information_schema.columns WHERE table_schema = ? ORDER BY table_name, ordinal_position',
                [$database],
            );
            $this->table(['Tabela', 'Coluna', 'Tipo'], collect($rows)->map(fn ($row) => [(string) $row->table_name, (string) $row->column_name, (string) $row->data_type]));

            return self::SUCCESS;
        } catch (Throwable $exception) {
            report($exception);
            $this->error('Nao foi possivel inspecionar a fonte legada. Verifique rede, usuario somente-leitura e configuracao.');

            return self::FAILURE;
        }
    }
}
