<?php

namespace App\Pattern\Behavioral\Memento;
class Command {
    private Snapshot $backup;

    public function __construct(private Editor $editor)
    {
    }

    public function makeBackup()
    {
        $this->backup = $this->editor->createSnapshot();
    }

    public function undo()
    {
        if ($this->backup != null) {
            $this->backup->restore();
        }
    }
}