<?php

namespace App\View\Components\Cms\Card;

use Illuminate\View\Component;

class CardConstructor extends Component
{
    /**
     * @var string|null
     */
    public $title;

    /**
     * @var bool|null
     */
    public $responsive;

    /**
     * @var bool
     */
    public $collapse;
    /**
     * @var bool
     */
    public $expand;
    /**
     * @var null
     */
    public $reload;

    /**
     * @var bool
     */
    public $vh;



    /**
     * Card constructor.
     * @param string|null $title
     * @param bool|null $responsive
     * @param bool|null $collapse
     * @param bool|null $expand
     * @param bool|null $reload
     * @param bool|null $vh
     */
    public function __construct(?string $title = null,
                                ?bool $responsive = null,
                                ?bool $collapse = null,
                                ?bool $expand = null,
                                ?bool $reload = null,
                                ?bool $vh = null) {

        $this->title = $title;
        $this->responsive = ($responsive) ??  false;
        $this->collapse = ($collapse) ??  false;
        $this->expand = ($expand) ??  false;
        $this->reload = ($reload) ??  false;
        $this->vh = ($vh) ?? false;

        $this->responsive = $responsive;
    }


    /**
     * @return \Illuminate\View\View|string|void
     * @throws \Exception
     */
    public function render()
    {
        throw new \Exception('This is just a class constructor');
    }
}
