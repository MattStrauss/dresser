<?php

namespace Tests\Feature;

use App\Article;

use App\Http\Livewire\ArticleTable;
use App\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Livewire\Livewire;
use Tests\TestCase;

class ArticleTableTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    function it_displays_all_articles_owned_by_user()
    {
        $user = factory(User::class)->create();
        $otherUser = factory(User::class)->create();

        factory(Article::class)->create(['name' => 'ABC', 'user_id' => $user->id]);
        factory(Article::class)->create(['name' => 'DEF', 'user_id' => $user->id]);
        factory(Article::class)->create(['name' => 'GHI', 'user_id' => $user->id]);
        factory(Article::class)->create(['name' => 'JKL', 'user_id' => $user->id]);
        factory(Article::class)->create(['name' => 'MNO', 'user_id' => $user->id]);
        factory(Article::class)->create(['name' => 'ZYX', 'user_id' => $otherUser->id]);

        $this->actingAs($user);

        Livewire::test(ArticleTable::class)
            ->assertSee('ABC')
            ->assertSee('DEF')
            ->assertSee('GHI')
            ->assertSee('JKL')
            ->assertSee('MNO')
            ->assertDontSee('ZYX');
    }

    /** @test */
    function it_sorts_by_all_fields_asc_and_desc()
    {
        $user = factory(User::class)->create();
        factory(Article::class, 5)->create(['user_id' => $user->id]);

        $this->actingAs($user);

        Livewire::test(ArticleTable::class)
            ->assertSet('sortField', 'name')
            ->assertSet('sortAsc', true)
            ->call('sortBy', 'name')
            ->assertSet('sortField', 'name')
            ->assertSet('sortAsc', false)
            ->call('sortBy', 'type')
            ->assertSet('sortField', 'type')
            ->assertSet('sortAsc', true)
            ->call('sortBy', 'type')
            ->assertSet('sortAsc', false)
            ->call('sortBy', 'color')
            ->assertSet('sortField', 'color')
            ->assertSet('sortAsc', true)
            ->call('sortBy', 'color')
            ->assertSet('sortAsc', false)
            ->call('sortBy', 'size')
            ->assertSet('sortField', 'size')
            ->assertSet('sortAsc', true)
            ->call('sortBy', 'size')
            ->assertSet('sortAsc', false);
    }

    /** @test */
    function it_displays_the_correct_number_of_articles_based_on_the_perPage_property()
    {
        $user = factory(User::class)->create();

        factory(Article::class)->create(['name' => 'ABC', 'user_id' => $user->id]);
        factory(Article::class)->create(['name' => 'DEF', 'user_id' => $user->id]);
        factory(Article::class)->create(['name' => 'GHI', 'user_id' => $user->id]);
        factory(Article::class)->create(['name' => 'JKL', 'user_id' => $user->id]);
        factory(Article::class)->create(['name' => 'MNO', 'user_id' => $user->id]); // 5

        factory(Article::class)->create(['name' => 'PQR', 'user_id' => $user->id]);
        factory(Article::class)->create(['name' => 'STU', 'user_id' => $user->id]);
        factory(Article::class)->create(['name' => 'VWX', 'user_id' => $user->id]);
        factory(Article::class)->create(['name' => 'YZA', 'user_id' => $user->id]);
        factory(Article::class)->create(['name' => 'YZB', 'user_id' => $user->id]); //10

        factory(Article::class)->create(['name' => 'YZC', 'user_id' => $user->id]);
        factory(Article::class)->create(['name' => 'YZD', 'user_id' => $user->id]);
        factory(Article::class)->create(['name' => 'YZE', 'user_id' => $user->id]);
        factory(Article::class)->create(['name' => 'YZF', 'user_id' => $user->id]);
        factory(Article::class)->create(['name' => 'YZG', 'user_id' => $user->id]);
        factory(Article::class)->create(['name' => 'YZH', 'user_id' => $user->id]);
        factory(Article::class)->create(['name' => 'YZI', 'user_id' => $user->id]);
        factory(Article::class)->create(['name' => 'YZJ', 'user_id' => $user->id]);
        factory(Article::class)->create(['name' => 'YZK', 'user_id' => $user->id]);
        factory(Article::class)->create(['name' => 'YZL', 'user_id' => $user->id]); // 20

        factory(Article::class)->create(['name' => 'YZM', 'user_id' => $user->id]); // 21

        $this->actingAs($user);

        Livewire::test(ArticleTable::class)
                ->assertSee('ABC')
                ->assertSee('MNO')
                ->assertDontSee('PQR')
                ->set('perPage', 10)
                ->assertSee('PQR')
                ->assertSee('YZB')
                ->assertDontSee('YZC')
                ->set('perPage', 20)
                ->assertSee('YZC')
                ->assertSee('YZL')
                ->assertDontSee('YZM')
                ->set('perPage', 10)
                ->assertSee('PQR')
                ->assertSee('YZB')
                ->assertDontSee('YZC')
                ->set('perPage', 5)
                ->assertSee('ABC')
                ->assertSee('MNO')
                ->assertDontSee('PQR');
    }

    /** @test */
    function it_displays_the_correct_articles_based_on_the_search_property()
    {
        $user = factory(User::class)->create();

        factory(Article::class)->create(['name' => 'ABC', 'user_id' => $user->id]);
        factory(Article::class)->create(['name' => 'DEF', 'user_id' => $user->id]);
        factory(Article::class)->create(['name' => 'GHI', 'user_id' => $user->id]);
        factory(Article::class)->create(['name' => 'JKL', 'user_id' => $user->id]);
        factory(Article::class)->create(['name' => 'MNO', 'user_id' => $user->id]);
        factory(Article::class)->create(['name' => 'PQR', 'user_id' => $user->id]);
        factory(Article::class)->create(['name' => 'STU', 'user_id' => $user->id]);
        factory(Article::class)->create(['name' => 'VWX', 'user_id' => $user->id]);
        factory(Article::class)->create(['name' => 'YAZ', 'user_id' => $user->id]);
        factory(Article::class)->create(['name' => 'YZA', 'user_id' => $user->id]);


        $this->actingAs($user);

        Livewire::test(ArticleTable::class)
                ->assertSee('ABC')
                ->assertSee('DEF')
                ->assertSee('GHI')
                ->assertSee('JKL')
                ->assertSee('MNO')
                ->assertDontSee('PQR')
                ->set('search', 'd')
                ->assertDontSee('ABC')
                ->assertSee('DEF')
                ->assertDontSee('GHI')
                ->assertDontSee('JKL')
                ->assertDontSee('MNO')
                ->set('search', 'k')
                ->assertDontSee('ABC')
                ->assertDontSee('DEF')
                ->assertDontSee('GHI')
                ->assertSee('JKL')
                ->assertDontSee('MNO')
                ->set('search', 't')
                ->assertDontSee('ABC')
                ->assertDontSee('DEF')
                ->assertDontSee('GHI')
                ->assertDontSee('JKL')
                ->assertDontSee('MNO')
                ->assertSee('STU')
                ->set('search', 'a')
                ->assertSee('ABC')
                ->assertDontSee('DEF')
                ->assertDontSee('GHI')
                ->assertDontSee('JKL')
                ->assertDontSee('MNO')
                ->assertSee('YAZ')
                ->assertSee('YZA');
    }

    /** @test */
    function it_prompts_a_delete_confirmation_through_an_emit_event()
    {
        $user = factory(User::class)->create();

        $article = factory(Article::class)->create(['name' => 'ABC', 'user_id' => $user->id]);

        $this->actingAs($user);

        Livewire::test(ArticleTable::class)
                ->call('promptDeleteConfirm', $article->id, $article->name)
                ->assertEmitted('showDeleteConfirmModal', 'Article', $article->id, $article->name, 'articlesUpdated');
    }


}
