<?php

namespace App\DTO;

final class CallStats
{
    private $id;
    private $length;
    private $recordingUrl;

    public function __construct($id, $length, $recordingUrl)
    {
        $this->id = $id;
        $this->length = $length;
        $this->recordingUrl = $recordingUrl;
    }

    public function getId()
    {
        return $this->id;
    }

    public function getLength()
    {
        return $this->length;
    }

    public function getRecordingUrl()
    {
        return $this->recordingUrl;
    }
}
