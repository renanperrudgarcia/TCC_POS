<?php

declare(strict_types=1);

namespace App\Reports\Adapters\Http;

use App\Reports\UseCases\User\ReportUserApiUseCase;
use App\Shared\Adapters\Http\PayloadAction;
use Exception;
use Fig\Http\Message\StatusCodeInterface;

final class ReportUserApiAction extends PayloadAction
{
    private ReportUserApiUseCase $useCase;
    private int $type_user;

    public function __construct(ReportUserApiUseCase $useCase)
    {
        $this->useCase = $useCase;
    }

    protected function handle(): array
    {
        $this->ValidateInput($this->args);
        return  $this->useCase->handle($this->type_user);
    }

    protected function ValidateInput(array $input)
    {
        if (empty($input['type_user'])) {
            throw new Exception("Campo type_user não pode ser vazio.", StatusCodeInterface::STATUS_BAD_REQUEST);
        }

        $this->type_user = intval($input['type_user']);
    }
}
