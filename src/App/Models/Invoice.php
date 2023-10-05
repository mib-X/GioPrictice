<?php

declare(strict_types=1);

namespace App\Models;

use Exception;
use PDO;

class Invoice extends Model
{
    public function create(float $amount, int $user_id): int
    {
        try {
            $queryBuilder = $this->db->createQueryBuilder();
            $queryBuilder->insert('invoices')
                ->values([
                    'amount' => '?',
                    'user_id' => '?',
                ])
                ->setParameters([
                    '0' => $amount,
                    '1' => $user_id
                ]);
            $queryBuilder->executeQuery();
        } catch (Exception $e) {
            echo $e->getMessage();
        }
        return (int) $this->db->lastInsertId();
    }

    public function find(int $invoiceId): array
    {
        try {
            $sql = (/** @lang text */
                'SELECT full_name, email, amount, invoices.id AS invoice_id, invoices.status AS invoice_status
                FROM users
                INNER JOIN invoices
                on user_id = users.id
                WHERE invoices.id = ?'
            );
            $invoice = $this->db->executeQuery($sql, [$invoiceId])->fetchAssociative();
        } catch (Exception $e) {
            echo $e->getMessage();
        }
        return $invoice ?? [];
    }
    public function allByStatus(int $status = 0): array
    {
        try {
//            $stmt = $this->db->prepare('SELECT id, amount, status
//                FROM invoices
//                WHERE status = ?');
//
            $stmt = $this->db->executeQuery(/** @lang text */
                'SELECT id, amount, status 
                FROM invoices
                WHERE status = ?',
                [$status]
            );
            $invoice = $stmt->fetchAllAssociative();
        } catch (Exception $e) {
            echo $e->getMessage();
        }
        return $invoice ?? [];
    }
    public function all(): array
    {
        try {
            $Stmt = $this->db->createQueryBuilder()
                ->select('id', 'amount', 'status')
                ->from('invoices');
            $invoice = $Stmt->fetchAllAssociative();

        } catch (Exception $e) {
            echo $e->getMessage();
        }
        return $invoice ?? [];
    }
}
