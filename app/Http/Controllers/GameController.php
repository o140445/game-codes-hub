<?php

namespace App\Http\Controllers;

use App\Models\Games;
use App\Services\GameService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class GameController extends Controller
{

    public  $service;

    public function __construct(GameService $service)
    {
        $this->service = $service;
    }


    public function index(Request $request)
    {
        $query = Games::where('status', 1);

        // Search functionality
        if ($request->has('search') && $request->search) {
            $query->where('name', 'like', '%' . $request->search . '%')
                  ->orWhere('description', 'like', '%' . $request->search . '%');
        }

        // Filter by category
        if ($request->has('category') && $request->category) {
            $query->where('category', $request->category);
        }

        // Filter by platform
        if ($request->has('platform') && $request->platform) {
            $query->where('platform', $request->platform);
        }

        $page = $request->input('page', 1);

        $select = ['id', 'name', 'slug', 'image', 'summary', 'views', 'updated_at', 'category', 'platform', 'description'];

        $games = $query->orderByDesc('created_at')->paginate(20, $select, 'page', $page);

        // Format games
        $items = $this->service->formatGamesArray($games->items());

        $games->setCollection(collect($items));

        // Get unique categories and platforms for filters
        $categories = Games::where('status', 1)->distinct()->pluck('category')->filter();
        $platforms = Games::where('status', 1)->distinct()->pluck('platform')->filter();

        return view('games.index', compact('games', 'categories', 'platforms'));
    }

    public function show($slug)
    {
        $key = 'game_detail_' . $slug;
        $cachedGame = cache()->get($key);
        if (!$cachedGame) {
            $game = Games::where('slug', $slug)->where('status', 1)->firstOrFail();
            // Cache the game details for 10 minutes
            cache()->put($key, $game, 60 * 10);

        }else{
            $game = $cachedGame;
        }


        $related_key = 'related_games_' . $game->id;
        $relatedGames = cache()->get($related_key);
        if (!$relatedGames) {
            // Get related games from the database
            $relatedGames = Games::where('status', 1)
                ->where('id', '!=', $game->id)
                ->where('category', $game->category)
                ->whereNotNull('slug')
                ->where('slug', '!=', '')
                ->limit(8)
                ->get();

            // Format related games
            $relatedGames = $this->service->formatGames($relatedGames);

            // Cache the related games for 24 hours
            cache()->put($related_key, $relatedGames, 60 * 60 * 10);
        }

        // 判断兑换码总数
//        var_dump($game->total_codes);die;
        $game->codes = $game->codes()->where('status', 1)->orderByDesc('is_latest')->get();
        $game->invalidCodes = $game->codes()->where('status', 0)->orderByDesc('created_at')->get();

        $game->codes_total = count($game->codes) + count($game->invalidCodes);
        $game->codes_valid = count($game->codes);



        //图片
        if ($game->image) {
            $game->image = '/storage/' . $game->image;
        }



        // Increment views count
        $updated = Games::where('id', $game->id)
            ->update(['views' => $game->views + 1, 'updated_at' =>  DB::raw('updated_at')]);
        if ($updated) {
            // Update the cache with the new views count
            $game->views += 1;
//            cache()->put($key, $game, 60 * 60 * 10); // Cache for 24 hours
        }


        return view('games.show', compact('game', 'relatedGames'));
    }
}
