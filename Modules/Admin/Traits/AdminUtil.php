<?php

use Carbon\Carbon;

trait AdminUtil
{
    /**
     * Upload images
     *
     * @param Object $file
     * @param string $path
     * @return string $filePath
     */
    public function uploadImages($file, string $path)
    {
        $fileName = time() . '_' . $file->getClientOriginalName();
        return $file->storeAs($path . '/' . date('Y'), $fileName, 'public');
    }

    /**
     * Convert expression to slug
     *
     * @param string $expression
     * @param string $seprator
     * @return string $slug
     */
    public function createSlug(string $expression, string $seprator = '-')
    {
        // \x{0600}-\x{06FF} is the persian characters ranges
        $expression = preg_replace('/[^A-Za-z0-9\x{0600}-\x{06FF}-]+/u', $seprator, $expression);
        
        return trim($expression, $seprator);
    }

    /**
     * Make bytes readable
     *
     * @param integer $bytes
     * @param integer $precision
     * @return string
     */
    public function formatBytes(int $bytes, int $precision = 2)
    {
        $units = ['B','KB','MB','GB','TB','PB','EB','ZB','YB'];
        $step = 1024;
        $i = 0;

        while (($bytes / $step) > 0.9) {
            $bytes = $bytes / $step;
            $i++;
        }

        return round($bytes, $precision) . ' ' . $units[$i];
    }
}