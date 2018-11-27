<?php

namespace App\Twig\Extension;

use Twig\Extension\AbstractExtension;
use Twig\TwigFilter;

class TextExtension extends AbstractExtension
{

    public function getFilters() {
        return [
            new TwigFilter('strpad', [$this, 'strpad']),
            new TwigFilter('truncate', [$this, 'truncate']),
        ];
    }

    public function getName()
    {
        return 'text_extension';
    }

    /**
     * @param string $stringToComplete
     * @param int $padLength
     * @param string $padString
     * @param int $direction
     *
     * @return string
     */
    public function strpad(string $stringToComplete, int $padLength, string $padString = ' ', int $direction = STR_PAD_LEFT): string
    {
        return str_pad($stringToComplete, $padLength, $padString, $direction);
    }


    public function truncate(string $value, int $length, $separator = ' ...')
    {
        if (strlen($value) < $length) {
            return $value;
        }

        return substr($value, 0, $length) . $separator;
    }
}
