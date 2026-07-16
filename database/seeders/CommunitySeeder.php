<?php

namespace Database\Seeders;

use App\Models\Follow;
use App\Models\Trip;
use App\Models\User;
use App\Models\UserProfile;
use Illuminate\Database\QueryException;
use Illuminate\Database\Seeder;

class CommunitySeeder extends Seeder
{
    public function run(): void
    {
        $namedUsers = [
            ['name' => 'Swasti Chapagain', 'email' => 'fb.royaladish@gmail.com', 'bio' => 'Exploring Nepal one trail at a time 🏔️'],
            ['name' => 'Adish Dahal', 'email' => 'me.adishdahal@gmail.com', 'bio' => 'Builder of MyTrips. Traveler at heart.'],
        ];

        $firstNames = [
            'Sabin', 'Rojina', 'Bishal', 'Manisha', 'Prakash', 'Sunita', 'Dipesh', 'Anisha', 'Bikash', 'Sarita',
            'Nabin', 'Puja', 'Rabin', 'Milan', 'Rekha', 'Suman', 'Kabita', 'Ashok', 'Meena', 'Deepak',
            'Rina', 'Ramesh', 'Sujata', 'Bhim', 'Laxmi', 'Yubraj', 'Sushila', 'Krishna', 'Radha', 'Ganesh',
            'Parbati', 'Hari', 'Devi', 'Mohan', 'Kamala', 'Shyam', 'Gita', 'Bishnu', 'Maya', 'Narayan',
            'Durga', 'Keshab', 'Sarala', 'Tek', 'Bimala', 'Surya', 'Chandra', 'Indira', 'Madhav', 'Kalpana',
        ];

        $lastNames = [
            'Sharma', 'Gurung', 'Magar', 'Shrestha', 'Thapa', 'Tamang', 'Rai', 'Adhikari', 'Karki', 'Gharti',
            'Poudel', 'Koirala', 'Bhattarai', 'Basnet', 'Khadka', 'Yadav', 'Lama', 'Rana', 'Pandey', 'Regmi',
        ];

        // Names already used by PublicTripsSeeder's core travelers — skip to avoid duplicate accounts.
        $existingNames = [
            'Aarav Sharma', 'Priya Gurung', 'Sita Magar', 'Bibek Shrestha', 'Anjali Thapa',
            'Rajesh Tamang', 'Kritika Rai', 'Sagar Adhikari', 'Nisha Karki', 'Sunil Gharti',
        ];
        $usedNames = collect($existingNames)->merge(collect($namedUsers)->pluck('name'))->all();

        $fillerCount = 88;
        $fillerNames = [];
        foreach ($firstNames as $first) {
            foreach ($lastNames as $last) {
                $full = "{$first} {$last}";
                if (in_array($full, $usedNames, true) || in_array($full, $fillerNames, true)) {
                    continue;
                }
                $fillerNames[] = $full;
                if (count($fillerNames) >= $fillerCount) {
                    break 2;
                }
            }
        }

        $namedAccounts = collect($namedUsers)->map(function ($data) {
            $user = User::firstOrCreate(
                ['email' => $data['email']],
                ['name' => $data['name']]
            );

            if ($user->name !== $data['name']) {
                $user->update(['name' => $data['name']]);
            }

            UserProfile::firstOrCreate(
                ['user_id' => $user->id],
                ['bio' => $data['bio'], 'avatar' => UserProfile::DEFAULT_AVATAR, 'countries' => 3, 'km_traveled' => 4200]
            );

            return $user;
        });

        $fillerAccounts = collect($fillerNames)->map(function ($name) {
            $user = User::firstOrCreate(
                ['email' => strtolower(str_replace(' ', '.', $name)) . '@mytrips.demo'],
                ['name' => $name]
            );

            UserProfile::firstOrCreate(
                ['user_id' => $user->id],
                ['avatar' => UserProfile::DEFAULT_AVATAR]
            );

            return $user;
        });

        $coreTravelers = collect($existingNames)->map(
            fn ($name) => User::where('email', strtolower(str_replace(' ', '.', $name)) . '@mytrips.demo')->first()
        )->filter();

        $everyone = $coreTravelers->merge($namedAccounts)->merge($fillerAccounts)->values();

        $follow = function (User $follower, User $followee) {
            if ($follower->id === $followee->id) {
                return;
            }
            try {
                Follow::firstOrCreate(['follower_id' => $follower->id, 'followee_id' => $followee->id]);
            } catch (QueryException) {
                // race — already following
            }
        };

        // Everyone follows both named users, guaranteeing a strong follower base for the showcase accounts.
        foreach ($everyone as $user) {
            foreach ($namedAccounts as $named) {
                $follow($user, $named);
            }
        }

        // The named users follow each other and a broad, randomized slice of the community.
        foreach ($namedAccounts as $named) {
            foreach ($namedAccounts as $other) {
                $follow($named, $other);
            }
            foreach ($everyone->shuffle()->take(30) as $target) {
                $follow($named, $target);
            }
        }

        // General organic follow graph: every user follows a handful of random others.
        foreach ($everyone as $user) {
            $targets = $everyone->reject(fn ($u) => $u->id === $user->id)->shuffle()->take(rand(3, 8));
            foreach ($targets as $target) {
                $follow($user, $target);
            }
        }

        $this->seedShowcaseTrips($namedAccounts, $everyone);
    }

    private function seedShowcaseTrips($namedAccounts, $everyone): void
    {
        $nepalPhotos = [
            'photo-1544735716-392fe2489ffa',
            'photo-1526772662000-3f88f10405ff',
            'photo-1605640840605-14ac1855827b',
            'photo-1605649487212-47bdab064df7',
            'photo-1544620347-c4fd4a3d5957',
        ];

        $showcaseTrips = [
            [
                'name' => 'Weekend in Pokhara',
                'destination' => 'Pokhara, Nepal',
                'stops' => [['Lakeside', 28.2096, 83.9497], ['World Peace Pagoda', 28.2032, 83.9424]],
            ],
            [
                'name' => 'Kathmandu Heritage Walk',
                'destination' => 'Kathmandu, Nepal',
                'stops' => [['Durbar Square', 27.7040, 85.3070], ['Swayambhunath', 27.7149, 85.2903]],
            ],
        ];

        foreach ($namedAccounts as $ai => $account) {
            foreach ($showcaseTrips as $ti => $data) {
                if (Trip::where('user_id', $account->id)->where('name', $data['name'])->exists()) {
                    continue;
                }

                $trip = Trip::create([
                    'user_id' => $account->id,
                    'name' => $data['name'],
                    'destination' => $data['destination'],
                    'flag' => '🇳🇵',
                    'status' => 'completed',
                    'start_date' => now()->subDays(20 + $ti * 5),
                    'end_date' => now()->subDays(18 + $ti * 5),
                    'budget' => 25000,
                    'spent' => 18500,
                    'currency' => 'NPR',
                    'cover_photo' => "https://images.unsplash.com/{$nepalPhotos[($ai + $ti) % count($nepalPhotos)]}?w=800",
                    'description' => "A memorable trip to {$data['destination']}.",
                    'transport' => 'car',
                    'visibility' => 'public',
                    'privacy_photos' => true,
                    'privacy_notes' => true,
                    'privacy_expenses' => true,
                    'pref_purpose' => 'leisure',
                    'pref_accommodation' => 'hotel',
                    'pref_pace' => 'moderate',
                    'pref_food_priority' => 'local',
                ]);

                foreach ($data['stops'] as $pos => [$name, $lat, $lng]) {
                    $trip->routeStops()->create([
                        'label' => chr(65 + $pos),
                        'name' => $name,
                        'lat' => $lat,
                        'lng' => $lng,
                        'color' => $pos === 0 ? 'green' : 'coral',
                        'position' => $pos,
                    ]);
                }

                $trip->photos()->create([
                    'url' => "https://images.unsplash.com/{$nepalPhotos[$ai % count($nepalPhotos)]}?w=700",
                    'caption' => 'Golden hour over the valley',
                    'lat' => $data['stops'][0][1],
                    'lng' => $data['stops'][0][2],
                    'date' => now()->subDays(19 + $ti * 5),
                ]);

                $trip->notes()->create([
                    'title' => 'Great trip',
                    'body' => "Loved every moment of {$data['destination']} — already planning the next one.",
                    'mood' => '😍',
                    'date' => now()->subDays(19 + $ti * 5),
                    'color' => '#FFF3E0',
                ]);

                $trip->expenses()->create([
                    'description' => 'Hotel stay',
                    'amount' => 8000,
                    'currency' => 'NPR',
                    'date' => now()->subDays(19 + $ti * 5),
                    'category' => 'Accommodation',
                    'icon' => 'bed-outline',
                    'ai_suggested' => false,
                ]);

                $likers = $everyone->reject(fn ($u) => $u->id === $account->id)->shuffle()->take(rand(15, 40));
                foreach ($likers as $liker) {
                    $trip->likes()->firstOrCreate(['user_id' => $liker->id]);
                }

                $commenters = $everyone->reject(fn ($u) => $u->id === $account->id)->shuffle()->take(rand(2, 6));
                foreach ($commenters as $commenter) {
                    $trip->comments()->create([
                        'user_id' => $commenter->id,
                        'body' => 'Amazing trip, thanks for sharing!',
                    ]);
                }
            }
        }
    }
}
