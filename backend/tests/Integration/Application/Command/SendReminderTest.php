<?php

namespace Tests\Integration\Application\Command;

use DateTime;
use Exception;
use PHPUnit\Framework\TestCase;
use Src\Application\Commands\SendReminder;
use Src\Application\Connection\Connection;
use Src\Application\Enviroment\Env;
use Src\Application\Exceptions\NotFoundException;
use Src\Application\Repository\ReminderRepository;
use Src\Domain\Character;
use Src\Domain\Reminder;
use Src\Infra\Connection\PDOConnection;
use Src\Infra\Enviroment\DotEnvAdapter;
use Src\Infra\Gateway\ZAPIMessageSenderGateway;
use Src\Infra\Http\Server\GuzzleHTTPClient;
use Src\Infra\Repository\DatabaseReminderRepository;

class SendReminderTest extends TestCase
{
    private Env $fakeEnv;
    private Reminder $reminder;
    private SendReminder $sendReminder;
    private ReminderRepository $reminderRepository;

    public function setUp(): void
    {
        $this->fakeEnv = new class extends DotEnvAdapter
        {
            public function get(string $key, mixed $default = null): mixed
            {
                $val = parent::get($key, $default);
                return ($key == 'ENVIROMENT') ? 'local' : $val;
            }
        };
        $connection = new PDOConnection($this->fakeEnv);
        $this->reminderRepository = new DatabaseReminderRepository($connection);
        $messageSender = new ZAPIMessageSenderGateway(
            new GuzzleHTTPClient(),
            $this->fakeEnv
        );

        $this->sendReminder = new SendReminder(
            $this->reminderRepository,
            $messageSender
        );

        $character = Character::create(
            '1',
            'Character Name',
            'Happy',
            'Hero',
            'Young',
            'Origin',
            'Speech',
            'Accent',
            'Archetype',
            'ImagePath',
            'blue'
        );

        $this->reminder = new Reminder(
            'Original Message',
            'Processed Message',
            new DateTime('2024-07-16 12:00:00'),
            $character,
        );

    }

    public function testSuccesSend()
    {
        $reminderId = $this->reminderRepository->save($this->reminder);

        $result = $this->sendReminder->execute($reminderId);
        $this->assertTrue($result);
    }

    public function testReminderAlreadySender()
    {
        $this->expectException(Exception::class);
        $reminderId = '141';

        $result = $this->sendReminder->execute($reminderId);
        $this->assertTrue($result);
    }

    public function testNotFoundReminder()
    {
        $this->expectException(NotFoundException::class);
        $reminderId = '1223';

        $result = $this->sendReminder->execute($reminderId);
        $this->assertTrue($result);
    }
}
