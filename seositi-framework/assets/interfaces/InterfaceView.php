<?php

namespace seositiframework;

/**
 * Interfaccia di gestione delle funzioni View
 *
 * @author SeoSiti Developing Team
 */

interface InterfaceView {
    
    public function listenerDetailsForm();

    public function printDetailsForm(int $ID): string;

    public function listenerSaveForm();

    public function printSaveForm(): string;
}
