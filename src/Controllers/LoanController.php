<?php

namespace App\Controllers;

use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;
use App\Models\Loan;
use Slim\Exception\HttpNotFoundException;
use Rollbar\Rollbar;
use Rollbar\Payload\Level;

class LoanController
{

    public function __construct()
    {
        require dirname(__DIR__) . '/Models/Loan.php';
    }

    public function main(Request $request, Response $response): Response
    {
        Rollbar::log(Level::INFO, 'Test info message2');
        return $response->withHeader('Content-Type', 'application/json')->withStatus(203);
    }

    public function index(Request $request, Response $response): Response
    {
        $loan = Loan::all();
        $response->getBody()->write(json_encode($loan));
        return $response->withHeader('Content-Type', 'application/json')->withStatus(200);
    }

    public function show(Request $request, Response $response, array $args): Response
    {
        $id = $args['id'];
        $loan = Loan::find($id);

        if (!$loan) {
            throw new HttpNotFoundException($request, 'Loan not found');
        }
        $response->getBody()->write(json_encode($loan));
        return $response->withHeader('Content-Type', 'application/json')->withStatus(200);
    }

    public function store(Request $request, Response $response): Response
    {
        $data = $request->getParsedBody();
        $loan = new Loan();
        $loan->amount = $data['amount'];
        $loan->interest_rate = $data['interest_rate'];
        $loan->term = $data['term'];
        $loan->created_at = $data['term'];
        $loan->save();
        $response->getBody()->write(json_encode($loan));
        return $response->withHeader('Content-Type', 'application/json')->withStatus(201);
    }

    public function update(Request $request, Response $response, array $args): Response
    {
        $id = $args['id'];
        $loan = Loan::find($id);
        
        if (!$loan) {
            throw new HttpNotFoundException($request, 'Loan not found');
        }
       
        $data = $request->getParsedBody();
        $loan->amount = $data['amount'];
        $loan->interest_rate = $data['interest_rate'];
        $loan->term = $data['term'];
        $loan->save();
        $response->getBody()->write(json_encode($loan));
        return $response->withHeader('Content-Type', 'application/json')->withStatus(201);
    }

    public function destroy(Request $request, Response $response, array $args): Response
    {
        $id = $args['id'];
        $loan = Loan::find($id);
        if (!$loan) {
            throw new HttpNotFoundException($request, 'Loan not found');
        }
        $loan->delete();
        return $response->withStatus(204);
    }
}
