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
            $newInvoiceStmt = $this->db->prepare(/** @lang text */ "INSERT INTO invoices (amount, user_id) 
                VALUES (?, ?)");
            $newInvoiceStmt->execute([$amount, $user_id]);
        } catch (Exception $e) {
            echo $e->getMessage();
        }
        $newInvoiceStmt = $this->db->prepare(/** @lang text */"INSERT INTO invoices (amount, user_id) 
                VALUES (?, ?)");
        $newInvoiceStmt->execute([$amount, $user_id]);
        return (int) $this->db->lastInsertId();
    }

    public function find(int $invoiceId): array
    {
        try {
            $selectStmt = $this->db->prepare(/** @lang text */
                'SELECT full_name, email, amount, invoices.id AS invoice_id
                FROM users
                INNER JOIN invoices
                on user_id = users.id
                WHERE invoices.id = ?'
            );
            $selectStmt->execute([$invoiceId]);
            $invoice = $selectStmt->fetch();
        } catch (Exception $e) {
            echo $e->getMessage();
        }
        return $invoice ?? [];
    }
    public function allByStatus(int $status = 0): array
    {
        try {
            $Stmt = $this->db->prepare(/** @lang text */'SELECT id, amount, status 
                FROM invoices
                WHERE status = ?');
            $Stmt->execute([$status]);
            $invoice = $Stmt->fetchAll(PDO::FETCH_ASSOC);
        } catch (Exception $e) {
            echo $e->getMessage();
        }
        return $invoice ?? [];
    }
    public function all(): array
    {
        try {
            $Stmt = $this->db->prepare(/** @lang text */'SELECT id, amount, status 
                FROM invoices');
            $Stmt->execute([]);
            $invoice = $Stmt->fetchAll(PDO::FETCH_ASSOC);
        } catch (Exception $e) {
            echo $e->getMessage();
        }
        return $invoice ?? [];
    }
}
