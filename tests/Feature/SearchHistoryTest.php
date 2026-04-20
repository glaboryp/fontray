<?php

namespace Tests\Feature;

use App\Models\User;
use App\Services\FontIdentificationService;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use Inertia\Testing\AssertableInertia as Assert;
use Mockery\MockInterface;
use Tests\TestCase;

class SearchHistoryTest extends TestCase
{
    use RefreshDatabase;

    public function test_authenticated_user_successful_identification_saves_search_history(): void
    {
        $user = User::factory()->create();
        Storage::fake('public');

        $this->mock(FontIdentificationService::class, function (MockInterface $mock) {
            $mock->shouldReceive('identify')
                ->once()
                ->andReturn([
                    'success' => true,
                    'fonts' => [
                        ['name' => 'Roboto', 'similarity' => 95],
                    ],
                    'total_found' => 1,
                ]);
        });

        $response = $this->actingAs($user)->postJson('/identify', [
            'image' => UploadedFile::fake()->create('history-auth.png', 100, 'image/png'),
        ]);

        $response->assertStatus(200);
        $response->assertJsonPath('success', true);

        $this->assertDatabaseCount('search_histories', 1);

        $saved = DB::table('search_histories')->first();

        $this->assertNotNull($saved);
        $this->assertSame($user->id, $saved->user_id);
        $this->assertIsString($saved->image_reference);
        $this->assertStringStartsWith('images/history/', $saved->image_reference);
        $this->assertTrue(Storage::disk('public')->exists($saved->image_reference));
        $this->assertSame(1, json_decode($saved->font_results, true)['total_found']);
    }

    public function test_guest_successful_identification_does_not_save_search_history(): void
    {
        $this->mock(FontIdentificationService::class, function (MockInterface $mock) {
            $mock->shouldReceive('identify')
                ->once()
                ->andReturn([
                    'success' => true,
                    'fonts' => [
                        ['name' => 'Roboto', 'similarity' => 95],
                    ],
                    'total_found' => 1,
                ]);
        });

        $response = $this->postJson('/identify', [
            'image' => UploadedFile::fake()->create('history-guest.png', 100, 'image/png'),
        ]);

        $response->assertStatus(200);
        $response->assertJsonPath('success', true);

        $this->assertDatabaseCount('search_histories', 0);
    }

    public function test_history_route_returns_only_current_user_history_entries(): void
    {
        $currentUser = User::factory()->create();
        $otherUser = User::factory()->create();

        DB::table('search_histories')->insert([
            [
                'user_id' => $currentUser->id,
                'image_reference' => 'mine-older.png',
                'font_results' => json_encode(['success' => true, 'total_found' => 1], JSON_THROW_ON_ERROR),
                'created_at' => now()->subMinutes(2),
                'updated_at' => now()->subMinutes(2),
            ],
            [
                'user_id' => $currentUser->id,
                'image_reference' => 'mine-newer.png',
                'font_results' => json_encode(['success' => true, 'total_found' => 2], JSON_THROW_ON_ERROR),
                'created_at' => now()->subMinute(),
                'updated_at' => now()->subMinute(),
            ],
            [
                'user_id' => $otherUser->id,
                'image_reference' => 'other-user.png',
                'font_results' => json_encode(['success' => true, 'total_found' => 3], JSON_THROW_ON_ERROR),
                'created_at' => now(),
                'updated_at' => now(),
            ],
        ]);

        $response = $this->actingAs($currentUser)->get('/history');

        $response->assertStatus(200);
        $response->assertInertia(fn (Assert $page) => $page
            ->component('HistoryDashboard')
            ->has('histories.data', 2)
            ->where('histories.data.0.image_reference', 'mine-newer.png')
            ->where('histories.data.0.image_url', null)
            ->where('histories.data.1.image_reference', 'mine-older.png')
            ->where('histories.data.1.image_url', null)
        );
    }

    public function test_history_route_exposes_renderable_image_url_only_for_safe_references(): void
    {
        $user = User::factory()->create();

        DB::table('search_histories')->insert([
            [
                'user_id' => $user->id,
                'image_reference' => 'images/history-safe.png',
                'font_results' => json_encode(['success' => true, 'total_found' => 1], JSON_THROW_ON_ERROR),
                'created_at' => now()->subMinute(),
                'updated_at' => now()->subMinute(),
            ],
            [
                'user_id' => $user->id,
                'image_reference' => 'history-raw-name.png',
                'font_results' => json_encode(['success' => true, 'total_found' => 1], JSON_THROW_ON_ERROR),
                'created_at' => now(),
                'updated_at' => now(),
            ],
        ]);

        $response = $this->actingAs($user)->get('/history');

        $response->assertStatus(200);
        $response->assertInertia(fn (Assert $page) => $page
            ->component('HistoryDashboard')
            ->has('histories.data', 2)
            ->where('histories.data.0.image_reference', 'history-raw-name.png')
            ->where('histories.data.0.image_url', null)
            ->where('histories.data.1.image_reference', 'images/history-safe.png')
            ->where('histories.data.1.image_url', asset('storage/images/history-safe.png'))
        );
    }

    public function test_history_route_returns_renderable_image_url_for_newly_stored_history_image_path(): void
    {
        $user = User::factory()->create();

        DB::table('search_histories')->insert([
            'user_id' => $user->id,
            'image_reference' => 'images/history/stored-entry.png',
            'font_results' => json_encode(['success' => true, 'total_found' => 4], JSON_THROW_ON_ERROR),
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        $response = $this->actingAs($user)->get('/history');

        $response->assertStatus(200);
        $response->assertInertia(fn (Assert $page) => $page
            ->component('HistoryDashboard')
            ->has('histories.data', 1)
            ->where('histories.data.0.image_reference', 'images/history/stored-entry.png')
            ->where('histories.data.0.image_url', asset('storage/images/history/stored-entry.png'))
        );
    }
}
