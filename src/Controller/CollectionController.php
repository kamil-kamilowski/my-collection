<?php
/**
 * Created by PhpStorm.
 * User: Kamil Roczniok
 * Date: 2018-01-20
 * Time: 20:08
 */

namespace App\Controller;

use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class CollectionController extends Controller
{
    /**
     * @Route("/"), name="collection_list")
     * @Route("/list/{page}", name="collection_list")
     *
     * @param int $page
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function collectionList($page = 1)
    {
        return $this->render('collection/list.html.twig', array('page' => $page));
    }

    /**
     * @Route("/item/view/{id}", name="item_view")
     *
     * @param int $id
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function itemView($id) {
        return $this->render('collection/item-view.html.twig', array('id' => $id));
    }
}