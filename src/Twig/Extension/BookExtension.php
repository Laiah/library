<?php

namespace App\Twig\Extension;

use Twig\Extension\AbstractExtension;
use Twig\TwigFunction;

/**
 * Class BookExtension.
 *
 * @package App\Twig\Extension
 */
class BookExtension extends AbstractExtension {

    public function getFunctions() {
        return [
            new TwigFunction('shortTitle', [$this, 'shortenTitle'] )
        ];
    }

    public function getName()
    {
        return 'book_extension';
    }

    public function shortenTitle(string $title, int $maxLength)
    {
        if (strlen($title) < $maxLength) {
            return $title;
        }

        return substr($title, 0, $maxLength) . ' ...';
    }
}
