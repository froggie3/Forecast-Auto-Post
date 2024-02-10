<?php

declare(strict_types=1);

namespace App\Command\Forecast;

require_once __DIR__ . '/../../../app/Config/Config.php';
require_once __DIR__ . '/../../../app/Constants/Constants.php';

use Minicli\Command\CommandController;
use \Exception;
use \App\Fetcher\ForcastFetcher;
use \App\Poster\ForecastPoster;
use \Monolog\{Logger, Handler\StreamHandler, Handler\ErrorLogHandler,};
use const \Constants\{WEBHOOK_URL_KEY, PLACE_ID_KEY};

class DefaultController extends CommandController
{
    public function handle(): void
    {
        $loggingPath = __DIR__ . '/../../../logs/app.log';

        $LogHandlers = [new StreamHandler($loggingPath, \Config\MONOLOG_LOG_LEVEL), new ErrorLogHandler()];
        $logger = new Logger("Forecast", $LogHandlers);

        try {
            if (!$placeId = getenv(PLACE_ID_KEY))
                throw new Exception("Environment variable '" . PLACE_ID_KEY . "' is not set");

            if (gettype($placeId) !== 'string')
                throw new Exception("Environment variable '" . PLACE_ID_KEY . "' must be string");

            if (!$webhookUrl = getenv(WEBHOOK_URL_KEY))
                throw new Exception("Environment variable '" . WEBHOOK_URL_KEY . "' is not set");

            if (gettype($webhookUrl) !== 'string')
                throw new Exception("Environment variable '" . WEBHOOK_URL_KEY . "' must be string");
        } catch (Exception $e) {
            $logger->error($e->getMessage());
            return;
        }

        $fetch = new ForcastFetcher(new Logger(\Constants\MODULE_FORECAST_FETCHER, $LogHandlers));
        $logger->info("Location UID to get: '$placeId'");
        $fetch->addQueue($placeId);

        foreach ($fetch->fetchForecast() as $forecast) {
            $post = new ForecastPoster(new Logger(\Constants\MODULE_FORECAST_POSTER, $LogHandlers), $forecast->process()[0], $webhookUrl);
            $post->post();
        }
    }
}
