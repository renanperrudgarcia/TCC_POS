<?php

namespace App\Login\Adapters\Repositories;

use App\Login\Domain\ValueObjects\User;
use App\Login\UseCases\Contracts\UserApiRepositoryInterface;
use App\Shared\Adapters\Contracts\QueryBuilder\InsertStatement;
use App\Shared\Adapters\Contracts\QueryBuilder\SelectStatement;
use App\Shared\Domain\Entity\Usuario;
use DateTimeImmutable;
use Exception;
use Fig\Http\Message\StatusCodeInterface;

final class UserApiRepository implements UserApiRepositoryInterface
{
    private SelectStatement $selectStatement;
    private InsertStatement $insertStatement;

    public function __construct(
        SelectStatement $selectStatement,
        InsertStatement $insertStatement
    ) {
        $this->selectStatement = $selectStatement;
        $this->insertStatement = $insertStatement;
    }

    public function findUserApi(string $user): ?Usuario
    {
        try {
            $usuario  = new Usuario();
            $row = $this->selectStatement
                ->select()
                ->from("public.usuario")
                ->where("usuario", $user)
                ->fetchOne();
            if (!$row) {
                return null;
            }
            $usuario->fill($row);
            return $usuario;
        } catch (Exception $exception) {
            throw new Exception("Ocorreu uma exceção durante a execução da busca pelo usuário.", StatusCodeInterface::STATUS_INTERNAL_SERVER_ERROR);
        }
    }

    public function insertUserApi(User $user, string $password): void
    {
        $values = [
            'nome' =>  $user->getName(),
            'usuario' => $user->getUser(),
            'senha' => $password,
            'created_at' => (new DateTimeImmutable())->format('Y-m-d H:i:s')
        ];

        $this->insertStatement
            ->into("public.usuario")
            ->values($values)
            ->insert();
    }
}
