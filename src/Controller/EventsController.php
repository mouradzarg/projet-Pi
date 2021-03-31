<?php
namespace App\Controller;

use App\Entity\Evenement;
use App\Repository\EvenementRepository;
use Doctrine\Persistence\ObjectManager;
use Knp\Component\Pager\PaginatorInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\Serializer\Normalizer\NormalizerInterface;
class EventsController extends AbstractController
{

    /**
     * @var EvenementRepository
     */
    private $repository;

    /**
     * @var ObjectManager
     */
    private $em;

    public function __construct(EvenementRepository $repository, EntityManagerInterface $em)
    {
        $this->repository = $repository;
        $this->em = $em;
    }

    /**
     * @return Response
     * @Route("events", name="events.index")
     */

    public function index(PaginatorInterface $paginator, Request $request): Response
    {
        $evenements = $paginator->paginate($this->repository->findAllVisibleQuery(),
            $request->query->getInt('page', 1)
            , 8);
        return $this->render('events/index.html.twig', [
            'current_menu' => 'event',
            'events' => $evenements
        ]);
    }


    /**
     * @Route("/event/{slug}-{id}", name="event.show", requirements={"slug": "[a-z0-9\-]*"})
     * @param Evenement $evenement
     * @return Response
     */
    public function show(Evenement $evenement, string $slug): Response
    {
        if ($evenement->getSlug() !== $slug) {
            return $this->redirectToRoute('event.show', [
                'id' => $evenement->getId(),
                'slug' => $evenement->getSlug()
            ], 301);
        }
        return $this->render('events/show.html.twig', [
            'event' => $evenement,
            'current_menu' => 'events'
        ]);
    }

    /**
     * @Route("/searchStudentx ", name="searchStudentx")
    public function searchStudentx(Request $request,NormalizerInterface $Normalizer)
    {
        $repository = $this->getDoctrine()->getRepository(Evenement::class);
        $requestString=$request->get('searchValue');
        $students = $repository->findStudentByNsc($requestString);
        $jsonContent = $Normalizer->normalize($students, 'json',['groups'=>'students:read']);
        $retour=json_encode($jsonContent);
        return new Response($retour);

    }



    /**
     * @Route("/EventSearch",name="ajax_searchh")

    public function searchAction(Request $request){
        $em = $this->getDoctrine()->getManager();
        $requestString = $request->get('q');
        $entities =  $em->getRepository(Evenement::class)->findEntitiesByString($requestString);
        if(!$entities) {
            $result['entities']['error'] = "Aucune événement";
        } else {
            $result['entities'] = $this->getRealEntities($entities);
        }

        return new Response(json_encode($result));
    }

    public function getRealEntities($entities)
    {
        foreach ($entities as $entity){
            $realEntities[$entity->getId()] = $entity->getTitre();
        }

        return $realEntities;
    }*/
}