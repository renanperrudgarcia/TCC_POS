<?php


use Phinx\Seed\AbstractSeed;

class UsuarioSeeder extends AbstractSeed
{
    public function run()
    {
        $now = (new DateTimeImmutable())->format('Y-m-d H:i:s');

        $data = [
            [
                'nome' => 'Renan',
                'usuario' => 'renan',
                'senha' => '123',
                'tipo_usuario' => 1,
                'created_at' => $now
            ],
            [
                'nome' => 'Aline',
                'usuario' => 'aline',
                'senha' => '321',
                'tipo_usuario' => 1,
                'created_at' => $now
            ],
        ];

        $usuarios = $this->table('usuario');
        $usuarios->insert($data)
            ->saveData();
    }
}
