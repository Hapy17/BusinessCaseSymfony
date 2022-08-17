<?php

namespace App\Twig;

use App\Service\ExcerptService;
use Twig\Extension\AbstractExtension;
use Twig\TwigFilter;
use Twig\TwigFunction;

class ExcerptExtension extends AbstractExtension
{
    public function __construct(
        private ExcerptService $excerptService
    )
    {
        
    }

    public function getFilters(): array
    {
        return [
            // Premier param : nome dans le twig
            // Second param : ou se trouve l'action à effectuer et son nom
            new TwigFilter('excerpt', [$this, 'excerpt']),
        ];
    }

    public function excerpt(string $text): string
    {
        return $this->excerptService->excerpt($text);
    }
}
