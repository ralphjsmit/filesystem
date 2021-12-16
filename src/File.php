<?php

namespace RalphJSmit\Stubs;

use Illuminate\Support\Str;
use RalphJSmit\Stubs\Exceptions\NamespaceNotFoundException;

class File
{
    public function __construct(
        public string $filepath,
        protected string $basepath = '',
        protected array $namespaces = [],
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

        if ( ! file_exists(dirname($this->basepath . $destinationPath)) ) {
            mkdir(dirname($this->basepath . $destinationPath), 0777, true);
        }

        file_put_contents($this->basepath . $destinationPath, $contents);

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
        return file_get_contents($this->basepath . $this->filepath);
    }

    public function delete(): void
    {
        unlink($this->basepath . $this->filepath);
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
        $namespaceSubfolder = Str::of($namespace)->after('\\')->replace('\\', '/');

        $namespaceRoot = $this->namespaces[Str::before($namespace, '\\')] ?? throw new NamespaceNotFoundException();
        $target = $this->putInFolder(
            $namespaceRoot . $namespaceSubfolder
        )->replaceNamespace(Str::of($namespace));

        $this->delete();

        return $target;
    }
}
