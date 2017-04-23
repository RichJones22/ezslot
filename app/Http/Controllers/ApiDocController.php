<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class ApiDocController extends Controller
{
    /**
     * Index action
     * @return string
     *
     */
    public function index()
    {
        // path to generated swagger json
        // - to generate the swagger json, run the below from the app root.
        // - ./vendor/bin/swagger app/ -o public/docs/
        // - also the SwaggerGeneragteDoc.php command builds the public/docs/ as well...
        $path = '/api-docs/getdocs';

        return view('vendor.swaggervel.index')->with('urlToDocs', $path);
    }


    /**
     * Fetch docs for JSON.
     * @return \Illuminate\Contracts\Routing\ResponseFactory|\Illuminate\Http\JsonResponse|\Symfony\Component\HttpFoundation\Response
     */
    public function getDocs()
    {
        $location = base_path("public/docs/swagger.json");

        return response(
            file_get_contents(base_path("public/docs/swagger.json"))
        );
    }
}
