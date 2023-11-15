<?php


namespace App\View\Components\Cms\Filter;


use Illuminate\View\Component;

class FilterContainer extends Component
{
    /**
     * @var string
     */
    public $action;
    /**
     * @var string
     */
    public $method;

    public function __construct(string $action, $method= 'get'){

        $this->action = $action;
        $this->method = $method;
    }

    public function render()
    {
        return view('components.cms.filter.filter-container');
        // TODO: Implement render() method.
    }
}
