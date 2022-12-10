<?php

use App\Shared\Adapters\Contracts\HttpClient;
use App\Shared\Adapters\Contracts\DatabaseDriver;
use App\Shared\Adapters\Contracts\ValidatorTool;
use App\Shared\Adapters\Contracts\Presentation\TemplatePresenter;
use App\Shared\Adapters\Contracts\QueryBuilder\DeleteStatement;
use App\Shared\Adapters\Contracts\QueryBuilder\InsertStatement;
use App\Shared\Adapters\Contracts\QueryBuilder\SelectStatement;
use App\Shared\Adapters\Contracts\QueryBuilder\UpdateStatement;
use App\Shared\Adapters\QueryBuilder\Postgres\Delete;
use App\Shared\Adapters\QueryBuilder\Postgres\Insert;
use App\Shared\Adapters\QueryBuilder\Postgres\Select;
use App\Shared\Adapters\QueryBuilder\Postgres\Update;


use App\Shared\Infra\GuzzleHttpClient;
use App\Shared\Infra\RespectValidation;
use App\Login\Adapters\Repositories\UserApiRepository;
use App\Login\UseCases\Contracts\UserApiRepositoryInterface;
use App\Reports\Adapters\Repositories\ReportUserApiRepository;
use App\Reports\UseCases\Contracts\ReportUserRepositoryInterface;

$injections = [
    // Adapters
    HttpClient::class => DI\autowire(GuzzleHttpClient::class),
    DatabaseDriver::class => DI\get('database'),
    ValidatorTool::class => DI\autowire(RespectValidation::class),
    TemplatePresenter::class => DI\get('templatePresentation'),
    SelectStatement::class => DI\autowire(Select::class),
    InsertStatement::class => DI\autowire(Insert::class),
    UpdateStatement::class => DI\autowire(Update::class),
    DeleteStatement::class => DI\autowire(Delete::class),

    //Login
    UserApiRepositoryInterface::class => DI\autowire(UserApiRepository::class),
    ReportUserRepositoryInterface::class => DI\autowire(ReportUserApiRepository::class),

];
