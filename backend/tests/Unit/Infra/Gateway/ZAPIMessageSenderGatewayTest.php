<?php

use PHPUnit\Framework\TestCase;
use Src\Domain\Character;
use Src\Domain\Reminder;
use Src\Infra\Enviroment\DotEnvAdapter;
use Src\Infra\Gateway\ZAPIMessageSenderGateway;
use Src\Infra\Http\Server\GuzzleHTTPClient;

class ZAPIMessageSenderGatewayTest extends TestCase
{
    public function testSendMessage()
    {
       $env = new DotEnvAdapter();
       $httpClient = new GuzzleHTTPClient();
       $messageSenderGateway = new ZAPIMessageSenderGateway($httpClient, $env);

       $reminder = new Reminder(
        'messagem teste',
        'messagem teste',
         new DateTime(),
         new Character(
            'name',
            '',
            '',
            '',
            '',
            '',
            '',
            '',
            ''
         )
       );
       $send = $messageSenderGateway->sendReminder($reminder);
       $this->assertTrue($send);
    }
}
