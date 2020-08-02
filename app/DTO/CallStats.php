<?php

namespace App\DTO;

final class CallStats
{
    private $id;
    private $length;
    private $recordingUrl;

    public function __construct(int $id, string $length, string $recordingUrl)
    {
        $this->id = $id;
        $this->length = $length;
        $this->recordingUrl = $recordingUrl;
    }

    public function getId(): int
    {
        return $this->id;
    }

    public function getLength(): string
    {
        return $this->length;
    }

    public function getRecordingUrl(): string
    {
        return $this->recordingUrl;
    }

}
