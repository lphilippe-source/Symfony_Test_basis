<?php

namespace App\Controller;
use App\Entity\Country;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class TestController extends AbstractController
{
    /**
     * @Route("/test", name="test", methods={"GET","POST"})
     */
    public function test(): Response
    {

        $res = new Response();
        $res -> setContent('test');
        $res->headers->set('X-Token', md5("coucou"));
        return $res;

        // return $this->render('test/index.html.twig', [
        //     'controller_name' => 'TestController',
        // ]);
    }

    /**
     * @Route("/", name="index")
     */
    public function test2()
    {

        $student = ['name' => 'Jerem', 'age'=>18, 'isMute' => true];
        // $student = json_encode($student);
                // dd(json_encode($student));

        // return new Response(json_encode($student));
        return $this->json($student);
        // $res = new Response();
        // $res -> setContent('test');
        // $res->headers->set('X-Token', md5("coucou"));
        // return $res;

        // return $this->render('test/index.html.twig', [
        //     'controller_name' => 'TestController',
        // ]);
    }

    /**
     * @Route("/test3", name="test3")
     */
    public function test3(Request $req){
        // dd($req);
        $searchedValue = $req->query->get('search');
        $method = $req->getMethod();
        // dd($searchedValue, $method);
        //pour envoyer a twig
        return $this->render('test/test3.html.twig',[
            'title'=>'test 3',
            'searchValue'=>$searchedValue,
            'method'=>$method,
            'students'=>['JEREMIE','NOEMIE','UMBERTO','PHILIPPE']
        ]);
    }

    /**
     * @Route("/test4/student/{id}/delete",
     *  name="test4",
     * requirements={"id"="\d\d"})
     */
    public function test4(int $id):Response{
        return new Response($id);
    }


    /**
     * @Route("/test5/{countryName}",
     * name="test5"
     * )
     */
    public function test5($countryName){

        $em =  $this->getDoctrine()->getManager();
        $country = new Country();
        $country->setName($countryName);
        $em->persist($country); //pending request
        $em->flush(); //exec request

        return new Response( sprintf('Country id %d', $country->getId() ));
    }

    /**
     * @Route("/test6",
     * name="test6"
     * )
     */
    public function test6(){

       $repo = $this->getDoctrine()->getRepository(Country::class);
       $countries = $repo->findAll();

       return $this->render('test/test6.html.twig',[
           'countries' => $countries
       ]);
    }

    /**
     * @Route("/test7/{order}",
     * name="country_list"
     * )
     */
    public function test7($order = 'ASC'){

        $repo = $this->getDoctrine()->getRepository(Country::class);
        $countries = $repo->findby([],['name'=>$order]);
 
        // dd($countries);
        return $this->render('test/test6.html.twig',[
            'countries' => $countries
        ]);
     }

     /**
     * @Route("/test8/{id}",
     * name="country_detail"
     * )
     */
    public function test8($id){

        $repo = $this->getDoctrine()->getRepository(Country::class);
        $country = $repo->find(intval($id));
        // dd($country);
        return $this->render('test/test8.html.twig',[
            'country' => $country
        ]);
     }

     /**
     * @Route("/test9",
     * name="country_form"
     * )
     */
     public function test9(Request $req, EntityManagerInterface $em){

        // dd($req);
        if($req->getMethod()==='POST'){
            $name = $req->request->get('name');
            $population = $req->request->get('population');
            $country = new Country();
            $country
                ->setName($name)
                ->setPopulation($population);

            $em->persist($country);
            $em->flush();

            //redirections
            return $this->redirectToRoute('country_list');
        }
        
        return $this->render('country/form.html.twig',[

        ]);
     }
}

