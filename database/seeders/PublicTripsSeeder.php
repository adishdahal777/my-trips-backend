<?php

namespace Database\Seeders;

use App\Models\Trip;
use App\Models\User;
use Illuminate\Database\Seeder;

class PublicTripsSeeder extends Seeder
{
    public function run(): void
    {
        $travelers = collect([
            'Aarav Sharma', 'Priya Gurung', 'Sita Magar', 'Bibek Shrestha', 'Anjali Thapa',
            'Rajesh Tamang', 'Kritika Rai', 'Sagar Adhikari', 'Nisha Karki', 'Sunil Gharti',
        ])->map(fn ($name) => User::firstOrCreate(
            ['email' => strtolower(str_replace(' ', '.', $name)) . '@mytrips.demo'],
            ['name' => $name]
        ));

        $expensePool = [
            ['category' => 'Food', 'icon' => '🍜', 'items' => ['Dal bhat set', 'Momo tasting', 'Tea house breakfast', 'Sel roti & tea', 'Yak cheese platter']],
            ['category' => 'Transport', 'icon' => '🚌', 'items' => ['Local bus fare', 'Jeep hire', 'Domestic flight', 'Porter fee', 'Taxi to airport']],
            ['category' => 'Accommodation', 'icon' => '🏨', 'items' => ['Tea house lodge', 'Lakeside guesthouse', 'Homestay night', 'Hotel in Thamel', 'Jungle resort']],
            ['category' => 'Activities', 'icon' => '🎭', 'items' => ['Trekking permit (TIMS)', 'ACAP entry fee', 'Jungle safari', 'Paragliding flight', 'Monastery visit']],
            ['category' => 'Shopping', 'icon' => '🛍️', 'items' => ['Pashmina shawl', 'Singing bowl', 'Khukuri souvenir', 'Handwoven scarf']],
        ];

        $noteBank = [
            ['title' => 'Best dal bhat yet', 'body' => "Found a tiny tea house past the ridge that refills your plate as many times as you want — exactly what we needed after that climb.", 'mood' => '😍', 'color' => '#FFF3E0'],
            ['title' => 'Getting around', 'body' => "Local buses are packed but cheap and honestly part of the experience. Jeep share is worth it once the road gets rough.", 'mood' => '😊', 'color' => '#E8F5E9'],
            ['title' => 'Hidden viewpoint', 'body' => 'Woke up at 4am to catch the sunrise over the peaks — completely empty and the light on the snow was unreal.', 'mood' => '🤩', 'color' => '#E3F2FD'],
            ['title' => 'Packing note', 'body' => 'Weather flips fast up here. Down jacket, good boots, and a headlamp saved the whole trek.', 'mood' => '🧳', 'color' => '#F3E5F5'],
            ['title' => 'Slow day in the village', 'body' => "Didn't plan anything today — just sat with tea and watched the prayer flags move. Best decision of the trip.", 'mood' => '🥰', 'color' => '#FCE4EC'],
        ];

        $photoCaptions = ['Golden hour over the peaks', 'Local market', 'Prayer flags on the ridge', 'View from the pass', 'Terraced fields', 'Tea house lunch', 'Sunset over the valley', 'Morning fog on the lake'];

        $commentBank = [
            'Looks amazing! Adding this to my list.',
            'The photos are incredible, how long did the trek take?',
            "I've been wanting to do this route — any tips on the best season?",
            'This just made it to the top of my travel wishlist.',
            'Following your route for our trip next month!',
            'That view from the pass is unbelievable.',
        ];

        // Verified-live Unsplash photo IDs, checked for real Nepal/Himalaya subject matter.
        $nepalPhotos = [
            'photo-1544735716-392fe2489ffa', // Everest region with stupa
            'photo-1526772662000-3f88f10405ff', // trekker overlooking the Himalaya
            'photo-1605640840605-14ac1855827b', // Boudhanath Stupa, Kathmandu
            'photo-1605649487212-47bdab064df7', // snowy Himalayan range
            'photo-1544620347-c4fd4a3d5957', // bus at a mountain pass
        ];

        $trips = [
            ['name' => 'Everest Base Camp Trek', 'destination' => 'Solukhumbu, Nepal', 'flag' => '🇳🇵', 'status' => 'completed', 'transport' => 'flight', 'stops' => [['Lukla', 27.6869, 86.7314], ['Namche Bazaar', 27.8069, 86.7140], ['Everest Base Camp', 28.0026, 86.8528]]],
            ['name' => 'Annapurna Circuit', 'destination' => 'Manang, Nepal', 'flag' => '🇳🇵', 'status' => 'ongoing', 'transport' => 'bus', 'stops' => [['Besisahar', 28.2333, 84.3667], ['Manang', 28.6667, 84.0167], ['Thorong La Pass', 28.7911, 83.9339]]],
            ['name' => 'Pokhara Lakeside Escape', 'destination' => 'Pokhara, Nepal', 'flag' => '🇳🇵', 'status' => 'completed', 'transport' => 'flight', 'stops' => [['Pokhara Airport', 28.2009, 83.9820], ['Phewa Lake', 28.2096, 83.9497], ['Sarangkot', 28.2380, 83.9530]]],
            ['name' => 'Chitwan Jungle Safari', 'destination' => 'Chitwan, Nepal', 'flag' => '🇳🇵', 'status' => 'completed', 'transport' => 'bus', 'stops' => [['Bharatpur', 27.6770, 84.4330], ['Sauraha', 27.5769, 84.5061], ['Chitwan National Park', 27.5291, 84.3542]]],
            ['name' => 'Kathmandu Valley Heritage Tour', 'destination' => 'Kathmandu, Nepal', 'flag' => '🇳🇵', 'status' => 'upcoming', 'transport' => 'car', 'stops' => [['Tribhuvan Airport', 27.6966, 85.3591], ['Boudhanath', 27.7215, 85.3620], ['Patan Durbar Square', 27.6727, 85.3247]]],
            ['name' => 'Lumbini Pilgrimage', 'destination' => 'Lumbini, Nepal', 'flag' => '🇳🇵', 'status' => 'completed', 'transport' => 'bus', 'stops' => [['Bhairahawa', 27.5058, 83.4160], ['Lumbini Garden', 27.4833, 83.2767], ['Kapilvastu', 27.5667, 83.0500]]],
            ['name' => 'Bandipur Hill Town Getaway', 'destination' => 'Bandipur, Nepal', 'flag' => '🇳🇵', 'status' => 'completed', 'transport' => 'car', 'stops' => [['Dumre', 27.9500, 84.4000], ['Bandipur Bazaar', 27.9350, 84.4083], ['Tundikhel Viewpoint', 27.9367, 84.4100]]],
            ['name' => 'Mustang Desert Trail', 'destination' => 'Mustang, Nepal', 'flag' => '🇳🇵', 'status' => 'ongoing', 'transport' => 'flight', 'stops' => [['Jomsom', 28.7807, 83.7259], ['Kagbeni', 28.8377, 83.7863], ['Lo Manthang', 29.1846, 83.9531]]],
            ['name' => 'Rara Lake Expedition', 'destination' => 'Mugu, Nepal', 'flag' => '🇳🇵', 'status' => 'completed', 'transport' => 'flight', 'stops' => [['Nepalgunj', 28.0500, 81.6167], ['Talcha Airport', 29.3167, 82.1833], ['Rara Lake', 29.5236, 82.0806]]],
            ['name' => 'Ilam Tea Garden Trail', 'destination' => 'Ilam, Nepal', 'flag' => '🇳🇵', 'status' => 'completed', 'transport' => 'bus', 'stops' => [['Kakarvitta', 26.6167, 88.1667], ['Ilam Bazaar', 26.9088, 87.9280], ['Mai Pokhari', 26.8628, 87.9273]]],
            ['name' => 'Janakpur Cultural Journey', 'destination' => 'Janakpur, Nepal', 'flag' => '🇳🇵', 'status' => 'upcoming', 'transport' => 'flight', 'stops' => [['Janakpur Airport', 26.7288, 85.9252], ['Janaki Mandir', 26.7271, 85.9247], ['Ram Sagar Pond', 26.7180, 85.9350]]],
            ['name' => 'Gosaikunda Sacred Lakes Trek', 'destination' => 'Rasuwa, Nepal', 'flag' => '🇳🇵', 'status' => 'completed', 'transport' => 'bus', 'stops' => [['Dhunche', 28.1000, 85.3000], ['Sing Gompa', 28.1333, 85.3167], ['Gosaikunda Lake', 28.0833, 85.4167]]],
            ['name' => 'Langtang Valley Trek', 'destination' => 'Langtang, Nepal', 'flag' => '🇳🇵', 'status' => 'ongoing', 'transport' => 'bus', 'stops' => [['Syabrubesi', 28.1667, 85.3500], ['Lama Hotel', 28.1833, 85.4000], ['Kyanjin Gompa', 28.2167, 85.5667]]],
            ['name' => 'Bardia Wildlife Safari', 'destination' => 'Bardia, Nepal', 'flag' => '🇳🇵', 'status' => 'completed', 'transport' => 'flight', 'stops' => [['Nepalgunj', 28.0500, 81.6167], ['Thakurdwara', 28.3667, 81.3333], ['Bardia National Park', 28.4167, 81.3333]]],
            ['name' => 'Manaslu Circuit Trek', 'destination' => 'Gorkha, Nepal', 'flag' => '🇳🇵', 'status' => 'completed', 'transport' => 'bus', 'stops' => [['Machha Khola', 28.1167, 84.9667], ['Samagaon', 28.5667, 84.6167], ['Larkya La Pass', 28.6167, 84.5500]]],
        ];

        foreach ($trips as $i => $data) {
            $user = $travelers[$i % $travelers->count()];
            $numPhotos = 5 + ($i % 4);
            $numNotes = 2 + ($i % 3);
            $numExpenses = 6 + ($i % 5);
            $budget = 15000 + ($i * 3500) % 40000;
            $spent = (int) ($budget * (0.4 + (($i * 13) % 50) / 100));

            $trip = Trip::create([
                'user_id' => $user->id,
                'name' => $data['name'],
                'destination' => $data['destination'],
                'flag' => $data['flag'],
                'status' => $data['status'],
                'start_date' => now()->subDays(60 - $i * 4),
                'end_date' => now()->subDays(50 - $i * 4),
                'budget' => $budget,
                'spent' => $data['status'] === 'upcoming' ? 0 : $spent,
                'currency' => 'NPR',
                'cover_photo' => "https://images.unsplash.com/{$nepalPhotos[$i % count($nepalPhotos)]}?w=800",
                'description' => "An unforgettable journey through {$data['destination']}.",
                'transport' => $data['transport'],
                'visibility' => 'public',
                'privacy_photos' => $i % 5 !== 4,
                'privacy_notes' => $i % 3 !== 2,
                'privacy_expenses' => $i % 2 === 0,
                'pref_purpose' => ['leisure', 'adventure', 'cultural', 'relaxation'][$i % 4],
                'pref_accommodation' => ['hotel', 'airbnb', 'hostel', 'resort'][$i % 4],
                'pref_pace' => ['relaxed', 'moderate', 'packed'][$i % 3],
                'pref_food_priority' => ['local', 'finedining', 'mixed'][$i % 3],
            ]);

            foreach ($data['stops'] as $pos => [$name, $lat, $lng]) {
                $trip->routeStops()->create([
                    'label' => chr(65 + $pos),
                    'name' => $name,
                    'lat' => $lat,
                    'lng' => $lng,
                    'color' => $pos === 0 ? 'green' : ($pos === count($data['stops']) - 1 ? 'coral' : 'blue'),
                    'position' => $pos,
                ]);
            }

            for ($p = 0; $p < $numPhotos; $p++) {
                $stop = $data['stops'][$p % count($data['stops'])];
                $trip->photos()->create([
                    'url' => "https://images.unsplash.com/{$nepalPhotos[($i + $p) % count($nepalPhotos)]}?w=700",
                    'caption' => $photoCaptions[($i + $p) % count($photoCaptions)],
                    'lat' => $stop[1],
                    'lng' => $stop[2],
                    'date' => now()->subDays(55 - $i * 4 - $p),
                    'is_private' => $p === $numPhotos - 1 && $i % 4 === 0,
                ]);
            }

            for ($n = 0; $n < $numNotes; $n++) {
                $note = $noteBank[($i + $n) % count($noteBank)];
                $trip->notes()->create([
                    'title' => $note['title'],
                    'body' => $note['body'],
                    'mood' => $note['mood'],
                    'date' => now()->subDays(54 - $i * 4 - $n),
                    'color' => $note['color'],
                    'is_private' => $n === $numNotes - 1 && $i % 3 === 1,
                ]);
            }

            for ($e = 0; $e < $numExpenses; $e++) {
                $group = $expensePool[$e % count($expensePool)];
                $trip->expenses()->create([
                    'description' => $group['items'][$e % count($group['items'])],
                    'amount' => 200 + (($i + $e) * 170) % 2800,
                    'currency' => 'NPR',
                    'date' => now()->subDays(53 - $i * 4 - $e),
                    'category' => $group['category'],
                    'icon' => $group['icon'],
                    'ai_suggested' => $e % 2 === 0,
                    'is_private' => $e === $numExpenses - 1 && $i % 5 === 0,
                ]);
            }

            $others = $travelers->reject(fn ($t) => $t->id === $user->id)->shuffle();
            $likeCount = 3 + ($i * 5) % ($others->count() - 1);
            foreach ($others->take($likeCount) as $liker) {
                $trip->likes()->create(['user_id' => $liker->id]);
            }

            $commentCount = 1 + ($i % 4);
            foreach ($others->take($commentCount) as $ci => $commenter) {
                $trip->comments()->create([
                    'user_id' => $commenter->id,
                    'body' => $commentBank[($i + $ci) % count($commentBank)],
                ]);
            }
        }
    }
}
