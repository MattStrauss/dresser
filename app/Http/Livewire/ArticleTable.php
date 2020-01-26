<?php

namespace App\Http\Livewire;

use App\Article;
use Illuminate\Support\Facades\Auth;
use Livewire\Component;
use Livewire\WithPagination;

class ArticleTable extends Component
{
    use withPagination;

    public $search = '';
    public $user;
    public $perPage = 5;
    public $sortField = 'name';
    public $sortAsc = true;

    protected $listeners = ['articlesUpdated' => 'updateArticles'];

    public function mount()
    {
        $this->user = Auth::user();
    }

    public function updatingSearch()
    {
        $this->gotoPage(1);
    }

    public function updatingPerPage()
    {
        $this->gotoPage(1);
    }

    public function updateArticles()
    {
        // rerender on update to articles...
    }

    public function sortBy($field)
    {
        if ($this->sortField === $field) {
            $this->sortAsc = ! $this->sortAsc;
        } else {
            $this->sortAsc = true;
        }
        $this->sortField = $field;
    }

    public function promptDeleteConfirm($id, $name)
    {
        $this->emit('showDeleteConfirmModal', 'Article', $id, $name, 'articlesUpdated');
    }


    public function render()
    {
        return view('livewire.article-table', [
            'articles' => $this->getArticles()
        ]);
    }

    private function getArticles()
    {
        return Article::query()
                      ->where('user_id', $this->user->id)
                      ->when($this->search !== '', function($q) {
                          return $q->where('name', 'like', '%'.$this->search.'%');
                      })
                      ->orderBy($this->sortField, $this->sortAsc ? 'asc' : 'desc')
                      ->paginate($this->perPage);
    }
}
