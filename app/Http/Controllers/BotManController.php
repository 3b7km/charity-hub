<?php

namespace App\Http\Controllers;

use App\Models\Campaign;
use BotMan\BotMan\BotMan;
use BotMan\BotMan\BotManFactory;
use BotMan\BotMan\Drivers\DriverManager;
use BotMan\Drivers\Web\WebDriver;

class BotManController extends Controller
{
    public function handle()
    {
        DriverManager::loadDriver(WebDriver::class);

        $botman = BotManFactory::create(config('botman.config'));

        // Simple replies
        $botman->hears('hello|hi|hey', function (BotMan $bot) {
            $bot->reply('Hello! How can I help you today? 👋 Try asking about "campaigns".');
        });

        $botman->hears('.*(campaign|campaigns|available campaigns|show campaigns).*', function (BotMan $bot) {
            $campaigns = Campaign::active()->take(3)->get();
            
            if ($campaigns->isEmpty()) {
                $bot->reply('There are currently no active campaigns. Please check back later!');
                return;
            }

            $reply = "Here are some of our active campaigns:<br><br>";
            foreach ($campaigns as $campaign) {
                $url = route('campaigns.show', $campaign->slug);
                $reply .= "🌟 <strong>{$campaign->title}</strong><br>";
                $reply .= "Goal: {$campaign->formatted_goal} | Raised: {$campaign->formatted_raised}<br>";
                $reply .= "<a href='{$url}' target='_top' style='color: #1a6b4a; text-decoration: underline; font-weight: bold;'>View Campaign Details</a><br><br>";
            }

            $bot->reply($reply);
        });

        $botman->hears('help', function (BotMan $bot) {
            $bot->reply('Sure! Ask me about "campaigns", or anything else and I\'ll do my best to help.');
        });

        $botman->fallback(function (BotMan $bot) {
            $bot->reply('Sorry, I didn\'t understand that. Try asking about "campaigns" or saying "help".');
        });

        $botman->listen();
    }
}
