<?php

class HomeController extends BaseController {

    public function index()
    {
        $statistics = Statistics::find(1);

        return View::make('home')->with('statistics', $statistics);
    }
}
