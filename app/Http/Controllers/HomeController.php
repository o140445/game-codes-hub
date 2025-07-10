<?php

namespace App\Http\Controllers;

use AnourValar\EloquentSerialize\Service;
use Illuminate\Http\Request;
use App\Models\Games;
use App\Services\GameService;

class HomeController extends Controller
{
    public  $service;

    public function __construct(GameService $service)
    {
        $this->service = $service;
    }

    public function index()
    {
        $exclusion_ids = [];

        // 特别推荐
        $specialRecommendedGames = $this->getSpecialRecommended();
        $exclusion_ids[] = $specialRecommendedGames->id ?? null; // 如果有特别推荐游戏，则排除它的ID

        //推荐
        $recommendedGames = $this->getRecommended($exclusion_ids);
        $exclusion_ids = array_merge($exclusion_ids, $recommendedGames->pluck('id')->toArray()); // 将推荐游戏的ID添加到排除列表中

        // 最火 8条
        $hotGames = $this->getHotGames($exclusion_ids);
        // 最新 8条
        $newGames = $this->getNewGames();

        // 格式化
        $recommendedGames = $this->service->formatGames($recommendedGames);
        $specialRecommendedGames = $this->service->formatGames(collect([$specialRecommendedGames]))->first();
        $hotGames = $this->service->formatGames($hotGames);
        $newGames = $this->service->formatGames($newGames);

        // 合并数据
        $data = [
            'recommended' => $recommendedGames,
            'first' => $specialRecommendedGames,
            'hot' => $hotGames,
            'new' => $newGames,
        ];

        return view('home', compact('data'));
    }

    // 获取推荐
    public function getRecommended($exclusion_ids)
    {
        $key = 'recommended_games';
        $cachedGames = cache()->get($key);
        if ($cachedGames) {
            return $cachedGames;
        }

        $games = $this->service->getRecommendedGames(5, $exclusion_ids);

        cache()->put($key, $games, 60 * 60); // 缓存1小时
        return $games;
    }

    // 获取特别推荐 1 条
    public function getSpecialRecommended()
    {
        $key = 'special_recommended_games';
        $cachedGames = cache()->get($key);
        if ($cachedGames) {
            return $cachedGames;
        }

        $games =  $this->service->getSpecialRecommended();
        cache()->put($key, $games, 60 * 60 * 24); // 缓存1小时
        return $games;
    }

    // 获取最火游戏
    public function getHotGames($exclusion_ids)
    {
        $key = 'hot_games';
        $cachedGames = cache()->get($key);
        if ($cachedGames) {
            return $cachedGames;
        }

        $games = $this->service->getHotGames(8, $exclusion_ids);

        cache()->put($key, $games, 60 * 10); // 缓存30分钟
        return $games;
    }

    // 获取最新游戏
    public function getNewGames()
    {
        $key = 'new_games';
        $cachedGames = cache()->get($key);
        if ($cachedGames) {
            return $cachedGames;
        }

        $games = $this->service->getLatestGames(8);
        // 缓存24小时 但是后台更新就会删除缓存
        cache()->put($key, $games, 60 * 10); // 缓存10分钟
        return $games;
    }
}
