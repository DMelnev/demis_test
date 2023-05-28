<?php

namespace App\Twig;

use Twig\Extension\AbstractExtension;
use Twig\TwigFilter;

class PhoneNumberDecorationExtension extends AbstractExtension
{
    public function getFilters(): array
    {
        return [
            new TwigFilter('phoneDecoration', [$this, 'decoration']),
        ];
    }


    public function decoration($value): string
    {
        if (strlen($value)==11){
            return '+'
                . substr($value, 0,1)
                .'('
                . substr($value,1, 3)
                .') '
                . substr($value,4, 3)
                .'-'
                . substr($value,7, 2)
                .'-'
                . substr($value,9, 2);
        }else{
            return $value;
        }
    }
}
