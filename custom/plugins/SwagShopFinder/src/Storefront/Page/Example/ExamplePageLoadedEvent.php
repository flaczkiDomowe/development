<?php declare(strict_types = 1);

namespace SwagShopFinder\Storefront\Page\Example;

use Shopware\Core\System\SalesChannel\SalesChannelContext;
use Shopware\Storefront\Page\PageLoadedEvent;
use Symfony\Component\HttpFoundation\Request;

class ExamplePageLoadedEvent extends PageLoadedEvent
{
    protected ExamplePage $page;

    public function __construct(ExamplePage $page, SalesChannelContext $salesChannelContext, Request $request)
    {
        $this->page = $page;
        parent::__construct($salesChannelContext, $request);
    }

    public function getPage(): ExamplePage
    {
        return $this->page;
    }
}

