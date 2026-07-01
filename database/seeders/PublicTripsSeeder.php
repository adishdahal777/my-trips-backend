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
            'Alex Rivera', 'Maya Chen', 'Sam Okafor', 'Priya Nair', 'Liam Park',
            'Sofia Petrov', 'James Whitfield', 'Elena Romero', 'Noah Kim', 'Aisha Bello',
        ])->map(fn ($name) => User::firstOrCreate(
            ['email' => strtolower(str_replace(' ', '.', $name)) . '@mytrips.demo'],
            ['name' => $name]
        ));

        $expensePool = [
            ['category' => 'Food', 'icon' => '🍜', 'items' => ['Street food tour', 'Local market breakfast', 'Rooftop dinner', 'Coffee & pastries', 'Night market snacks']],
            ['category' => 'Transport', 'icon' => '🚗', 'items' => ['Airport taxi', 'Car rental', 'Train tickets', 'Local bus pass', 'Scooter rental']],
            ['category' => 'Accommodation', 'icon' => '🏨', 'items' => ['Boutique hotel', 'Beachfront villa', 'Hostel dorm bed', 'Guesthouse stay', 'Mountain lodge']],
            ['category' => 'Activities', 'icon' => '🎭', 'items' => ['Guided city tour', 'Museum entry', 'Snorkeling trip', 'Sunset cruise', 'Hiking permit']],
            ['category' => 'Shopping', 'icon' => '🛍️', 'items' => ['Local souvenirs', 'Handmade textiles', 'Spice market haul', 'Postcards & prints']],
        ];

        $noteBank = [
            ['title' => 'Best local eats', 'body' => "Found a tiny family-run spot near the old town — ask for the daily special, it's never on the menu.", 'mood' => '😍', 'color' => '#FFF3E0'],
            ['title' => 'Getting around', 'body' => 'Public transport passes pay for themselves after day two. Download the offline map before you land.', 'mood' => '😊', 'color' => '#E8F5E9'],
            ['title' => 'Hidden viewpoint', 'body' => 'Climbed up before sunrise — completely empty and the light was unreal. Worth the early alarm.', 'mood' => '🤩', 'color' => '#E3F2FD'],
            ['title' => 'Packing note', 'body' => 'Weather flips fast here. Layers, a rain shell, and good shoes saved the whole trip.', 'mood' => '🧳', 'color' => '#F3E5F5'],
            ['title' => 'Slow day', 'body' => "Didn't plan anything today and it was the best decision. Wandered, napped, ate well.", 'mood' => '🥰', 'color' => '#FCE4EC'],
        ];

        $photoCaptions = ['Golden hour', 'Local market', 'Old town streets', 'View from the top', 'Coastline drive', 'Street food stall', 'Sunset over the water', 'Morning fog'];

        $commentBank = [
            'Looks amazing! Adding this to my list.',
            'The photos are incredible, how long were you there?',
            "I've been wanting to visit — any tips on when to go?",
            'This just made it to the top of my travel wishlist.',
            'Following your route for our trip next month!',
            'That view in photo two is unbelievable.',
        ];

        // Curated, verified-live Unsplash photo IDs per destination (images.unsplash.com/{id}).
        $trips = [
            ['name' => 'Summer in Bali', 'destination' => 'Bali, Indonesia', 'flag' => '🇮🇩', 'status' => 'completed', 'transport' => 'flight', 'currency' => 'USD', 'photos' => ['photo-1537996194471-e657df975ab4', 'photo-1552733407-5d5c46c3bb3b', 'photo-1518548419970-58e3b4079ab2'], 'stops' => [['Denpasar', -8.6705, 115.2126], ['Ubud', -8.5069, 115.2625], ['Uluwatu', -8.8291, 115.0849]]],
            ['name' => 'Tokyo Neon Nights', 'destination' => 'Tokyo, Japan', 'flag' => '🇯🇵', 'status' => 'ongoing', 'transport' => 'flight', 'currency' => 'USD', 'photos' => ['photo-1540959733332-eab4deabeeaf', 'photo-1513407030348-c983a97b98d8', 'photo-1503899036084-c55cdd92da26'], 'stops' => [['Narita', 35.7720, 140.3929], ['Shibuya', 35.6598, 139.7004], ['Shinjuku', 35.6938, 139.7036]]],
            ['name' => 'Road Trip Iceland', 'destination' => 'Reykjavik, Iceland', 'flag' => '🇮🇸', 'status' => 'completed', 'transport' => 'car', 'currency' => 'USD', 'photos' => ['photo-1490682143684-14369e18dce8', 'photo-1587595431973-160d0d94add1', 'photo-1580619305218-8423a7ef79b4'], 'stops' => [['Reykjavik', 64.1466, -21.9426], ['Vik', 63.4194, -19.0060], ['Jokulsarlon', 64.0784, -16.2306]]],
            ['name' => 'Backpacking Peru', 'destination' => 'Cusco, Peru', 'flag' => '🇵🇪', 'status' => 'ongoing', 'transport' => 'bus', 'currency' => 'USD', 'photos' => ['photo-1526392060635-9d6019884377', 'photo-1499856871958-5b9627545d1a', 'photo-1522093007474-d86e9bf7ba6f'], 'stops' => [['Cusco', -13.5320, -71.9675], ['Ollantaytambo', -13.2583, -72.2636], ['Machu Picchu', -13.1631, -72.5450]]],
            ['name' => 'Parisian Escape', 'destination' => 'Paris, France', 'flag' => '🇫🇷', 'status' => 'completed', 'transport' => 'train', 'currency' => 'EUR', 'photos' => ['photo-1502602898657-3e91760cbb34', 'photo-1550340499-a6c60fc8287c', 'photo-1529260830199-42c24126f198'], 'stops' => [['CDG Airport', 49.0097, 2.5479], ['Eiffel Tower', 48.8584, 2.2945], ['Montmartre', 48.8867, 2.3431]]],
            ['name' => 'Roman Holiday', 'destination' => 'Rome, Italy', 'flag' => '🇮🇹', 'status' => 'completed', 'transport' => 'flight', 'currency' => 'EUR', 'photos' => ['photo-1552832230-c0197dd311b5', 'photo-1489493887464-892be6d1daae', 'photo-1552550049-db097c9480d1'], 'stops' => [['Fiumicino', 41.8003, 12.2389], ['Colosseum', 41.8902, 12.4922], ['Trastevere', 41.8896, 12.4695]]],
            ['name' => 'NYC Long Weekend', 'destination' => 'New York, USA', 'flag' => '🇺🇸', 'status' => 'upcoming', 'transport' => 'flight', 'currency' => 'USD', 'photos' => ['photo-1496442226666-8d4d0e62e6e9', 'photo-1522083165195-3424ed129620', 'photo-1485871981521-5b1fd3805eee'], 'stops' => [['JFK Airport', 40.6413, -73.7781], ['Manhattan', 40.7831, -73.9712], ['Brooklyn', 40.6782, -73.9442]]],
            ['name' => 'Sydney & the Coast', 'destination' => 'Sydney, Australia', 'flag' => '🇦🇺', 'status' => 'completed', 'transport' => 'flight', 'currency' => 'USD', 'photos' => ['photo-1506973035872-a4ec16b8e8d9', 'photo-1523059623039-a9ed027e7fad', 'photo-1524293581917-878a6d017c71'], 'stops' => [['Sydney Airport', -33.9399, 151.1753], ['Bondi Beach', -33.8908, 151.2743], ['Blue Mountains', -33.7128, 150.3119]]],
            ['name' => 'Cape Town Adventure', 'destination' => 'Cape Town, South Africa', 'flag' => '🇿🇦', 'status' => 'completed', 'transport' => 'car', 'currency' => 'USD', 'photos' => ['photo-1571939228382-b2f2b585ce15', 'photo-1577948000111-9c970dfe3743', 'photo-1489749798305-4fea3ae63d43'], 'stops' => [['Cape Town Airport', -33.9715, 18.6021], ['Table Mountain', -33.9628, 18.4098], ['Cape Point', -34.3568, 18.4970]]],
            ['name' => 'Northern Lights Chase', 'destination' => 'Tromsø, Norway', 'flag' => '🇳🇴', 'status' => 'completed', 'transport' => 'flight', 'currency' => 'USD', 'photos' => ['photo-1531366936337-7c912a4589a7', 'photo-1483347756197-71ef80e95f73', 'photo-1520769669658-f07657f5a307'], 'stops' => [['Oslo', 60.1975, 11.1004], ['Tromsø', 69.6496, 18.9560], ['Lofoten Islands', 68.2340, 14.5680]]],
            ['name' => 'Thailand Island Hop', 'destination' => 'Phuket, Thailand', 'flag' => '🇹🇭', 'status' => 'ongoing', 'transport' => 'flight', 'currency' => 'USD', 'photos' => ['photo-1552465011-b4e21bf6e79a', 'photo-1573790387438-4da905039392', 'photo-1531572753322-ad063cecc140'], 'stops' => [['Phuket', 7.8804, 98.3923], ['Krabi', 8.0863, 98.9063], ['Koh Phi Phi', 7.7407, 98.7784]]],
            ['name' => 'Marrakech & the Desert', 'destination' => 'Marrakech, Morocco', 'flag' => '🇲🇦', 'status' => 'completed', 'transport' => 'car', 'currency' => 'EUR', 'photos' => ['photo-1489493887464-892be6d1daae', 'photo-1489749798305-4fea3ae63d43', 'photo-1531572753322-ad063cecc140'], 'stops' => [['Marrakech', 31.6295, -7.9811], ['Ait Ben Haddou', 31.0470, -7.1315], ['Merzouga Dunes', 31.0801, -4.0133]]],
            ['name' => 'Backpacking Vietnam', 'destination' => 'Hanoi, Vietnam', 'flag' => '🇻🇳', 'status' => 'ongoing', 'transport' => 'bus', 'currency' => 'USD', 'photos' => ['photo-1528127269322-539801943592', 'photo-1583417319070-4a69db38a482', 'photo-1528181304800-259b08848526'], 'stops' => [['Hanoi', 21.0278, 105.8342], ['Ha Long Bay', 20.9101, 107.1839], ['Hoi An', 15.8801, 108.3380]]],
            ['name' => 'Santorini Sunsets', 'destination' => 'Santorini, Greece', 'flag' => '🇬🇷', 'status' => 'completed', 'transport' => 'flight', 'currency' => 'EUR', 'photos' => ['photo-1570077188670-e3a8d69ac5ff', 'photo-1613395877344-13d4a8e0d49e', 'photo-1529260830199-42c24126f198'], 'stops' => [['Santorini Airport', 36.3992, 25.4793], ['Oia', 36.4618, 25.3753], ['Fira', 36.4163, 25.4319]]],
            ['name' => 'Patagonia Trek', 'destination' => 'Torres del Paine, Chile', 'flag' => '🇨🇱', 'status' => 'completed', 'transport' => 'flight', 'currency' => 'USD', 'photos' => ['photo-1464822759023-fed622ff2c3b', 'photo-1501785888041-af3ef285b470', 'photo-1587595431973-160d0d94add1'], 'stops' => [['Punta Arenas', -53.1638, -70.9171], ['Torres del Paine', -50.9423, -73.4068], ['Grey Glacier', -51.0253, -73.1811]]],
        ];

        foreach ($trips as $i => $data) {
            $user = $travelers[$i % $travelers->count()];
            $numPhotos = 5 + ($i % 4);
            $numNotes = 2 + ($i % 3);
            $numExpenses = 6 + ($i % 5);
            $budget = 1500 + ($i * 350) % 4000;
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
                'currency' => $data['currency'],
                'cover_photo' => "https://images.unsplash.com/{$data['photos'][0]}?w=800",
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
                    'url' => "https://images.unsplash.com/{$data['photos'][$p % count($data['photos'])]}?w=700",
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
                    'amount' => 8 + (($i + $e) * 17) % 280,
                    'currency' => $data['currency'],
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
