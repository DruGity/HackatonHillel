<?php
namespace App\Controller;
use App\Entity\Adress;
use App\Entity\City;
use App\Entity\Country;
use App\Entity\Street;
use App\Entity\User;
use App\Repository\AdressRepository;
use App\Repository\CityRepository;
use App\Repository\CountryRepository;
use App\Repository\StreetRepository;
use App\Repository\UserRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Config\Definition\Exception\Exception;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
class ApiController extends AbstractController
{
    /** @var EntityManagerInterface */
    private $em;

    /** @var  AdressRepository */
    private $adressRepository;

    /** @var  CountryRepository */
    private $countryRepository;

    /** @var  CityRepository */
    private $cityRepository;

    /** @var  StreetRepository */
    private $streetRepository;

    /** @var UserRepository  */
    private $userRepository;

    public function __construct(
        EntityManagerInterface $em,
        AdressRepository $adressRepository,
        CountryRepository $countryRepository,
        CityRepository $cityRepository,
        StreetRepository $streetRepository,
        UserRepository $userRepository
    ){
        $this->em = $em;
        $this->adressRepository = $adressRepository;
        $this->countryRepository = $countryRepository;
        $this->cityRepository = $cityRepository;
        $this->streetRepository = $streetRepository;
        $this->userRepository = $userRepository;
    }

    /**
     * @return JsonResponse
     * @Route("/userinfo/add", name="add", methods={"POST"})
     */
    public function addUserInfoAction(Request $request)
    {

        /** @var Country $country */
        $country = $this->countryRepository->findOneBy(['name' => $request->request->get('country')]);
        /** @var City $city */
        $city = $this->cityRepository->findOneBy(['name' => $request->request->get('city')]);
        /** @var Street $street */
        $street = $this->streetRepository->findOneBy(['name' => $request->request->get('street')]);

        if(!$country instanceof Country || !$city instanceof City || !$street instanceof Street) {
            $response = [
                'status' => 406,
                'message' =>sprintf("Adress %s %s %s doesnt exist.",$request->request->get('country'),$request->request->get('city'), $request->request->get('street') )
            ];
            return new JsonResponse($response, 406);
        }

        /** @var Adress $adress */
        $adress = $this->adressRepository->findOneBy([
            'street' => $street->getId(),
            'city' => $city->getId(),
            'country' => $country->getId()
        ]);

        if(!$adress instanceof Adress) {
            $response = [
              'status' => 406,
                'message' =>sprintf("Adress %s %s %s doesnt exist.",$request->request->get('country'),$request->request->get('city'), $request->request->get('street') )
            ];
            return new JsonResponse($response, 406);
        }

        $existingUser = $this->userRepository->findOneBy([
                'firstname' => $request->request->get('firstname'),
                'lastname' => $request->request->get('lastname')
            ]);

        if($existingUser instanceof User) {
            $response = [
                'status' => 204,
                'message' =>sprintf("User %s %s already exists.", $existingUser->getFirstname(), $existingUser->getLastname())
            ];
            return new JsonResponse($response, 204);
        }

        $user = new User();
        $user->setFirstname($request->request->get('firstname'));
        $user->setLastname($request->request->get('lastname'));
        $user->setAdress($adress);

        $this->em->persist($user);

        $this->em->flush();
        $this->em->clear();

        $response = [
            'status' => 201,
            'message' =>sprintf("User %s %s was created.", $user->getFirstname(), $user->getLastname())
        ];

        return new JsonResponse($response, 201);
    }

    /**
     * @return JsonResponse
     * @Route("/userinfo/get/{firstname}/{lastname}", name="get", methods={"get"})
     */
    public function getAction($firstname, $lastname)
    {
        try{
            $existingUser = $this->userRepository->findOneBy([
                'firstname' => $firstname,
                'lastname' => $lastname
            ]);
            if($existingUser instanceof User) {
                $response = [
                    'status' => 200,
                    'firstname' => $existingUser->getFirstname(),
                    'lastname' => $existingUser->getLastname(),
                    'country' => $existingUser->getAdress()->getCountry()->getName(),
                    'city' => $existingUser->getAdress()->getCity()->getName(),
                    'street' => $existingUser->getAdress()->getStreet()->getName()
                ];
                return new JsonResponse($response, 201);
            } else {
                throw new \Exception('user not found', 4);
            }
        } catch (\Exception $e) {
                $response = [
                    'status' => 204,
                    'message' =>sprintf("User %s %s doesnt exists.", $firstname, $lastname)
                ];
                return new JsonResponse($response, 204);
            }

    }

}
