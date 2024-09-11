<?php

namespace App\Services;


use App\Contracts\CounterContract;
use Illuminate\Contracts\Cache\Factory as Cache;
use Illuminate\Contracts\Session\Session;

class Counter implements CounterContract{
    private $timeout;
    private $cache;
    private $session;
    private $supportsTags;

    public function __construct(Cache $cache,Session $session, int $timeout){
        $this->timeout = $timeout;
        $this->cache = $cache;
        $this->session = $session;
        $this->supportsTags = method_exists($cache, 'tags');
        //method_exists($cache, 'tags') 檢查 $cache 實例是否具有名為 tags 的方法。
        //如果 tags 方法存在，method_exists 會返回 true，否則返回 false。
    }


    //PostsController cut paste
    public function increment(string $key, array $tags = null):int
    {
        $sessionId = $this->session->getId();
        $counterKey = "{$key}-counter";
        $usersKey = "{$key}-users";

        $cache = $this->supportsTags &&  $tags !== null
        ? $this->cache->tags($tags) :$this->cache;

        $users = $cache->get($usersKey,[]);
        //$sessiondId為users的key
        //如果 $usersKey 在緩存中存在，則返回相應的值（這裡是 $users 陣列）。
        //如果 $usersKey 在緩存中不存在，則返回默認值（這裡是一個空陣列 []）。
        $usersUpdate=[];
        $difference = 0;
        $now = now();
      
        //如果用戶過期，減少$difference
        foreach($users as $session =>$lastVist){
            if($now->diffInMinutes($lastVist) >= $this->timeout){
                $difference--;
            }else{
                $usersUpdate[$session] = $lastVist;
                
            }
        }
        
        //為新用戶:$sessionId不在$users內
        if(!array_key_exists($sessionId,$users)||
        $now->diffInMinutes($users[$sessionId])>= $this->timeout){
            $difference++;
        }
        

        $usersUpdate[$sessionId] = $now;
        $cache->forever($usersKey,$usersUpdate);
         
        if(!$cache->has($counterKey)){
            $cache->forever($counterKey,1);
        }else{
            $cache->increment($counterKey,$difference);
        }

        // dd($usersUpdate[$sessionId]);
        
        $counter = $cache->get($counterKey);
        
        return $counter;
    }
}
