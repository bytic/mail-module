<?php

declare(strict_types=1);

namespace Nip\MailModule\Tests;

use Nip\Config\Config;
use Nip\Container\Utility\Container;
use PHPUnit\Framework\TestCase;

/**
 * Class AbstractTest.
 */
abstract class AbstractTest extends TestCase
{
    protected $object;

    protected $tester;

    /**
     * This method is called before each test.
     */
    protected function setUp(): void
    {
        parent::setUp();

        $config = new Config([], true);
        Container::get()->set('config', $config);
    }
}
