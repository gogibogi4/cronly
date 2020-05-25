<?php

namespace Cronly\Test;

use Cronly\BaseJob;
use Cronly\Utils\Logger;
use Cronly\Utils\MySQLHandle;

class TestJob extends BaseJob
{
    /** @var \PDO */
    private $dbHandle;

    /**
     * @inheritDoc
     */
    function preExecute(array $params = []): void
    {
        $this->dbHandle = MySQLHandle::getInstance();
    }

    /**
     * @inheritDoc
     */
    function execute(): void
    {
        var_export($this->dbHandle->query('SELECT * FROM table')->fetchAll(\PDO::FETCH_ASSOC));
    }

    /**
     * @inheritDoc
     */
    function afterExecute(): void
    {
        Logger::logMessage(3, 'afterExecute');
    }
}