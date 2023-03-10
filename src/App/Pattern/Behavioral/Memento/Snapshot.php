<?php

namespace App\Pattern\Behavioral\Memento;

class Snapshot
{
    public function __construct(private Editor $editor, private string $text, private string $curX, private string $curY, private string $selectionWidth)
    {
    }

    public function restore()
    {
        echo "Restore snapshot\n";
        $this->editor->setText($this->text);
        $this->editor->setCurX($this->curX);
        $this->editor->setCurY($this->curY);
        $this->editor->setSelectionWidth($this->selectionWidth);
    }
}