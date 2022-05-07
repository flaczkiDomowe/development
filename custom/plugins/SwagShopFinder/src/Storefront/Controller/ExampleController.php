<?php declare(strict_types=1);

namespace SwagShopFinder\Storefront\Controller;

use Shopware\Core\Framework\Routing\Annotation\RouteScope;
use Shopware\Core\System\SalesChannel\SalesChannelContext;
use Shopware\Storefront\Controller\StorefrontController;
use SwagShopFinder\Storefront\Page\Example\ExamplePageLoader;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;


/**
 * @RouteScope(scopes={"storefront"})
 */
class ExampleController extends StorefrontController
{

    private ExamplePageLoader $examplePageLoader;

    public function __construct(ExamplePageLoader $examplePageLoader)
    {
        $this->examplePageLoader = $examplePageLoader;
    }

    /**
     * @Route("/example-page",name="storefront.custom.swag_shop_finder.examplepage")
     */
    public function examplePage(Request $request, SalesChannelContext $context): Response
    {
        $page = $this->examplePageLoader->load($request, $context);
        $specificShop=$request->request->get("shop_id");
        return $this->renderStorefront('@SwagShopFinder/storefront/page/example/index.html.twig', [
            'example' => 'Hello world',
            'page' => $page,
            'shop_id' => $specificShop
        ]);
    }
}
