<?php

/** 
 * @file
 * Generates markup to be displayed.  Functionality in this Controller is wired to Drupal in mymodule.routing.yml
 *
 */

namespace Drupal\mymodule\Controller;

use Drupal\Core\Controller\ControllerBase;

use Symfony\Component\HttpFoundation\HttpRequest;
use Symfony\Component\HttpKernel\Exception\HttpException;



class FirstController extends ControllerBase {

  public function content() {
    return [
      '#type' => 'markup',
      '#markup' => $this->t('Welcome to the world of ESPN through my first php controller.'),
    ];
  }

  public function variableContent($name1, $name2) {
    return [
      '#type' => 'markup',
      '#markup' => $this->t('@name1 and @name2, welcome to the world of ESPN through my first php controller.', 
        ['@name1' => $name1, '@name2' => $name2]),
    ];
  }

  public function getNFL() {
    
    $client = \Drupal::httpClient();
    $request = $client->get('https://odds.p.rapidapi.com/v4/sports/americanfootball_nfl/scores',
      [
        'headers' => [
          'X-RapidAPI-Key' => 'd825f6ccc4msh5c52f4fbeced2a9p13985fjsne7ef710dac4e',
          'X-RapidAPI-Host' => 'odds.p.rapidapi.com',
        ],
        'query' => [
          'daysFrom' => '3'
        ]
      ]);
    $response = $request->getBody();
    $data = json_decode($response, TRUE);
    echo $data;
    
    

    // $client = \Drupal::httpClient();
    // $request = \Drupal::httpClient()->request('GET', 'https://odds.p.rapidapi.com/v4/sports/americanfootball_nfl/scores', [
    //   'headers' => [
    //     'X-RapidAPI-Key' => 'd825f6ccc4msh5c52f4fbeced2a9p13985fjsne7ef710dac4e',
    //     'X-RapidAPI-Host' => 'odds.p.rapidapi.com'
    //   ],
    //   'query' => [
    //     'daysFrom' => '3'
    //   ]
    // ]);
    
    // $request->setRequestUrl('https://odds.p.rapidapi.com/v4/sports/americanfootball_nfl/scores');
    // $request->setRequestMethod('GET');
    // $request->setQuery(new http\QueryString([
    //     'daysFrom' => '3'
    // ]));
    
    // $request->setHeaders([
    //     'X-RapidAPI-Key' => 'd825f6ccc4msh5c52f4fbeced2a9p13985fjsne7ef710dac4e',
    //     'X-RapidAPI-Host' => 'odds.p.rapidapi.com'
    // ]);
    
    // $client->enqueue($request)->send();
    // $response = $client->getResponse();
    
    // echo $response;

    return [
      '#type' => 'markup',
      '#markup' => $this->t('NFL scores will go here.'),
      '#echo' => $data
    ];
  }
}

