<div class="space-y-6">
    @if(session('status'))
        <span>
       {{session('status')}}
  </span>
    @endif
    <form wire:submit.prevent="addTask" class="flex items-center gap-4 bg-gray-50">
{{--  Prevent the default form submission (i.e., no full page reload).--}}
{{--  .lazy: Only updates the backend after input loses focus (on blur) to reduce requests.--}}
        <x-filament::input wire:model.lazy="title" placeholder="Enter a task..." class="w-full" />
 <x-filament::input wire:model.lazy="image" type="file"" />
        {{--   Type submit means it triggers the form’s wire:submit.--}}
        <x-filament::button type="submit">Add</x-filament::button>
    </form>

    <ul class="space-y-2">
{{--  space-y-6 (TailwindCSS) → vertical spacing between form and list of tasks.--}}
    @foreach ($tasks as $task)
{{--   $tasks is passed from the Livewire component via render() method.--}}
            <li class="flex items-center justify-between bg-gray-50 p-4 rounded shadow-sm">
                <div wire:key="{{ $task->id }}">
                <div class="{{ $task->is_done ? 'line-through text-gray-400' : '' }}">
                    {{ $task->title }}
                </div>
                </div>
                <div class="space-x-2">
                    <x-filament::button color="warning" wire:click="toggleTask({{ $task->id }})">
                        {{ $task->is_done ? 'Undo' : 'Done' }}
                    </x-filament::button>
                    <x-filament::button color="danger" wire:click="deleteTask({{ $task->id }})">
                        Delete
                    </x-filament::button>
                </div>
            </li>
        @endforeach
    </ul>
        <div class="mt-4 p-6">
            {{ $tasks->links() }}
        </div>
</div>

