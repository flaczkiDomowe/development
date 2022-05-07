<?php declare(strict_types=1);

namespace SwagShopFinder\Storefront\Page\Example;

use Shopware\Core\System\SalesChannel\SalesChannelContext;
use Shopware\Storefront\Page\GenericPageLoaderInterface;
use Symfony\Component\EventDispatcher\EventDispatcherInterface;
use Symfony\Component\HttpFoundation\Request;

class ExamplePageLoader
{
    private GenericPageLoaderInterface $genericPageLoader;

    private EventDispatcherInterface $eventDispatcher;

    public function __construct(GenericPageLoaderInterface $genericPageLoader, EventDispatcherInterface $eventDispatcher)
    {
        $this->genericPageLoader = $genericPageLoader;
        $this->eventDispatcher = $eventDispatcher;
    }

    public function load(Request $request, SalesChannelContext $context): ExamplePage
    {

        $page = $this->genericPageLoader->load($request, $context);
        /** @var ExamplePage $page */
        $page = ExamplePage::createFrom($page);

        // Do additional stuff, e.g. load more data from repositories and add it to page


        $this->eventDispatcher->dispatch(
            new ExamplePageLoadedEvent($page, $context, $request)
        );

        return $page;
    }
}
