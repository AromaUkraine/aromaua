<?php

namespace Modules\Gallery\Events;

use App\Models\Page;
use App\Models\PageComponent;
use Illuminate\Http\Request;
use Illuminate\Queue\SerializesModels;

class CreatePageGalleryEvent
{
    use SerializesModels;

    /**
     * @var Request
     */
    public $request;
    /**
     * @var Page
     */
    public $page;
    /**
     * @var PageComponent
     */
    public $pageComponent;
    /**
     * @var string
     */
    public $type;

    /**
     * Create a new event instance.
     *
     * @param Request $request
     * @param Page $page
     * @param PageComponent $alias
     * @param string $type
     */
    public function __construct(Request $request, Page $page, $alias, string $type)
    {

        $this->request = $request;
        $this->page = $page;
        $this->pageComponent = PageComponent::where('page_id', $page->id)->where('alias', $alias)->firstOrFail();
        $this->type = $type;
    }

    /**
     * Get the channels the event should be broadcast on.
     *
     * @return array
     */
    public function broadcastOn()
    {
        return [];
    }
}