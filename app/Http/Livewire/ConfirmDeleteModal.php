<?php

namespace App\Http\Livewire;

use Livewire\Component;

class ConfirmDeleteModal extends Component
{
    public $isOpen, $modelType, $modelId, $modelName, $postDeleteEventToEmit;

    protected $listeners = ['showDeleteConfirmModal' => 'open'];

    public function mount()
    {
        $this->isOpen = false;
        $this->clearModelInfo();
    }

    public function open($modelType, $id, $name = null, $postDeleteEventToEmit = null)
    {
        $this->isOpen = true;
        $this->modelType = $modelType;
        $this->modelId = $id;
        $this->modelName = $name;
        $this->postDeleteEventToEmit = $postDeleteEventToEmit;
    }

    public function close()
    {
        $this->isOpen = false;
        $this->clearModelInfo();
    }

    public function delete()
    {
        $model = 'App\\'. $this->modelType;
        $model::findOrFail($this->modelId)->delete();
        if ($this->postDeleteEventToEmit) { $this->emit($this->postDeleteEventToEmit); }
        $this->emit('alertMessageShow', $this->modelType. ' successfully deleted!');
        $this->close();
    }

    public function render()
    {
        return view('livewire.confirm-delete-modal');
    }

    private function clearModelInfo()
    {
        $this->modelType = null;
        $this->modelId = null;
        $this->modelName = null;
        $this->postDeleteEventToEmit = null;
    }
}
