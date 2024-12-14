<?php

class DbConnection
{
    private PDO $pdo;

    public static array $priorities = ['Low', 'Medium', 'High'];
    public static array $statuses = ['Open', 'In Progress', 'Resolved'];

    public function __construct(string $dsn, string $username, string $password)
    {
        try {
            $this->pdo = new PDO($dsn, $username, $password);
            $this->pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            $this->pdo->setAttribute(PDO::ATTR_DEFAULT_FETCH_MODE, PDO::FETCH_ASSOC);

        } catch(PDOException $e) {
            die("Connection failed: " . $e->getMessage());
        }
    }

    // Hint : you may update this function add search / filter functionality
    public function getTickets(): array
    {
        $stmt = $this->pdo->query("SELECT * FROM tickets ORDER BY created_at DESC");
        $tickets = $stmt->fetchAll();

        return is_array($tickets) ? $tickets : [];
    }

    public function createTicket(string $title, string $description, string $priority): bool
    {
        if (empty($_POST['title']) || empty($_POST['description'])) {
            throw new InvalidArgumentException('Title and description cannot be empty');
        }

        if (!in_array($_POST['priority'], self::$priorities)) {
            throw new InvalidArgumentException('Invalid priority value');
        }

        $query = "INSERT INTO tickets (title, description, priority, status) VALUES (:title, :description, :priority, :status)";
        $stmt = $this->pdo->prepare($query);

        return $stmt->execute([
            'title' => $this->sanitizeString($title),
            'description' => $this->sanitizeString($description),
            'priority' => $priority,
            'status' => 'Open',
        ]);
    }

    function updateTicketStatus(string $status, string|int $ticket_id): bool
    {
        if (!in_array($_POST['status'], self::$statuses)) {
            throw new InvalidArgumentException('Invalid status value');
        }

        $stmt = $this->pdo->prepare("UPDATE tickets SET status = :status WHERE id = :id");
        return $stmt->execute([
            'status' => $status,
            'id' => $this->sanitizeInt($ticket_id),
        ]);
    }

    private function sanitizeString(string $input): string {
        // Remove HTML and PHP tags
        $sanitized = strip_tags($input);
        // Convert special characters to HTML entities
        $sanitized = htmlspecialchars($sanitized, ENT_QUOTES, 'UTF-8');
        // Remove any null bytes
        $sanitized = str_replace(chr(0), '', $sanitized);

        return $sanitized;
    }

    private function sanitizeInt(mixed $input): int {
        $sanitized = filter_var($input, FILTER_SANITIZE_NUMBER_INT);
        if ($sanitized === false || $sanitized === '') {
            throw new InvalidArgumentException('Invalid integer value');
        }
        return (int)$sanitized;
    }
}
