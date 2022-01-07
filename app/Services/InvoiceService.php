<?php

namespace App\Services;

use App\Repositories\Interfaces\InvoiceRepositoryInterface;

class InvoiceService extends BaseService
{
    public function __construct(InvoiceRepositoryInterface $repository)
    {
        parent::__construct($repository);
    }

    public function saveInvoice($validatedData)
    {
       $newInvoice = $this->repository->create($validatedData);
       $newInvoice->products()->sync($validatedData['product_id']);
       return $newInvoice;
}
    public function updateInvoice($validatedData, $invoiceId)
    {
        $this->repository->update($invoiceId, $validatedData);
        $invoice = $this->repository->findById($invoiceId);
        $invoice->products()->sync($validatedData['product_id']);
        return $invoice;
    }
    public function deleteInvoice(int $invoiceId)
    {
        $this->repository->deleteById($invoiceId);
        return true;
    }
}
