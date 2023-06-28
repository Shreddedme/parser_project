<?php

namespace App\Interface;

interface DataUpdaterInterface
{
    public function getLasDataUpdate(): \DateTime;
    public function saveLastDataUpdate(\DateTime $dateTime): void;
}