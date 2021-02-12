<?php

declare(strict_types=1);

namespace Davidwyly\Lunchnlearn\Http\Controller\Parse;

use stdClass;

interface Json
{
    public function parseJson(stdClass $data): array;
}