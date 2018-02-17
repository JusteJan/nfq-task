<?php
/**
 * Created by PhpStorm.
 * User: Juste
 * Date: 2018-02-13
 * Time: 21:01
 */

namespace AppBundle\Controller;


use AppBundle\Entity\Orders;
use AppBundle\Form\OrderType;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;

class NewOrderController extends Controller
{
    /**
     * @Route("/orders/new", name="orders_new")
     */
    public function newAction(Request $request)
    {
        $form = $this->createForm(OrderType::class);

        $form->handleRequest($request);

        if($form->isSubmitted() && $form->isValid()) {
            $order = $form->getData();
            $customer = $order->getCustomer();

            $em = $this->getDoctrine()->getManager();
            $customerRepo = $em->getRepository('AppBundle:Customer');

            //Jeigu užsakovas jau yra duomenų bazėje, jam nesukuriamas naujas įrašas 'customer'
            //lentelėje
            if($customerRepo->findOneByOneCustomer($customer)) {
                $order->setCustomer($customerRepo->findOneByOneCustomer($customer));
            }
            $order->setDate(new \DateTime());
            $em->persist($order);
            $em->flush();

            $this->addFlash('success', 'Užsakymas pateiktas');

            return $this->redirectToRoute('orders_list');
        }

        return $this->render('orders/new.html.twig', [
            'orderForm' => $form->createView(),
            'price' => Orders::PRICE
    ]);
    }

    /**
     * @Route("/orders/table_information", name="order_table_info")
     */

    public function getListAction()
    {
        $orderList = [];
        $orders = $this->getDoctrine()
            ->getRepository('AppBundle:Orders')
            ->findAllTableInformation();

        foreach ($orders as $order) {
            $orderList[] = [
                'id' => $order['id'],
                'name' => $order['name'],
                'surname' => $order['surname'],
                'date' => $order['date']->format('Y-m-d'),
                'quantity' => $order['quantity'],
                'total' => $order['totalPrice'],
            ];
        }
        return new JsonResponse($orderList);
    }

    /**
     * @Route("/orders/list", name="orders_list")
     */
    public function listAction()
    {
        $keys = [
            'Užsakymo nr.' => 'id',
            'Užsakovo vardas' => 'name',
            'Užsakovo pavardė' => 'surname',
            'Užsakymo data' => 'date',
            'Kiekis' => 'quantity',
            'Galutinė kaina' => 'total'
        ];
        return $this->render('orders/list.html.twig', [
            'keys' => $keys
        ]);
    }

    /**
     * @Route("/order/info/{orderId}", name="order_info")
     */
    public function showAction($orderId)
    {
        $getOrder = $this->getDoctrine()
            ->getRepository('AppBundle:Orders')
            ->findOneWithCustomerById($orderId);

        return $this->render('orders/info.html.twig', [
            'orderInfo' => $getOrder[0]
        ]);

    }
}

