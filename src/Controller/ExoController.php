<?php

namespace App\Controller;
//import du service via namespace
use App\Entity\City;
use App\Service\CalculatorService;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class ExoController extends AbstractController
{
    /**
     * @Route("/exo/exo1/{slug}", name="exo", requirements={"slug"="\d+"} )
     */
    public function exo($slug): Response
    {
        $calculator = new CalculatorService();
        $carre = $calculator->square($slug);
        // dd($carre);
        // $carre=$slug*$slug;
        return new Response($carre);
    }

    /**
     * @Route("/exo2",
     * name="City_form"
     * )
     */
    public function exo2(Request $req, EntityManagerInterface $em){
        if($req->getMethod()==='POST'){
        $name = $req->request->get('name');
        $mayor = $req->request->get('mayor');
        //countryIdent
        //$country
            dd($req);
        $city = new City();
        $city->setName($name);
        $city->setMayor($mayor);
        // $city->setMayor($country);

        // $city->getCountry()->getName();
        $em->persist($city);
        $em->flush();
    }
        return $this->render('/city/form.html.twig',[]);
    }
}
