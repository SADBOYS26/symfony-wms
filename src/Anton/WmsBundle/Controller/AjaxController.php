<?

namespace Anton\WmsBundle\Controller;

use Anton\WmsBundle\Entity\Product;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class AjaxController extends Controller
{
    public function ProductDetailAction($id)
    {
        $product = $this->getDoctrine()->getManager()->getRepository(Product::class)->find($id);
        return $this->render('@AntonWms/Default/products.detail.html.twig', ['product' => $product]);
    }
}