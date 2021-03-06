<?php

namespace Jaeger\Tests\Reporter;

use Jaeger\Reporter\RemoteReporter;
use Jaeger\Sender\UdpSender;
use Jaeger\Span;
use PHPUnit\Framework\TestCase;

class RemoteReporterTest extends TestCase
{
    /** @var RemoteReporter */
    private $reporter;

    /** @var UdpSender */
    private $transport;

    function setUp()
    {
        $this->transport = $this->createMock(UdpSender::class);
        $this->reporter = new RemoteReporter($this->transport);
    }

    function testReportSpan()
    {
        $span = $this->createMock(Span::class);

        $this->transport->expects($this->once())->method('append')->with($span);

        $this->reporter->reportSpan($span);
    }

    function testClose()
    {
        $this->transport->expects($this->once())->method('flush');
        $this->transport->expects($this->once())->method('close');

        $this->reporter->close();
    }
}
