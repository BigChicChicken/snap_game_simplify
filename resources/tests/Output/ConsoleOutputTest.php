<?php

declare(strict_types=1);

namespace App\Tests\Output;

use App\Helper\Color;
use App\Output\ConsoleOutput;
use App\Output\OutputInterface;
use Exception;
use PHPUnit\Framework\TestCase;

/**
 * All tests for ConsoleOutput
 *
 * @see ConsoleOutput
 */
final class ConsoleOutputTest extends TestCase
{
    /**
     * Test the creation
     *
     * @return void
     */
    public function testCanBeCreated(): void
    {
        $this->assertInstanceOf(
            OutputInterface::class,
            new ConsoleOutput()
        );

        $this->assertInstanceOf(
            ConsoleOutput::class,
            new ConsoleOutput()
        );
    }

    /**
     * Test to write into CLI
     *
     * @return void
     */
    public function testCanWriteSomething(): void
    {
        $string = "Something";
        $consoleOutput = new ConsoleOutput();
        $this->expectOutputString($string);
        $consoleOutput->write($string);
    }

    /**
     * Test to set foreground into CLI
     *
     * @return void
     * @throws Exception
     */
    public function testCanSetForeground(): void
    {
        $consoleOutput = new ConsoleOutput();
        $this->expectOutputString("\033[38;2;0;0;0m\033[0m");
        $consoleOutput
            ->foreground(Color::BLACK)
            ->reset()
        ;
    }

    /**
     * Test to set background into CLI
     *
     * @return void
     * @throws Exception
     */
    public function testCanSetBackground(): void
    {
        $consoleOutput = new ConsoleOutput();
        $this->expectOutputString("\033[48;2;0;0;0m\033[0m");
        $consoleOutput
            ->background(Color::BLACK)
            ->reset()
        ;
    }

    /**
     * Test to set bold into CLI
     *
     * @return void
     * @throws Exception
     */
    public function testCanSetBold(): void
    {
        $consoleOutput = new ConsoleOutput();
        $this->expectOutputString("\033[1m\033[0m");
        $consoleOutput
            ->bold()
            ->reset()
        ;
    }

    /**
     * Test to reset styles into CLI
     *
     * @return void
     * @throws Exception
     */
    public function testCanReset(): void
    {
        $consoleOutput = new ConsoleOutput();
        $this->expectOutputString("\033[0m");
        $consoleOutput
            ->reset()
        ;
    }

    /**
     * Test to add newline into CLI
     *
     * @return void
     * @throws Exception
     */
    public function testCanLn(): void
    {
        $consoleOutput = new ConsoleOutput();
        $this->expectOutputString("\n");
        $consoleOutput
            ->ln()
        ;
    }
}