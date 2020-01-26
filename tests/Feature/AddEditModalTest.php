<?php

namespace Tests\Feature;

use App\Article;
use App\Http\Livewire\AddEditModal;
use App\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Livewire\Livewire;
use Tests\TestCase;

class AddEditModalTest extends TestCase
{

    use RefreshDatabase;

    /** @test  */
    function it_is_closed_by_default()
    {
        Livewire::test(AddEditModal::class, false)
                ->assertSet('isOpen', false);
    }
    /** @test  */
    function it_can_toggle_display_of_its_button_on()
    {
        Livewire::test(AddEditModal::class, true)
                ->assertSee('Add Article');
    }

    /** @test  */
    function it_can_toggle_display_of_its_button_off()
    {
        Livewire::test(AddEditModal::class, false)
                ->assertDontSee('Add Article');
    }

    /** @test  */
    function it_defaults_to_add_mode()
    {
        Livewire::test(AddEditModal::class, false)
                ->assertSet('addOrEdit', 'Add');
    }

    /** @test  */
    function it_initializes_correct_default_article_properties()
    {
        Livewire::test(AddEditModal::class, false)
                ->assertSet('article', ['name' => null, 'type' => 'Shorts', 'color' => 'Black', 'size' => 'X-Small']);
    }

    /** @test */
    function it_can_open()
    {
        Livewire::test(AddEditModal::class, false)
                ->assertDontSee('Add Article')
                ->call('open')
                ->assertSee('Add Article')
                ->assertSet('isOpen', true);
    }

    /** @test */
    function it_defaults_to_add_mode_when_opened()
    {
        Livewire::test(AddEditModal::class, false)
                ->call('open')
                ->assertSet('addOrEdit', 'Add');
    }

    /** @test */
    function it_can_open_with_an_article_passed_as_a_parameter()
    {
        $article = factory(Article::class)->create(['name' => 'TestName', 'color' => 'Pink', 'size' => 'X-Large', 'type' => 'Pants']);

        Livewire::test(AddEditModal::class, false)
                ->call('open', $article)
                ->assertSet('article.name', 'TestName')
                ->assertSet('article.color', 'Pink')
                ->assertSet('article.size', 'X-Large')
                ->assertSet('article.type', 'Pants')
                ->assertSet('addOrEdit', 'Edit')
                ->assertSee('Edit Article');
    }

    /** @test */
    function it_can_close()
    {
        Livewire::test(AddEditModal::class, false)
                ->assertDontSee('Add Article')
                ->call('open')
                ->assertSee('Add Article')
                ->call('close')
                ->assertDontSee('Add Article')
                ->assertSet('isOpen', false)
                ->assertSet('article', ['name' => null, 'type' => 'Shorts', 'color' => 'Black', 'size' => 'X-Small']);
    }

    /** @test */
    function it_validates_missing_article_data()
    {
        Livewire::test(AddEditModal::class, false)
                ->call('open')
                ->set('article', ['name' => null, 'type' => 'Shorts', 'color' => 'Black', 'size' => 'X-Small'])
                ->call('submit')
                ->assertHasErrors('article.name')
                ->assertSee('The article.name field is required.');
    }

    /** @test */
    function it_clears_all_errors_when_close_method_is_called()
    {
        Livewire::test(AddEditModal::class, false)
                ->call('open')
                ->set('article', ['name' => null, 'type' => 'Shorts', 'color' => 'Black', 'size' => 'X-Small'])
                ->call('submit')
                ->assertHasErrors('article.name')
                ->assertSee('The article.name field is required.')
                ->call('close')
                ->assertHasNoErrors()
                ->assertDontSee('The article.name field is required.');
    }

    /** @test */
    function it_creates_a_new_article()
    {
        // required Auth user for below submit call
        $user = factory(User::class)->create();
        $this->actingAs($user);

        Livewire::test(AddEditModal::class, false)
                ->call('open')
                ->set('article', ['name' => 'New Article', 'type' => 'Shorts', 'color' => 'Black', 'size' => 'X-Small'])
                ->call('submit')
                ->assertHasNoErrors()
                ->assertSet('addOrEdit', 'Add')
                ->assertSet('article', ['name' => null, 'type' => 'Shorts', 'color' => 'Black', 'size' => 'X-Small'])
                ->assertEmitted('articlesUpdated')
                ->assertEmitted('alertMessageShow');

        $this->assertDatabaseHas('articles', ['name' => 'New Article', 'user_id' => $user->id]);
    }

    /** @test */
    function it_allows_edits_to_existing_articles()
    {
        // required Auth user for below submit call
        $user = factory(User::class)->create();
        $article = factory(Article::class)->create(['name' => 'Editable Article', 'color' => 'Pink', 'size' => 'X-Large', 'type' => 'Pants', 'user_id' => $user->id]);
        $this->actingAs($user);

        Livewire::test(AddEditModal::class, false)
                ->call('open', $article)
                ->set('article', ['name' => 'Newly Edited Article', 'type' => 'Shorts', 'color' => 'Black', 'size' => 'X-Small', 'id' => $article->id])
                ->call('submit')
                ->assertHasNoErrors()
                ->assertSet('addOrEdit', 'Edit')
                ->assertEmitted('articlesUpdated')
                ->assertEmitted('alertMessageShow');

        $this->assertDatabaseHas('articles', ['name' => 'Newly Edited Article', 'type' => 'Shorts', 'color' => 'Black', 'size' => 'X-Small', 'user_id' => $user->id]);
        $this->assertDatabaseMissing('articles', ['name' => 'Editable Article', 'color' => 'Pink', 'size' => 'X-Large', 'type' => 'Pants', 'user_id' => $user->id]);
    }

    /** @test */
    function it_does_not_allow_edits_to_articles_by_other_users()
    {
        // required Auth user for below submit call
        $user = factory(User::class)->create();
        $otherUser = factory(User::class)->create();
        $article = factory(Article::class)->create(['name' => 'Editable Article', 'color' => 'Pink', 'size' => 'X-Large', 'type' => 'Pants', 'user_id' => $user->id]);
        $this->actingAs($otherUser);

        Livewire::test(AddEditModal::class, false)
                ->call('open', $article)
                ->set('article', ['name' => 'Newly Edited Article', 'type' => 'Shorts', 'color' => 'Black', 'size' => 'X-Small', 'id' => $article->id, 'user_id' => $user->id])
                ->call('submit')
                ->assertForbidden();

        $this->assertDatabaseMissing('articles', ['name' => 'Newly Edited Article', 'type' => 'Shorts', 'color' => 'Black', 'size' => 'X-Small', 'user_id' => $user->id]);
        $this->assertDatabaseHas('articles', ['name' => 'Editable Article', 'color' => 'Pink', 'size' => 'X-Large', 'type' => 'Pants', 'user_id' => $user->id]);
    }
}
