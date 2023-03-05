<?php

namespace App\Pattern\Behavioral\Command;
/**
 * Интерфейс Команды объявляет основной метод выполнения, а также несколько
 * вспомогательных методов для получения метаданных команды.
 */
interface Command
{
    public function execute(): void;

    public function getId(): int;

    public function getStatus(): int;
}