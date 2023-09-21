<?php

declare(strict_types=1);

namespace App\Models;

use App\Enums\EmailStatus;
use PDO;
use Symfony\Component\Mime\Address;

class Email extends Model
{
    public function queue(
        Address $to,
        Address $from,
        string $subject,
        string $html,
        ?string $text = null
    ): void {
        $queueStmt = $this->db->prepare('INSERT INTO emails (
                    subject,
                    email_status,
                    text_body,
                    html_body,
                    meta,
                    created_at) VALUES (?, ?, ?, ?, ?, NOW())');
        $meta['to'] = $to->toString();
        $meta['from'] = $from->toString();
        $queueStmt->execute([$subject, EmailStatus::QUEUE, $text, $html, json_encode($meta)]);
    }

    public function findByEmailStatus(int $emailStatus): array
    {
        $stmt = $this->db->prepare('SELECT * FROM emails WHERE email_status = ?');
        $stmt->execute([$emailStatus]);
        return $stmt->fetchAll(PDO::FETCH_OBJ);
    }
    public function markEmailSent(int $id): void
    {
        $stmt = $this->db->prepare('UPDATE emails SET sent_at=NOW(), email_status = ? WHERE id = ?');
        $stmt->execute([EmailStatus::SENT, $id]);
    }
}
