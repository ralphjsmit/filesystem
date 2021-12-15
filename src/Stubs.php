<?php

namespace RalphJSmit\Stubs;

class Stubs
{
    //    public static function copy(string $source, string $destinationFolder)
    //    {
    //        $basename = basename($source);
    //        $sourceFolder = dirname(__DIR__ . '/' . $source);
    //
    //        dump($basename);
    //        dump($sourceFolder);
    //        $contents = file_get_contents($sourceFolder . '/' . $basename);
    //
    //        file_put_contents($sourceFolder . $basename, $contents);
    //    }

    public static function file(string $filepath)
    {
        return $file = new File($filepath);
    }
}

