<?php

namespace App\Pattern\Behavioral\Command;
/**
 * Базовая Команда скрейпинга устанавливает базовую инфраструктуру загрузки,
 * общую для всех конкретных команд скрейпинга.
 */
abstract class WebScrapingCommand implements Command
{
    public $id;

    public $status = 0;

    /**
     * @var string URL для скрейпинга.
     */
    public $url;

    public function __construct(string $url)
    {
        $this->url = $url;
    }

    public function getId(): int
    {
        return $this->id;
    }

    public function getStatus(): int
    {
        return $this->status;
    }

    public function getURL(): string
    {
        return $this->url;
    }

    /**
     * Поскольку методы выполнения для всех команд скрейпинга очень похожи, мы
     * можем предоставить реализацию по умолчанию, позволив подклассам
     * переопределить её при необходимости.
     *
     * Шш! Наблюдательный читатель может обнаружить здесь другой поведенческий
     * паттерн в действии.
     */
    public function execute(): void
    {
        $html = $this->download();
        $this->parse($html);
        $this->complete();
    }

    public function download(): string
    {
        $html = file_get_contents($this->getURL());
        echo "WebScrapingCommand: Downloaded {$this->url}\n";

        return $html;
    }

    abstract public function parse(string $html): void;

    public function complete(): void
    {
        $this->status = 1;
        Queue::get()->completeCommand($this);
    }
}