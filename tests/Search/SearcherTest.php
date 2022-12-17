<?php

namespace Tests\Search;

use MercuryHolidays\Search\Searcher;
use PHPUnit\Framework\TestCase;

class SearcherTest extends TestCase
{
    // You can remove this test when it is not needed.
    public function testSearchDoesReturnEmptyArray(): void
    {
        $searcher = new Searcher();

        $this->expectDeprecationMessage('Method not implemented');

        $searcher->search(0, 0, 0);
    }
}
