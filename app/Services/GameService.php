<?php

namespace App\Services;
use App\Models\Games;

class GameService
{
    /**
     * 获取游戏列表
     */
    public function getGameList($where, $order = 'id desc', $field = '*', $paginate = 10)
    {
        $query = Games::where($where)->orderByRaw($order)->selectRaw($field);

        if ($paginate) {
            return $query->paginate($paginate);
        }

        return $query->get();
    }

    /**
     * 获取游戏详情
     */
    public function getGameDetail($id, $field = '*')
    {
        return Games::where('id', $id)->selectRaw($field)->first();
    }


    /**
     * 获取游戏分类
     */
    public function getGameCategories()
    {
        return Games::select('category')->distinct()->pluck('category');
    }

    /**
     * 特别推荐游戏
     *
     */
    public function getSpecialRecommended()
    {
        return Games::where('is_special_recommend', 1)
            ->where('status', 1)
            ->orderByDesc('created_at')
            ->first(['id','name', 'slug', 'image', 'summary', 'views', 'updated_at']);
    }


    /**
     * 获取游戏推荐
     */
    public function getRecommendedGames($limit = 5, $exclusion_ids= [])
    {
        return Games::where('is_recommended', 1)
            ->where('status', 1)
            ->whereNotIn('id', $exclusion_ids)
            ->orderByDesc('created_at')
            ->limit($limit)
            ->get(['id','name', 'slug', 'image', 'summary', 'views', 'updated_at']);
    }
    /**
     * 获取游戏热门
     */
    public function getHotGames($limit = 8, $exclusion_ids= [])
    {
        return Games::where('status', 1)
            ->whereNotIn('id', $exclusion_ids)
            ->orderByDesc('views')
            ->limit($limit)
            ->get(['id','name', 'slug', 'image', 'summary', 'views', 'updated_at']);
    }

    /**
     * 获取最新游戏
     */
    public function getLatestGames($limit = 8)
    {
        return Games::where('status', 1)
            ->orderByDesc('created_at')
            ->limit($limit)
            ->get(['id', 'name', 'slug', 'image', 'summary', 'views', 'updated_at']);
    }

    /**
     * 格式话游戏数据
     */
    public function formatGames($games)
    {
        return $games->map(function ($game) {
            // 获取英文
            $date = date('F Y',  strtotime($game->updated_at));

            return [
                'name' => $game->name . ' (' . $date . ')',
                'slug' => $game->slug,
                'image' => 'storage/'.$game->image ,
                'summary' => $game->summary,
                'views' => $game->views,
                'update_date' => $this->formatDate($game->updated_at),
                'author' => $game->author ?? 'BabeDime',
            ];
        });
    }

    /**
     * 格式话游戏数据 数组
     */
    public function formatGamesArray($games)
    {
        return array_map(function ($game) {
            // 获取英文
            $date = date('F Y',  strtotime($game['updated_at']));

            return [
                'name' => $game['name'] . ' (' . $date . ')',
                'slug' => $game['slug'],
                'image' => 'storage/'.$game['image'],
                'summary' => $game['summary'],
                'description' => $game['description'] ?? '',
                'views' => $game['views'],
                'update_date' => $this->formatDate($game['updated_at']),
                'author' => $game['author'] ?? 'BabeDime',
            ];
        }, $games);
    }

    // 时间格式话
    public function formatDate($date)
    {
        $currentDate = time();
        $date = strtotime($date);

        $diff = $currentDate - $date;

        if ($diff < 86400) { // 小于24小时
            // 按小时
            $hours = floor($diff / 3600);
            if ($hours < 1) {
                return 'just now';
            } elseif ($hours < 2) {
                return 'an hour ago';
            } else {
                return $hours . ' hours ago';
            }
        } elseif ($diff < 86400 * 2) { // 小于48小时
            return 'yesterday ago';
        } elseif ($diff < 86400 * 30) {

            // 按天
            $days = floor($diff / 86400);
            if ($days < 2) {
                return 'a day ago';
            } else {
                return $days . ' days ago';
            }

        } else {
            return date('F j, Y', $date); // 返回格式化的日期
        }
    }
}
