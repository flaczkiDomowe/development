<?php declare(strict_types=1);

namespace SwagShopFinder\Storefront\Subscriber;

use Shopware\Core\Framework\DataAbstractionLayer\EntityRepositoryInterface;
use Shopware\Core\Framework\DataAbstractionLayer\Search\Criteria;
use Shopware\Core\Framework\DataAbstractionLayer\Search\Filter\EqualsFilter;
use Shopware\Storefront\Event\StorefrontRenderEvent;
use SwagShopFinder\Core\Content\ShopFinder\ShopFinderCollection;
use SwagShopFinder\Core\Content\ShopFinder\ShopFinderEntity;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;

class PageSubscriber implements EventSubscriberInterface
{
    protected $shopFinderRepository;
    public function __construct(EntityRepositoryInterface $shopFinderRepository)
    {
        $this->shopFinderRepository=$shopFinderRepository;
    }

    public static function getSubscribedEvents(): array
    {
        return [
            StorefrontRenderEvent::class => 'onStorefrontRender'
        ];
    }

    public function onStorefrontRender(StorefrontRenderEvent $event)
    {
        $route = $event->getRequest()->get('route');
        $shopId=$event->getRequest()->get('shop_id');
        $criteria=new Criteria();
        $criteria->addFilter(new EqualsFilter('id',$shopId));
        $criteria->setLimit(1);
        /** @var ShopFinderCollection $shopFinderCollecton */
        $shopFinderCollecton=$this->shopFinderRepository->search($criteria,$event->getContext())->getEntities();
//        if ($route == 'storefront.custom.swag_shop_finder.examplepage') {
            $event->setParameter('entity',$shopFinderCollecton);
//        }
    }
}
