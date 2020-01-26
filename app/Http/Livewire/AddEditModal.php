<?php

namespace App\Http\Livewire;

use App\Article;
use Illuminate\Support\Facades\Auth;
use Livewire\Component;

class AddEditModal extends Component
{
    public $addOrEdit, $isOpen, $article, $showButton;

    protected $listeners = ['showModal' => 'open', 'closeModal' => 'close'];

    public function mount($showButton)
    {
        $this->isOpen = false;
        $this->showButton = $showButton;
        $this->addOrEdit = 'Add';
        $this->initArticleDetails();
    }

    public function open($passedArticle = null)
    {
        $this->addOrEdit = 'Add';
        $this->isOpen = true;

        if ($passedArticle !== null) {
            $this->addOrEdit = 'Edit';
            $this->article = json_decode($passedArticle, true);
        }
    }

    public function close()
    {
        $this->isOpen = false;
        $this->initArticleDetails();
        $this->resetErrorBag();
    }

    public function submit()
    {
        $validatedData = $this->validate([
            'article.name' => 'required|min:3',
            'article.type' => 'required',
            'article.color' => 'required',
            'article.size' => 'required',
        ]);

        // remove outer 'article' array
        $validatedData = array_shift($validatedData);

        $user = Auth::user();

        // add required model attributes to validated array
        $validatedData['user_id'] = $this->article['user_id'] ?? $user->id;

        if ($validatedData['user_id'] !== $user->id) {
            abort(403, 'Unauthorized action.');
        }

        Article::updateOrCreate(['id' => $this->article['id'] ?? null], $validatedData);

        if ($this->addOrEdit === 'Add') {
           $this->initarticleDetails();
        }

        $this->emit('articlesUpdated');
        $this->emit('alertMessageShow', 'Articles successfully '. $this->addOrEdit. 'ed!', 2);

    }

    public function render()
    {
        $colors = Article::getColors();
        $sizes = Article::getSizes();
        $types= Article::getTypes();

        return view('livewire.add-edit-modal', compact('colors', 'sizes', 'types'));
    }


    private function initArticleDetails()
    {
        $this->article = [];
        $this->article['name'] = null;
        $this->article['type'] = "Shorts";
        $this->article['color'] = "Black";
        $this->article['size'] = "X-Small";
    }

}
