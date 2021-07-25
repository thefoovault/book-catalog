<?php

declare(strict_types=1);

namespace Test;

use Doctrine\DBAL\Connection;
use Symfony\Bundle\FrameworkBundle\Test\KernelTestCase;

class DoctrineTestCase extends KernelTestCase
{
    public function connection(): Connection
    {
        return $this->getContainer()->get(Connection::class);
    }

    protected function setUp(): void
    {
        $this->connection()->beginTransaction();
    }

    protected function tearDown(): void
    {
        $this->connection()->rollBack();
    }
}
