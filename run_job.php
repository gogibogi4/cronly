<?php

use Ahc\Cron\Expression;
use Cronly\Utils\Logger;
use Symfony\Component\Yaml\Yaml;

require_once __DIR__ . '/vendor/autoload.php';

const JOB_TYPE_CLASS = 'Class';

$config = Yaml::parse(file_get_contents('config/schedule.yml'));

foreach ($config as $job => $data) {
    if (Expression::isDue($data['scheduled_at'])) {
        Logger::logMessage(0, sprintf('Starting job: %s', $data['name']));

        if ($data['type'] === JOB_TYPE_CLASS) {
            $class = new $data['class'];

            $class->preExecute();
            $class->execute();
            $class->afterExecute();
        }

        Logger::logMessage(0, 'Job finished');
    }
}