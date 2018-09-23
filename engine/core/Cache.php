<?php declare(strict_types=1);

namespace engine;

/**
 * Class Cache
 *
 * @author sergey
 */
class Cache 
{
    use TraitSingletone;

    /**
     * Set cache
     * 
     * @param string $key - unique name file
     * @param mixed $data
     * @param string $seconds
     * @return boolean
     */
    public function set($key, $data, $seconds = 3600): bool
    {
        if ($seconds) {
            $content['data'] = $data;
            $content['end_time'] = time() + $seconds;
            if (file_put_contents(CACHE . '/' . md5($key) . '.txt', serialize($content))) {
                return true;
            }
        }
        return false;
    }
    
    /**
     * Get cache data
     * 
     * @param string $key
     * @return boolean
     */
    public function get($key): bool
    {
        $file = CACHE . '/' . md5($key) . '.txt';
        if (file_exists($file)) {
            $content = unserialize(file_get_contents($file));
            if (time() <= $content['end_time']) {
                return $content;
            }
            unlink($file);
        }
        return false;
    }
    
    /**
     * Delete cache
     * 
     * @param string $key
     */
    public function delete($key): void
    {
        $file = CACHE . '/' . md5($key) . '.txt';
        if (file_exists($file)) {
            unlink($file);
        }
    }
}
