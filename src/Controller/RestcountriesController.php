<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Contracts\HttpClient\HttpClientInterface;
use Symfony\Component\HttpFoundation\Request; // Nous avons besoin d'accéder à la requête pour obtenir le numéro de page
use Knp\Component\Pager\PaginatorInterface; // Nous appelons le bundle KNP Paginator

class RestcountriesController extends AbstractController
{
    private $client;

    public function __construct(HttpClientInterface $client)
    {
        $this->client = $client;
    }
    /**
     * @Route("/restcountries", name="restcountries")
     */
    public function index()
    {
        $response = $this->client->request(
            'GET',
            'https://restcountries.com/v2/all'
        );

        $statusCode = $response->getStatusCode();
        // $statusCode = 200
        $contentType = $response->getHeaders()['content-type'][0];
        // $contentType = 'application/json'
        $content = $response->getContent();
        // $content = '{"id":521583, "name":"symfony-docs", ...}'
        $content = $response->toArray();
        // $content = ['id' => 521583, 'name' => 'symfony-docs', ...]

        // return $content;

        return $this->json($content);

        // return $this->render('restcountries/index.html.twig', [
        //     'controller_name' => $content,
        // ]);
    }
    /**
     * @Route("/restcountries/pagination", name="restcountries")
     */
    public function indexPagination(Request $request, PaginatorInterface $paginator)
    {
        $response = $this->client->request(
            'GET',
            'https://restcountries.com/v2/all'
        );

        $statusCode = $response->getStatusCode();
        // $statusCode = 200
        $contentType = $response->getHeaders()['content-type'][0];
        // $contentType = 'application/json'
        $countries = $response->getContent();
        // $content = '{"id":521583, "name":"symfony-docs", ...}'
        $countries = $response->toArray();
        // $content = ['id' => 521583, 'name' => 'symfony-docs', ...]

        // return $content;
        $countriesP = $paginator->paginate(
            $countries, // Requête contenant les données à paginer (ici nos articles)
            $request->query->getInt('page', 1), // Numéro de la page en cours, passé dans l'URL, 1 si aucune page
            6 // Nombre de résultats par page
        );

        return $this->render('restcountries/index.html.twig', [
            'countries' => $countriesP,
        ]);
    }

    // /**
    //  * @Route("/restcountries/filter/{filter}", name="restcountries")
    //  */
    // public function filtercoutrie($filter)
    // {
    //     $resultat =array();
    //     $response = $this->client->request(
    //         'GET',
    //         'https://restcountries.com/v2/all'
    //     );

    //     $statusCode = $response->getStatusCode();
    //     // $statusCode = 200
    //     $contentType = $response->getHeaders()['content-type'][0];
    //     // $contentType = 'application/json'
    //     $countries = $response->getContent();
    //     // $content = '{"id":521583, "name":"symfony-docs", ...}'
    //     $countries = $response->toArray();
    //     // $content = ['id' => 521583, 'name' => 'symfony-docs', ...]

    //     // return $content;

    //     foreach ($countries as $countrie) {
    //         // var_dump($countrie);exit;
    //         if ((str_contains($countrie['name'], $filter)) || (str_contains($countrie['alpha2Code'], $filter))) {
    //             $resultat[] = $countrie;
    //         }
    //     }
    //     return $this->json($resultat);
    // }


    // /**
    //  * @Route("/restcountries/delete/{name}", name="restcountries")
    //  */
    // public function DeleteCountrie($name)
    // {
    //     $response = $this->client->request('Delete', 'https://restcountries.com/v2/all', [
    //         // these values are automatically encoded before including them in the URL
    //         'query' => [
    //             'name' => $name,
    //         ],
    //     ]);

    //     $statusCode = $response->getStatusCode();
    //     // $statusCode = 200
    //     $contentType = $response->getHeaders()['content-type'][0];
    //     // $contentType = 'application/json'
    //     $countries = $response->getContent();
    //     // $content = '{"id":521583, "name":"symfony-docs", ...}'
    //     $countries = $response->toArray();
    //     // $content = ['id' => 521583, 'name' => 'symfony-docs', ...]

    //     // return $content;


    //     return $this->render('restcountries/index.html.twig', [
    //         'countries' => $countries,
    //     ]);
    // }
}
