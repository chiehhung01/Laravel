<?php

namespace App\Livewire;

use App\Models\Option;
use App\Models\Poll;
use Livewire\Component;

class Polls extends Component
{
    protected $listeners = [
        'pollCreated' => 'render'
    ];
    //定義了 Livewire 組件的監聽器（listeners）。當 Livewire 組件接收到名稱為 'pollCreated' 的事件時，
    //它會呼叫組件的 render 方法重新渲染組件。這個機制讓你可以在組件中處理其他組件發出的事件
    public function render()
    {
        $polls =Poll::with('options.votes')->latest()->get();
        return view('livewire.polls',['polls' => $polls]);
    }

    public function vote(Option $option)
    {
       $option->votes()->create();
    }
}
