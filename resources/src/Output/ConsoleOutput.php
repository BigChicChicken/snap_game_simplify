<?php

declare(strict_types=1);

namespace App\Output;

use App\Helper\Color;
use Exception;

/**
 * CLI output
 */
class ConsoleOutput implements OutputInterface
{
    /**
     * @var resource
     */
    private mixed $stream;

    /**
     * @throws Exception
     */
    function __construct()
    {
        $stream = fopen('php://output', 'w');
        if (!$stream) {
            throw new Exception('Failed to open stream.');
        }

        $this->stream = $stream;
    }


    function __destruct() {
        fclose($this->stream);
    }

    /**
     * Change foreground of CLI
     *
     * @param string $color
     *
     * @return ConsoleOutput
     * @throws Exception
     */
    public function foreground(string $color): ConsoleOutput
    {
        [$red, $green, $blue] = Color::fromHex($color);
        $this->write("\033[38;2;${red};${green};${blue}m");

        return $this;
    }

    /**
     * Change background of CLI
     *
     * @param string $color
     *
     * @return ConsoleOutput
     * @throws Exception
     */
    public function background(string $color): ConsoleOutput
    {
        [$red, $green, $blue] = Color::fromHex($color);
        $this->write("\033[48;2;${red};${green};${blue}m");

        return $this;
    }

    public function bold(): ConsoleOutput
    {
        $this->write("\033[1m");

        return $this;
    }

    /**
     * Reset all style into CLI
     *
     * @return $this
     */
    public function reset(): ConsoleOutput
    {
        $this->write("\033[0m");

        return $this;
    }

    /**
     * Write a newline into CLI
     *
     * @return $this
     */
    public function ln(): ConsoleOutput
    {
        $this->write("\n");

        return $this;
    }

    /**
     * Write into CLI
     *
     * @param string $text
     *
     * @return $this
     */
    public function write(string $text): ConsoleOutput
    {
        @fwrite($this->stream, $text);

        return $this;
    }

    /**
     * Prompt into CLI
     *
     * @param string $text
     * @param mixed $defaultValue
     *
     * @return string
     */
    public function prompt(string $text, mixed $defaultValue = null): string
    {
        $suffix = "";
        if ($defaultValue) {
            $suffix = "[${defaultValue}]";
        }

        $this
            ->write("${text} ${suffix}")
            ->ln()
        ;

        $handle = fopen ("php://stdin","r");
        $response = trim(fgets($handle));
        fclose($handle);

        return ($response === "") ? $defaultValue : $response;
    }
}