<?php

namespace TheBrain;

use Monolog\Logger as Mlogger;
use Monolog\Handler\StreamHandler;
use Monolog\Formatter\JsonFormatter;
use Swift_Mailer;
use Swift_Message;
use Swift_SmtpTransport;
use Swift_SendmailTransport;

Class Logger
{

    protected $api;

    public function __construct($api)
    {
        $this->api = $api;
    }

    public function RequestInformation($context){
        $path_logs = dirname(dirname(__FILE__)) . '/logs/the-brain-api.log';
        if($this->api->getPathLogInfo()){
            $path_logs = $this->api->getPathLogInfo();
        }

        $formatter  = new JsonFormatter();
        $stream     = new StreamHandler($path_logs, MLogger::INFO);
        $stream->setFormatter($formatter);

        $log = new Mlogger('The Brain API');
        $log->pushHandler($stream);

        $response = [
            'data' => [
                'url'               => $this->api->getUrl(),
                'method'            => $this->api->getMethod(),
                'query'             => $this->api->getQuery(),
                'header'            => $this->api->getHeader(),
                'response'          => $context
            ]
        ];
        $log->info('RequestInformation', [$response]);
    }

    public function RequestException(){
        $path_logs = dirname(dirname(__FILE__)) . '/logs/the-brain-api.log';
        if($this->api->getPathLogError()){
            $path_logs = $this->api->getPathLogError();
        }

        $formatter  = new JsonFormatter();
        $stream     = new StreamHandler($path_logs, MLogger::ERROR);
        $stream->setFormatter($formatter);

        $log = new Mlogger('The Brain API');
        $log->pushHandler($stream);
        $log->error('RequestException', [$this->api->errorHandler()->debug()]);
    }

    public function SendMail($options = [])
    {
        switch ($options['transport']) {
            case 'smtp':
                $transport = (new Swift_SmtpTransport($options['host'], $options['port'], isset($options['security']) ? $options['security'] : null))
                    ->setUsername($options['username'])
                    ->setPassword($options['password']);
                if(isset($options['stream_options'])) {
                    $transport->setStreamOptions($options['stream_options']);
                }
                break;
            case 'sendmail':
                $transport = new Swift_SendmailTransport('/usr/sbin/sendmail -bs');
                break;
        }
        $mailer 	    = new Swift_Mailer($transport);
        $message 	    = (new Swift_Message($this->api->errorHandler()->getMessage()))
            ->setFrom($options['from'])
            ->setTo($options['to'])
            ->setBody(json_encode($this->api->errorHandler()->debug(), JSON_PRETTY_PRINT));
        $mailer->send($message);
    }
}