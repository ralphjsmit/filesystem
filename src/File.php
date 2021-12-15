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
            "/Users/ralphjsmit/Library/Mobile Documents/com~apple~CloudDocs/Work/Development/Packages/stubs/tests/__fixtures__/demo-application/MoveFile.php"
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

    public function putFile(string $destinationPath, mixed $contents): string
    {
        file_put_contents($destinationPath, $contents);

        return $destinationPath;
    }

    public function putInFolder(string $destinationFolder, mixed $contents): string
    {
        return $this->putFile(rtrim($destinationFolder, '/') . '/' . $this->getBasename(), $contents);
    }
}
