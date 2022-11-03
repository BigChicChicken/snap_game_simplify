<?php

declare(strict_types=1);

namespace App;

use App\Entity\Card;
use App\Entity\Deck;
use App\Entity\Player;
use App\Entity\Snap;
use App\Output\ConsoleOutput;
use Exception;

require_once dirname(__DIR__).'/vendor/autoload.php';

$consoleOutput = new ConsoleOutput();

try {
    $snap = new Snap($consoleOutput);
    $snap->start();
}
catch (Exception $exception) {
    $consoleOutput
        ->write($exception->getMessage())
        ->ln()
    ;
}