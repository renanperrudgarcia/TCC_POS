<?php

declare(strict_types=1);

use Phinx\Migration\AbstractMigration;

final class Usuario extends AbstractMigration
{
    public function change(): void
    {
        $players = $this->table('usuario');

        $players->addColumn('nome', 'string', ['limit' => 60])
            ->addColumn('usuario', 'string', ['limit' => 14])
            ->addColumn('senha', 'string', ['limit' => 100])
            ->addColumn('created_at', 'datetime', ['null' => true])
            ->addColumn('ended_at', 'datetime', ['null' => true])
            ->create();
    }
}
