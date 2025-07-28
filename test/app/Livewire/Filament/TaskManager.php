<?php
namespace App\Livewire\Filament;

use App\Models\Task;
use Livewire\Attributes\Validate;
use Livewire\Component;
use Filament\Notifications\Notification;
use Livewire\WithFileUploads;
use Livewire\WithPagination;

class TaskManager extends Component
{
    use WithPagination, WithFileUploads;
    //$title is two-way bound (wire:model) to the input field in your Blade file.
    //When the input changes in the browser, Livewire syncs the change to this variable using AlpineJS + AJAX.
//2-way binding means the data in the backend (PHP) and the data in the frontend (HTML/JS) are always kept in sync automatically.
    #[Validate('required|min:3')]
    public string $title = '';
public $image = [];
    public function addTask()
    {
        $this->validate();
foreach ($this->image as $image){
   $image->store('images', 'local');
}
        Task::create([
            'title' => $this->title,
        ]);
//Resets the input box (2-way bound via wire:model).
        $this->title = '';
        $this->image = [];
request()->session()->flash('status', 'done');

        Notification::make()
            ->title('Task added!')
            ->success()
            ->send();
    }

    public function toggleTask(Task $task)
    {
        //toggle operation.
        //The ! operator negates the current value.
        //If $task->is_done is true, this sets it to false.
        //If it's false, it sets it to true.
        $task->is_done = !$task->is_done;
        $task->save();
    }

    public function deleteTask(Task $task)
    {
        $task->delete();

        Notification::make()
            ->title('Task deleted!')
            ->danger()
            ->send();
    }
// Livewire render flow:
//On any state change, Livewire serializes public properties, sends them to the backend via AJAX, then runs render(), and finally updates the DOM with the new view using morphdom.
//morphdom updates the DOM by only changing what’s different
    public function render()
    {
        return view('livewire.filament.task-manager', [
            'tasks' => Task::latest()->paginate(2),
        ]);
    }
}
