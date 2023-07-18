<?php

namespace App\Http\Livewire\Navigation;

use App\Models\Navitem;
use Livewire\Component;

class Navigation extends Component
{
    public $items;
    //variable que sera la lista de items del componente de navegacion
    public $openSlideover = false;
    //booleano de apertura del formulario de edicion
    public $addNewItem = false;

    protected $rules = [
        'items.*.label' => 'required|max:20',
        'items.*.link'  => 'required|max:40',
    ];
    //el asterisco es para simular un id dinamico

    protected $listeners = ['deleteItem'];


    public function mount()
    {
        $this->items = Navitem::all();
    }

    public function openSlide($addNewItem = false)
    {
        $this->addNewItem = $addNewItem;
        $this->openSlideover = true;
    }

    public function edit()
    {
        $this->validate();

        foreach ($this->items as $item) {
            $item->save();
        }

        $this->reset('openSlideover');
        // notify
        $this->dispatchBrowserEvent('notify', ['message' => __('Menu items updated successfully!')]);
    }

    public function deleteItem(Navitem $item)
    {
        $item->delete();
        $this->mount();
        $this->dispatchBrowserEvent('deleteMessage', ['message' => __('Menu item has been deleted.')]);
    }


    public function render()
    {
        return view('livewire.navigation.navigation');
    }
}
