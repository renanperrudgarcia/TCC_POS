<?php

declare(strict_types=1);

namespace App\Shared\Infra;

use App\Shared\Adapters\Contracts\Presentation\TemplatePresenter;
use Twig\Environment as Twig;

final class TwigEngine implements TemplatePresenter
{
    private Twig $twig;
    private array $options;

    public function __construct(Twig $twig, array $options = [])
    {
        $this->twig = $twig;
        $this->options = $options;
    }

    public function render(string $templateName, array $data = []): string
    {
        return $this->twig->render($templateName, $data);
    }
}
