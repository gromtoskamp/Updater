<?php

namespace Groskampweb\Updater\Helper;

use Exception;

class AssetFetcher
{
    /**
     * @param $name
     * @return string
     * @throws Exception
     */
    public function getAssetHtml($name): string
    {
        $assetsFolder = $this->getSetupFolder() . '/assets/';

        if (!is_dir($assetsFolder)) {
            $pathHint = $this->getAssetFolderHint($assetsFolder);
            throw new Exception('No assets folder found. Please create an \'assets\' folder at ' . $pathHint);
        }

        $filePath = $assetsFolder . $name . '.html';

        if (!file_exists($filePath)) {
            $pathHint = $this->getAssetFileHint($filePath);
            throw new Exception('Asset file \'' . $name . '\' not found. please create your asset file at ' . $pathHint);
        }

        return file_get_contents($filePath);
    }

    /**
     * @return string
     * @throws Exception
     */
    private function getSetupFolder(): string
    {
        $updaterFilePathArray = explode('/', $this->getUpdaterFile());
        array_pop($updaterFilePathArray);

        $folderPath = '';
        foreach ($updaterFilePathArray as $key => $item) {
            $folderPath .= '/' . $item;

            if ($item === 'Setup') {
                return $folderPath;
            }
        }

        throw new Exception('Cannot find Setup folder, please call this tool from a Vendor/Module/Setup folder');
    }

    /**
     * @return string
     * @throws Exception
     */
    private function getUpdaterFile(): string
    {
        foreach (debug_backtrace() as $traceItem) {
            if (strpos($traceItem['file'], 'Groskampweb/Updater') === false) {
                return $traceItem['file'];
            }
        }

        throw new Exception('Not really sure what happened here, but something went wrong');
    }

    /**
     * @param string $path
     * @return string
     */
    private function getAssetFolderHint(string $path): string
    {
        return $this->getPathHint($path, 3);
    }

    /**
     * @param string $path
     * @return string
     */
    private function getAssetFileHint(string $path): string
    {
        return $this->getPathHint($path, 5);
    }

    /**
     * @param string $path
     * @param $length
     * @return string
     */
    private function getPathHint(string $path, $length): string
    {
        $pathItems = explode('/', $path);

        $offset = 0;
        foreach ($pathItems as $key => $pathItem) {
            if ($pathItem === 'Setup') {
                $offset = $key - 2;
                break;
            }
        }

        $splicedPathItems = array_splice($pathItems, $offset, $length);

        return implode('/' , $splicedPathItems) . '/';
    }
}
