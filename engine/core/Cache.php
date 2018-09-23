<?php declare(strict_types=1);

namespace engine;

/**
 * Description of Cache
 *
 * @author sergey
 */
class Cache 
{
    use TSingletone;

    /**
     * 
     * @param string $key - unique name file
     * @param string $data
     * @param string $seconds
     * @return boolean
     */
    public function set($key, $data, $seconds = 3600){
        if($seconds){
            $content['data'] = $data;
            $content['end_time'] = time() + $seconds;
            if(file_put_contents(CACHE . '/' . md5($key) . '.txt', serialize($content))){
                return true;
            }
        }
        return false;
    }

    public function get($key){
        $file = CACHE . '/' . md5($key) . '.txt';
        if(file_exists($file)){
            $content = unserialize(file_get_contents($file));
            if(time() <= $content['end_time']){
                return $content;
            }
            unlink($file);
        }
        return false;
    }

    public function delete($key){
        $file = CACHE . '/' . md5($key) . '.txt';
        if(file_exists($file)){
            unlink($file);
        }
    }
}
