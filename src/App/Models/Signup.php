<?php

declare(strict_types=1);

namespace App\Models;

use App\Models\User;
use App\Models\Invoice;

class Signup extends Model
{

    /**
     * Signup constructor.
     * @param User $userModel
     * @param Invoice $invoiceModel
     */
    public function __construct(protected User $userModel, protected Invoice $invoiceModel)
    {
        parent::__construct();
    }

    public function register(array $userInfo, array $InvoiceInfo): int
    {
        try {
            $this->db->beginTransaction();
            $userId = $this->userModel->create($userInfo['email'], $userInfo['name']);
            $invoiceId = $this->invoiceModel->create($InvoiceInfo['amount'], $userId);

            $this->db->commit();
        } catch (\Exception $e) {
                $this->db->rollBack();
                echo 'Something goes Wrong.  ' . $e->getMessage() . " Code: " . $e->getCode();
        }
        return $invoiceId;
    }
}