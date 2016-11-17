<?php

class ErrorController extends \BaseController {

    /**
     * Redirects to a view which says that the page the user tried to access
     * is wrong or doesn't exist.
     *
     * @return view with "wrong page" content
     */
    public function wrongPage()
    {
        return View::make('error.wrong_page');
    }

}