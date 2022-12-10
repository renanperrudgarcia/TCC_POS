<?php


use Phinx\Seed\AbstractSeed;

class TipoUsuarioSeeder extends AbstractSeed
{
    public function run()
    {
        $data = [
            [
                'nome' => 'Aluno'
            ],
            [
                'nome' => 'Personal',
            ],
        ];

        $usuarios = $this->table('tipo_usuario');
        $usuarios->insert($data)
            ->saveData();
    }
}
