<?php

use Cards\CardDeck;
use NumberGenerators\XkcdNumberGenerator;

require __DIR__ . '/vendor/autoload.php';




$deck = new CardDeck(new XkcdNumberGenerator());
$deck->deal();

while ($card = $deck->drawCard()) {
    echo $card->value . ' of ' . $card->suit . "\n";
}
