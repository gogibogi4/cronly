<?php

namespace Cronly;

abstract class BaseJob
{
    /**
     * Initialize variables
     * @param array $params
     */
    abstract function preExecute(array $params = []): void;

    /**
     * Run job
     */
    abstract function execute(): void;

    /**
     * After execution logic
     */
    abstract function afterExecute(): void;
}