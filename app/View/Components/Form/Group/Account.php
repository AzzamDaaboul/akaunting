<?php

namespace App\View\Components\Form\Group;

use App\Abstracts\View\Components\Form;
use App\Models\Banking\Account as Model;

class Account extends Form
{
    public $type = 'account';

    public $path;

    public $accounts;

    /** @var bool */
    public $hideCurrency;

    /** @var string */
    public $formGroupClass;

    /**
     * Create a new component instance.
     *
     * @return void
     */
    public function __construct(bool $hideCurrency = false, string $formGroupClass = 'sm:col-span-3') {
        $this->hideCurrency = $hideCurrency;
        $this->formGroupClass = $formGroupClass;
    }

    /**
     * Get the view / contents that represent the component.
     *
     * @return \Illuminate\Contracts\View\View|string
     */
    public function render()
    {
        if (empty($this->name)) {
            $this->name = 'account_id';
        }

        $this->path = route('modals.accounts.create');

        $this->accounts = $this->getAccounts();

        if (empty($this->selected) && empty($this->getParentData('model'))) {
            $this->selected = setting('default.account');
        }

        return view('components.form.group.account');
    }

    protected function getAccounts()
    {
        if ($this->hideCurrency) {
            return Model::enabled()->orderBy('name')->pluck('name', 'id');
        }

        return Model::enabled()->orderBy('name')->get()->pluck('title', 'id');
    }
}
