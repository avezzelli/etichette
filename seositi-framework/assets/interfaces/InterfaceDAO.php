<?php

namespace seositiframework;

/**
 * Interfaccia di gestione delle funzioni DAO
 *
 * @author SeoSiti Developing Team
 */

interface InterfaceDAO {
   
    public function getArray(MyObject $o): array;
    public function getFomato(): array;
    public function getObj($item);
    public function save(MyObject $o): bool|int;
    public function getResults($where = null, $order = null): array|null;
    public function update(MyObject $o): int|bool|null;
    public function deleteByID($ID): bool;
    public function exists(MyObject $o): bool;
    public function search($query): array|null;
    public function getResultByID($ID);
    public function getArrayResult(array $resultQuery): array|null;    
}
