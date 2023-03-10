<?php

namespace App\Pattern\Behavioral\Memento;
class Editor
{
    public function __construct(private string $text, private string $curX, private string $curY, private string $selectionWidth)
    {
    }
    /**
     * @param string $text
     */
    public function setText(string $text): void
    {
        $this->text = $text;
    }

    /**
     * @param string $curX
     */
    public function setCurX(string $curX): void
    {
        $this->curX = $curX;
    }

    /**
     * @param string $curY
     */
    public function setCurY(string $curY): void
    {
        $this->curY = $curY;
    }

    /**
     * @param string $selectionWidth
     */
    public function setSelectionWidth(string $selectionWidth): void
    {
        $this->selectionWidth = $selectionWidth;
    }

    public function createSnapshot(): Snapshot
    {
        echo "Create snapshot\n";
        return new Snapshot($this, $this->text, $this->curX, $this->curY, $this->selectionWidth);
    }
}