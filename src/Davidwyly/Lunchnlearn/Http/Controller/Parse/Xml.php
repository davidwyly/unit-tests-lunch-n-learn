<?php

declare(strict_types=1);

namespace Davidwyly\Lunchnlearn\Http\Controller\Parse;

use SimpleXMLElement;

interface Xml
{
    public function parseXml(SimpleXMLElement $data): array;
}