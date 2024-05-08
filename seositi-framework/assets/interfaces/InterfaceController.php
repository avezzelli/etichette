<?php

namespace seositiframework;

/**
 * Interfaccia di gestione delle funzioni Controller
 *
 * @author SeoSiti Developing Team
 */

interface InterfaceController {
    
    public function save(MyObject $o): bool;    

    public function update(MyObject $o): bool|int;

    public function delete(int $ID): bool;
    
    public function get(int $ID): MyObject|null;
    
}
