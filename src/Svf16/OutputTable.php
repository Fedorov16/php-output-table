<?php

declare(strict_types=1);

namespace App\Svf16;

class OutputTable
{
    private const MAX_COLUMN_WIDTH = 15;

    private array $data = [];

    private int $padding = 0;
    private array $columnWidth = [];
    private bool $isConsole = false;

    public function setHeaders(array $headers): self
    {
        $this->data[] = $headers;

        return $this;
    }

    public function addRow(array $data): self
    {
        $this->data[] = $data;

        return $this;
    }

    public function build(): string
    {
        $this->validate($this->data);
        $output = $this->isConsole ? PHP_EOL : '';
        $boarder = $this->buildBorder();
        $output .= $boarder;
        foreach ($this->data as $mainKey => $row) {
            foreach ($row as $key => $word) {
                $output .= '|' . str_repeat(' ', $this->padding) . $word . str_repeat(' ', ($this->columnWidth[$key] - strlen((string)$word))) . str_repeat(' ', $this->padding);
            }

            $output .= '|' . PHP_EOL;

            if ($mainKey === 0) {
                $boarder = $this->buildBorder();
                $output .= $boarder;
            }
        }

        $boarder = $this->buildBorder();
        $output .= $boarder;

        return $output;
    }

    private function buildBorder(): string
    {
        $rowBorder = '';
        foreach ($this->columnWidth as $max) {
            $rowBorder .= sprintf('+%s', str_repeat('-', $max + ($this->padding * 2)));
        }
        return $rowBorder . '+' . PHP_EOL;
    }

    private function validate(array $data): void
    {
        if (empty($data)) {
            throw OutputTableException::emptyData();
        }

        $headerLn = count($data[0]);
        $maxWidth = [];
        foreach ($data as $row) {
            if (count($row) !== $headerLn) {
                throw OutputTableException::wrongDataCount();
            }

            foreach ($row as $key => $word) {
                $maxWidth[$key] = $maxWidth[$key] ?? 0;
                $word = (string) $word;
                $maxWidth[$key] = max(strlen($word), $maxWidth[$key]);
            }
            $last = count($maxWidth) - 1;
            $maxWidth[$last] = min($maxWidth[$last], self::MAX_COLUMN_WIDTH);
        }

        $this->columnWidth = $maxWidth;
    }
}
