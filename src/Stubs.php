<?php

namespace RalphJSmit\Stubs;

class Stubs
{
    public function __construct(
        protected array $namespaces = []
    ) {}

    public static function file(string $filepath): File
    {
        return new File(
            $filepath
        );
    }

    public function getFile(string $filepath): File
    {
        return new File(
            $filepath,
            $this->namespaces
        );
    }

    public static function new(array $namespaces = []): static
    {
        return new static($namespaces);
    }

    public function namespaces(array $namespaces): static
    {
        $this->namespaces = array_merge(
            $this->namespaces,
            collect($namespaces)->mapWithKeys(function ($folder, $namespace) {
                return [$namespace => rtrim($folder, '/') . '/'];
            })->all()
        );

        return $this;
    }
}
