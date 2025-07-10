<?php

namespace App\Console\Commands;

use App\Models\Games;
use Spatie\Sitemap\Sitemap;
use Spatie\Sitemap\Tags\Url;
use Illuminate\Console\Command;

class GenerateSitemap extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'app:generate-sitemap';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Command description';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $sitemap = Sitemap::create();

        // 首页
        $sitemap->add(Url::create('/')
            ->setlastModificationDate(now())
            ->setChangeFrequency(Url::CHANGE_FREQUENCY_DAILY)
            ->setPriority(1.0));



        // about 页面
        $sitemap->add(Url::create('/about')
            ->setChangeFrequency(Url::CHANGE_FREQUENCY_MONTHLY)
            ->setPriority(0.8));

        // contact 页面
        $sitemap->add(Url::create('/contact')
            ->setChangeFrequency(Url::CHANGE_FREQUENCY_MONTHLY)
            ->setPriority(0.8));

        // privacy-policy 页面
        $sitemap->add(Url::create('/privacy-policy')
            ->setChangeFrequency(Url::CHANGE_FREQUENCY_MONTHLY)
            ->setPriority(0.8));

        // terms-of-service 页面
        $sitemap->add(Url::create('/terms-of-service')
            ->setChangeFrequency(Url::CHANGE_FREQUENCY_MONTHLY)
            ->setPriority(0.8));

        // Games 页面
        $sitemap->add(Url::create('/games')
            ->setChangeFrequency(Url::CHANGE_FREQUENCY_DAILY)
            ->setlastModificationDate(now())
            ->setPriority(0.8));

        Games::scopePublished()->chunk(100, function ($games) use ($sitemap) {
            foreach ($games as $game) {
                $sitemap->add(Url::create("/{$game->slug}")
                    ->setLastModificationDate($game->updated_at)
                    ->setChangeFrequency(Url::CHANGE_FREQUENCY_DAILY)
                    ->setPriority(0.8));
            }
        });

        // 生成 sitemap.xml 文件
        $sitemap->writeToFile(public_path('sitemap.xml'));
        $this->info('Sitemap generated successfully!');
    }
}
