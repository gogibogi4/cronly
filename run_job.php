<?php

use Ahc\Cron\Expression;
use Cronly\Utils\Logger;
use Symfony\Component\Yaml\Yaml;

require_once __DIR__ . '/vendor/autoload.php';

define('BASE_CONFIG_DIR', 'config/');

const JOB_TYPE_CLASS   = 'Class';
const JOB_TYPE_COMMAND = 'Command';

$config = Yaml::parse(file_get_contents(sprintf('%s/schedule.yml', BASE_CONFIG_DIR)));

$params = handleParams($argv);

if (isset($params['job'])) {
    if (!isset($config[$params['job']])) {
        throw new RuntimeException(sprintf('Job %s does not exist!', $params['job']));
    }

    handleJob($config[$params['job']], $config[$params['job']]['type']);
} else {
    handleScheduledJobs($config);
}

/**
 * @param $config
 */
function handleScheduledJobs($config): void
{
    foreach ($config as $job => $data) {
        if (Expression::isDue($data['scheduled_at'])) {
            handleJob($data, $data['type']);
        }
    }
}

/**
 * @param array $data
 * @param string $type
 */
function handleJob(array $data, string $type): void
{
    Logger::logMessage(0, sprintf('Starting job: %s', $data['name']));

    switch ($type) {
        case JOB_TYPE_COMMAND:
            shell_exec($data['command']);

            break;
        case JOB_TYPE_CLASS:
            $class = new $data['class'];

            $class->preExecute($data['params'] ?? []);
            $class->execute();
            $class->afterExecute();

            break;
    }

    Logger::logMessage(0, 'Job finished');
}

/**
 * @param array $argv
 * @return array
 */
function handleParams(array $argv): array
{
    if (count($argv) === 1) {
        return [];
    }

    array_splice($argv, 0, 1);

    $params = [];

    foreach ($argv as $val) {
        $temp = explode('=', $val);

        $params[trim($temp[0], '-')] = $temp[1];
    }

    return $params;
}