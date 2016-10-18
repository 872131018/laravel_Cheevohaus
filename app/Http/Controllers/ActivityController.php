<?php

namespace App\Http\Controllers;

use App\Gamertag;
use App\Relationship;
//use App\Profile;
use Guzzle\Http\Client;
use App\Http\Requests;
use Illuminate\Http\Request;

class ActivityController extends Controller
{
  /**
   * Create a new controller instance.
   *
   * @return void
   */
  public function __construct()
  {
      $this->middleware('auth');
  }
  /**
   * Load the gamertag of the authorized user
   *
   * @param  Request  $request
   * @return Response
   */
  public function load_activity(Request $request)
  {
    /*
    * Set user id for current request
    */
    $user_id = $request->user()->id;
    /*
    * Check if relationship exists for a logged in user
    */
    $relationship = Relationship::where('user_id', $user_id)->first();
    /*
    * Each relationship should link to a user
    */
    if(isset($relationship->user_id)) {
      /*
      * Gamertag found direct to profile loader
      */
      $profile = Profile::where('id', $relationship->profile_id)->first();
      return json_encode($profile); die;
    }
    else {
      /*
      * Make request to verify gamertag for a new user
      */
      $guzzle_client = new Client('https://xboxapi.com');
      $guzzle_client->setDefaultOption('headers/X-AUTH', getenv('XBOX_API_KEY'));
      $guzzle_response = $guzzle_client->get("/v2/xuid/".$request->gamertag)->send();
      /*
      * Interpret the response
      */
      $status = $guzzle_response->getStatusCode();
      switch($status)
      {
        /*
        * Successfull response with a gamertag
        */
        case 200:
          $guzzle_response = $guzzle_response->getBody();
          /*
          * Create set and commit the xuid
          */
          $gamertag = new Gamertag();
          $gamertag->xuid = $guzzle_response;
          $gamertag->save();
          /*
          * Update the relationship model with the insert id
          */
          $relationship = new Relationship();
          $relationship->user_id = $user_id;
          $relationship->gamertag_id = $gamertag->id;
          $relationship->save();
          break;
        default:
          die("FAIL");
          break;
      }
      /*
      * Retrieve xuid to set in as it officially set
      */
      $relationship = Relationship::where('user_id', $user_id)->first();
      $gamertag = Gamertag::find($relationship->gamertag_id)->first();
      /*
      * Make request to verify gamertag for a new user
      */
      $guzzle_client = new Client('https://xboxapi.com');
      $guzzle_client->setDefaultOption('headers/X-AUTH', getenv('XBOX_API_KEY'));
      $guzzle_response = $guzzle_client->get("/v2/gamertag/".$gamertag->xuid)->send();
      /*
      * Interpret the response
      */
      $status = $guzzle_response->getStatusCode();
      switch($status)
      {
        /*
        * Successfull response with a gamertag
        */
        case 200:
          $guzzle_response = $guzzle_response->getBody();
          /*
          * Create set and commit the xuid
          */
          $gamertag->gamertag = $guzzle_response;
          $gamertag->save();
          break;
        default:
          die("FAIL");
          break;
      }
      /*
      * Retrieve xuid to set in as it officially set
      */
      $relationship = Relationship::where('user_id', $user_id)->first();
      $gamertag = Gamertag::find($relationship->gamertag_id)->first();
      /*
      * Make request to load profile
      */
      $guzzle_client = new Client('https://xboxapi.com');
      $guzzle_client->setDefaultOption('headers/X-AUTH', getenv('XBOX_API_KEY'));
      $guzzle_response = $guzzle_client->get("/v2/{$gamertag->xuid}/profile")->send();
      /*
      * Interpret the response
      */
      $status = $guzzle_response->getStatusCode();
      switch($status)
      {
        /*
        * Successfull response with a gamertag
        */
        case 200:
          $guzzle_response = $guzzle_response->json();
          /*
          * Create set and commit the profile
          */
          $profile = new Profile();
          $profile->xuid = $guzzle_response['id'];
          $profile->gamertag = $guzzle_response['Gamertag'];
          $profile->gamerscore = $guzzle_response['Gamerscore'];
          $profile->game_display_pic_raw = $guzzle_response['GameDisplayPicRaw'];
          $profile->preferred_color = $guzzle_response['PreferredColor'];
          $profile->save();
          /*
          * Update the relationship model with the insert id
          */
          $relationship->profile_id = $profile->id;
          $relationship->save();
          break;
        default:
          die("FAIL");
          break;
      }
      /*
      * Build a template and send it back
      */
      $profile = Profile::where('id', $relationship->profile_id)->first();
      return json_encode($profile); die;
    }

  }
}
