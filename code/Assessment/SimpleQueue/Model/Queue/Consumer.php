<?php

declare(strict_types=1);

namespace Assessment\SimpleQueue\Model\Queue;


use Monolog\Logger;


class Consumer{
    /**
     * @var Logger
     */
    private $logger;

    /**
     * @param Logger $logger
     */
    public function __construct(Logger $logger){

        $this->logger = $logger;
    }

    /**
     * Takes the message off of the queue and writes it to a debug log
     * @param string $message
     */
    public function process(string $message){
        $this->logger->debug($message);
    }
}