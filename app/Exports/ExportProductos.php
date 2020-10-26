<?php

namespace App\Exports;

use App\Producto;
use Maatwebsite\Excel\Concerns\FromArray;

class ExportProductos implements FromArray
{
    protected $invoices;

    public function __construct(array $invoices)
    {
        $this->invoices = $invoices;
    }

    public function array(): array
    {
        return $this->invoices;
    }
}