<?php

namespace App\Http\Controllers;

use App\Traits\User;

class HomeController {

    use User;

    public function index(){
        
        $rowOneTiles = collect();
        $rowOneTiles->push([
            'route_name' => 'dashboard',
            'image' => 'tiles/my_dashboard.png',
            'alt' => 'Dashboard'
        ]);
        $rowOneTiles->push([
            'route_name' => 'member_guide',
            'image' => 'tiles/member_guide.png',
            'alt' => 'Member Guide'
        ]);
        $rowOneTiles->push([
            'route_name' => 'ranking',
            'image' => 'tiles/rankings.png',
            'alt' => 'Ranking'
        ]);
        $rowOneTiles->push([
            'route_name' => 'incentives',
            'image' => 'tiles/incentives.png',
            'alt' => 'Incentives'
        ]);

        $rowTwoTiles = collect();
        $rowTwoTiles->push([
            'route_name' => 'product_challenge',
            'image' => 'tiles/product_challenge.png',
            'alt' => 'Product Challenge'
        ]);
        $rowTwoTiles->push([
            'route_name' => 'guild',
            'image' => 'tiles/md_guild.png',
            'alt' => 'Guild'
        ]);
        $rowTwoTiles->push([
            'route_name' => 'jump_to_dealer',
            'target_blank' => true,
            'image' => 'tiles/nissan_doty.png',
            'alt' => 'Jump To Dealer'
        ]);
        $rowTwoTiles->push([
            'route_name' => 'calendar',
            'image' => 'tiles/calendar.png',
            'alt' => 'Calendar'
        ]);

        $trainingUrl = theme_config($this->getCurrentUser()->isMember() ? 'training_url_members' : 'training_url_region_HO');
        $rowThreeTiles = collect();
        $rowThreeTiles->push([
            'route_name' => null,
            'url' => $trainingUrl,
            'target_blank' => true,
            'image' => 'tiles/nissan_academy.png',
            'alt' => 'Nissan Academy'
        ]);
        $rowThreeTiles->push([
            'route_name' => theme_config('feature_further_sales') ? 'future_sales' : null,
            'url' => null,
            'image' => 'tiles/future_sales.png',
            'alt' => 'Futrue Sales'
        ]);
        $rowThreeTiles->push([
            'route_name' => null,
            'url' => $trainingUrl,
            'target_blank' => true,
            'image' => 'tiles/ce.png',
            'alt' => 'Customer Experience'
        ]);
        $rowThreeTiles->push([
            'route_name' => null,
            'url' => 'https://www.nissan.com.au/about-nissan/news-and-events.html',
            'target_blank' => true,
            'image' => 'tiles/whatsnew.png',
            'alt' => 'What "s New'
        ]);
        
        return view('home', ['rowTiles' => collect([$rowOneTiles, $rowTwoTiles, $rowThreeTiles])]);
    }
}
