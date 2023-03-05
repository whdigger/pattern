<?php

namespace App\Pattern\Behavioral\Command;
/**
 * Класс Очередь действует как Отправитель. Он складывает объекты команд в стек
 * и выполняет их поочерёдно. Если выполнение скрипта внезапно завершится,
 * очередь и все её команды можно будет легко восстановить, и вам не придётся
 * повторять все выполненные команды.
 *
 * Обратите внимание, что это очень примитивная реализация очереди команд,
 * которая хранит команды в локальной базе данных SQLite. Существуют десятки
 * надёжных реализаций очереди, доступных для использования в реальных
 * приложениях.
 */
class Queue
{
    private $db;

    public function __construct()
    {
        $this->db = new \SQLite3(__DIR__ . '/../../../../../data/commands.sqlite', SQLITE3_OPEN_CREATE | SQLITE3_OPEN_READWRITE);

        $this->db->query('CREATE TABLE IF NOT EXISTS commands (id INTEGER PRIMARY KEY NOT NULL,command TEXT,status INTEGER)');
    }

    public function isEmpty(): bool
    {
        $query = 'SELECT COUNT(id) FROM commands WHERE status = 0';

        return $this->db->querySingle($query) === 0;
    }

    public function add(Command $command): void
    {
        $query = 'INSERT INTO commands (command, status) VALUES (:command, :status)';
        $statement = $this->db->prepare($query);
        $statement->bindValue(':command', base64_encode(serialize($command)));
        $statement->bindValue(':status', $command->getStatus());
        $statement->execute();
    }

    public function getCommand(): Command
    {
        $query = 'SELECT * FROM commands WHERE status = 0 LIMIT 1';
        $record = $this->db->querySingle($query, true);
        $command = unserialize(base64_decode($record['command']));
        $command->id = $record['id'];

        return $command;
    }

    public function completeCommand(Command $command): void
    {
        $query = 'UPDATE commands SET status = :status WHERE id = :id';
        $statement = $this->db->prepare($query);
        $statement->bindValue(':status', $command->getStatus());
        $statement->bindValue(':id', $command->getId());
        $statement->execute();
    }

    public function work(): void
    {
        while (!$this->isEmpty()) {
            $command = $this->getCommand();
            $command->execute();
        }
    }

    /**
     * Для удобства объект Очереди является Одиночкой.
     */
    public static function get(): Queue
    {
        static $instance;
        if (!$instance) {
            $instance = new Queue();
        }

        return $instance;
    }
}