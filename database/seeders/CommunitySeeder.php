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
            [
                'name' => 'Swasti Chapagain',
                'email' => 'fb.royaladish@gmail.com',
                'bio' => 'Exploring Nepal one trail at a time 🏔️',
                'countries' => 2,
                'km_traveled' => 1850,
                'trips' => [
                    [
                        'name' => 'Weekend in Pokhara',
                        'destination' => 'Pokhara, Nepal',
                        'photo' => 'photo-1544735716-392fe2489ffa',
                        'stops' => [['Lakeside', 28.2096, 83.9497], ['World Peace Pagoda', 28.2032, 83.9424]],
                        'note' => "Woke up early for the sunrise over the Annapurna range from the pagoda — worth every step.",
                        'budget' => 18000,
                        'spent' => 12400,
                    ],
                    [
                        'name' => 'Chitwan Jungle Escape',
                        'destination' => 'Chitwan, Nepal',
                        'photo' => 'photo-1605649487212-47bdab064df7',
                        'stops' => [['Sauraha', 27.5769, 84.5061], ['Chitwan National Park', 27.5291, 84.3542]],
                        'note' => "Spotted a rhino on the jungle walk! Definitely doing the canoe ride again next time.",
                        'budget' => 22000,
                        'spent' => 19800,
                    ],
                ],
            ],
            [
                'name' => 'Adish Dahal',
                'email' => 'me.adishdahal@gmail.com',
                'bio' => 'Builder of MyTrips. Traveler at heart.',
                'countries' => 4,
                'km_traveled' => 6200,
                'trips' => [
                    [
                        'name' => 'Kathmandu Heritage Walk',
                        'destination' => 'Kathmandu, Nepal',
                        'photo' => 'photo-1605640840605-14ac1855827b',
                        'stops' => [['Durbar Square', 27.7040, 85.3070], ['Swayambhunath', 27.7149, 85.2903]],
                        'note' => "Spent the whole afternoon wandering Durbar Square — the woodwork on the temples is unreal.",
                        'budget' => 12000,
                        'spent' => 9100,
                    ],
                    [
                        'name' => 'Everest View Trek',
                        'destination' => 'Solukhumbu, Nepal',
                        'photo' => 'photo-1526772662000-3f88f10405ff',
                        'stops' => [['Lukla', 27.6869, 86.7314], ['Namche Bazaar', 27.8069, 86.7140]],
                        'note' => "Namche at sunset with the first real view of Everest in the distance — still can't believe it.",
                        'budget' => 45000,
                        'spent' => 38700,
                    ],
                ],
            ],
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

        // Deterministic, visually distinct avatar per user — pravatar.cc serves 70 unique real portraits.
        $avatarFor = fn (int $userId) => "https://i.pravatar.cc/300?img=" . (($userId % 70) + 1);

        $setDistinctAvatar = function (User $user, ?string $bio = null, array $extra = []) use ($avatarFor) {
            $profile = UserProfile::firstOrCreate(['user_id' => $user->id], []);

            // Don't clobber an avatar a real user already set for themselves via the app.
            if (! $profile->avatar || $profile->avatar === UserProfile::DEFAULT_AVATAR) {
                $profile->avatar = $avatarFor($user->id);
            }
            if ($bio && ! $profile->bio) {
                $profile->bio = $bio;
            }
            $profile->fill($extra);
            $profile->save();
        };

        $namedAccounts = collect($namedUsers)->map(function ($data) use ($setDistinctAvatar) {
            $user = User::firstOrCreate(
                ['email' => $data['email']],
                ['name' => $data['name']]
            );

            if ($user->name !== $data['name']) {
                $user->update(['name' => $data['name']]);
            }

            $setDistinctAvatar($user, $data['bio'], ['countries' => $data['countries'], 'km_traveled' => $data['km_traveled']]);

            return $user;
        });

        $fillerAccounts = collect($fillerNames)->map(function ($name) use ($setDistinctAvatar) {
            $user = User::firstOrCreate(
                ['email' => strtolower(str_replace(' ', '.', $name)) . '@mytrips.demo'],
                ['name' => $name]
            );

            $setDistinctAvatar($user);

            return $user;
        });

        $coreTravelers = collect($existingNames)->map(
            fn ($name) => User::where('email', strtolower(str_replace(' ', '.', $name)) . '@mytrips.demo')->first()
        )->filter();

        $coreTravelers->each(fn (User $user) => $setDistinctAvatar($user));

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

        $this->seedShowcaseTrips($namedUsers, $namedAccounts, $everyone);
    }

    private function seedShowcaseTrips(array $namedUsers, $namedAccounts, $everyone): void
    {
        // Earlier runs of this seeder gave both named accounts the exact same two trip
        // names/content — clean up the mismatched leftovers before reseeding distinct ones.
        $staleCrossNames = ['Weekend in Pokhara', 'Kathmandu Heritage Walk'];
        foreach ($namedAccounts as $ai => $account) {
            $ownNames = collect($namedUsers[$ai]['trips'])->pluck('name');
            Trip::where('user_id', $account->id)
                ->whereIn('name', $staleCrossNames)
                ->whereNotIn('name', $ownNames)
                ->delete();
        }

        foreach ($namedAccounts as $ai => $account) {
            $trips = $namedUsers[$ai]['trips'];

            foreach ($trips as $ti => $data) {
                // Delete and recreate rather than patch in place — guarantees the expense
                // breakdown below always matches `spent` exactly, even after reseeding.
                Trip::where('user_id', $account->id)->where('name', $data['name'])->delete();

                $trip = Trip::create([
                    'user_id' => $account->id,
                    'name' => $data['name'],
                    'destination' => $data['destination'],
                    'flag' => '🇳🇵',
                    'status' => 'completed',
                    'start_date' => now()->subDays(20 + $ai * 15 + $ti * 5),
                    'end_date' => now()->subDays(18 + $ai * 15 + $ti * 5),
                    'budget' => $data['budget'],
                    'spent' => $data['spent'],
                    'currency' => 'NPR',
                    'cover_photo' => "https://images.unsplash.com/{$data['photo']}?w=800",
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
                    'url' => "https://images.unsplash.com/{$data['photo']}?w=700",
                    'caption' => 'Golden hour over the valley',
                    'lat' => $data['stops'][0][1],
                    'lng' => $data['stops'][0][2],
                    'date' => now()->subDays(19 + $ai * 15 + $ti * 5),
                ]);

                $trip->notes()->create([
                    'title' => 'Great trip',
                    'body' => $data['note'],
                    'mood' => '😍',
                    'date' => now()->subDays(19 + $ai * 15 + $ti * 5),
                    'color' => '#FFF3E0',
                ]);

                // Expense line items must sum exactly to the trip's `spent` total — real usage keeps
                // these in sync (ExpenseController increments/decrements `spent` alongside each row),
                // so seed data that doesn't match makes the spending-insight numbers look "wrong".
                $breakdown = [
                    ['description' => 'Hotel stay', 'category' => 'Accommodation', 'icon' => 'bed-outline', 'share' => 0.45],
                    ['description' => 'Local food & dining', 'category' => 'Food', 'icon' => 'restaurant-outline', 'share' => 0.30],
                    ['description' => 'Local transport', 'category' => 'Transport', 'icon' => 'car-outline', 'share' => 0.25],
                ];
                $remaining = $data['spent'];
                foreach ($breakdown as $bi => $item) {
                    $amount = $bi === count($breakdown) - 1
                        ? $remaining
                        : (int) round($data['spent'] * $item['share']);
                    $remaining -= $amount;

                    $trip->expenses()->create([
                        'description' => $item['description'],
                        'amount' => $amount,
                        'currency' => 'NPR',
                        'date' => now()->subDays(19 + $ai * 15 + $ti * 5 - $bi),
                        'category' => $item['category'],
                        'icon' => $item['icon'],
                        'ai_suggested' => false,
                    ]);
                }

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
