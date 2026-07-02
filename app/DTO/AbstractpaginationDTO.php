<?php

namespace App\DTO;

abstract class AbstractpaginationDTO
{
    public array $data = [];
    public int $perPage = 10;
    public ?int $total = null;
    public ?int $totalPage = null;
    public ?int $pageNo = null;
    public ?array $additionalResult = [];

    public function __construct(
        array $data = [],
        int $perPage = 10,
        ?int $total = null,
        ?int $totalPage = null,
        ?int $pageNo = null,
        ?array $additionalResult = []
    ) {
        $this->perPage = $perPage;
        $this->total = $total;
        $this->totalPage = $totalPage;
        $this->pageNo = $pageNo;
        $this->data = $data;

        if (is_array($additionalResult)) {
            foreach ($additionalResult as $key => $value) {
                $this->$key = $value;
            }
        }
    }
}
