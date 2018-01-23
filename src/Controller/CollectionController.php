<?php
/**
 * Created by PhpStorm.
 * User: Kamil Roczniok
 * Date: 2018-01-20
 * Time: 20:08
 */

namespace App\Controller;

use App\Entity\Item;

use App\Entity\User;
use App\Form\ItemType;
use App\Repository\ItemRepository;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Session\Session;

define("PAGE_SIZE", 5);

class CollectionController extends Controller
{
    /** @var Session $session */
    private $session;

    /**
     * CollectionController constructor.
     */
    public function __construct()
    {
        $this->session = new Session();
        $this->session->start();
    }

    /**
     * @Route("/"), name="collection_list")
     * @Route("/list/{page}", name="collection_list")
     *
     * @param int $page
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function collectionList($page = 1)
    {
        // handle session
        $itemAdded = $this->session->get('item_successfully_added');
        if ($itemAdded) {
            $this->session->remove('item_successfully_added');
        }

        /** @var ItemRepository $itemRepository */
        $itemRepository = $this->getDoctrine()->getRepository(Item::class);

        // get items for current page
        $items = $itemRepository->getPage($page - 1, PAGE_SIZE);

        // calculate total pages
        $totalPages = ceil(count($itemRepository->findAll()) / PAGE_SIZE);

        // render twig
        return $this->render('collection/list.html.twig', array(
            'page' => $page,
            'totalPages' => $totalPages,
            'items' => $items,
            'itemSuccessfullyAdded' => $itemAdded
        ));
    }

    /**
     * @Route("/item/form", name="item_form")
     *
     * @param Request $request
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function itemForm(Request $request)
    {
        // create form
        $item = new Item();
        $item->setUser($this->getDoctrine()->getRepository(User::class)->find(1));
        $form = $this->createForm(ItemType::class, $item);

        // handle submitted item form
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {

            $item = $form->getData();
            $em = $this->getDoctrine()->getManager();
            $em->persist($item);
            $em->flush();

            $this->session->set('item_successfully_added', true);
            return $this->redirectToRoute('collection_list');
        }

        // render form
        return $this->render('collection/item-form.html.twig', array('form' => $form->createView()));
    }
}