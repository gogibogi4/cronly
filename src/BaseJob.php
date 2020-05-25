<?php

namespace Cronly;

abstract class BaseJob
{
    /**
     * Initialize variables
     */
    abstract function preExecute(): void;

    /**
     * Run job
     */
    abstract function execute(): void;

    /**
     * After execution logic
     */
    abstract function afterExecute(): void;
}