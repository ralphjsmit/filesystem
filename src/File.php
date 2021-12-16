<?php

namespace RalphJSmit\Stubs;

use Illuminate\Support\Str;
use RalphJSmit\Stubs\Exceptions\NamespaceNotFoundException;

class File
{
    public function __construct(
        public string $filepath,
        protected array $namespaces = []
    ) {}

    public function copy(string $destinationPath): static
    {
        $this->putInFolder($destinationPath, $this->getContents());

        return new static(
            $destinationPath . '/' . $this->getBasename()
        );
    }

    public function getBasename(): string
    {
        return basename($this->filepath);
    }

    public function putFile(mixed $contents, string $destinationPath = null): static
    {
        if ( ! $destinationPath ) {
            $destinationPath = $this->filepath;
        }

        if ( ! file_exists(dirname($destinationPath)) ) {
            mkdir(dirname($destinationPath), 0777, true);
        }

        dump($destinationPath);
        file_put_contents($destinationPath, $contents);

        return new static($destinationPath);
    }

    public function putInFolder(string $destinationFolder, mixed $contents = null): static
    {
        return $this->putFile(
            $contents ?? $this->getContents(),
            rtrim($destinationFolder, '/') . '/' . $this->getBasename()
        );
    }

    public function move(string $destinationFolder): static
    {
        $newFile = $this->putFile(
            $this->getContents(),
            rtrim($destinationFolder, '/') . '/' . $this->getBasename()
        );

        $this->delete();

        return $newFile;
    }

    public function getContents(): string
    {
        return file_get_contents($this->filepath);
    }

    public function delete(): void
    {
        unlink($this->filepath);
    }

    public function replaceNamespace(string $namespace): static
    {
        $contents = $this->getContents();

        $contents = Str::replace(
            Str::of($contents)->after('namespace ')->before(';'),
            $namespace,
            $contents
        );

        return $this->putFile($contents);
    }

    public function namespace(string $namespace): static
    {
        $namespaceRoot = Str::of($namespace)->before('\\');
        $namespaceSubfolder = Str::of($namespace)->after('\\')->replace('\\', '/');

        $namespaceRootFolder = $this->namespaces[(string) $namespaceRoot] ?? throw new NamespaceNotFoundException();

        $target = $this->putInFolder($namespaceRootFolder . $namespaceSubfolder)
            ->replaceNamespace(Str::of($namespace));

        $this->delete();

        return $target;
    }
}
