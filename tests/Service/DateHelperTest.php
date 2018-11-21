<?php

namespace App\Tests\Service;

use App\Service\DateHelper;
use PHPUnit\Framework\TestCase;

class DateHelperTest extends TestCase
{

    private $dateHelper;

    public function setUp()
    {
        $this->dateHelper = new DateHelper();
    }

    /**
     * @dataProvider dateProvider
     */
    public function testGetDatesFromRange($start, $end, $expected)
    {
        $this->assertSame($expected, $this->dateHelper->getDatesFromRange($start, $end));
    }

    public function dateProvider()
    {
       return  [
            [new \DateTime('25-11-2018'), new \DateTime('28-11-2018'), ['2018-11-25', '2018-11-26', '2018-11-27', '2018-11-28']],
            [new \DateTime('25-11-2018'), new \DateTime('28-01-2018'), []],
        ];
    }
}
