<?php

declare(strict_types=1);

namespace App\Tests\Api\EventListeners;

use App\Api\EventListeners\ResponseExceptionListener;
use App\Kernel;
use InvalidArgumentException;
use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpKernel\Event\ExceptionEvent;
use Symfony\Component\HttpKernel\KernelEvents;

class ResponseExceptionListenerTest extends WebTestCase
{
    private ResponseExceptionListener $responseExceptionListener;

    public function setUp(): void
    {
        parent::setUp();
        $this->responseExceptionListener = new ResponseExceptionListener(false);
    }

    public function testGetSubscribeEventReturnsCorrectArray()
    {
        $this->assertIsArray(ResponseExceptionListener::getSubscribedEvents());
        $this->assertArrayHasKey(KernelEvents::EXCEPTION, ResponseExceptionListener::getSubscribedEvents());
        $this->assertEquals('onKernelException', ResponseExceptionListener::getSubscribedEvents()[KernelEvents::EXCEPTION][0][0]);
        $this->assertEquals(-1, ResponseExceptionListener::getSubscribedEvents()[KernelEvents::EXCEPTION][0][1]);
    }

    public function testOnKernelException()
    {
        $exception = new InvalidArgumentException('I like cookies ;)');
        $request = new Request(content: json_encode(['filter' => 'foo']));
        $exceptionEvent = new ExceptionEvent(new Kernel('dev', false), $request, 1, $exception);

        $event = $this->responseExceptionListener->onKernelException($exceptionEvent);
        $this->assertJson($event->getResponse()->getContent());
        $this->assertEquals(
            '{"errors":{"code":"0","status":"500","title":"Internal Server Error","detail":"I like cookies ;)"}}',
            $event->getResponse()->getContent()
        );
    }
}
