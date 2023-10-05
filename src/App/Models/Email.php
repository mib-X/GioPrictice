<?php

declare(strict_types=1);

namespace App\Models;

use App\Enums\EmailStatus;
use Doctrine\DBAL\Exception;
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
        try {
            $queueStmt = $this->db->prepare(/** @lang text */'INSERT INTO emails (
                        subject,
                        email_status,
                        text_body,
                        html_body,
                        meta,
                        created_at) VALUES (?, ?, ?, ?, ?, NOW())');
        } catch (Exception $e) {
            echo $e->getMessage();
        }
        $meta['to'] = $to->toString();
        $meta['from'] = $from->toString();

        try {
            $queueStmt->executeStatement([$subject, EmailStatus::QUEUE, $text, $html, json_encode($meta)]);
        } catch (Exception $e) {
            echo $e->getMessage();
        }
    }

    public function findByEmailStatus(int $emailStatus): array
    {
        $result = $this->db->executeQuery(/** @lang text */'SELECT * FROM emails WHERE email_status = ?', [$emailStatus]);
        return $result->fetchAllAssociative();
    }
    public function markEmailSent(int $id): void
    {
        $stmt = $this->db->prepare(/** @lang text */'UPDATE emails SET sent_at=NOW(), email_status = ? WHERE id = ?');
        $stmt->executeStatement([EmailStatus::SENT, $id]);
    }
}
