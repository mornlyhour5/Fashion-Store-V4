<?php

namespace App\DTO;

/**
 * @template T
 */

class PaginationDTO extends AbstractpaginationDTO {
    /**
     * @param array<int, T> $data
     */
    public function __construct(
        array $data = [],
        int $perPage = 10,
        ?int $total = null,
        ?int $totalPage = null,
        ?int $pageNo = null,
        ?array $additionalResult = []
    ){
        return parent::__construct($data, $perPage, $total, $totalPage, $pageNo, $additionalResult);
    }
}
