<?php

namespace App\Livewire;

use App\Models\Poll;
use Livewire\Component;

class CreatePoll extends Component
{ 
    public $title;
    public $options = ['First'];

    protected $rules = [
        'title' => 'required|min:3|max:255',
        'options' => 'required|array|min:1|max:10',
        'options.*' => 'required|min:1|max:255'
    ];
    //https://laravel-livewire.com/docs/2.x/input-validation#introduction
    protected $messages = [
        'options.*' => "the option can't be empty."
    ];
    //https://laravel-livewire.com/docs/2.x/input-validation#customize-error-message-and-attributes
    public function updated($propertyName)
    {
        $this->validateOnly($propertyName);
    }
    //https://laravel-livewire.com/docs/2.x/input-validation#real-time-validation


    public function render()
    {
        return view('livewire.create-poll');
    }

    public function addOption()
    {
        $this->options[] = '';
    }

    public function removeOption($index)
    {
        unset($this->options[$index]);//在 PHP 中，unset 函數用於刪除變數。
        $this->options = array_values($this->options);
    }

   

    public function createPoll()
    {
        $this->validate();
        //這個方法會根據您在組件中定義的 $rules 屬性來驗證表單數據

        Poll::create([
            'title' => $this->title
        ])->options()->createMany(
            collect($this->options)
            ->map(fn($option)=>['name' => $option])
            ->all()
        );
        // foreach($this->options as $optionName){
        //     $poll->options()->create(['name' =>$optionName]);
        // }
        $this->reset(['title','options']);

        $this->dispatch('pollCreated');
        //https://livewire.laravel.com/docs/events#dispatching-events
    }
}

