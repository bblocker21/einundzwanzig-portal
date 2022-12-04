<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use App\Models\Category;
use App\Models\City;
use App\Models\Country;
use App\Models\Course;
use App\Models\Event;
use App\Models\Lecturer;
use App\Models\Participant;
use App\Models\Registration;
use App\Models\Team;
use App\Models\User;
use App\Models\Venue;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;
use Spatie\Permission\Models\Role;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     * @return void
     */
    public function run()
    {
        Role::create([
            'name'       => 'super-admin',
            'guard_name' => 'web',
        ]);
        $user = User::create([
            'name'              => 'Admin',
            'email'             => 'admin@einundzwanzig.space',
            'email_verified_at' => now(),
            'password'          => bcrypt('1234'),
            'remember_token'    => Str::random(10),
            'is_lecturer'       => true,
        ]);
        $team = Team::create([
            'name'          => 'Admin Team',
            'user_id'       => $user->id,
            'personal_team' => true,
        ]);
        $user->current_team_id = $team->id;
        $user->save();
        Country::create([
            'name' => 'Deutschland',
            'code' => 'de',
        ]);
        Country::create([
            'name' => 'Österreich',
            'code' => 'at',
        ]);
        Country::create([
            'name' => 'Schweiz',
            'code' => 'ch',
        ]);
        City::create([
            'country_id' => 1,
            'name'       => 'Füssen',
            'latitude'   => 47.57143,
            'longitude'  => 10.70171,
        ]);
        City::create([
            'country_id' => 1,
            'name'       => 'Kempten',
            'latitude'   => 47.728569,
            'longitude'  => 10.315784,
        ]);
        City::create([
            'country_id' => 1,
            'name'       => 'Pfronten',
            'latitude'   => 47.582359,
            'longitude'  => 10.5598,
        ]);
        City::create([
            'country_id' => 2,
            'name'       => 'Wien',
            'latitude'   => 48.20835,
            'longitude'  => 16.37250,
        ]);
        City::create([
            'country_id' => 3,
            'name'       => 'Zürich',
            'latitude'   => 47.41330,
            'longitude'  => 8.65639,
        ]);
        Venue::create([
            'city_id' => 1,
            'name'    => 'The Blue Studio Coworking (Füssen)',
            'street'  => 'Teststraße 1',
        ]);
        Venue::create([
            'city_id' => 2,
            'name'    => 'The Blue Studio Coworking (Kempten)',
            'street'  => 'Teststraße 2',
        ]);
        Venue::create([
            'city_id' => 3,
            'name'    => 'The Blue Studio Coworking (Pfronten)',
            'street'  => 'Teststraße 3',
        ]);
        Lecturer::create([
            'team_id' => 1,
            'name'    => 'Markus Turm',
            'active'  => true,
        ]);
        Lecturer::create([
            'team_id' => 1,
            'name'    => 'Beppo',
            'active'  => true,
        ]);
        $category = Category::create([
            'name' => 'Präsenzunterricht',
            'slug' => str('Präsenzunterricht')->slug('-', 'de'),
        ]);
        $categoryOnline = Category::create([
            'name' => 'Online-Kurs',
            'slug' => str('Online-Kurs')->slug('-', 'de'),
        ]);
        $course = Course::create([
            'lecturer_id' => 1,
            'name'        => 'Hands on Bitcoin',
        ]);
        $course->categories()
               ->attach($category);
        $course = Course::create([
            'lecturer_id' => 1,
            'name'        => 'Bitcoin <> Crypto',
        ]);
        $course->categories()
               ->attach($categoryOnline);
        $course = Course::create([
            'lecturer_id' => 2,
            'name'        => 'Bitcoin Lightning Network',
        ]);
        $course->categories()
               ->attach($categoryOnline);
        Participant::create([
            'first_name' => 'Roman',
            'last_name'  => 'Reher',
        ]);
        Event::create([
            'course_id' => 2,
            'venue_id'  => 1,
            'link'      => 'https://einundzwanzig.space',
            'from'      => now()
                ->addDays(14)
                ->startOfDay(),
            'to'        => now()
                ->addDays(14)
                ->startOfDay()
                ->addHour(),
        ]);
        Event::create([
            'course_id' => 1,
            'venue_id'  => 2,
            'link'      => 'https://einundzwanzig.space',
            'from'      => now()
                ->addDays(3)
                ->startOfDay(),
            'to'        => now()
                ->addDays(3)
                ->startOfDay()
                ->addHour(),
        ]);
        Event::create([
            'course_id' => 1,
            'venue_id'  => 3,
            'link'      => 'https://einundzwanzig.space',
            'from'      => now()
                ->addDays(4)
                ->startOfDay(),
            'to'        => now()
                ->addDays(4)
                ->startOfDay()
                ->addHour(),
        ]);
        Event::create([
            'course_id' => 3,
            'venue_id'  => 3,
            'link'      => 'https://einundzwanzig.space',
            'from'      => now()
                ->addDays(4)
                ->startOfDay(),
            'to'        => now()
                ->addDays(4)
                ->startOfDay()
                ->addHour(),
        ]);
        Registration::create([
            'event_id'       => 1,
            'participant_id' => 1,
        ]);
    }
}
