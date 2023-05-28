<?php

namespace App\Twig;

use Twig\Extension\AbstractExtension;
use Twig\TwigFilter;

class TruncateBySentenceExtension extends AbstractExtension
{
    const SENTENCE_OFFSET = 5;

    public function getFilters(): array
    {
        return [
            new TwigFilter('truncateSentence', [$this, 'truncateSentence']),
        ];
    }

    public function truncateSentence($value): string
    {
        $pos = strlen($value) - 1;
        foreach (['.', '?' , '!'] as $symbol) {
            $temp = mb_strpos($value, $symbol, self::SENTENCE_OFFSET);
            if ($temp && $temp > self::SENTENCE_OFFSET) $pos = min($pos, $temp);
        }

        return mb_substr($value, 0, $pos + 1);
    }
}
