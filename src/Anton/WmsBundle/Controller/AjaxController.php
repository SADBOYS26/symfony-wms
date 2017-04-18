<?

namespace Anton\WmsBundle\Controller;

use Anton\WmsBundle\Entity\Product;
use Anton\WmsBundle\Form\ProductType;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;

class AjaxController extends Controller
{
    public function ProductDetailAction(Product $product)
    {
        return $this->render('@AntonWms/Default/products.detail.html.twig', ['product' => $product]);
    }

    public function ProductEditAction(Request $request, Product $product)
    {
        $form = $this->createForm(ProductType::class, $product);
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $this->getDoctrine()->getManager()->flush();
        }

        return $this->render('@AntonWms/Default/products.edit.html.twig', ['form' => $form->createView()]);
    }
}