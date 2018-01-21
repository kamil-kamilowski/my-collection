<?php
/**
 * Created by PhpStorm.
 * User: Kamil Roczniok
 * Date: 2018-01-20
 * Time: 20:08
 */

namespace App\Controller;

use App\Entity\Item;
use App\Entity\ItemCategory;
use App\Entity\ItemGenre;
use App\Entity\User;
use App\Form\ItemType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class CollectionController extends Controller
{
    /**
     * @Route("/"), name="collection_list")
     * @Route("/list/{page}", name="collection_list")
     * @Route("/list/{page}/{success}", name="collection_list")
     *
     * @param int $page
     * @param bool $success
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function collectionList($page = 1, $success = false)
    {
        $items = $this->getDoctrine()->getRepository(Item::class)->findAll();
        return $this->render('collection/list.html.twig', array(
            'page' => $page,
            'items' => $items,
            'item_successfully_added' => $success
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
        $form =  $this->createForm(ItemType::class, $item);

        // handle submitted item form
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {

            $item = $form->getData();
            $em = $this->getDoctrine()->getManager();
            $em->persist($item);
            $em->flush();

            return $this->redirectToRoute('collection_list', array('page' => 1, 'success' => 'success'));
        }

        // render form
        return $this->render('collection/item-form.html.twig', array(
                'form' => $form->createView(),
                'item_added' => $request->get('success') !== null
            )
        );
    }
}