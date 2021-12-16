<?php

namespace RalphJSmit\Stubs;

use Illuminate\Support\Str;

class File
{
    public function __construct(
        public string $filepath
    ) {
    }

    public function copy(string $destinationPath): static
    {
        $contents = file_get_contents(
            $this->filepath
        );

        $this->putInFolder($contents, $destinationPath);

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
        if (! $destinationPath) {
            $destinationPath = $this->filepath;
        }

        if (! file_exists(dirname($destinationPath))) {
            mkdir(dirname($destinationPath), 0777, true);
        }

        file_put_contents($destinationPath, $contents);

        return new static($destinationPath);
    }

    public function putInFolder(mixed $contents, string $destinationFolder): static
    {
        return $this->putFile($contents, rtrim($destinationFolder, '/') . '/' . $this->getBasename());
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
}
