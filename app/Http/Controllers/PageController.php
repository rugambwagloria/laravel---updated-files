<?php

namespace App\Http\Controllers;

use App\Models\Analytics;
use Illuminate\Http\Request;

class PageController extends Controller
{
    /**
     * Display all the static pages when authenticated
     *
     * @param string $page
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View
     */
    public function index()
    {
        $analytics = new Analytics();
        $challenges=$analytics->getChallenges();
        $top5_general=$analytics->getTop5Schools();
        $bottom5_general=$analytics->getBottom5Schools();

       return view("pages.schools-performance", compact('challenges','top5_general','bottom5_general'));

    }

    public function view(Request $request)
    {
        $analytics = new Analytics();
        //read from form
        $challengeName = $request->input('challenge_name');
        $top5=$analytics->getTop5SchoolsPerChallenge($challengeName);
        $bottom5=$analytics->getBottom5SchoolsPerChallenge($challengeName);
        $challenges=$analytics->getChallenges();
        $top5_general=$analytics->getTop5Schools();
        $bottom5_general=$analytics->getBottom5Schools();


        return view("pages.schools-performance", compact('top5','bottom5','challengeName','challenges','top5_general','bottom5_general'));
    }

    public function rtl()
    {
        return view("pages.rtl");
    }

    public function profile()
    {
        return view("pages.profile-static");
    }

    public function signin()
    {
        return view("pages.sign-in-static");
    }

    public function signup()
    {
        return view("pages.sign-up-static");
    }
}
