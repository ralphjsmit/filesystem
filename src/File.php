<?php

namespace RalphJSmit\Stubs;

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

        $this->putInFolder($destinationPath, $contents);

        return new static(
            $destinationPath . '/' . $this->getBasename()
        );
    }

    public function getBasename(): string
    {
        return basename($this->filepath);
    }

    public function putFile(string $destinationPath, mixed $contents): static
    {
        if (! file_exists(dirname($destinationPath))) {
            mkdir(dirname($destinationPath), 0777, true);
        }

        file_put_contents($destinationPath, $contents);

        return new static($destinationPath);
    }

    public function putInFolder(string $destinationFolder, mixed $contents): static
    {
        return $this->putFile(rtrim($destinationFolder, '/') . '/' . $this->getBasename(), $contents);
    }

    public function move(string $destinationFolder): static
    {
        $newFile = $this->putFile(
            rtrim($destinationFolder, '/') . '/' . $this->getBasename(),
            $this->getContents()
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
}
