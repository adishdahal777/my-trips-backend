<?php

namespace Database\Seeders;

use App\Models\AppRating;
use App\Models\Destination;
use App\Models\FeatureCard;
use App\Models\LandingSection;
use App\Models\ProcessStep;
use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class LandingContentSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        LandingSection::updateOrCreate(['key' => 'features'], [
            'badge' => 'Features',
            'title' => 'Everything you need to<br>remember every journey',
            'subtitle' => 'From route mapping to expense tracking, MyTrips gives you the tools to document and share your adventures beautifully.',
        ]);

        LandingSection::updateOrCreate(['key' => 'how_it_works'], [
            'badge' => 'Simple process',
            'title' => 'Three steps to your<br>first trip story',
            'subtitle' => null,
        ]);

        LandingSection::updateOrCreate(['key' => 'social_showcase'], [
            'badge' => "And there's more",
            'title' => 'Social sharing<br>built right in.',
            'subtitle' => 'Publish your trips publicly and let others explore your adventures. Get likes, comments, and inspire fellow travelers from around the globe.',
        ]);

        LandingSection::updateOrCreate(['key' => 'testimonials'], [
            'badge' => 'Loved by travelers',
            'title' => 'What explorers say',
            'subtitle' => null,
        ]);

        if (FeatureCard::count() === 0) {
            $cards = [
                ['icon' => 'map-pin', 'color_key' => 'brand', 'title' => 'Route Mapping', 'description' => 'Plot every stop on your journey with interactive maps. See your path come alive with colored waypoints and distances.', 'position' => 1],
                ['icon' => 'credit-card', 'color_key' => 'coral', 'title' => 'Expense Tracking', 'description' => 'Log every rupee, dollar, or euro spent. Categorize expenses and watch your budget with smart AI-powered insights.', 'position' => 2],
                ['icon' => 'camera', 'color_key' => 'teal', 'title' => 'Photo Journal', 'description' => 'Capture geotagged photos at every destination. Build a visual story of your trip that lasts forever.', 'position' => 3],
                ['icon' => 'pen-line', 'color_key' => 'purple', 'title' => 'Trip Notes', 'description' => 'Write journal entries with mood tracking and color coding. Capture how you felt at every moment of your journey.', 'position' => 4],
            ];
            foreach ($cards as $card) {
                FeatureCard::create($card);
            }
        }

        if (ProcessStep::count() === 0) {
            $steps = [
                ['icon' => 'map-pin', 'color_key' => 'brand', 'title' => 'Create your trip', 'description' => 'Set your destination, dates, and budget. Add route stops to map out your journey from start to finish.', 'position' => 1],
                ['icon' => 'camera', 'color_key' => 'coral', 'title' => 'Capture moments', 'description' => 'Log expenses, snap photos, and write journal notes as you travel. Everything stays organized by date and location.', 'position' => 2],
                ['icon' => 'upload-cloud', 'color_key' => 'teal', 'title' => 'Share your story', 'description' => 'Publish your trip to the public feed or keep it private. Let the world see your adventure — or just your future self.', 'position' => 3],
            ];
            foreach ($steps as $step) {
                ProcessStep::create($step);
            }
        }

        if (Destination::count() === 0) {
            $destinations = [
                ['name' => 'Nepal', 'country' => 'Nepal', 'flag' => '🇳🇵', 'cover_image' => 'https://images.unsplash.com/photo-1544735716-392fe2489ffa?w=800&q=80', 'trip_count' => 342, 'is_featured' => true],
                ['name' => 'Bali', 'country' => 'Indonesia', 'flag' => '🇮🇩', 'cover_image' => 'https://images.unsplash.com/photo-1506929562872-bb421503ef21?w=600&q=80', 'trip_count' => 218, 'is_featured' => true],
                ['name' => 'Japan', 'country' => 'Japan', 'flag' => '🇯🇵', 'cover_image' => 'https://images.unsplash.com/photo-1528164344705-47542687000d?w=600&q=80', 'trip_count' => 189, 'is_featured' => true],
                ['name' => 'Dubai', 'country' => 'United Arab Emirates', 'flag' => '🇦🇪', 'cover_image' => 'https://images.unsplash.com/photo-1518684079-3c830dcef090?w=600&q=80', 'trip_count' => 156, 'is_featured' => true],
                ['name' => 'Switzerland', 'country' => 'Switzerland', 'flag' => '🇨🇭', 'cover_image' => 'https://images.unsplash.com/photo-1476514525535-07fb3b4ae5f1?w=600&q=80', 'trip_count' => 134, 'is_featured' => true],
                ['name' => 'Italy', 'country' => 'Italy', 'flag' => '🇮🇹', 'cover_image' => 'https://images.unsplash.com/photo-1516483638261-f4dbaf036963?w=600&q=80', 'trip_count' => 128, 'is_featured' => true],
            ];
            foreach ($destinations as $dest) {
                Destination::create([...$dest, 'status' => 'approved']);
            }
        }

        if (AppRating::count() === 0) {
            $testimonials = [
                ['name' => 'Aarav Sharma', 'email' => 'aarav.demo@mytrips.app', 'comment' => 'MyTrips completely changed how I document my travels. The route mapping feature is incredible — I can see every stop I\'ve ever made on a single map.'],
                ['name' => 'Priya Gurung', 'email' => 'priya.demo@mytrips.app', 'comment' => 'The expense tracker saved me so much hassle. I used to lose receipts and forget what I spent. Now everything is categorized automatically.'],
                ['name' => 'Sita Magar', 'email' => 'sita.demo@mytrips.app', 'comment' => 'I love the journal feature. Writing notes with moods and colors makes looking back at trips so much more emotional and meaningful.'],
            ];
            foreach ($testimonials as $t) {
                $user = User::firstOrCreate(
                    ['email' => $t['email']],
                    ['name' => $t['name'], 'password' => bcrypt(str()->random(32)), 'email_verified_at' => now()]
                );
                AppRating::updateOrCreate(['user_id' => $user->id], [
                    'stars' => 5,
                    'comment' => $t['comment'],
                    'is_featured' => true,
                ]);
            }
        }
    }
}
