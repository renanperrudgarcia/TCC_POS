<?php

declare(strict_types=1);

use Phinx\Migration\AbstractMigration;

final class TipoUsuario extends AbstractMigration
{
    public function change(): void
    {
        $players = $this->table('tipo_usuario');

        $players->addColumn('nome', 'string', ['limit' => 20])
            ->create();
    }
}
