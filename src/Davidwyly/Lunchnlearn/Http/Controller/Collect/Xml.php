<?php

declare(strict_types=1);

namespace Davidwyly\Lunchnlearn\Http\Controller\Collect;

use Davidwyly\Lunchnlearn\Exception\ControllerException;
use SimpleXMLElement;

trait Xml
{
    /**
     * @return SimpleXMLElement
     * @throws ControllerException
     */
    protected function collectXml(): SimpleXMLElement
    {
        if (empty($this->request->post['xml'])) {
            throw new ControllerException("Empty XML in request", self::HTTP_CLIENT_ERROR);
        }
        return $this->request->post['xml'];
    }
}