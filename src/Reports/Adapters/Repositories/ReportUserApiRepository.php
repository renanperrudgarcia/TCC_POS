<?php

namespace App\Reports\Adapters\Repositories;

use App\Reports\UseCases\Contracts\ReportUserRepositoryInterface;
use App\Reports\UseCases\User\UserOutputBoundary;
use App\Shared\Adapters\Contracts\QueryBuilder\SelectStatement;
use App\Shared\Domain\Entity\Usuario;
use DateTimeImmutable;
use Exception;
use Fig\Http\Message\StatusCodeInterface;

final class ReportUserApiRepository implements ReportUserRepositoryInterface
{
    private SelectStatement $selectStatement;

    public function __construct(
        SelectStatement $selectStatement
    ) {
        $this->selectStatement = $selectStatement;
    }

    public function findAllUsers(int $type_user): ?array
    {

        $rows = $this->selectStatement
            ->select()
            ->from("public.usuario")
            ->where("tipo_usuario", $type_user)
            ->fetchAll();
        if (!$rows) {
            throw new Exception("Ocorreu uma exceção durante a execução da busca pelo usuário.", StatusCodeInterface::STATUS_NO_CONTENT);
        }
        foreach ($rows as $row)
            $usuarios[] = UserOutputBoundary::build($row);
        return $usuarios;
    }
}
