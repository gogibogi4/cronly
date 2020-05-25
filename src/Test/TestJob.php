<?php

namespace Cronly\Test;

use Cronly\BaseJob;
use Cronly\Utils\Logger;

class TestJob extends BaseJob
{
    /**
     * @inheritDoc
     */
    function preExecute(): void
    {
        Logger::logMessage(1, 'preExecute');
    }

    /**
     * @inheritDoc
     */
    function execute(): void
    {
        Logger::logMessage(2, 'execute');
    }

    /**
     * @inheritDoc
     */
    function afterExecute(): void
    {
        Logger::logMessage(3, 'afterExecute');
    }
}