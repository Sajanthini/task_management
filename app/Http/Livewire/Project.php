<?php

namespace App\Http\Livewire;

use App\Models\Project as ProjectModel;
use Livewire\Component;
use Livewire\WithPagination;

class Project extends Component
{
    use WithPagination;
    public $name;

    protected $rules = [
        'name' => 'required|min:6',
    ];

    public function store()
    {
        $this->validate();
        ProjectModel::create(['name' => $this->name, 'user_id' => auth()->id()]);
        $this->reset();
        session()->flash('message', 'Project Created');
    }

    public function render()
    {
        return view('livewire.project', [
            'projects' => ProjectModel::with('user')->paginate(15)
        ]);
    }
}
