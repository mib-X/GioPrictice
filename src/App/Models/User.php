<?php

declare(strict_types=1);

namespace App\Models;

use Exception;

class User extends Model
{
    public function create(string $email, string $name, bool $is_active = true): int
    {
        try {
            $newUserStmt = $this->db->prepare("INSERT INTO users (email, full_name, is_active, created_at) 
                VALUES (?, ?, ?, NOW())");
            $newUserStmt->executeStatement([$email, $name, $is_active]);
        } catch (Exception $e) {
            echo $e->getMessage();
        }
        return (int) $this->db->lastInsertId();
    }
}
