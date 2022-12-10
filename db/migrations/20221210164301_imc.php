<?php

declare(strict_types=1);

use Phinx\Migration\AbstractMigration;

final class Imc extends AbstractMigration
{
    public function change(): void
    {
        $players = $this->table('imc');

        $players->addColumn('imc', 'integer')
            ->addColumn('data', 'timestamp', ['default' => 'CURRENT_TIMESTAMP'])
            ->addColumn('id_aluno', 'integer')
            ->addColumn('id_proficional', 'integer')
            ->addForeignKey('id_aluno', 'public.usuario')
            ->addForeignKey('id_proficional', 'public.usuario')
            ->create();
    }
}
