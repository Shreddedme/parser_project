<?php

namespace App\Interface;

interface DataSaverInterface
{
    public function saveData(string $xmlFile): void;
}