<?php

namespace RalphJSmit\Stubs;

class Stubs
{
    public function __construct(
        protected string $basepath = '',
        protected array $namespaces = [],
    ) {}

    public static function dir(string $basepath): static
    {
        return new static($basepath);
    }

    public static function file(string $filepath): File
    {
        return new File(
            filepath: $filepath,
        );
    }

    public function getBasepath(): string
    {
        return $this->basepath;
    }

    public function getFile(string $filepath): File
    {
        return new File(
            filepath  : $filepath,
            basepath  : $this->basepath,
            namespaces: $this->namespaces,
        );
    }

    public function getNamespaces(): array
    {
        return $this->namespaces;
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

    public static function new(array $namespaces = []): static
    {
        return new static(
            namespaces: $namespaces,
        );
    }
}
